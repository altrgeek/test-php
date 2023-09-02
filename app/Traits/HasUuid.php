<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * The column name in which to store the UUID key.
     *
     * @var string
     */
    protected static string $uid_key = 'uid';

    /**
     * Laravel will call this function while booting the model.
     *
     * @return void
     */
    public static function bootHasUuid()
    {
        static::creating(function (Model $model): void {
            $model->{static::$uid_key} = Str::orderedUuid();
        });
    }
}
