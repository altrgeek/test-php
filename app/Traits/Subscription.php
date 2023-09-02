<?php

namespace App\Traits;

use Stripe\Stripe as StripeStripe;
use illuminate\Support\Str;
trait Subscription
{
    public function StripeCustomer($request)
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        StripeStripe::setApiKey(config('stripe.keys.secret_key'));

        $customer = \Stripe\Customer::create([
            'address' => [
                'line1' => $request->user()->address,
                'line2' => $request->user()->address,
            ],

            'email' => $request->user()->email,
            'name' => $request->user()->name,
            'phone' => $request->user()->phone,

        ]);

        $customer_id = $customer->id;

        return $this->StripeCharge($customer_id, $request);
    }

    public function StripeCharge($customer_id, $request)
    {
        if ($request['subscribe_price']) {
            $amount = $request['subscribe_price'];

        } elseif ($request['appointment_order_amount']) {
            $amount = $request['appointment_order_amount'];

        } elseif ($request['package_price']) {
            $amount = $request['package_price'];
        }

        $intent = \Stripe\Charge::create([
            'amount' => $amount * 100, // Convert dollar into cents,
            'currency' => 'usd',
            'source' => $request['stripeSource'], // A source token created from stripe.js while submitting the form
            'customer' => $customer_id,
        ], [
            'idempotency_key' => Str::orderedUuid(),
        ]);

        return $intent;
    }
}
