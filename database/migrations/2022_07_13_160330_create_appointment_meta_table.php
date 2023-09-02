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
        Schema::create('appointment_meta', function (Blueprint $table) {
            $table->id();

            $table->enum('appointment_type', [
                'superAdmin_admin',
                'admin_provider',
                'provider_client',
            ]);

            $table->unsignedBigInteger('appointment_id');
            $table->string('meta_key');
            $table->json('meta_value', 500)
                ->nullable();

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
        Schema::dropIfExists('appointment_meta');
    }
};
