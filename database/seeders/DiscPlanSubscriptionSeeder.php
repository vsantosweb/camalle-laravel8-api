<?php

namespace Database\Seeders;

use App\Models\Disc\DiscPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscPlanSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc_plan_subscriptions')->insert([
            'code' => strtoupper(uniqid()),
            'customer_id' => 1,
            'disc_plan_id' => 1,
            'status' => 1,
            'credits' => DiscPlan::find(1)->features->credits,
            'amount' => DiscPlan::find(1)->price,
            'validity_days' => DiscPlan::find(1)->periods[0]->validity_days,
            'expire_at' => now()->addDays(30),
        ]);
    }
}
