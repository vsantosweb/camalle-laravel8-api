<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class RespondentDiscMessages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('respondent_disc_messages')->insert([
            'uuid' => Str::uuid(),
            'customer_id' => 1,
            'name' => 'Message '. now(),
            'subject' => 'Relatório',
            'sender_name' => 'Jhon Doe',
            'content' => 'Lorem Impsum',
        ]);
    }
}
