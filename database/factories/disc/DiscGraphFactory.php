<?php

namespace Database\Factories\disc;

use App\Models\Disc\DiscGraph;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscGraphFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscGraph::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'graphs' => json_decode(str_replace(array("\r", "\n", " "), "", '[{
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
                ]
            ]'))
        ];
    }
}
