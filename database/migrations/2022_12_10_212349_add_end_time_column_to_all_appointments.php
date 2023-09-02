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
        Schema::table('client_provider_appointments', function (Blueprint $table) {
            $table->timestamp('ends_at');
        });

        Schema::table('admin_provider_appointments', function (Blueprint $table) {
            $table->timestamp('ends_at');
        });

        Schema::table('admin_super_admin_appointments', function (Blueprint $table) {
            $table->timestamp('ends_at');
        });
    }
};
