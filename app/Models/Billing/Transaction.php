<?php

namespace App\Models\Billing;

use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     * @var array<string>
     */
    protected $fillable = [
        'transaction_id',
        'amount',
        'user_id',
        'subscriptions_id',
        'order_id',
        'bought_packages_id',
    ];

    /**
     * Subscriptions can be created only by super_admin's
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Subscriptions has a relation with transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscriptions(): BelongsTo
    {
        return $this->belongsTo(Subscriptions::class);
    }

    /**
     * Order has a relation with transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * bought_packages has a relation with transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bought_packages(): BelongsTo
    {
        return $this->belongsTo(BoughtPackages::class);
    }
}
