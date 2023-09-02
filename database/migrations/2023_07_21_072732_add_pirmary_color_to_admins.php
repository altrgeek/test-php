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
            $table->string('primary_color')->default('#5CD0B0')->nullable();
            $table->string('secondary_color')->default('#253668')->nullable();
            $table->string('text_color')->default('#6e82a5')->nullable();
            $table->string('logo')->default('images/cogni_logo_reg.png')->nullable('');
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
            $table->dropColumn('primary_color');
            $table->dropColumn('secondary_color');
            $table->dropColumn('text_color');
            $table->dropColumn('logo');
        });
    }
};
