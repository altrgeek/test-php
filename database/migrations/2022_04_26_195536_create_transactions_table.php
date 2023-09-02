<?php

use App\Models\Billing\BoughtPackages;
use App\Models\Billing\Order;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();


            $table->uuid('transaction_id')->unique();
            $table->unsignedMediumInteger('amount')->default(0);

            $table
                ->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table
                ->foreignIdFor(Subscriptions::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table
                ->foreignIdFor(Order::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('transactions');
    }
}
