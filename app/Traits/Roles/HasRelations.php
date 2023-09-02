<?php

namespace App\Traits\Roles;

use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Roles\{Admin, Client, Provider, SuperAdmin};
use Exception;

trait HasRelations
{

    /**
     * Loads appropriate role based on associated user role
     *
     * @throws \Exception
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role(): HasOne
    {
        if ($this->isSuperAdmin())
            return $this->superAdmin();
        else if ($this->isAdmin())
            return $this->admin();
        else if ($this->isProvider())
            return $this->provider();
        else if ($this->isClient())
            return $this->client();

        throw new Exception('User does not have a dynamic role!');
    }

    /**
     * A user record could be a super-admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function superAdmin(): HasOne
    {
        return $this->hasOne(SuperAdmin::class);
    }

    /**
     * A user record could be an admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * A user record could be a provider
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class);
    }

    /**
     * A user record could be a client
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }
}
