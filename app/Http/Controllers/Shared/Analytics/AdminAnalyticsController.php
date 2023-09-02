<?php

namespace App\Http\Controllers\Shared\Analytics;

use App\Concerns\Analytics\ParsesAdmin;
use App\Http\Controllers\Controller;
use App\Models\Roles\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminAnalyticsController extends Controller
{
    use ParsesAdmin;

    /**
     * Show stats for all admins.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->isSuperAdmin(), Response::HTTP_FORBIDDEN);

        $admins = Admin::all()->map(fn (Admin $admin) => static::getAdminStats($admin));

        return view('roles.shared.analytics.admin.index', compact('admins'));
    }

    /**
     * Show stats for all admins.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return  \Illuminate\View\View
     */
    public function packages(Request $request, Admin $admin): View
    {
        $user = $request->user();
        abort_unless($user->isSuperAdmin(), Response::HTTP_FORBIDDEN);

        return view('roles.shared.analytics.admin.packages', [
            'packages' => static::getAdminPackages($admin)
        ]);
    }
}
