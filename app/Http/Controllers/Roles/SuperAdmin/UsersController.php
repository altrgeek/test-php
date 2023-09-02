<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Roles\Admin;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(Request $request): View
    {
        // Clients for specific provider are requested, load all clients for
        // the specified provider only
        if ($request->has('provider_id') && is_numeric($request->input('provider_id'))) {
            $request->validate([
                'provider_id' => ['required', 'numeric', Rule::exists('providers', 'id')]
            ]);

            // Get all clients (roles) of the specified provider
            $users = Provider::with(['clients'])
                ->findOrFail($request->input('provider_id'))
                ->clients;
        }

        // Providers for specific admin are requested, load all providers for
        // the specified admin only
        else if ($request->has('admin_id') && is_numeric($request->input('admin_id'))) {
            $request->validate([
                'admin_id' => ['required', 'numeric', Rule::exists('admins', 'id')]
            ]);

            // Get all providers (roles) of the specified provider
            $users = Admin::with(['providers'])
                ->findOrFail($request->input('admin_id'))
                ->providers;
        }

        // No role specific user accounts are requested, load all roles with
        // users
        else {
            $users = User::all()
                // Remove super-admin records
                ->filter(fn ($user) => !$user->isSuperAdmin())
                // Grab role of the user
                ->map(fn ($user) => $user->role);
        }

        return view('roles.super-admin.users', [
            'users'  => $users,
            'admins' => Admin::with(['providers'])->get()
        ]);
    }
}
