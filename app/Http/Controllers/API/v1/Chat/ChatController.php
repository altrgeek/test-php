<?php

namespace App\Http\Controllers\API\v1\Chat;


use App\Enums\Chat\Chat as ChatType;
use App\Enums\Chat\Message\Type as MessageType;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Traits\Chat\InteractsWithChats;
use Helpers\JSON;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class ChatController extends Controller
{
    use InteractsWithChats;

    /**
     * Return JSON response for this API endpoint
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $chats = $user
            ->chats()
            ->with(['participants'])
            ->get()
            // Eager loading does not works on last message so no other option
            // left for not using a N+1 query
            ->map(function (Chat $chat) use ($user) {
                $chat->last_message = $chat
                    ->messages()
                    ->with(['user'])
                    // Only load message which the user is meant to see
                    ->whereJsonContains('visibility->audience', $user->id)
                    ->whereNot('type', MessageType::EVENT)
                    ->latest('id')
                    ->first();

                return $chat;
            });

        return JSON::success($chats);
    }

    /**
     * Search for chats and contacts that contain given name.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => ['nullable', 'string', 'max:255']
        ]);

        $user = $request->user();
        $name = $request->input('query');

        return JSON::success(static::searchChat($user, $name));
    }

    /**
     * Get the chat user has requested.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \App\Models\Chat\Chat  $chat_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $chat): JsonResponse
    {
        $request->validate([
            'type' => ['nullable', 'string', Rule::in(['contact', 'group', 'individual'])],
        ]);

        $user = $request->user();

        // Open an individual chat with the provided contact ID
        if ($request->input('type') === 'contact') {
            // Find an individual chat in which user and and other person is
            // participants
            $room = $user
                ->chats()
                ->with(['participants'])
                ->where('type', ChatType::INDIVIDUAL)
                ->whereHas('participants', function (Builder $query) use ($chat) {
                    $query->where('user_id', $chat);
                })
                ->firstOr(function () use ($user, $chat) {
                    $room = Chat::create(['type' => ChatType::INDIVIDUAL]);
                    $room
                        ->participants()
                        ->attach([$user->id, $chat]);
                    return $room;
                });

            $room->load(['participants', 'messages']);

            return JSON::success($room);
        }

        $chat = Chat::where('uid', $chat)->firstOrFail();

        // User is not a listed participant of specified chat
        if (!$chat->participants()->find($user->id))
            return JSON::error('You are not allowed to view this chat!', Response::HTTP_UNAUTHORIZED);

        $chat->load([
            'participants',
            'messages' => function ($query) use ($user) {
                $query
                    ->with(['user'])
                    // Only load message which the user is meant to see
                    ->whereJsonContains('visibility->audience', $user->id);
            }
        ]);

        return JSON::success($chat);
    }
}
