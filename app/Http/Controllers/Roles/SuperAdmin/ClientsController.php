<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Roles\Client;

use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index(): View
    {
        return view('roles.super-admin.clients', [
            'clients' => Client::all()->map(function (Client $client) {
                return $client->user;
            }),
        ]);
    }
}
