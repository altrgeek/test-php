<?php

namespace App\Mail\Order;

use App\Models\Billing\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Cancelled extends Mailable
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
    public function __construct(Order $order)
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
