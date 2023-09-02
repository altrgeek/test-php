<?php

namespace App\Models\Therapies;

use App\Models\Roles\Provider;
use Illuminate\Support\Carbon;
use App\Models\ClientToDoListSelf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VRTherapy extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vr_therapies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'duration', 'provider_id','material','method','image'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'date',
    ];

    protected function prettyTiming(): Attribute
    {
        return Attribute::get(function (mixed $value, array $attributes) {
            $timing = new Carbon($attributes['duration']);

            return $timing->format('H:m:s');
        });
    }

    /**
     * A therapy can belong to many marketplace options.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function marketplaces(): BelongsToMany
    {
        return $this->belongsToMany(
            MarketplaceOption::class,
            'therapies_marketplace_pivot',
            'vr_therapy_id',
            'marketplace_option_id'
        );
    }
    /**
     * A therapy can belong to many marketplace options.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clientToDo(): HasMany
    {
        return $this->HasMany( ClientToDoListSelf::class, 'vr_therapy_id','id');
    }

    /**
     * A therapy belongs to a provider
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
