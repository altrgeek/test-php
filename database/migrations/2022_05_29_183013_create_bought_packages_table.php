<?php

use App\Models\Packages;
use App\Models\Roles\Client;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoughtPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bought_packages', function (Blueprint $table) {
            $table->id();

            //this makes a column named user_id that references id on user's table
            $table
            ->foreignIdFor(User::class)
            ->constrained()
            ->cascadeOnDelete();

            //this makes a column named Client_id that references id on Client's table
            $table
            ->foreignIdFor(Client::class)
            ->constrained()
            ->cascadeOnDelete();

            //this makes a column named Packages_id that references id on Packages's table
            $table
            ->foreignIdFor(Packages::class)
            ->constrained()
            ->cascadeOnDelete();

            $table->uuid('uid')->uniqid();
            $table->string('title');
            $table->bigInteger('amount');
            $table->smallInteger('sessions')->unsigned();

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
        Schema::dropIfExists('bought_packages');
    }
}
