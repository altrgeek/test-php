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
        Schema::create('completed_listings', function (Blueprint $table) {
            $table->id();
            $table->string('assignee_role')->comment(
                'provider,admin,superadmin'
            );
            $table->foreignId('accepted_id')->constrained('id')->on('client_to_do_list_self');
            $table->foreignId('assignee_id')->constrained('id')->on('providers');
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
        Schema::dropIfExists('completed_listings');
    }
};
