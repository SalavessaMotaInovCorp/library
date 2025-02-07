<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for generating fake Author data
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(), // Generate a random author name
            'photo' => 'https://picsum.photos/id/' . $this->faker->numberBetween(100, 200) . '/200/300', // Generate a random photo URL
        ];
    }
}
