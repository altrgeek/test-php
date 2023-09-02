<?php

namespace App\Http\Controllers\Roles\Provider;

use App\Models\ArVr;
use Illuminate\View\View;
use App\Models\ArVroptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderController extends Controller
{
    /**
     * Load the admin dashboard with birds-eye view of all registered users on
     * Cogni platform
     *
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request): View
    {
        // Get current provider's record
        $provider = $request->user()->provider;

        // Grab only number of rows from database
        $clients = $provider->clients()->count();

        return view('roles.provider.dashboard', compact('clients'));
    }
}
