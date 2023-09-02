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
        Schema::table('vr_therapies', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->dropColumn('timing');
            $table->time('duration');
            $table->string('material');
            $table->string('method');
            $table->string('image');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vr_therapies', function (Blueprint $table) {
            $table->dropColumn('material');
            $table->dropColumn('method');
            $table->dropColumn('image');
            $table->dropColumn('duration');
        });
    }
};
