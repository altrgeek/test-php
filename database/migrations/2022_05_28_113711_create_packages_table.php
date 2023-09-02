<?php

use App\Models\Roles\Admin;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            //this makes a column named user_id that references id on user's table
            $table
            ->foreignIdFor(User::class)
            ->constrained()
            ->cascadeOnDelete();

            //this makes a column named Admin_id that references id on Admin's table
            $table
            ->foreignIdFor(Admin::class)
            ->constrained()
            ->cascadeOnDelete();

            $table->string('title');
            $table->smallInteger('sessions');
            $table->string('description', 255);
            $table->bigInteger('price');

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
        Schema::dropIfExists('packages');
    }
}
