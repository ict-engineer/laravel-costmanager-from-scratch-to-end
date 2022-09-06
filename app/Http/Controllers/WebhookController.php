<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\Notifications\InvoicePaid;

class WebhookController extends CashierController
{
    /**
     * Handle payment succeeds.
     *
     * @param  array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleInvoicePaymentSucceeded(array $payload)
    {
        $invoice = $payload['data']['object'];
        $user = $this->getUserByStripeId($invoice['customer']);
        if ($user) {
            $user->notify(new InvoicePaid($invoice));
        }

        return new Response('Webhook Handled', 200);
    }
}