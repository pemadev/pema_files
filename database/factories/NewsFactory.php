<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['berita', 'pengumuman']),
            'title' => fake()->sentence(5),
            'content' => fake()->paragraphs(3, true),
            'image' => null,
            'date' => fake()->date(),
            'author' => fake()->name(),
            'is_published' => true,
        ];
    }
}
