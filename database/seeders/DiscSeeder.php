<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc')->insert([
            ['letter' => 'D', 'name' => 'Dominância'],
            ['letter' => 'I', 'name' => 'influência'],
            ['letter' => 'S', 'name' => 'Estabilidade '],
            ['letter' => 'C', 'name' => 'Conformidade'],
        ]);
    }
}
