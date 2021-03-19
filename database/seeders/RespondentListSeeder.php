<?php

namespace Database\Seeders;

use App\Models\Respondent\RespondentList;
use Illuminate\Database\Seeder;

class RespondentListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RespondentList::factory()->count(12)->create();
    }
}
