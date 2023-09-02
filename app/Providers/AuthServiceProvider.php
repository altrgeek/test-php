<?php

namespace App\Providers;

use App\Models\Therapies\VRTherapy;
use App\Models\User;
use App\Policies\VRTherapyPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        VRTherapy::class => VRTherapyPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('access-bookings', function (User $user) {
            if ($user->isSuperAdmin()) return true;

            // Super-admin has bought a subscription and has permission to view bookies
            if ($user->isAdmin())
                return $user->admin->subscription && $user->admin->subscription->availableCaps->contains('cogni-meet');


            if ($user->isProvider()) {
                $admin = $user->provider->admin;
                return $admin->subscription && $admin->subscription->availableCaps->contains('cogni-meet');
            }

            if ($user->isClient()) {
                $admin = $user->client->provider->admin;
                return $admin->subscription && $admin->subscription->availableCaps->contains('cogni-meet');
            }

            return false;
        });

        Gate::define('manage-subscriptions', function (User $user) {
            // if ($user->isSuperAdmin()) return true;

            // // Super-admin has bought a subscription and has permission to view bookies
            // if ($user->isAdmin())
            //     return $user->admin->subscription && $user->admin->subscription->availableCaps->contains('subscriptions');


            // if ($user->isProvider()) {
            //     $admin = $user->provider->admin;
            //     return $admin->subscription && $admin->subscription->availableCaps->contains('subscriptions');
            // }

            // if ($user->isClient()) {
            //     $admin = $user->client->provider->admin;
            //     return $admin->subscription && $admin->subscription->availableCaps->contains('subscriptions');
            // }

            // return false;
            return true;
        });

        Gate::define('access-chatting', function (User $user) {
            if ($user->isSuperAdmin()) return true;

            // Super-admin has bought a subscription and has permission to view bookies
            if ($user->isAdmin())
                return $user->admin->subscription && $user->admin->subscription->availableCaps->contains('chatting');


            if ($user->isProvider()) {
                $admin = $user->provider->admin;
                return $admin->subscription && $admin->subscription->availableCaps->contains('chatting');
            }

            if ($user->isClient()) {
                $admin = $user->client->provider->admin;
                return $admin->subscription && $admin->subscription->availableCaps->contains('chatting');
            }

            return false;
        });

        Gate::define('access-therapies', function (User $user) {
            if ($user->isSuperAdmin()) return true;

            // Super-admin has bought a subscription and has permission to view bookies
            if ($user->isAdmin())
                return $user->admin->subscription && $user->admin->subscription->availableCaps->contains('cogni-xr');


            if ($user->isProvider()) {
                $admin = $user->provider->admin;
                return $admin->subscription && $admin->subscription->availableCaps->contains('cogni-xr');
            }

            if ($user->isClient()) {
                $admin = $user->client->provider->admin;
                return $admin->subscription && $admin->subscription->availableCaps->contains('cogni-xr');
            }

            return false;
        });
    }
}
