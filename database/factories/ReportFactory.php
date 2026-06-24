<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'file' => null,
            'year' => (string) fake()->year(),
            'description' => fake()->paragraph(),
            'is_published' => true,
        ];
    }
}
