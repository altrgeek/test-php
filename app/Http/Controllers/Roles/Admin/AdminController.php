<?php

namespace App\Http\Controllers\Roles\Admin;

use Illuminate\View\View;
use App\Models\Roles\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /**
     * Load the admin dashboard with birds-eye view of all registered users on
     * Cogni platform
     *
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request): View
    {
        // Get current admin's record
        $admin = $request->user()->admin;

        // Grab only number of rows from database
        $providers = $admin->providers()->count();
        $clients = $admin->clients()->count();

        // Sum all the models to get total user (except admin)
        $users = $providers + $clients;

        return view('roles.admin.dashboard', compact('providers', 'clients', 'users', 'admin'));
    }
    
     /**
     * Update the branding of admin so that client and provider can see there company branding in the portal
     *
    * @param Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update_branding(Request $request): RedirectResponse
    {
       
        $user = $request->user()->admin;
        $admin = Admin::findOrFail($user->id);
       

        // If a new primary is passed then validate it
        if (isset($request->primary) )
        {
            $validated['primary_color'] = $request->primary;
        }
        if (isset($request->secondary) )
        {
            $validated['secondary_color'] = $request->secondary;
        }
        if (isset($request->text) )
        {
            $validated['text_color'] = $request->text;
        }
        if(isset($request->logo))
        {
            
            $validated['logo'] = $request->file('logo');
            $logo_name = $validated['logo']->getClientOriginalName();
            $ImgUrl = public_path().'/images/';
        
            if(!$validated['logo']->move($ImgUrl, $logo_name)){
                throw new \Exception('File upload failed');
            }
            
            $validated['logo']  = asset('images').'/'.$logo_name;
    
        }
        // dd($validated);
        $admin->update($validated);
        // dd($admin);
        return redirect()
            ->route('admin.dashboard')
            ->with('updated', 'Your Branding was updated!');
    }
    
}
