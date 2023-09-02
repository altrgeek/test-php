<?php

namespace App\Mail\Transaction;

use App\Models\Billing\Order as BillingOrder;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use SerializesModels;

    /**
     * The order that was created
     *
     * @var \App\Models\Billing\Order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(BillingOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
