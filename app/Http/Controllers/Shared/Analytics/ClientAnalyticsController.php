<?php

namespace App\Http\Controllers\Shared\Analytics;

use App\Concerns\Analytics\ParsesClient;
use App\Http\Controllers\Controller;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientAnalyticsController extends Controller
{
    use ParsesClient;

    public function index(Request $request)
    {
        $user = $request->user();
        $this->verify($user);

        $provider_id = $request->query('provider');

        $clients = match ($user->getRole()) {
            'super_admin' => $provider_id ? Client::where('provider_id', $provider_id) : Client::query(),
            'admin' => $provider_id ? Client::where('provider_id', $provider_id) : $user->admin->clients(),
            'provider' => $user->provider->clients(),
        };

        $clients = $clients
            ->get()
            ->map(fn (Client $client) => static::getClientStats($client));

        return view('roles.shared.analytics.client.index', compact('clients'));
    }

    public function sessions(Request $request, Client $client)
    {
        $user = $request->user();
        $this->verify($user, $client);

        return view('roles.shared.analytics.client.sessions', [
            'sessions' => static::getClientSessions($client)
        ]);
    }

    public function packages(Request $request, Client $client)
    {
        $user = $request->user();
        $this->verify($user, $client);

        return view('roles.shared.analytics.client.packages', [
            'packages' => static::getClientPackages($client)
        ]);
    }

    public function spending(Request $request, Client $client)
    {
        $user = $request->user();
        $this->verify($user, $client);

        return view('roles.shared.analytics.client.spending', [
            'transactions' => static::getClientSpending($client)
        ]);
    }

    /**
     * Verify if the passed user can view the specified client or can list out
     * users.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Roles\Client|null  $client
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function verify(User $user, Client $client = null): void
    {
        $user->load(['superAdmin', 'admin', 'provider']);

        // Check if the user has listing privileges
        abort_unless(
            $user->isSuperAdmin() || $user->isAdmin() || $user->isProvider(),
            Response::HTTP_FORBIDDEN,
        );

        // No concrete client instance provided
        if (!$client)
            return;

        // Check if the user can view the specified client's details
        abort_unless(
            $user->isSuperAdmin() ||
                ($user->isAdmin() && $client->provider->admin_id == $user->admin->id) ||
                ($user->isProvider() && $client->provider_id == $user->provider->id),
            Response::HTTP_FORBIDDEN,
        );
    }
}
