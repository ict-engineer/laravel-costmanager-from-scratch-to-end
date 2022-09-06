<?php

namespace App\Http\Controllers\Client;

require_once('../vendor/autoload.php');

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Provider;
use App\User;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Transaction;
use Session;
use Stripe;
use Exception;
use Laravel\Cashier\Cashier;

class PurchaseController extends Controller
{
    //
    public function index(Request $request)
    {
        if(!(Auth::user()->hasRole('Client')))
            return redirect()->route('user.profile');

        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            return redirect()->route('welcome');
        $user = Auth::user();
        $isAvaliable = false;
        $client = Auth::user()->client;
        $payments = Payment::where('country', Auth::user()->client->country)->orderby('price')->get();

        $current_date = date('Y-m-d');

        $dateStr = date('M d,Y', $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"]);
        $currentPlan = Payment::where('stripeprice_id', $user->asStripeCustomer()["subscriptions"]->data[0]['plan']->id)->first();
        return view('user.client.purchase.index')->with('payments', $payments)->with('dateStr', $dateStr)->with('isAvaliable', $isAvaliable)
                ->with('currentPlan', $currentPlan->id);
    }

    public function setPlan(Request $request)
    {
        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            return redirect()->route('welcome');    

        $client = Auth::user()->client;
        $user = Auth::user();
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

        $current_amount = Payment::where('id', Auth::user()->client->payment)->first()->price;
        if($current_amount < $request->amount)
        {
            // $cursub_id =  $user->asStripeCustomer()["subscriptions"]->data[0]["id"];
            // $objInvoiceCollection = \Stripe\Invoice::all([
            //     'subscription' => $cursub_id
            // ]);
            
            // if ($objInvoiceCollection->total_count === 0) {
            //     throw new \Exception("warning: \$subscriptionId={$subscriptionId} - no invoices found!");
            // } else {
            //     $objInvoice = current($objInvoiceCollection);
            //     $chargeId = $objInvoice->charge;
            //     $objRefund = \Stripe\Refund::create(['charge' => $chargeId]);
            // }
            // $invoices = $user->invoices();
            // $chargeId = $invoices[0]->charge;
            // $objRefund = \Stripe\Refund::create(['charge' => $chargeId]);

            try {
                $user->subscription('default')->cancelNow();
                $user->newSubscription('default', $payment->stripeprice_id)->create($paymentMethod, [
                    'email' => $user->email
                ]);
                $client->payment = $request->paymentid;
                $client->payment_date = date('Y-m-d');
                $client->update();
            } catch (\Exception $e) {
                return response()->json(['text'=>'fail', 'error'=>$e->getMessage()]);
            }
        }
        else{
            $user->subscription('default')->cancel();
            $start_date = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
            try {
                \Stripe\SubscriptionSchedule::create([
                    'customer' => $user->asStripeCustomer()['id'],
                    'start_date' => $start_date,
                    'end_behavior' => 'release',
                    'phases' => [
                      [
                        'items' => [
                          [
                            'price' => $payment->stripeprice_id,
                            'quantity' => 1,
                          ],
                        ],
                      ],
                    ],
                  ]);
                $client->payment = $request->paymentid;
                $client->payment_date = date('Y-m-d');
                $client->update();
            } catch (\Exception $e) {
                return response()->json(['text'=>'fail', 'error'=>$e->getMessage()]);
            }
        }

        $client->payment = $request->paymentid;
        $client->payment_date = date('Y-m-d');
        $client->update();
        
        Session::put('type', 'Client');
        User::sendPurchaseSuccessEmail();
        return response()->json(['text'=>'success','userName' => Auth::user()->name, 'date' => date('M d,Y', strtotime("+1 months", strtotime(date('Y-M-d'))))]);
    }

    public function cancelPurchaseplan()
    {
        $client = Auth::user()->client;
        $user = Auth::user();

        try {
            $user->subscription('default')->cancelNow();
        } catch (\Exception $e) {
            return response()->json(['text'=>'fail', 'error'=>$e->getMessage()]);
        }

        return response()->json(['success'=>'Successed.']);
    }
}
