<?php

namespace App\Http\Controllers\Shared\Analytics;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BaseAnalyticsController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        $route = match ($user->getRole()) {
            'super_admin' => 'dashboard.analytics.admins',
            'admin' => 'dashboard.analytics.providers',
            'provider' => 'dashboard.analytics.clients',
            'default' => 'login'
        };

        return redirect()->route($route);
    }
}
