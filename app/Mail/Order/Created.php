<?php

namespace App\Mail\Order;

use App\Models\User;
use App\Models\Billing\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Created extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public Order $order,
        public User $customer,
    ) {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $order->uid (order ID)
        // $order->client->user (Client record)
        // $order->appointment->provider->user (Provider record)
        return $this->view('emails.order.created');
    }
}
