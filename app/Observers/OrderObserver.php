<?php

namespace App\Observers;

use Exception;
use Illuminate\Support\Str;
use App\Models\Billing\Order;
use App\Models\Roles\SuperAdmin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Order\Created as OrderCreated;
use App\Mail\Order\Cancelled as OrderCancelled;
use App\Mail\Order\Completed as OrderCompleted;
use App\Mail\Transaction\Order as OrderNotification;

class OrderObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Billing\Order  $order
     * @return void
     */
    public function creating(Order $order)
    {
        $order->uid = Str::orderedUuid();
        return $order;
    }

    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Billing\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $client = $order->client->user;


        try {
            Mail::to($client->email)->send(new OrderCreated($order, $client));
        } catch (Exception $error) {
            Log::critical('Could not send order creation email!', [
                'id' => $order->uid,
                'email' => $client->email,
                'error' => $error->getMessage(),
            ]);
        }
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Billing\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        // Send order cancelled email to provider
        if ($order->status === 'cancelled') {
            $email = $order
                ->appointment()
                ->with(['provider']) // For reducing DB queries
                ->provider
                ->user
                ->email;
            try {
                Mail::to($email)->send(new OrderCancelled($order));
            } catch (Exception $error) {
                Log::critical('Could not send order completion email to client!', [
                    'order' => $order->uid,
                    'email' => $email,
                    'error' => $error->getMessage()
                ]);
            }
        }
        // Notify client, provider and super admin about order completion
        elseif ($order->status === 'paid') {
            // Gent client and provider references
            $client = $order->client->user;
            $provider = $order->appointment->provider->user;

            // Notify client and provider about order completion
            Mail::to($client->email)->send(new OrderCompleted($order, $client));
            Mail::to($provider->email)->send(new OrderCompleted($order, $client));

            // Send email notification to super admins about order completion
            $this->notifySuperAdmins($order);
        }
    }

    /**
     * Sends email notification to super admins about successful payment of the
     * order
     *
     * @param \App\Models\Billing\Order
     *
     * @return void
     */
    protected function notifySuperAdmins(Order $order)
    {
        $emails = SuperAdmin::all()->map(function (SuperAdmin $super_admin) {
            return $super_admin->user()->email;
        });

        try {
            Mail::to($emails)->send(new OrderNotification($order));
        } catch (Exception $error) {
            Log::critical('Could not send order completion mail to super admins!', [
                'id' => $order->uid,
                'error' => $error->getMessage(),
                'recipients' => $emails
            ]);
        }
    }
}
