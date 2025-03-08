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
            'phone' => '11999999999',
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

    public function test_update_barbershop()
    {
        $owner = User::factory()->create(['role' => UserRole::OWNER]);

        $barbershop = Barbershop::factory()->create(['owner_id' => $owner->id]);

        $updateData = [
            'name' => 'Barbearia do João Atualizada',
            'address' => 'Nova Rua, 456',
            'phone' => '11999576845',
        ];

        $response = $this->actingAs($owner)->patchJson("/api/barbershops/{$barbershop->id}", $updateData);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'address',
                    'phone',
                    'created_at'
                ],
            ])
            ->assertJsonPath('data.name', 'Barbearia Do João Atualizada')
            ->assertJsonPath('data.address', 'Nova Rua, 456')
            ->assertJsonPath('data.phone', '11999576845');
    }

    public function test_update_barbershop_unauthorized()
    {
        $owner = User::factory()->create(['role' => UserRole::OWNER]);

        $anotherOwner = User::factory()->create(['role' => UserRole::OWNER]);

        $barbershop = Barbershop::factory()->create(['owner_id' => $owner->id]);

        $updateData = [
            'name' => 'Barbearia do João Atualizada',
        ];

        $response = $this->actingAs($anotherOwner)->patchJson("/api/barbershops/{$barbershop->id}", $updateData);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'error',
                'message' => 'Ação não permitida.',
            ]);
    }
    public function test_delete_barbershop()
    {
        $owner = User::factory()->create(['role' => UserRole::OWNER]);

        $barbershop = Barbershop::factory()->create(['owner_id' => $owner->id]);

        $response = $this->actingAs($owner)->deleteJson("/api/barbershops/{$barbershop->id}");
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Barbearia excluída com sucesso.',
            ]);

        $this->assertSoftDeleted($barbershop);
    }
    public function test_delete_barbershop_as_admin()
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $owner = User::factory()->create(['role' => UserRole::OWNER]);

        $barbershop = Barbershop::factory()->create(['owner_id' => $owner->id]);

        $response = $this->actingAs($admin)->deleteJson("/api/barbershops/{$barbershop->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Barbearia excluída com sucesso.',
            ]);
        $this->assertSoftDeleted($barbershop);
    }
}
