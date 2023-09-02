<?php

use App\Models\Therapies\ArVr;
use App\Models\Therapies\MarketplaceOption;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapiesMarketplacePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapies_marketplace_pivot', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vr_therapy_id')
                ->constrained()
                ->references('id')
                ->on('vr_therapies')
                ->cascadeOnDelete();

            $table->foreignIdFor(MarketplaceOption::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapies_marketplace_pivot');
    }
}
