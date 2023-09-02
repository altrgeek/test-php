<?php

namespace App\Http\Controllers\Roles\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display the client dashboard
     *
     * @return \Illuminate\View\View
     */
    public function dashboard(): View
    {
        return view('roles.client.dashboard');
    }
}
