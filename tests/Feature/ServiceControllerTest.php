<?php

namespace Tests\Feature;

use App\Enum\UserRole;
use App\Models\Barbershop;
use App\Models\Service;
use App\Models\User;
use Database\Factories\ServiceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;
    /*
    public function test_store_service()
    {
        // Cria um usuário OWNER
        $owner = User::factory()->create(['role' => UserRole::OWNER]);

        // Cria uma barbearia associada ao OWNER
        $barbershop = Barbershop::factory()->create(['owner_id' => $owner->id]);

        // Dados do serviço
        $serviceData = [
            'name' => 'Corte de Cabelo',
            'description' => 'Corte moderno e estiloso.',
            'price' => 50.00,
            'duration' => 30,
            'barbershop_id' => $barbershop->id,
        ];

        // Faz a requisição de criação do serviço
        $response = $this->actingAs($owner)->postJson('/api/services', $serviceData);

        // Verifica a resposta
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'duration',
                    'barbershop' => [
                        'id',
                        'name',
                    ],
                    'created_at',
                ],
            ])
            ->assertJsonPath('data.name', 'Corte de Cabelo')
            ->assertJsonPath('data.price', 'R$50')
            ->assertJsonPath('data.duration', 30)
            ->assertJsonPath('data.barbershop.id', $barbershop->id);
    }
    public function test_store_service_unauthorized()
    {
        $customer = User::factory()->create(['role' => UserRole::CUSTOMER]);

        $barbershop = Barbershop::factory()->create();

        $serviceData = [
            'name' => 'Corte de Cabelo',
            'description' => 'Corte moderno e estiloso.',
            'price' => 50.00,
            'duration' => 30,
            'barbershop_id' => $barbershop->id,
        ];

        $response = $this->actingAs($customer)->postJson('/api/services', $serviceData);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'error',
                'message' => 'Ação não permitida.',
            ]);
    }

    public function test_store_service_validation_errors()
    {
        $owner = User::factory()->create(['role' => UserRole::OWNER]);

        $barbershop = Barbershop::factory()->create(['owner_id' => $owner->id]);

        $invalidServiceData = [
            'name' => '',
            'price' => -10,
            'duration' => 0,
            'barbershop_id' => 999,
        ];

        $response = $this->actingAs($owner)->postJson('/api/services', $invalidServiceData);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O nome do serviço é obrigatório. (and 3 more errors)',
                'code' => 422,
            ]);
    }
            */

    public function test_show_service()
    {
        // Cria um usuário CUSTOMER
        $customer = User::factory()->create(['role' => UserRole::CUSTOMER]);

        // Cria uma barbearia
        $barbershop = Barbershop::factory()->create();

        // Cria um serviço para a barbearia
        $service = Service::factory()->create(['barbershop_id' => $barbershop->id]);


        // Faz a requisição para exibir o serviço
        $response = $this->actingAs($customer)->getJson("/api/services/{$service->id}");

        // Verifica a resposta
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'duration',
                    'barbershop' => [
                        'id',
                        'name',
                    ],
                    'created_at',
                ],
            ])
            ->assertJsonPath('data.id', $service->id)
            ->assertJsonPath('data.name', $service->name)
            ->assertJsonPath('data.barbershop.id', $barbershop->id);
    }
    public function test_index_services_for_barbershop()
    {
        $customer = User::factory()->create(['role' => UserRole::CUSTOMER]);

        $barbershop = Barbershop::factory()->create();

        $services = Service::factory()->count(3)->create(['barbershop_id' => $barbershop->id]);

        $response = $this->actingAs($customer)->getJson("/api/services/{$barbershop->id}/services");

     
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'duration',
                        'barbershop' => [
                            'id',
                            'name',
                        ],
                        'created_at',
                    ],
                ],
                'links',
                'meta',
            ])
            ->assertJsonCount(3, 'data');
    }
}
