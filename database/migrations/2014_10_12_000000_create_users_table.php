<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            // Address & Location
            $table->string('address')->nullable();
            $table->double('longitude')->nullable(); // Geo spatial values
            $table->double('latitude')->nullable(); // Geo spatial values

            // Additional details
            $table->timestamp('dob')->nullable(); // Timestamp
            $table->string('phone')->nullable(); // Intl phone number
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            $table->string('avatar')->nullable();

            // Verification and authentication details
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
}
