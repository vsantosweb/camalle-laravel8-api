<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc_categories')->insert([
            ['name' => 'Estável', 'uuid' => uniqid()],
            ['name' => 'Cauteloso', 'uuid' => uniqid()],
            ['name' => 'Dominante, influente e cauteloso', 'uuid' => uniqid()],
            ['name' => 'Dominante e influente', 'uuid' => uniqid()],
            ['name' => 'Influente e cauteloso', 'uuid' => uniqid()],
            ['name' => 'Influente', 'uuid' => uniqid()],
            ['name' => 'Dominante', 'uuid' => uniqid()],
            ['name' => 'Dominante e estável', 'uuid' => uniqid()],
            ['name' => 'Estável', 'uuid' => uniqid()],
            ['name' => 'Influente e estável', 'uuid' => uniqid()],
            ['name' => 'Dominante, influente e estável', 'uuid' => uniqid()],
            ['name' => 'Dominante e cauteloso', 'uuid' => uniqid()],
            ['name' => 'Dominante', 'uuid' => uniqid()],
            ['name' => 'Dominante, estável e cauteloso', 'uuid' => uniqid()],
            ['name' => 'Estável e cauteloso', 'uuid' => uniqid()],
            ['name' => 'Influente, estável e cauteloso', 'uuid' => uniqid()],
        ]);
    }
}
