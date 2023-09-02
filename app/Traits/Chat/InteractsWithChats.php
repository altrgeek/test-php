<?php

namespace App\Traits\Chat;

use App\Enums\Chat\Chat as ChatType;
use App\Enums\Chat\Visibility;
use App\Models\Chat\Chat;
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use App\Models\Roles\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

trait InteractsWithChats
{
    /**
     * Search for contacts the passed user can chat with and chat groups that
     * user is a participant of which match the passed name.
     *
     * @param \App\Models\User  $user
     * @param string  $name
     *
     * @return array<string, \App\Models\User|\App\Models\Chat\Chat>
     */
    public static function searchChat(User $user, string $name = null)
    {
        // Get all user IDs the current user can chat with
        $available_contacts = static::getContactsIDs($user);

        $contacts = User::whereIn('id', $available_contacts->toArray())
            ->select(['id', 'name', 'avatar'])
            ->when(is_string($name) && strlen($name) > 0, function (Builder $query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->get();

        $groups = $user
            ->chats()
            ->where('type', ChatType::GROUP)
            ->with([
                'participants' => function (BelongsToMany $query) {
                    $query->select(['name', 'avatar']);
                }
            ])
            // Get all chats that are not blocked by the user
            // ->wherePivot('visibility', '<>', Visibility::BLOCKED())
            // Get all chat groups the user in involved in containing the name
            ->when(is_string($name) && strlen($name) > 0, function (Builder $query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->get();

        return compact('groups', 'contacts');
    }

    /**
     * Get collection of all user IDs with whom the user can contact with.
     *
     * @param \App\Models\User  $user
     *
     * @return \Illuminate\Support\Collection<int>
     */
    public static function getContactsIDs(User $user): Collection
    {
        // 1. Super-admin can contact with any role.
        // 2. Admin can contact with their providers and super admins.
        // 3. Provider can contact with their admin and clients.
        // 4. Client can only contact with their provider.

        // Super-admin can contact with any role
        if ($user->isSuperAdmin())
            // Get all user IDs except for the user
            return User::select('id')->whereNot('id', $user->id)->get();

        // Admin can contact with their providers and super admins
        elseif ($user->isAdmin())
            return $user
                ->admin
                ->providers()
                ->with('user:id')
                ->get()
                ->map(function (Provider $provider) {
                    return $provider->user->id;
                })
                ->concat(
                    SuperAdmin::with('user:id')
                        ->get()
                        ->map(fn (SuperAdmin $super_admin) => $super_admin->user->id),
                );

        // Provider can contact with their admin and clients
        elseif ($user->isProvider())
            return $user
                ->provider
                ->clients() // All clients of provider
                ->with('user:id')
                ->get()
                ->map(fn (Client $client) => $client->user->id)
                ->push(
                    $user
                        ->provider
                        ->admin() // The admin of provider
                        ->with('user:id')
                        ->get()
                        ->first()
                        ->user
                        ->id
                );

        // Client can only contact with their provider
        elseif ($user->isClient())
            return $user
                ->client
                ->provider() // The provider of client
                ->with('user:id')
                ->get()
                ->map(fn (Provider $provider) => $provider->user->id);

        return collect([]);
    }

    /**
     * Fetches an individual chat room with provided participants.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\User|int  $other
     *
     * @return \App\Models\Chat\Chat|null
     */
    public static function getIndividualGroupWithContact(User $user, User|int $other): ?Chat
    {
        return $user
            ->chats()
            ->wherePivot('type', ChatType::INDIVIDUAL) // An individual chat
            // Where the chat has record for such a participant whose `user_id`
            // matches the other user's ID
            ->whereHas('participants', function (Builder $query) use ($other) {
                $id = $other instanceof User ? $other->id : $other;

                $query->where('user_id', $id);
            })
            ->first();
    }

    /**
     * Creates a new individual chat between the two provided participants or
     * returns if such group already exists.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\User|int  $other
     *
     * @return \App\Models\Chat\Chat
     */
    public function createIndividualGroupWithContact(User $user, User|int $other): ?Chat
    {
        // Get such an individual chat which have both users as a
        // participant
        $chat = static::getIndividualGroupWithContact($user, $other);


        // No such chat exists between provided users, create a new individual
        // chat between provided users
        if (!$chat)
            $chat = Chat::create(['type' => ChatType::INDIVIDUAL])
                ->participants()
                // List both of the users as chat member participants
                ->attach([
                    $user->id,
                    $other instanceof User ? $other->id : $other
                ]);


        return $chat;
    }
}
