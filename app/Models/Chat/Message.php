<?php

namespace App\Models\Chat;

use App\Enums\Chat\Message\Type as MessageType;
use App\Enums\Chat\Message\Status as MessageStatus;
use App\Events\MessageCreated;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'event_context',
        'target_id',
        'content',
        'is_deleted',
        'parent_id',
        'preview',
        'type',
        'status',
        'visibility',
        'chat_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_deleted' => 'boolean',
        'type' => MessageType::class,
        'status' => MessageStatus::class,
        'visibility' => 'array',
    ];

    /**
     * A message is sent in a chat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * A message is sent by a user (author).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        //
    }
}
