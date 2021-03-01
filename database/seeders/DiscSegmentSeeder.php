<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscSegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i = 1; $i <= 7; $i++){
            DB::table('disc_segments')->insert([
                'name' => 'Segmento '. $i,
                'number' => $i
            ]);
        }
    }
}
