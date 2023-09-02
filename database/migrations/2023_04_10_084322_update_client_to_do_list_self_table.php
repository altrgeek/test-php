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
            $table->renameColumn('provider_id', 'assignee_id');
            $table->renameColumn('client_id', 'assigned_to_id');
            $table->string('assignee_role')->nullable()->comment('provider,admin,superadmin');
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
            $table->renameColumn('assignee_id', 'provider_id');
            $table->renameColumn('assigned_to_id', 'client_id');
            $table->dropColumn('assignee_role');
        });
    }
};
