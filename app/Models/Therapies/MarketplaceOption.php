<?php

namespace App\Models\Therapies;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class MarketplaceOption extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'marketplace_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'url'];

    protected function prettyUpdated(): Attribute
    {
        return Attribute::get(function (mixed $value, array $attributes) {
            $updated_at = new Carbon($attributes['updated_at']);

            return $updated_at->format('jS F Y \a\t h:i:s');
        });
    }

    /**
     * A marketplace option can belong to many therapies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function therapies(): BelongsToMany
    {
        return $this->belongsToMany(
            VRTherapy::class,
            'therapies_marketplace_pivot',
            'marketplace_option_id',
            'vr_therapy_id'
        );
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function (MarketplaceOption $option) {
            if (!$option->url)
                $option->url = sprintf('http://www.example.com/%s', Str::slug($option->name));

            return $option;
        });
    }
}
