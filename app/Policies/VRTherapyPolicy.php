<?php

namespace App\Policies;

use App\Models\Therapies\VRTherapy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VRTherapyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): Response|bool
    {
        return true;

        return ($user->isSuperAdmin() || $user->isAdmin() || $user->isProvider())
            ? Response::allow()
            : Response::deny('Only admin or providers can create therapies!');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Therapies\VRTherapy  $therapy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, VRTherapy $therapy): Response|bool
    {
        // Super admin can do anything
        if ($user->isSuperAdmin()) return Response::allow();

        $provider = $therapy->provider;

        // The current user is an admin and the provider who offers this
        // therapy is created by this admin
        if (
            $user->isAdmin() &&
            $user->admin->providers()->find($provider->id)
        )
            return Response::allow();

        // The current user is a provider and this therapy was created for them
        if ($user->isProvider() && $user->provider->id === $provider->id)
            return Response::allow();

        return Response::deny('You cannot edit this therapy!');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Therapies\VRTherapy  $therapy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, VRTherapy $therapy): Response|bool
    {
        // Super admin can do anything
        if ($user->isSuperAdmin()) return Response::allow();

        $provider = $therapy->provider;

        // The current user is an admin and the provider who offers this
        // therapy is created by this admin
        if (
            $user->isAdmin() &&
            $user->admin->providers()->find($provider->id)
        )
            return Response::allow();

        // The current user is a provider and this therapy was created for them
        if ($user->isProvider() && $user->provider->id === $provider->id)
            return Response::allow();

        return Response::deny('You cannot edit this therapy!');
    }
}
