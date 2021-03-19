<?php

namespace Database\Factories\respondent;

use App\Models\Respondent\RespondentList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RespondentListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RespondentList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'List '. strtoupper(uniqid()),
            'customer_id' => 1,
            'uuid' => Str::uuid(),
            'description' => $this->faker->paragraph
        ];
    }
}
