<?php

namespace App\Traits\Roles;

use Exception;

trait HasValidators
{
    /**
     * Match user's role with predefined set of roles.
     *
     * @return string;
     */
    public function getRole(): string
    {
        if ($this->hasRole('super_admin'))
            return 'super_admin';
        else if ($this->hasRole(['admin', 'local_admin']))
            return 'admin';
        else if ($this->hasRole(['provider', 'service_provider']))
            return 'provider';
        else if ($this->hasRole(['client']))
            return 'client';
        else if ($this->hasRole(['user', 'guest']))
            return 'user';

        throw new Exception('The user does not have a valid role!');
    }

    public function isSuperAdmin(): bool
    {
        return $this->getRole() === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->getRole() === 'admin';
    }

    public function isProvider(): bool
    {
        return $this->getRole() === 'provider';
    }

    public function isServiceProvider(): bool
    {
        return $this->isProvider();
    }

    public function isClient(): bool
    {
        return $this->getRole() === 'client';
    }

    public function isUser(): bool
    {
        return $this->getRole() === 'user';
    }

    public function isGuest(): bool
    {
        return $this->isUser();
    }
}
