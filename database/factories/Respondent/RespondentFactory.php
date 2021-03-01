<?php

namespace Database\Factories\Respondent;

use App\Models\Respondent\Respondent;
use App\Models\Respondent\RespondentList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RespondentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Respondent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'customer_id' => 1,
            'respondent_list_id' => mt_rand(1, RespondentList::count()),
            'email' => $this->faker->unique()->safeEmail,
            'uuid' => Str::uuid()
        ];
    }
}
