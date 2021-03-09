<?php

namespace Database\Seeders;

use App\Models\Disc\DiscCombination;
use App\Models\Disc\DiscRanges;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscTest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RespondentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Respondent::factory()->count(800)->create();

        // Respondent::factory()->count(15)->has(RespondentDiscTest::factory()->count(1)->state(function(array $attr, Respondent $respondent){ return['respondent_name' => $respondent->name]; }), 'discTests')->create();
    }
}
