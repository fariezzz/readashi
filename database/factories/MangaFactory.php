<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manga>
 */
class MangaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'genre_id' => Genre::query()->inRandomOrder()->value('id') ?? 1,
            'name' => fake()->sentence(4, true),
            'code' => fake()->unique()->numerify('###########'),
            'author' => fake()->name(),
            'publisher' => fake()->optional()->company(),
            'published_year' => fake()->optional()->numberBetween(1980, (int) date('Y')),
            'synopsis' => fake()->optional()->sentence(),
            'stock' => fake()->numberBetween(1, 50),
            'image' => null,
        ];
    }
}



