<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_status')->insert([
            [
                'name' => 'Pago',
                'slug' => 'payd',
            ],
            [
                'name' => 'Pendente',
                'slug' => 'padding',
            ],
            [
                'name' => 'Cancelado',
                'slug' => 'canceled',
            ]
        ]);
    }
}
