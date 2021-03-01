<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_types')->insert([
            [
                'name'=> 'Common',
                'slug' => \Str::slug('common')
            ],
            [
                'name'=> 'Partiner',
                'slug' => \Str::slug('partner')
            ],
        ]);
    }
}

