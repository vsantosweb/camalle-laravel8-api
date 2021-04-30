<?php

namespace Database\Seeders;

use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentDiscReport;
use App\Models\Respondent\RespondentList;
use Illuminate\Database\Seeder;


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

        Respondent::factory()->count(25)->has(
            RespondentDiscReport::factory()->count(1)->state(function (array $attr, Respondent $respondent) {
                return ['respondent_name' => $respondent->name];
            }),
            'reports'
        )->create();

        $lists = RespondentList::all();
        Respondent::all()->each(function ($respondent) use ($lists) { 
            $respondent->lists()->attach(
                $lists->random(1)->pluck('id')->toArray()
            ); 
        });
       
    }
}
