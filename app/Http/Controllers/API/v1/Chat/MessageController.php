<?php

namespace App\Http\Controllers\API\v1\Chat;

use App\Enums\Chat\Message\Type as MessageType;
use App\Enums\Chat\Message\Status as MessageStatus;
use App\Events\MessageCreated;
use App\Events\MessageDeleted;
use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use Helpers\JSON;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\File;

class MessageController extends Controller
{
    /**
     * Return JSON response for this API endpoint
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Chat $chat)
    {
        $request->validate([
            'type'    => ['required', 'string', new Enum(MessageType::class)],
            'content' => [
                'string',
                'min:1',
                'max:65535', // Max size which MySQL's `TEXT` column supports
                Rule::requiredIf(fn () => $request->input('type') === MessageType::TEXT()),
            ],
            'parent' => ['integer', 'min:1', Rule::exists('messages', 'id')],
            'image' => [
                File::image()->max(config('cogni.storage.limits.image')),
                Rule::requiredIf(fn () => $request->input('type') === MessageType::IMAGE())
            ],
            'video' => [
                File::types(config('cogni.storage.types.video'))
                    ->max(config('cogni.storage.limits.video')),
                Rule::requiredIf(fn () => $request->input('type') === MessageType::VIDEO())
            ],
            'audio' => [
                File::types(config('cogni.storage.types.audio'))
                    ->max(config('cogni.storage.limits.audio')),
                Rule::requiredIf(fn () => $request->input('type') === MessageType::AUDIO())
            ],
            'voice' => [
                File::types(config('cogni.storage.types.audio'))
                    ->max(config('cogni.storage.limits.audio')),
                Rule::requiredIf(fn () => $request->input('type') === MessageType::VOICE())
            ],
            'document' => [
                File::types(config('cogni.storage.types.document'))
                    ->max(config('cogni.storage.limits.document')),
                Rule::requiredIf(fn () => $request->input('type') === MessageType::DOCUMENT())
            ],
        ]);

        $user = $request->user();
        $chat->load(['participants']);

        // User is not a listed participant of specified chat
        if (!$chat->participants->find($user->id))
            return JSON::error(
                'You are not allowed to send message in this chat!',
                Response::HTTP_UNAUTHORIZED
            );

        $storage = Storage::disk('public');
        $content = $request->input('type') === MessageType::TEXT() ? $request->input('content') : null;
        $content = $request->input('type') === MessageType::IMAGE() ? $request->file('image')->store('chat', 'public') : $content;
        $content = $request->input('type') === MessageType::VIDEO() ? $request->file('video')->store('chat', 'public') : $content;
        $content = $request->input('type') === MessageType::AUDIO() ? $request->file('audio')->store('chat', 'public') : $content;
        $content = $request->input('type') === MessageType::VOICE() ? $request->file('voice')->store('chat', 'public') : $content;
        $content = $request->input('type') === MessageType::DOCUMENT() ? $request->file('document')->store('chat', 'public') : $content;

        if ($request->input('type') !== MessageType::TEXT() && str_contains($content, '/')) {
            $content = explode('/', $content);
            $content = $content[count($content) - 1];
        }

        $preview = optional($request->input('parent'), function ($id) use ($request, $chat) {
            $message = Message::with('chat')->find($id);

            // Can only reply to text messages in the same chat
            if ($message->chat->id !== $chat->id || $message->type !== MessageType::TEXT)
                return null;

            return Str::limit($message->content, 80);
        });

        $visibility = [
            'audience' => $chat->participants->map(fn ($user) => $user->id)->toArray(),
            'views'    => [$user->id], // Only the message owner has seen it till now
        ];

        $message = $chat->messages()->create([
            'type' => MessageType::from($request->input('type')),
            'content' => $content,
            'user_id' => $user->id,
            'preview' => $preview,
            'parent_id' => $request->input('parent'),
            'status' => MessageStatus::SENT,
            'visibility' => $visibility,
        ]);

        $message->load('user', 'chat');

        broadcast(new MessageCreated($message))->toOthers();

        return JSON::success($message);
    }

    public function destroy(Request $request, Chat $chat, Message $message)
    {
        if (!$message->user()->is($request->user()))
            return JSON::error('You can delete your own messages only!');

        $message->update(['is_deleted' => true, 'content' => null]);

        broadcast(new MessageDeleted($message))->toOthers();

        return JSON::success();
    }
}
