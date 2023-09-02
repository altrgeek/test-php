<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billing\Transaction;
use App\Models\Packages;

class PackagesController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        return view('roles.super-admin.payments.package_payment', compact('transaction'));
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
        $request->validate([
            'title' => ['required', 'string'],
            'sessions' => ['required', 'numeric'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
        ]);

        $user = $request->user();

        $user->packages()->where([
            'id' => $request->package_id,
            'user_id' => $user->id,
            'admin_id' => $user->admin->id,
        ])->update([
            'title' => $request['title'],
            'sessions' => $request['sessions'],
            'description' => $request['description'],
            'price' => $request['price'],
        ]);

        return redirect()->route('admin.dashboard.packages')
        ->with('updated', 'The Package has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Packages::where('id', $id)->delete();

        return redirect()->route('admin.dashboard.packages')
        ->with('deleted', 'The package has been deleted');
    }
}
