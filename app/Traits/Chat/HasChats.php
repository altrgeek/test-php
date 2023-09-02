<?php

namespace App\Traits\Chat;

use App\Enums\Chat\Chat as ChatType;
use App\Models\Chat\Chat;
use App\Models\Chat\Participant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasChats
{
    /**
     * A user can participant in many chats.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function chats(): BelongsToMany
    {
        return $this
            ->belongsToMany(Chat::class, 'chat_participants')
            ->using(Participant::class)
            ->withPivot(['role', 'visibility']);
    }

    /**
     * A user can participant in many individual (one-to-one) chats.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function individual_chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_participants')
            ->using(Participant::class)
            ->withPivot(['role', 'visibility'])
            ->wherePivot('type', ChatType::INDIVIDUAL);
    }

    /**
     * A user can participant in many group chats.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function group_chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_participants')
            ->using(Participant::class)
            ->withPivot(['role', 'visibility'])
            ->wherePivot('type', ChatType::GROUP);
    }

    /**
     * Scope query to include messages from a given chat.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\Chat\Chat|string|int  $chat
     */
    public function messages(Builder $query, Chat|string|int $chat): Builder
    {
        return $query
            // Primary key provided
            ->when(is_numeric($chat) && (int) $chat > 0, function (Builder $query) use ($chat) {
                $query->with([
                    'chats' => fn (Builder $query) => $query->where('id', (int) $chat)
                ]);
            })
            // Unique ID provided (UUID)
            ->when(is_string($chat) && strlen($chat) > 0, function (Builder $query) use ($chat) {
                $query->with([
                    'chats' => fn (Builder $query) => $query->where('uid', $chat)
                ]);
            })
            // Chat instances provided
            ->when($chat instanceof Chat, function (Builder $query) use ($chat) {
                $query->with([
                    'chats' => fn (Builder $query) => $query->where('id', $chat->id)
                ]);
            });
    }

    public function canCreateGroup(): bool
    {
        return in_array($this->getRole(), ['super_admin', 'admin', 'provider']);
    }
}
