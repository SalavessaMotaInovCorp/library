<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
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
            'isbn' => $this->faker->isbn13(),
            'name' => $this->faker->words(3, true),
            'publisher_id' => Publisher::factory(),
            'description' => $this->faker->paragraph(),
            'cover_image' => 'https://picsum.photos/id/' . $this->faker->numberBetween(100, 200) . '/200/300',
            'price' => $this->faker->numberBetween(5, 500),
        ];
    }
}
