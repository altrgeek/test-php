<?php

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
        Schema::create('client_to_do_list_group', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('description');
            $table->dateTime('start');
            $table->integer('duration');
            $table->enum('status', [
                'declined', // The appointment has been declined by admin
                'booked', // The appointment has been created but not reviewed yet
                'pending', // Reviewed by admin, scheduled for start time
                'completed' // Session was completed
            ])->default('booked');
            $table->integer('provider_id');
            $table->string('client_id');
            $table->dateTime('end')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_to_do_list_group', function (Blueprint $table) {
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['client_id']);
            $table->dropColumn(['provider_id', 'client_id']);
            $table->dropColumn(['id', 'timestamps', 'title', 'description', 'start', 'duration', 'status', 'end']);
            
        });
    }
};
