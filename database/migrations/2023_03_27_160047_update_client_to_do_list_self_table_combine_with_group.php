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
            $table->unsignedBigInteger('client_id')->nullable()->change();
            $table->integer('duration')->change();
            $table->string('unit')->after('duration');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('do_list_self_table_combine_with_group', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
            $table->integer('duration')->change();
            $table->dropColumn('unit');
        });
    }
};
