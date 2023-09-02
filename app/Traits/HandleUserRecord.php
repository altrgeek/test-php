<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HandleUserRecord
{
    // Write your code here

    public static function bootHandleUserRecord()
    {
        static::deleted(function (Model $model): void {
            if (!$model->user) return;

            $model->user->delete();
        });
    }
}
