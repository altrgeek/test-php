<?php

namespace App\Http\Controllers\Roles\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billing\BoughtPackages;
use App\Models\Billing\Order;
use App\Models\Billing\Transaction;
use App\Models\Roles\Client;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client = Auth::user()->client;

        $orders = Order::where(['client_id' => $client->id])->paginate(10);

        // $clients = Client::with('bought_packages')->findOrFail($client->id);
        $bought_packages = BoughtPackages::where(['client_id' => $client->id])->get();

        return view('roles.client.payments.payments', compact('orders', 'bought_packages'));
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

        return view('roles.client.payments.payments_details', compact('transaction'));
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
