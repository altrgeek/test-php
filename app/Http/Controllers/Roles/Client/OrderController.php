<?php

namespace App\Http\Controllers\Roles\Client;

use Illuminate\Support\Str;
use App\Traits\Subscription;
use Illuminate\Http\Request;
use App\Models\Billing\Order;
use App\Traits\HandlesAppointments;
use App\Http\Controllers\Controller;
use App\Models\Billing\Transaction;

class OrderController extends Controller
{
    use Subscription, HandlesAppointments;
    /**
     * @return Request
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_order_id' => ['required'],
            'appointment_order_amount' => ['required']
        ]);

        $this->StripeCustomer($request);

        $user = $request->user();
        $order = Order::findOrFail($request['appointment_order_id']);

        Transaction::create([
                'user_id' => $user->id,
                'order_id' => $request['appointment_order_id'],
                'transaction_id' => Str::orderedUuid(),
                'amount' => $order->amount
            ]);

        $order->where(['id' => $order->id])
        ->update(['status' => 'paid']);

        $order->appointment->update([
            'status' => 'pending',
        ]);

        return redirect()
            ->route('client.dashboard.appointments')
            ->with('created', 'Your payment has been made successfully');
    }
}
