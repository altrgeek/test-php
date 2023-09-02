<?php

namespace App\Http\Controllers\Roles\Admin;

use App\Concerns\Analytics\ParsesProvider;
use App\Http\Controllers\Controller;
use App\Models\Appointments\ClientProviderAppointment;
use App\Models\Roles\Provider;
use App\Models\Therapies\VRTherapy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    use ParsesProvider;

    /**
     * Show the analytics page content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request): View
    {
        $admin = $request->user()->admin;

        $providers = $admin
            ->providers
            ->map(function (Provider $provider) {
                return static::getProviderStats($provider);
            });

        return view('roles.shared.analytics.admin.index');
    }
}
