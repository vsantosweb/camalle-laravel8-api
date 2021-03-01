<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            [
                'code' => strtoupper(uniqid()),
                'customer_id' => 1,
                'order_status_id' => 1,
                'status' => 'APPROVED',
                'payment_method' => 'CREDIT_CARD',
                'type' => 'PLAN_SUBSCRIPTION',
                'total' => 0,
            ]
        ]);
    }
}
