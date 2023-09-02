<?php

namespace App\Concerns\Analytics;

use App\Models\Packages;
use App\Models\Roles\Admin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;

trait ParsesAdmin
{
    public static function getAdminStats(Admin $admin): stdClass
    {
        $admin->load(['user']);

        $id = $admin->id;
        $name = $admin->user->name;
        $providers = $admin->providers()->count();
        $clients =
            DB::table('clients')
            ->join('providers', 'clients.provider_id', '=', 'providers.id')
            ->where('providers.admin_id', '=', $admin->id)
            ->count();
        // $earnings = DB::table('bought_packages')
        //     ->join('packages', 'bought_packages.packages_id', '=', 'packages.id')
        //     ->where('packages.admin_id', '=', 1)
        //     ->sum('amount');
        $earnings =
            DB::table('orders')
            ->join('clients', 'orders.client_id', '=', 'clients.id')
            ->join('providers', 'clients.provider_id', '=', 'providers.id')
            ->where('providers.admin_id', '=', 6)
            ->sum('amount');
        $packages = $admin->packages()->count();
        $joined = $admin->user->created_at;

        return (object) compact(
            'id',
            'name',
            'providers',
            'clients',
            'earnings',
            'packages',
            'joined'
        );
    }

    public static function getAdminPackages(Admin $admin): Collection
    {
        $admin->load(['packages']);

        return $admin
            ->packages
            ->map(function (Packages $package) {
                $name = $package->title;
                $price = $package->price;
                $earnings = $package->bought_packages()->sum('amount');
                $sales = $package->bought_packages()->count();
                $created_at = $package->created_at;

                return (object) compact('name', 'price', 'earnings', 'sales', 'created_at');
            });
    }
}
