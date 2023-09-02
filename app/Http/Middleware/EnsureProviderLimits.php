<?php

namespace App\Http\Middleware;

use App\Models\Subscriptions;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureProviderLimits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $user = $request->user();

        // Only super-admin and admins can create providers!
        if (!$user->isSuperAdmin() && !$user->isAdmin())
            return redirect('/')
                ->with('message', 'You do not have permissions for provider management!');

        // Validation for admins only, super-admin can bypass this validation
        if ($user->isAdmin()) {
            $admin = $user->admin;

            $active_subscription = $admin
                ->subscription()
                // Base subscription created by super admin
                // ->with('subscriptions')
                ->first();

        $subscriptions = Subscriptions::findOrFail($active_subscription->subscriptions_id);

            // Admin does not have any active subscription
            if (!$active_subscription)
                return redirect()
                    ->route('admin.dashboard')
                    ->with('message', 'You need to first buy a subscription before managing providers!');

            // Get the max allowed providers count from base subscription
            $max_allowed_providers = $subscriptions
                ->providers ?? 0;

            // Get current providers count
            $current_providers_count = $admin->providers()->count();

            // Admin has reached the limit of maximum providers their plan offers
            if ($current_providers_count >= (int) $max_allowed_providers)
                return redirect()
                    ->back()
                    ->with('message', sprintf('You have reached your limit of %s providers! Please upgrade your plan to register more providers'));
        }

        return $next($request);
    }
}
