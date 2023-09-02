<?php

namespace App\Http\Controllers\Roles\Client;

use App\Http\Controllers\Controller;
use App\Models\Billing\BoughtPackages;
use App\Models\Billing\Transaction;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\Subscription;
use illuminate\Support\Str;

class PackagesController extends Controller
{
    use Subscription;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Auth::user()->client->provider->admin;

        $packages = Packages::where(['admin_id' => $admins->id])->get();
        // dd($packages);

        return view('roles.client.packages.packages', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'package_id' => ['required', 'numeric'],
            'package_title' => ['required', 'string'],
            'package_sessions' => ['required', 'numeric'],
            'package_price' => ['required', 'numeric'],
        ]);

        $this->StripeCustomer($request);

        $user = $request->user();

        $bought_packages = $user->bought_packages()
        ->create([
            'user_id' => $user->id,
            'client_id' => $user->client->id,
            'packages_id' => $request->package_id,
            'uid' => Str::orderedUuid(),
            'title' => $request->package_title,
            'amount' => $request->package_price,
            'sessions' => $request->package_sessions,
        ]);

        $user->transactions()
        ->create([
            'user_id' => $user->id,
            'bought_packages_id' => $bought_packages->id,
            'transaction_id' => Str::orderedUuid(),
            'amount' => $bought_packages->amount,
        ]);

        return redirect()->route('client.dashboard.packages')
        ->with('created', 'You have bought the '.$bought_packages->title.' package');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::where('bought_packages_id', $id)->with('bought_packages')->get();

        return view('roles.client.payments.package_payment', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
