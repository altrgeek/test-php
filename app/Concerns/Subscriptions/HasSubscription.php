<?php

namespace App\Concerns\Subscriptions;

use App\Models\Billing\Subscription;
use App\Models\Packages;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasSubscription
{
    protected function plan(): Attribute
    {
        return Attribute::make(
            function (): Subscription|Packages|null {
                return match ($this->getRole()) {
                    'admin' => $this->subscription,
                    'client' => $this->bought_packages->first(),
                    default => null
                };
            }
        )->withoutObjectCaching();
    }
}
