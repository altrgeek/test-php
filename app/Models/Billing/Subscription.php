<?php

namespace App\Models\Billing;

use App\Models\Roles\Admin;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The table that relates the modal
     */
    protected $table = 'subscription';
    /**
     * The attributes that are mass assignable
     *
     * @var array<string>
     */
    protected $fillable = [
        'admin_id',
        'subscriptions_id',
        'name',
        'price'
    ];

    /**
     * Subscriptions can be created only by super_admin's
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Subscriptions can be created only by super_admin's
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscriptions(): BelongsTo
    {
        return $this->belongsTo(Subscriptions::class, 'subscriptions_id', 'id');
    }

    /**
     * A subscription is bought by an admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    protected function caps(): Attribute
    {
        return Attribute::make(
            get: function (): Collection {
                $caps = $this->subscriptions?->meta;
                return collect(Arr::get(is_array($caps) ? $caps : [], 'caps', []));
            }
        )->withoutObjectCaching();
    }

    protected function availableCaps(): Attribute
    {
        return Attribute::make(
            get: function (): Collection {
                $available = Arr::get($this->caps, 'available', []);
                return collect(is_array($available) ? $available : []);
            }
        )->withoutObjectCaching();
    }
}
