<?php

namespace App\Http\Controllers\API\v1\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Enums\Chat\Chat as ChatType;
use App\Enums\Chat\Participant;
use Helpers\JSON;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class GroupController extends Controller
{
    /**
     * Return JSON response for this API endpoint
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->canCreateGroup())
            return JSON::error('You are not allowed to create a group chats!');

        $request->validate([
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'icon' => ['nullable', File::image()->max(1024 * 2)->dimensions(1 / 1)],
            'description' => ['nullable', 'string', 'min:1', 'max:255'],
            'participants' => ['array'],
            'participants.*' => ['numeric', Rule::exists('users', 'id')]
        ]);

        $icon = optional($request->file('icon'), fn ($file) => $file->storePublicly('groups'));

        $group = Chat::create([
            'type' => ChatType::GROUP,
            'name' => $request->input('name'),
            'icon' => $icon,
            'description' => $request->input('description')
        ]);

        $group->participants->attach($request->input('participants', ['role' => Participant::MEMBER]));

        return JSON::success($group);
    }
}
