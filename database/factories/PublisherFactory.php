<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for generating fake Publisher data
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(), // Generate a random company name
            'logo' => 'https://picsum.photos/id/' . $this->faker->numberBetween(100, 150) . '/200/300', // Generate a random logo URL
        ];
    }
}
