<?php

namespace Tests\Feature;

use App\Enum\UserRole;
use App\Models\Barbershop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarbershopControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_barbershop()
    {
        $owner = User::factory()->create(['role' => UserRole::OWNER]);
        $response = $this->actingAs($owner)->postJson('/api/barbershops', [
            'name' => 'barbearia do joão',
            'address' => 'rua das flores, 123',
            'ddd' => '11',
            'phone' => '999999999',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'address',
                    'phone',
                    'owner',
                    'created_at'
                ],
            ]);
    }
    public function test_list_barbershops_with_search()
    {
        Barbershop::factory()->create(['name' => 'Barbearia do João']);
        Barbershop::factory()->create(['name' => 'Barbearia do Pedro']);
        Barbershop::factory()->create(['name' => 'Corte & Estilo']);

        $user = User::factory()->create(['role' => UserRole::CUSTOMER]);

        $response = $this->actingAs($user)->getJson('/api/barbershops?search=João');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Barbearia Do João');
    }
    public function test_index_barbershops_with_sorting()
    {
        Barbershop::factory()->create(['name' => 'Barbearia do João']);
        Barbershop::factory()->create(['name' => 'Barbearia do Pedro']);
        Barbershop::factory()->create(['name' => 'Corte & Estilo']);

        $user = User::factory()->create(['role' => UserRole::CUSTOMER]);

        $response = $this->actingAs($user)->getJson('/api/barbershops?sort_by=name&order=desc');

        $response->assertStatus(200)
            ->assertJsonPath('data.0.name', 'Corte & Estilo')
            ->assertJsonPath('data.1.name', 'Barbearia Do Pedro')
            ->assertJsonPath('data.2.name', 'Barbearia Do João');
    }
}
