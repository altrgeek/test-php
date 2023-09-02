<?php

namespace App\Models\Chat;

use App\Enums\Chat\Chat as ChatType;
use App\Enums\Chat\Message\Type as MessageType;
use App\Enums\Chat\Participant as ParticipantRole;
use App\Models\User;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'name',
        'icon',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => ChatType::class
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uid';
    }

    /**
     * A chat has many participants.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_participants')->using(Participant::class);
    }

    /**
     * A chat group has one owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function owner(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_participants')
            ->using(Participant::class)
            ->wherePivot('role', ParticipantRole::OWNER);
    }

    /**
     * A chat has many admin participants.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_participants')
            ->using(Participant::class)
            ->wherePivot('role', ParticipantRole::ADMIN);
    }

    /**
     * A chat has many member participants.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_participants')
            ->using(Participant::class)
            ->wherePivot('role', ParticipantRole::MEMBER);
    }

    /**
     * A chat has many messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Last activity happened in the group (message or event).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastActivity(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    /**
     * Most recent event created in the group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastEvent(): HasOne
    {
        return $this
            ->hasOne(Message::class)
            ->ofMany(['id' => 'max'], function (Builder $query) {
                $query->where('type', MessageType::EVENT);
            });
    }

    /**
     * Most recent message sent in the group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastMessage(): HasOne
    {
        return $this
            ->hasOne(Message::class)
            ->ofMany(['id' => 'max'], function (Builder $query) {
                $query->whereNot('type', MessageType::EVENT);
            });
    }
}
