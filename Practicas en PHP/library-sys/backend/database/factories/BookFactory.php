<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        'id' => (string) Str::uuid(),
        'name' => $this->faker->sentence(3),
        'edition' => $this->faker->randomElement(['1st', '2nd', '3rd']),
        'publish_date' => $this->faker->date(),
        ];
    }
}
