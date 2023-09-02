<?php

namespace App\Http\Controllers\Roles\Provider;

use App\Concerns\Analytics\ParsesClient;
use App\Http\Controllers\Controller;
use App\Models\Billing\Order;
use App\Models\Billing\Transaction;
use App\Models\Roles\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    use ParsesClient;

    /**
     * Show the analytics page content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request): View
    {
        $provider = $request->user()->provider;
        $provider->load(['clients' => ['user']]);

        $clients = $provider
            ->clients
            ->map(function (Client $client) {
                return static::getClientStats($client);
            });

        return view('roles.shared.analytics.client.index', compact('clients'));
    }

    /**
     * Show the analytics page content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function sessions(Request $request): View
    {
        $provider = $request->user()->provider;
        $provider->load(['clients' => ['appointments' => ['order']]]);

        $sessions = $provider
            ->clients
            ->map(function (Client $client) {
                return static::getClientSessions($client);
            });

        return view('roles.shared.analytics.client.sessions', compact('sessions'));
    }

    /**
     * Show the analytics page content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function packages(Request $request): View
    {
        $provider = $request->user()->provider;
        $provider->load(['clients' => ['bought_packages' => ['packages']]]);

        $packages = $provider
            ->clients
            ->map(function (Client $client) {
                return static::getClientPackages($client);
            });

        return view('roles.shared.analytics.client.packages', compact('packages'));
    }
}
