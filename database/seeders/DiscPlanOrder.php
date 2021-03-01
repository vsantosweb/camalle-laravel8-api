<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscPlanOrder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc_plan_orders')->insert([
            'order_id' => 1 ,
            'disc_plan_id' => 1 ,
            'quantity' => 1 ,
            'price' => 0 ,
            'total' => 0 ,
            'tax' => 0 
        ]);
    }
}
