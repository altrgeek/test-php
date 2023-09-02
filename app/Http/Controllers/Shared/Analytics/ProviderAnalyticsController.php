<?php

namespace App\Http\Controllers\Shared\Analytics;

use App\Concerns\Analytics\ParsesProvider;
use App\Http\Controllers\Controller;
use App\Models\Roles\Admin;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProviderAnalyticsController extends Controller
{
    use ParsesProvider;

    public function index(Request $request)
    {
        $user = $request->user();
        $this->verify($user);

        $admin_id = $request->query('admin');

        $providers = match ($user->getRole()) {
            'super_admin' => $admin_id ? Provider::where('admin_id', $admin_id) : Provider::query(),
            'admin' => $user->admin->providers(),
        };

        return view('roles.shared.analytics.provider.index', [
            'providers' => $providers
                ->get()
                ->map(fn (Provider $provider) => static::getProviderStats($provider))
        ]);
    }

    public function earnings(Request $request, Provider $provider)
    {
    }

    public function sessions(Request $request, Provider $provider)
    {
        $user = $request->user();
        $this->verify($user, $provider);

        return view('roles.shared.analytics.provider.sessions', [
            'sessions' => static::getProviderSessions($provider)
        ]);
    }

    public function therapies(Request $request, Provider $provider)
    {
        $user = $request->user();
        $this->verify($user, $provider);

        return view('roles.shared.analytics.provider.therapies', [
            'therapies' => static::getProviderTherapies($provider)
        ]);
    }


    /**
     * Verify if the passed user can view the specified provider or can list out
     * users.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Roles\Provider|null  $provider
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function verify(User $user, Provider $provider = null): void
    {
        $user->load(['superAdmin', 'admin']);

        // Check if the user has listing privileges
        abort_unless(
            $user->isSuperAdmin() || $user->isAdmin(),
            Response::HTTP_FORBIDDEN,
        );

        // No concrete provider instance provided
        if (!$provider)
            return;

        // Check if the user can view the specified provider's details
        abort_unless(
            $user->isSuperAdmin() ||
                ($user->isAdmin() && $provider->admin_id == $user->admin->id),
            Response::HTTP_FORBIDDEN,
        );
    }
}
