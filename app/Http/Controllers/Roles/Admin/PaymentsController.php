<?php

namespace App\Http\Controllers\Roles\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billing\BoughtPackages;
use App\Models\Billing\Order;
use App\Models\Billing\Subscription;
use App\Models\Billing\Transaction;
use App\Models\Roles\Client;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(10);

        $admin = Auth::user()->admin;

        $subscriptions = Subscription::where('admin_id', $admin->id)->get();

        $clients = Client::value('id');

        $bought_packages = BoughtPackages::where(['client_id' => $clients])->get();

        return view('roles.admin.payments.payments', compact('orders', 'subscriptions', 'bought_packages'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::where('order_id', $id)->with('order')->get();

        return view('roles.admin.payments.payments_details', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
