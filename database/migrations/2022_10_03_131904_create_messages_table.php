<?php

use App\Enums\Chat\Message\Status as MessageStatus;
use App\Enums\Chat\Message\Type as MessageType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Will be present in case of an event (like user join/leave etc.)
            $table->json('event_context')->nullable();
            $table->foreignId('target_id')->nullable()->constrained('users')->nullOnDelete();

            $table->text('content')->nullable(); // The message contents

            // Was the message deleted? If yes then who deleted this message?
            // The message author or an admin (which admin) and on what purpose?
            $table->boolean('is_deleted')->default(false);

            // These two fields will be set if message is a reply of another
            // message
            $table->foreignId('parent_id')->nullable()->constrained('messages')->nullOnDelete();
            $table->string('preview', 100)->nullable();

            // Message can be of different types
            $table->enum('type', MessageType::values());

            // For other participant in individual chat and for all users in a
            // group chat
            $table->enum('status', MessageStatus::values());
            // Visibility status of each participant (group chat)
            $table->json('visibility')->nullable();

            $table->foreignId('chat_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
