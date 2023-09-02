<?php

namespace App\Traits\Chat;

use App\Enums\Chat\Chat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasScopes
{


    /**
     * Scope query to search chats (group or individual or both).
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\Chat\Chat|string|int  $chat
     */
    public function scopeSearchChat(Builder $query, string $name, string $type = null): Builder
    {
        return $query
            ->with([
                'chats' => function (Builder $query) use ($name, $type) {
                    $query
                        // Search for specific type of chat (if provided)
                        ->when(
                            $type && in_array(Str::lower($type), Chat::values()),
                            function (Builder $query) use ($type) {
                                $query->where('type', $type);
                            }
                        )
                        ->when($name, function (Builder $query) use ($name) {
                            $query
                                ->where('name', 'like', "%{$name}%");
                        });
                }
            ]);
    }
}
