<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'name'=> 'john doe',
                'uuid' => Str::uuid(),
                'customer_type_id' => 1,
                'email'=> 'souzavito@hotmail.com',
                'password'=> Hash::make('password'),
                'email_verified_at'=> now(),
                'home_dir' => 'customers/'. md5(microtime()),
                'last_activity' => now()
            ],
        ]);
    }
}
