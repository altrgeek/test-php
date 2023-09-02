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
        Schema::table('client_to_do_list_self', function (Blueprint $table) {
            //add column status
            $table->string('status')->default('pending')->comment('accepted,rejected,completed')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_to_do_list_self', function (Blueprint $table) {
            //
        });
    }
};
