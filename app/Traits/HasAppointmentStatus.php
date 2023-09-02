<?php

namespace App\Traits;

use App\Models\Appointments\AdminProviderAppointment;
use App\Models\Appointments\AdminSuperAdminAppointment;
use App\Models\Appointments\ClientProviderAppointment;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\User;
use BadMethodCallException;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

trait HasAppointmentStatus
{
    // declined      The appointment has been declined
    // booked        The appointment has been created but not reviewed yet
    // reviewed      Reviewed and waiting for payment form the client
    // pending       Paid by client, scheduled for start time
    // completed     Session was completed

    public function isDeclined(): bool
    {
        return $this->status === "declined";
    }

    public function isBooked(): bool
    {
        return $this->status === "booked";
    }

    public function isReviewed(): bool
    {
        return $this->status === "reviewed";
    }

    public function isPending(): bool
    {
        return $this->status === "pending";
    }

    public function isCompleted(): bool
    {
        return $this->status === "completed";
    }

    public function isPaid(): bool
    {
        // Will throw an error if called other than client-provider appointment
        return $this->order?->status === 'paid';
    }

    public function getMeetingUrl(): string
    {
        return route('dashboard.session.join', [
            'token' => Crypt::encrypt([
                'meeting' => [
                    'id' => $this->uid,
                    'type' => get_class($this)
                ]
            ])
        ]);
    }

    /**
     * Return the user who requested (created) this appointment.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function requester(): Attribute
    {
        return Attribute::get(function (): User {
            // If the appointment is between admin and super-admin then check the roles
            if ($this instanceof AdminSuperAdminAppointment) {
                if ($this->requested_by === 'super_admin')
                    return $this->superAdmin->user;

                return $this->admin->user;
            }

            // If the appointment is between admin and provider then check the roles
            elseif ($this instanceof AdminProviderAppointment) {
                if ($this->requested_by === 'admin')
                    return $this->admin->user;

                return $this->provider->user;
            }

            // If the appointment is between provider and client then check the roles
            elseif ($this instanceof ClientProviderAppointment) {
                if ($this->requested_by === 'provider')
                    return $this->provider->user;

                return $this->client->user;
            }
            throw new BadMethodCallException('The requester method can only be called on appointment instances!');
        });
    }

    /**
     * Return the user who received this appointment (inverse of requester).
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function receiver(): Attribute
    {
        return Attribute::get(function (): User {
            // If the appointment is between admin and super-admin then check the roles
            if ($this instanceof AdminSuperAdminAppointment) {
                if ($this->requested_by === 'super_admin')
                    return $this->admin->user;

                return $this->superAdmin->user;
            }

            // If the appointment is between admin and provider then check the roles
            elseif ($this instanceof AdminProviderAppointment) {
                if ($this->requested_by === 'admin')
                    return $this->provider->user;

                return $this->admin->user;
            }

            // If the appointment is between provider and client then check the roles
            elseif ($this instanceof ClientProviderAppointment) {
                if ($this->requested_by === 'provider')
                    return $this->client->user;

                return $this->provider->user;
            }

            throw new BadMethodCallException('The requester method can only be called on appointment instances!');
        });
    }

    /**
     * The appointment end time.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function end(): Attribute
    {
        return Attribute::get(function ($value, $attributes): Carbon {
            return carbon($attributes['start'])->addSeconds($attributes['duration']);
        });
    }

    /**
     * The appointment resource's `show` route.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    public function getShowRouteName(User $user): string
    {
        $route = 'login';

        // We are checking for every possible role
        if ($this instanceof AdminSuperAdminAppointment) {
            if ($user->isSuperAdmin())
                $route = 'super_admin.dashboard.appointments.show';

            elseif ($user->isAdmin())
                $route = 'admin.dashboard.appointments.super_admin.show';
        } elseif ($this instanceof AdminProviderAppointment) {
            if ($user->isAdmin())
                $route = 'admin.dashboard.appointments.provider.show';

            elseif ($user->isProvider())
                $route = 'provider.dashboard.appointments.admin.show';
        } elseif ($this instanceof ClientProviderAppointment) {
            if ($user->isProvider())
                $route = 'provider.dashboard.appointments.client.show';
            elseif ($user->isClient())
                $route = 'client.dashboard.appointments.show';
        }

        return $route;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function bootHasAppointmentStatus()
    {
        static::creating(function (Model $model) {
            $model->ends_at =
                $model->ends_at ?:
                $model->start->addSeconds($model->duration);
        });
    }

    /**
     * Get the list of participants of current session.
     *
     * @return \Illuminate\Support\Collection
     *
     * @throws \Exception
     */
    public function getParticipants(): Collection
    {
        $participants = [];

        if ($this instanceof AdminSuperAdminAppointment) {
            $participants = [
                $this
                    ->superAdmin()
                    ->with(['user' => function ($query) {
                        $query->select(['id', 'name', 'avatar']);
                    }])
                    ->first()
                    ->user,
                $this
                    ->admin()
                    ->with(['user' => function ($query) {
                        $query->select(['id', 'name', 'avatar']);
                    }])
                    ->first()
                    ->user,
            ];
        } elseif ($this instanceof AdminProviderAppointment) {
            $participants = [
                $this
                    ->admin()
                    ->with(['user' => function ($query) {
                        $query->select(['id', 'name', 'avatar']);
                    }])
                    ->first()
                    ->user,
                $this
                    ->provider()
                    ->with(['user' => function ($query) {
                        $query->select(['id', 'name', 'avatar']);
                    }])
                    ->first()
                    ->user,
            ];
        } elseif ($this instanceof ClientProviderAppointment) {
            $participants = [
                $this
                    ->client()
                    ->with(['user' => function ($query) {
                        $query->select(['id', 'name', 'avatar']);
                    }])
                    ->first()
                    ->user,
                $this
                    ->provider()
                    ->with(['user' => function ($query) {
                        $query->select(['id', 'name', 'avatar']);
                    }])
                    ->first()
                    ->user,
            ];
        } else {
            throw new Exception(
                'The method [getParticipants] method of [HasAppointmentStatus] trait must be called on a valid appointment/meeting instance!'
            );
        }

        return collect($participants);
    }
}
