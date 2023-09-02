<?php

namespace Database\Seeders;

use App\Models\Roles\Provider;
use App\Models\Therapies\MarketplaceOption;
use App\Models\Therapies\VRTherapy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class VRTherapiesSeeder extends Seeder
{
    const MARKETPLACE_OPTIONS_COUNT = 3;
    const VR_THERAPIES_COUNT = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Only run in local, staging or testing environment!
        if (!App::environment('local', 'staging', 'testing')) return;

        $providers = Provider::limit(10)->get();

        VRTherapy::factory()
            ->count(self::VR_THERAPIES_COUNT)
            ->has(
                MarketplaceOption::factory()
                    ->count(random_int(3, self::MARKETPLACE_OPTIONS_COUNT)),
                'marketplaces'
            )
            ->state(['provider_id' => $providers->random()->id])
            ->create();
    }
}
