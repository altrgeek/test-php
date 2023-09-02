<?php

namespace App\Traits;

use Exception;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

trait RedirectsToDashboard
{
    /**
     * Redirect the user to their dashboard according to appropriate role
     *
     * @param \App\Models\User  $user
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToDashboard(Request $request, User $user): RedirectResponse
    {
        if ($user->isSuperAdmin())
            return redirect()->route('super_admin.dashboard');
        else if ($user->isAdmin())
            return redirect()->route('admin.dashboard');
        else if ($user->isProvider())
            return redirect()->route('provider.dashboard');
        else if ($user->isClient())
            return redirect()->route('client.dashboard');

        throw new Exception('No dashboard defined for current user!');
    }
}
