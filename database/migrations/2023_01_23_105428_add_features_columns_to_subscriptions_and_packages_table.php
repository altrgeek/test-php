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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->json('meta')->nullable()->after('expires_at');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->json('meta')->nullable()->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('meta');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('meta');
        });
    }
};
