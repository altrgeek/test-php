<?php

namespace App\Http\Controllers\API\v1;

use Helpers\JSON;
use App\Models\User;
use App\Models\Chat\Chat;
use Illuminate\Support\Str;
use App\Models\Roles\Client;
use Illuminate\Http\Request;
use App\Models\Roles\Provider;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Enums\Chat\Chat as ChatType;
use App\Http\Controllers\Controller;
use App\Models\Therapies\TherapiesData;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Chat\Message\Type as MessageType;
use App\Enums\Chat\Message\Status as MessageStatus;
use App\Events\MessageCreated;

class TherapyDataController extends Controller
{
    /**
     * Get the chat user has requested.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'service_provider_email' => ['required', 'email', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'token_key' => ['required', 'max:80'],
        ]);
        if (!isset($request->token_key) || $request->token_key != config('cogni.api.API_TOKEN_AI')) {
            return JSON::error('API token key not valid. Kindly contact with Cogni XR portal administration');
        }

        $service_provider_email = $request->service_provider_email;
        $client_email = $request->client_email;

        $service_provider = Provider::with(['user'])->whereHas('user', function (Builder $query) use ($service_provider_email) {
            $query->where('email', $service_provider_email);
        })->first();

        if (!isset($service_provider) && $service_provider == null)
            return JSON::error('Service provider not found');
        $client = Client::with(['user'])->whereHas('user', function (Builder $query) use ($client_email) {
            $query->where('email', $client_email);
        })->where('provider_id', $service_provider->id)->first();
        // return JSON::error($client);
        if (!isset($client) && $client == null)
            return JSON::error('Client not found for provided service provider');
        if ($request->file('data_file')) {
            $request->validate(['data_file' => 'mimes:pdf']);
            //Storage::delete('/public/TherapyData/'.$user->fileNameToStore);
            $path = $request->file('data_file')->store('/TherapyData', 'public');
            $image = request()->getSchemeAndHttpHost() . '/storage/' . $path;
        } else {
            return JSON::error('Data file not found');
        }
        $therapydata = TherapiesData::create([
            'provider_id' => $service_provider->id,
            'client_id' => $client->id,
            'data_file'      => $path,
        ]);

        return JSON::success('Successfully stored the therapy data');
    }
    public function send_chat(Request $request): JsonResponse
    {
        $request->validate([
            'service_provider_email' => ['required', 'email', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'token_key' => ['required', 'max:80'],
            'content' => [
                'required',
                'string',
                'min:1',
                'max:65535', // Max size which MySQL's `TEXT` column supports
                Rule::requiredIf(fn () => $request->input('type') === MessageType::TEXT()),
            ],
        ]);
        if (!isset($request->token_key) || $request->token_key != config('cogni.api.API_TOKEN_AI')) {
            return JSON::error('API token key not valid. Kindly contact with Cogni XR portal administration');
        }

        $service_provider_email = $request->service_provider_email;
        $client_email = $request->client_email;

        $service_provider = Provider::with(['user'])->whereHas('user', function (Builder $query) use ($service_provider_email) {
            $query->where('email', $service_provider_email);
        })->first();
        if (!isset($service_provider) && $service_provider == null)
            return JSON::error('Service provider not found');
        $client = Client::with(['user'])->whereHas('user', function (Builder $query) use ($client_email) {
            $query->where('email', $client_email);
        })->where('provider_id', $service_provider->id)->first();
        // return JSON::error($client);
        if (!isset($client) && $client == null)
            return JSON::error('Client not found for provided service provider');
        $user = $service_provider->user;
$user_client=$client->user->id;
        $room = $user
            ->chats()
            ->with(['participants'])
            ->where('type', ChatType::INDIVIDUAL)
            ->whereHas('participants', function (Builder $query) use ($user_client) {
                $query->where('user_id',$user_client );
            })
            ->firstOr(function () use ($user,$user_client) {
                $room = Chat::create(['type' => ChatType::INDIVIDUAL]);
                $room
                    ->participants()
                    ->attach([$user->id,$user_client]);
                return $room;
            });

        $room->load(['participants', 'messages']);
        $visibility = [
            'audience' => $room->participants->map(fn ($user) => $user->id)->toArray(),
            'views'    => [$user->id], // Only the message owner has seen it till now
        ];

        $message = $room->messages()->create([
            'type' => MessageType::from($request->input('type')),
            'content' => $request->content,
            'user_id' => $user->id,
            'preview' => null,
            'parent_id' => $request->input('parent'),
            'status' => MessageStatus::SENT,
            'visibility' => $visibility,
        ]);

        $message->load('user', 'chat');

        broadcast(new MessageCreated($message))->toOthers();

        return JSON::success($message);
    }
}
