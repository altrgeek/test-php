<?php

namespace App\Http\Controllers\Roles\Support;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class Supportpassword extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.support.support-password');
    }
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify_password(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:50'],
        ]);
        if(config('cogni.super_admin_support.password') == $request->password)
        {
            session(['SUPPORTCHECK' => True]);
            return redirect()->route('super_admin.dashboard')->with('created', 'Now you have access to support functionality');
        }
        else{
            return redirect()->back()->with('message', 'Password Incorrect');
        }
      
        
    }
}
