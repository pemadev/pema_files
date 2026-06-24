<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'position' => fake()->jobTitle(),
            'photo' => null,
            'category' => fake()->randomElement(['direksi', 'komisaris']),
            'sort_order' => 0,
        ];
    }
}
