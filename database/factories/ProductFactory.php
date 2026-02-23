<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? 1,
            'name' => fake()->sentence(4, true),
            'code' => fake()->unique()->numerify('###########'),
            'description' => fake()->optional()->sentence(),
            'stock' => fake()->numberBetween(1, 50),
            'price' => fake()->numberBetween(10000, 250000),
            'image' => null,
        ];
    }
}
