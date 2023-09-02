<?php

namespace Database\Seeders;

use App\Models\Roles\Admin;
use App\Models\Subscriptions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::with(['user'])
            ->get()
            ->each(function (Admin $admin) {
                $plan = Subscriptions::inRandomOrder()->first();

                $admin
                    ->subscription()
                    ->create([
                        'subscriptions_id' => $plan->id,
                        'name' => $plan->name,
                        'price' => $plan->price,
                    ]);

                $plan->transaction()->create([
                    'amount' => $plan->price,
                    'user_id' => $admin->user->id,
                ]);
            });
    }
}
