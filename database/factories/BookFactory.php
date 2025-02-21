<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for generating fake Book data
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isbn' => $this->faker->isbn13(), // Generate a random ISBN-13
            'name' => $this->faker->words(3, true), // Generate a random book title
            'publisher_id' => Publisher::factory(), // Create a related publisher
            'description' => $this->faker->paragraph(), // Generate a random description
            'cover_image' => 'covers/default_cover.jpg',
            'price' => $this->faker->numberBetween(1, 100), // Random price between 5 and 500
        ];
    }
}
