<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Enums\Chat\Participant as Role;
use App\Enums\Chat\Visibility;

class Participant extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chat_participants';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'role',
        'visibility',
        'chat_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'role' => Role::class,
        'visibility' => Visibility::class,
    ];
}
