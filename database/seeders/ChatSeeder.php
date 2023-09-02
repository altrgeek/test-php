<?php

namespace Database\Seeders;

use App\Enums\Chat\Participant;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a chat group of super-admin and admins
        static::create_super_admin_chat_group();
        static::create_super_admin_chat_group();

        // Create an individual chat between super admin and the first admin
        static::create_super_admin_individual_chat();

        Chat::all()->each(fn (Chat $chat) => static::populate_chats($chat));
    }

    /**
     * Returns the first super-admin user record.
     *
     * @return \App\Models\User|null
     */
    private static function get_super_admin(): ?User
    {
        return User::has('superAdmin')->select('id')->first();
    }

    /**
     * Creates a chat group of first super-admin and all registered admins
     * having the super-admin as group owner.
     *
     * @return void
     */
    private static function create_super_admin_chat_group(): void
    {
        // Get the first super admin
        $super_admin = static::get_super_admin()->id;

        // Create a group of super admin with all admins
        Chat::factory()
            ->group()
            ->create()
            ->participants()
            ->attach(
                // Super admin will be the owner
                collect([$super_admin => ['role' => Participant::OWNER]])
                    ->concat(
                        User::has('admin')
                            ->select('id')
                            ->get()
                            ->map(fn (User $user) => $user->id)
                    )
                    ->toArray(),
            );
    }

    /**
     * Creates an individual chat between first super-admin and a randomly
     * chosen admin.
     *
     * @return void
     */
    private static function create_super_admin_individual_chat(): void
    {
        Chat::factory()
            ->create()
            ->participants()
            ->attach([
                User::has('admin')
                    ->select('id')
                    ->first()
                    ->id,
                static::get_super_admin()->id
            ]);
    }

    /**
     * Creates specified number of random messages in provided chat
     *
     * @param \App\Models\Chat\Chat  $chat
     * @param int  $count
     *
     * @return void
     */
    private static function populate_chats(Chat $chat): void
    {
        // 1. Get all chat participants
        // 2. Create message for each chat participant

        $participants = $chat->participants;

        $participants
            ->each(function (User $user) use ($chat, $participants) {
                Message::factory()
                    ->count(random_int(1, 4))
                    ->for($chat)
                    ->for($user)
                    ->state([
                        'visibility' => [
                            'audience' => $participants->map(fn (User $user) => $user->id)->toArray(),
                            'views' => []
                        ]
                    ])
                    ->create();
            });
    }
}
