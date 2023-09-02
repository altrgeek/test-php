<?php

namespace App\Http\Controllers\Roles\Admin;

use Illuminate\View\View;
use App\Traits\Subscription;
use Illuminate\Http\Request;
use App\Models\Subscriptions;
use App\Models\Billing\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Billing\Subscription as BillingSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubscriptionsController extends Controller
{
    use Subscription;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $subscriptions = Subscriptions::all();

        $user = Auth::user();

        $subscription_id = BillingSubscription::where('admin_id', $user->admin->id)
        ->value('subscriptions_id');

        return view('roles.admin.subscriptions.index', compact('subscriptions', 'subscription_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::where('subscriptions_id', $id)
        ->with('subscriptions')
        ->get();

        return view('roles.admin.payments.subscription_payment', compact('transaction'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subscribe_id' => ['required'],
            'subscribe_name' => ['required'],
            'subscribe_price' => ['required'],
            'subscribe_duration_number' => ['required'],
            'subscribe_duration' => ['required']
        ]);

        $this->StripeCustomer($request);

        $duration = now()->addHour();

        if ($request['subscribe_duration'] === "Days") {
            $duration = now()->addDays($request['subscribe_duration_number']);
        } elseif ($request['subscribe_duration'] === "Months") {
            $duration = now()->addMonths($request['subscribe_duration_number']);
        } elseif ($request['subscribe_duration'] === "Years") {
            $duration = now()->addYears($request['subscribe_duration_number']);
        }

        Subscriptions::findOrFail($request['subscribe_id'])
            ->update([
                'expires_at' => $duration,
            ]);

        $user = $request->user();

        BillingSubscription::create([
            'admin_id' => $user->admin->id,
            'subscriptions_id' => $request['subscribe_id'],
            'name' => $request['subscribe_name'],
            'price' => $request['subscribe_price'],
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'subscriptions_id' => $request['subscribe_id'],
            'transaction_id' => Str::orderedUuid(),
            'amount' => $request['subscribe_price']
        ]);


        return redirect()->route('admin.dashboard.subscriptions')
            ->with('created', 'You have subscribed to the ' . $request['subscribe_name'] . ' subscription');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
