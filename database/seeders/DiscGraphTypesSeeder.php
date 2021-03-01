<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscGraphTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc_graph_types')->insert([
            ['name' => 'less'],
            ['name' => 'more'],
            ['name' => 'difference'],
        ]);
    }
}
