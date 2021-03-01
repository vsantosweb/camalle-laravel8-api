<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DiscPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disc_plans')->insert([
            [

                'code' => strtoupper(Str::random(15)),
                'name' => 'Free',
                'slug' =>  Str::slug('free'),
                'price' => 0.00,
                'joing_free' => 1,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'showcase' => 1,
                'features' => json_decode(json_encode(str_replace(array("\r", "\n", " "), "", '{
                    "credits": 4,
                    "additionals_credits": 0,
                    "graphs": [
                        {
                            "more": false,
                            "diff": true,
                            "less": false
                        }
                    ],
                    "profile": false,
                    "intensities": false,
                    "category": {
                        "visible": true,
                        "report": {
                            "descriptionParagraphs": true,
                            "priority": false,
                            "motivation": false,
                            "stress": true,
                            "discStyles": false,
                            "relationship": true,
                            "efficiency": true
                        }
                    }
                }'))),
            ],
            [

                'code' => strtoupper(Str::random(15)),
                'name' => 'Basic',
                'slug' =>  Str::slug('free'),
                'price' => 35.00,
                'joing_free'=> 0,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'showcase' => 1,
                'features' => json_decode(json_encode(str_replace(array("\r", "\n", " "), "", '{
                    "credits": 20,
                    "additionals_credits": 0,
                    "graphs": [
                        {
                            "more": false,
                            "diff": true,
                            "less": false
                        }
                    ],
                    "profile": false,
                    "intensities": false,
                    "category": {
                        "visible": true,
                        "report": {
                            "descriptionParagraphs": true,
                            "priority": false,
                            "motivation": false,
                            "stress": true,
                            "discStyles": false,
                            "relationship": true,
                            "efficiency": true
                        }
                    }
                }'))),
            ]
        ]);
    }
}
