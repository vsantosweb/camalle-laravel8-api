<?php

namespace Database\Factories\Respondent;

use App\Models\Disc\DiscCombination;
use App\Models\Disc\DiscRanges;
use App\Models\Respondent\RespondentDiscTest;
use Illuminate\Database\Eloquent\Factories\Factory;

class RespondentDiscTestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RespondentDiscTest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $graphs = json_decode(str_replace(array("\r", "\n", " "), "",'[{
            "graphName": "less",
                "graphLetters": {
                    "D": ' . mt_rand(0, 28) . ',
                    "I":' . mt_rand(0, 28) . ',
                    "S": ' . mt_rand(0, 28) . ',
                    "C": ' . mt_rand(0, 28) . '
                }
            },
            {
                "graphName": "more",
                "graphLetters": {
                    "D": ' . mt_rand(0, 28) . ',
                    "I":' . mt_rand(0, 28) . ',
                    "S": ' . mt_rand(0, 28) . ',
                    "C": ' . mt_rand(0, 28) . '
                }
            },
            {
                "graphName": "difference",
                "graphLetters": {
                    "D": ' . mt_rand(-28, 28) . ',
                    "I":' . mt_rand(-28, 28) . ',
                    "S": ' . mt_rand(-28, 28) . ',
                    "C": ' . mt_rand(-28, 28) . '
                }
            }
        ]'));

            

        for ($i = 0; $i < count($graphs); $i++) {
            foreach ($graphs[$i]->graphLetters as $letter => $value) {
                foreach (DiscRanges::all() as $discRanges) {
                    if ($discRanges->graphType->name == $graphs[$i]->graphName) {
                        foreach ($discRanges->range as $rangeIntensity) {
                            if ($letter == $discRanges->disc->letter) {
                                if (false !== array_search($value, $rangeIntensity->range)) {
                                    $profile[$graphs[$i]->graphName][] = $discRanges->segment->number;
                                    $intensities[$graphs[$i]->graphName][] =  $rangeIntensity->intensity;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (count($profile['difference']) < 4) {

            return 'Combinação inválida';
        }

        $code = $profile['difference'][0] . $profile['difference'][1] . $profile['difference'][2] . $profile['difference'][3];

        $combination = DiscCombination::where('code', $code)->with('profile', 'category')->first();
        $combination->intensities = $intensities;
        $combination->graphs = $graphs;
        
        return [
            'code' => strtoupper(uniqid()),
            'respondent_disc_test_message_id' => 1,
            'metadata' => json_decode($combination),
            'was_finished' => 1,
            'ip' => $this->faker->ipv4
        ];
    }
}
