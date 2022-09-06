<?php

namespace App\Http\Controllers\User;

require_once('../vendor/autoload.php');

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Support\Str;
use Session;
use Stripe;
use Exception;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        if(!(Auth::user()->hasRole('Client')))
            return redirect()->route('user.profile');

        if(Auth::user()->hasPermissionTo('Employee Administrative') || Auth::user()->hasPermissionTo('Employee Sales'))
            return redirect()->route('welcome');

        $client = Auth::user()->client;
        $user = Auth::user();
        
        $payment = Payment::find($client->payment);

        $invoice_url = "";
        $firstPayDate = date('M d,Y', $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_start"]);
        $dateStr = date('M d,Y', $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"]);
        $invoices = $user->invoices();
        $invoice_url = $invoices[0]->invoice_pdf;
        $lastfour = Str::substr($client->card_brand, -4, 4);
        return view('user.client.payment.index')->with('nextPay', $dateStr)->with('lastPay', $firstPayDate)->with('invoice', $invoice_url)
            ->with('payment', $payment->name)->with('lastfour', $lastfour);
    }

    public function setPayment(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // $charge = Stripe\Charge::create ([
        //     "amount" => 100 * $request->amount,
        //     "currency" => strtolower($request->currency),
        //     "source" => $request->stripeToken,
        //     "description" => "Payment for membership on laravel.com." 
        // ]);
        $client = Auth::user()->client;

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );   

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
        Auth::user()->deletePaymentMethods();
        Auth::user()->addPaymentMethod($paymentMethod);

        $client->card_brand = $request->cardnumber;
        $client->card_last_four = $request->cvv;
        $client->update();

        $lastfour = Str::substr($client->card_brand, -4, 4);
        return response()->json(['success' => 'Saved Successfully.', 'lastfour' => $lastfour]);
    }
}
