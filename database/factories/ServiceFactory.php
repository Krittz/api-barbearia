<?php

namespace Database\Factories;

use App\Models\Barbershop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 100),
            'duration' => fake()->numberBetween(15, 120),

            'barbershop_id' => Barbershop::factory(),
        ];
    }
}
