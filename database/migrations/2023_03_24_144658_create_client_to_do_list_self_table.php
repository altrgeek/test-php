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
        Schema::create('client_to_do_list_self', function (Blueprint $table) {
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
            $table->integer('client_id');
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
        Schema::dropIfExists('client_to_do_list_self');
    }
};
