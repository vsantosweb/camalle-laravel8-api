<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscPlanPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc_plan_periods')->insert([
            'name' => 'Mensal',
            'slug' => 'month',
            'validity_days' => 30,
        ]);
        
        DB::table('disc_plan_to_periods')->insert([
            'disc_plan_id' => 1,
            'disc_plan_period_id' => 1,
            'discount' => 0
        ]);
    }
}
