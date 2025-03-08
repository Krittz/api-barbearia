<?php

namespace Database\Factories;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barbershop>
 */
class BarbershopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(), // Nome da barbearia
            'address' => fake()->address(), // Endereço
            'phone' => fake()->numerify('###########'), // Telefone (11 dígitos)
            'owner_id' => User::factory()->create(['role' => UserRole::OWNER])->id, // Cria um usuário OWNER e usa o ID
        ];
    }
}
