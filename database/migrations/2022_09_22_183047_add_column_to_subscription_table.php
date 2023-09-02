<?php

use App\Models\Subscriptions;
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
        Schema::table('subscription', function (Blueprint $table) {
            $table->foreignIdFor(Subscriptions::class)
            ->after('admin_id')
            ->constrained()
            ->cascadeOnDelete();
        });
    }
};
