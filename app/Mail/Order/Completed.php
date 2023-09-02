<?php

namespace App\Mail\Order;

use App\Models\Billing\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Completed extends Mailable
{
    use SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        public Order $order,
        public User $customer
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
        return $this->view('view.name');
    }
}
