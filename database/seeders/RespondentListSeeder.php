<?php

namespace Database\Seeders;

use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
