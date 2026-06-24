<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    protected $model = Business::class;

    public function definition(): array
    {
        return [
            'category' => fake()->randomElement(['migas', 'agroindustri', 'jasa']),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'icon' => 'fi fi-rs-briefcase',
            'tags' => [fake()->word(), fake()->word()],
            'sort_order' => 0,
        ];
    }
}
