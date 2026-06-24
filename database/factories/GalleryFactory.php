<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'image' => 'gallery/test-' . fake()->uuid() . '.jpg',
            'caption' => fake()->sentence(),
            'sort_order' => 0,
        ];
    }
}
