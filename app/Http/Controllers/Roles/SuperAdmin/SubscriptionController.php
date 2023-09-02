<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Billing\Transaction;
use App\Models\Subscriptions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Yaml;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.super-admin.subscriptions', [
            'subscriptions' => Subscriptions::all()->except('user_id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name'        => ['required', 'string', 'min:5', 'max:50'],
            'description' => ['required', 'string', 'min:20', 'max:255'],
            'price'       => ['required', 'integer', 'min:50'],
            'number'      => ['required', 'integer'],
            'duration'    => ['required', 'string'],
            'providers'   => ['required', 'integer']
        ];

        $options = Yaml::parseFile(resource_path('data/subscription.yaml'));
        $features = collect($options['features']['available']);
        $features = $features->mapWithKeys(fn (array $feature) => [$feature['label'] => ['filled']]);

        $request->validate(array_merge($rules, $features->toArray()));

        $duration = $request->number . '-' . $request->duration;

        $caps = $features
            ->keys()
            ->map(fn (string $key) => $request->has($key) ? $key : null)
            ->filter();

        Subscriptions::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'duration'    => $duration,
            'providers'   => $request->providers,
            'meta'        => [
                'caps' => [
                    'available' => $caps
                ]
            ],
        ]);

        return redirect()
            ->route('super_admin.dashboard.subscriptions')
            ->with('created', 'Subscription has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::where('subscriptions_id', $id)->with('subscriptions')->get();

        return view('roles.super-admin.payments.subscription_payments', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscriptions  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriptions $subscription)
    {
        $rules = [
            'name' => ['string', 'min:5', 'max:50'],
            'description' => ['string', 'min:20', 'max:255'],
            'price' => ['integer'],
            'number' => ['integer'],
            'duration' => ['string'],
            'providers' => ['integer']
        ];

        $options = Yaml::parseFile(resource_path('data/subscription.yaml'));
        $features = collect($options['features']['available']);
        $features = $features->mapWithKeys(fn (array $feature) => [$feature['label'] => ['filled']]);

        $request->validate(array_merge($rules, $features->toArray()));

        //concatenating the number and the duration before updating
        $duration = $request->number . '-' . $request->duration;

        $caps = $features
            ->keys()
            ->map(fn (string $key) => $request->has($key) ? $key : null)
            ->filter()
            ->values();

        $meta = $subscription['meta'];
        Arr::set($meta, 'caps.available', $caps);

        $subscription->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $duration,
            'providers' => $request->providers,
            'meta' => $meta
        ]);

        return redirect()
            ->route('super_admin.dashboard.subscriptions')
            ->with('updated', 'The subscription has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subscriptions::where('id', $id)->delete();

        return redirect()->route('super_admin.dashboard.subscriptions')
            ->with('deleted', 'The subscription has been deleted');
    }
}
