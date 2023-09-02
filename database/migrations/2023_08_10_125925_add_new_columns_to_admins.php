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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('website')->nullable();
            $table->string('pricing_range')->nullable();
            $table->string('new_clients')->nullable();
            $table->string('tool_sharing')->nullable('');
            $table->string('type_of_client')->nullable('');
            $table->string('service_provided')->nullable('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('website');
            $table->dropColumn('pricing_range');
            $table->dropColumn('new_clients');
            $table->dropColumn('tool_sharing');
            $table->dropColumn('type_of_client');
            $table->dropColumn('service_provided');
        });
    }
};
