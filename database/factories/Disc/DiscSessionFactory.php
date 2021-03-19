<?php

namespace Database\Factories\Disc;

use App\Models\Disc\DiscSession;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscSessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscSession::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'expire_at' => now()->addMinutes(15),
            'has_expired' => 0,
            'has_finished'=>0,
            'active' => 1,
        ];
    }
}
