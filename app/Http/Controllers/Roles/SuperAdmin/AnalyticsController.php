<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Billing\BoughtPackages;
use App\Models\Roles\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    /**
     * Show the analytics page content.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke(): View
    {
        $admins = Admin::all();

        // 1. Number of service providers
        // 2. Number of clients
        // 2. Number of packages created (number of packages sold)
        // 3. Total earnings made by selling packages.
        // 4. Total earnings of all providers.
        // 5. Total sessions made

        $admins->map(function (Admin $admin) {
            $providers = DB::table('providers')->where('admin_id', $admin->id)->count();
            $clients = DB::table('clients')
                ->join('providers', 'clients.provider_id', '=', 'providers.id')
                ->where('providers.admin_id', $admin->id)
                ->count();

            $packages = DB::table('packages')->where('admin_id', $admin->id)->count();
            $package_earnings = DB::table(app(BoughtPackages::class)->getTable())
                ;
        });

        return view('roles.super-admin.analytics', compact('providers'));
    }
}
