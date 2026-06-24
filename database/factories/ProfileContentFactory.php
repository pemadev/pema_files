<?php

namespace Database\Factories;

use App\Models\ProfileContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileContentFactory extends Factory
{
    protected $model = ProfileContent::class;

    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['sambutan', 'sejarah', 'visi_misi', 'stakeholder']),
            'title' => fake()->sentence(4),
            'content' => fake()->paragraphs(2, true),
            'image' => null,
            'additional_info' => null,
        ];
    }
}
