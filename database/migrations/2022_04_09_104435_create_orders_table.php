<?php

use App\Models\Roles\Client;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique(); // Order ID

            $table->double('amount')->default(0.00);

            $table
                ->enum('status', ['paid', 'unpaid', 'cancelled'])
                ->default('unpaid');

            // For which client the order is being generated (used when creating/sending invoices)
            $table
                ->foreignIdFor(Client::class)
                ->constrained()
                ->cascadeOnDelete();

            $table
                ->foreignId('appointment_id')
                ->references('id')
                ->on('client_provider_appointments')
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
        Schema::dropIfExists('orders');
    }
}
