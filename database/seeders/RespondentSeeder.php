<?php

namespace Database\Seeders;

use App\Models\Disc\DiscCombination;
use App\Models\Disc\DiscRanges;
use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscReport;
use App\Models\Respondent\RespondentList;
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
        // Respondent::factory()->count(100)->create();

        Respondent::factory()->count(100)->has(
            RespondentDiscReport::factory()->count(1)->state(function (array $attr, Respondent $respondent) {
                return ['respondent_name' => $respondent->name];
            }),
            'discTests'
        )->create();

        $lists = RespondentList::all();
        Respondent::all()->each(function ($respondent) use ($lists) { 
            $respondent->lists()->attach(
                $lists->random(1)->pluck('id')->toArray()
            ); 
        });
       
    }
}
