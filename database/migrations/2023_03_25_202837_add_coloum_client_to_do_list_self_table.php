<?php

use App\Models\Therapies\VRTherapy;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->foreignId('vr_therapy_id')
                ->constrained()
                ->references('id')
                ->on('vr_therapies')
                ->cascadeOnDelete();
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
            $table->dropColumn('vr_therapy_id');
        });
    }
};
