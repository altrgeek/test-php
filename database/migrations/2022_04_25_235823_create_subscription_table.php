<?php

use App\Models\Roles\Admin;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            // Who bought the subscription
            $table
                ->foreignIdFor(Admin::class)
                ->constrained()
                ->cascadeOnDelete();

            // Which subscription was bought
            $table
                ->foreignIdFor(Subscriptions::class)
                ->constrained();

            // Subscription details when it was bought
            $table->string('name');
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
        Schema::dropIfExists('subscription');
    }
}
