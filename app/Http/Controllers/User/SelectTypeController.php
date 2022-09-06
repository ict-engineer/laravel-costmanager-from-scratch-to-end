<?php

namespace App\Http\Controllers\User;

require_once('../vendor/autoload.php');

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Provider;
use App\User;
use App\Models\Client;
use App\Models\Payment;
use Session;
use Stripe;
use Laravel\Cashier\Cashier;

class SelectTypeController extends Controller
{
    //
    public function index(Request $request)
    {
        Session::put('type', '');
        Session::put('isMexican', '');

        if(!Auth::check()){
            return redirect()->route('login');
        }
        if(Auth::user()->hasRole('Provider') && !(Auth::user()->hasRole('Client')))
            Session::put('type', 'Provider');
        else if(Auth::user()->hasRole('Client') && !(Auth::user()->hasRole('Provider')))
        {
            if(!(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales')))
            {
                if(Auth::user()->client == null)
                {
                    Client::where('user_id', Auth::user()->id)->delete();
                    Auth::user()->removeRole('Client');
                    return redirect()->route('login');
                }
                
                if(Auth::user()->client->country == "Mexico")
                    Session::put('isMexican', 'yes');

                if (!Auth::user()->subscribed('default') && !Auth::user()->subscriptions()->active()->count())
                    return redirect()->route('setpurchase');       
            }
            else
            {
                $client_id = Auth::user()->employee->client_id;
                $client = Client::find($client_id);

                if($client->country == "Mexico")
                    Session::put('isMexican', 'yes');
            }
            
            Session::put('type', 'Client');
        }
        else{
            return view('user.selecttype');
        }

        return redirect()->route('welcome');
    }

    public function setUserType(Request $request)
    {
        Session::put('isMexican', '');
        $data = $request->input();

        if(!(Auth::user()->hasRole($data['usertype'])))
        {
            if($data['usertype'] == 'Provider')
                return redirect()->route('setprovider');
            else if($data['usertype'] == 'Client')
                return redirect()->route('setclient');
        }
        if($data['usertype'] == 'Client')      
        {
            $client_id = 0;
            if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
                $client_id = Auth::user()->employee->client_id;
            else
                $client_id = Auth::user()->client->id;

            $client = Client::find($client_id);
            if($client->country == "")
                Session::put('isMexican', 'yes');

            if(!(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales')))
            {
                if (!(Auth::user()->subscribed('default') && Auth::user()->subscriptions()->active()->count()))
                    return redirect()->route('setpurchase');            
            }
            else
            {
                $user = User::find($client->user_id);
                if (!($user->subscribed('default') && Auth::user()->subscriptions()->active()->count()))
                    return redirect()->route('setpurchase');         
            }
        }

        Session::put('type', $data['usertype']);
        return redirect()->route('welcome');
    }

    public function setProvider(Request $request)
    {
        request()->validate([
            'companyname'      => 'required|unique:providers,companyname,'.Auth::user()->id.',user_id',
            'addline1'  => 'required',
            'country'  => 'required',
            'cp'  => 'required',
        ]);
        $user = Auth::user();
        $data = $request->input();
        Provider::where('user_id', Auth::user()->id)->delete();
        Provider::create([
            'companyname' => $data['companyname'],
            'addline1' => $data['addline1'],
            'country' => $data['country'],
            'cp' => $data['cp'],
            'user_id' => $user->id,
        ]);
        $user->removeRole('Test');
        $user->assignRole('Provider');
        Session::put('type', 'Provider');

        return redirect()->route('welcome');
    }

    public function setClient(Request $request)
    {
        request()->validate([
            'companyname'      => 'required|unique:clients,companyname,'.Auth::user()->id.',user_id',
            'addline1'  => 'required',
            'country'  => 'required',
            'cp'  => 'required',
            'numberofemployees'  => 'required',
            'service'  => 'required',
        ]);
        $user = Auth::user();
        $data = $request->input();

        Client::where('user_id', Auth::user()->id)->delete();
        Client::create([
            'companyname' => $data['companyname'],
            'addline1' => $data['addline1'],
            'country' => $data['country'],
            'cp' => $data['cp'],
            'numberofemployees' => $data['numberofemployees'],
            'service' => $data['service'],
            'user_id' => $user->id,
        ]);
        $user->removeRole('Test');
        $user->assignRole('Client');
        
        return redirect()->route('setpurchase');
    }

    public function postStripe(Request $request)
    {
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            return redirect()->route('welcome');    

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // $charge = Stripe\Charge::create ([
        //     "amount" => 100 * $request->amount,
        //     "currency" => strtolower($request->currency),
        //     "source" => $request->stripeToken,
        //     "description" => "Payment for membership on laravel.com." 
        // ]);
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );   
        $payment = Payment::find($request->paymentid);
        if($payment->stripe_id == null || $payment->stripe_id == '')
        {
            $product = Stripe\Product::create([
                'name' => $payment->name,
                'unit_label' => 'Month(s)',
            ]);
            $price = $stripe->plans->create([
                'amount' => 100 * $payment->price,
                'currency' => strtolower($payment->currency),
                'interval' => 'month',
                'product' => $product->id,
            ]);

            $payment->stripe_id = $product->id;
            $payment->stripeprice_id = $price->id;

            $payment->update();
        }
       
        $client = Auth::user()->client;

        $user = Auth::user();
                    
        $user->createOrGetStripeCustomer();

        $isfound = false;
        $paymentMethod = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => $request->cardnumber,
                'exp_month' => $request->expirymonth,
                'exp_year' => $request->expiryyear,
                'cvc' => $request->cvv,
            ],
        ]);

        $paymentMethods = $user->paymentMethods();
        
        foreach($paymentMethods as $data)
        {
            if($data->fingerprint == $paymentMethod->fingerprint && $data->exp_year  == $paymentMethod->exp_year 
                && $data->exp_month  == $paymentMethod->exp_month )
            {
                $isfound = true;
                $paymentMethod = $data->id;
                break;
            }
        }

        if(!$isfound)
        {
            $user->addPaymentMethod($paymentMethod);
        }

        $client->card_brand = $request->cardnumber;
        $client->card_last_four = $request->cvv;
        $client->update();

        try {
            $user->newSubscription('default', $payment->stripeprice_id)->trialDays(2)->create($paymentMethod, [
                'email' => $user->email
            ]);
            $client->payment = $request->paymentid;
            $client->payment_date = date('Y-m-d');
            $client->update();
        } catch (\Exception $e) {
            return response()->json(['text'=>'fail', 'error'=>$e->getMessage()]);
        }
        
        Session::put('isFirst', 'yes');
        Session::put('type', 'Client');
        User::sendPurchaseSuccessEmail();
        return response()->json(['text'=>'success']);
    }

    public function showPurchase()
    {
        $payments = Payment::where('country', Auth::user()->client->country)->orderby('price')->get();
        return view('auth.purchase', compact('payments'));        
    }
}
