<?php

namespace Tests\Feature;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /*
    use RefreshDatabase;

    public function test_store_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => UserRole::CUSTOMER->value
        ];

        $response = $this->postJson("/api/users", $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                ],
            ]);
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }
    public function test_index_users()
    {
        User::factory()->count(10)->create();
        $admin = User::factory()->create(['role' => UserRole::ADMIN->value]);
        $response = $this->actingAs($admin)->getJson("/api/users");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'role',
                        'created_at'
                    ],
                ],
            ]);
    }
    public function test_show_user()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => UserRole::ADMIN->value]);
        $response = $this->actingAs($admin)->getJson("api/users/{$user->id}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                ],
            ]);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $updateData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->actingAs($user)->patchJson("api/users/{$user->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
    }
    public function test_delete_user()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => UserRole::ADMIN->value]);

        $response = $this->actingAs($admin)->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Usuário excluído com sucesso.',
            ]);
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);
    }

    public function test_store_user_validation_errors()
    {
        // Testando campo 'name' obrigatório
        $response = $this->postJson('/api/users', [
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => UserRole::CUSTOMER->value,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O nome é obrigatório.',
            ]);

        // Testando campo 'email' inválido
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => UserRole::CUSTOMER->value,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O e-mail deve ser um endereço de e-mail válido.',
            ]);

        // Testando campo 'password' com menos de 8 caracteres
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '123',
            'password_confirmation' => '123',
            'role' => UserRole::CUSTOMER->value,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'A senha deve ter pelo menos 8 caracteres.',
            ]);

        // Testando campo 'role' inválido
        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'invalid-role',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O tipo de usuário é inválido.',
            ]);
    }

    public function test_update_user_validation_errors()
    {
        $user = User::factory()->create();

        // Testando campo 'email' inválido
        $response = $this->actingAs($user)->patchJson("/api/users/{$user->id}", [
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'O e-mail deve ser um endereço de e-mail válido.',
            ]);

        // Testando campo 'password' com menos de 8 caracteres
        $response = $this->actingAs($user)->patchJson("/api/users/{$user->id}", [
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'A senha deve ter pelo menos 8 caracteres.',
            ]);
    }

    public function test_unauthorized_exception()
    {
        $user = User::factory()->create(['role' => UserRole::CUSTOMER->value]);

        // Tentando acessar a lista de usuários sem ser admin
        $response = $this->actingAs($user)->getJson('/api/users');

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'error',
                'message' => 'Acesso não autorizado.',
                'code' => 403,
            ]);
    }
    public function test_authentication_exception()
    {
        // Tentando acessar uma rota protegida sem autenticação
        $response = $this->getJson('/api/users');

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Usuário não autenticado.',
                'code' => 401,
            ]);
    }

    public function test_authorization_exception()
    {
        $user = User::factory()->create(['role' => UserRole::CUSTOMER->value]);
        $anotherUser = User::factory()->create();

        // Tentando atualizar outro usuário sem permissão
        $response = $this->actingAs($user)->patchJson("/api/users/{$anotherUser->id}", [
            'name' => 'Jane Doe',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'error',
                'message' => 'Acesso não autorizado.',
                'code' => 403,
            ]);
    }

    public function test_index_pagination()
    {
        User::factory()->count(14)->create(); // Cria 15 usuários
        $admin = User::factory()->create(['role' => UserRole::ADMIN->value]);

        // Testa a primeira página
        $response = $this->actingAs($admin)->getJson('/api/users?page=1');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'role',
                        'created_at',
                    ],
                ],
                'links',
                'meta',
            ])
            ->assertJsonCount(10, 'data'); // Verifica se retornou 10 itens na primeira página

        // Testa a segunda página
        $response = $this->actingAs($admin)->getJson('/api/users?page=2');
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data'); // Verifica se retornou os 5 itens restantes
    }


    public function test_soft_delete()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => UserRole::ADMIN->value]);

        // Deleta o usuário
        $this->actingAs($admin)->deleteJson("/api/users/{$user->id}");

        // Verifica se o usuário não aparece na listagem
        $response = $this->actingAs($admin)->getJson('/api/users');
        $response->assertStatus(200)
            ->assertJsonMissing(['id' => $user->id]);

        // Verifica se o usuário ainda existe no banco de dados
        $this->assertDatabaseHas('users', ['id' => $user->id])
            ->assertNotNull(User::withTrashed()->find($user->id)->deleted_at);
    }
    public function test_partial_update()
    {
        $user = User::factory()->create(['name' => 'John Doe']);
        $updateData = ['email' => 'john.doe@example.com'];

        $response = $this->actingAs($user)->patchJson("/api/users/{$user->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => 'John Doe', // Nome não foi alterado
                    'email' => 'john.doe@example.com', // Email foi atualizado
                ],
            ]);
    }
    public function test_update_email_conflict()
    {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        // Tenta atualizar o email do user1 para o email do user2
        $response = $this->actingAs($user1)->patchJson("/api/users/{$user1->id}", [
            'email' => 'user2@example.com',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'E-mail inválido ou já está em uso.',
            ]);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes()
    {
        $user = User::factory()->create();

        // Tenta acessar a listagem de usuários sem autenticação
        $response = $this->getJson('/api/users');

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'error',
                'message' => 'Usuário não autenticado.',
                'code' => 401,
            ]);
    }
    public function test_duplicate_email_on_store()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => UserRole::CUSTOMER->value,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'E-mail inválido ou já está em uso.',
            ]);
    }
    public function test_index_performance_with_large_dataset()
    {
        User::factory()->count(1000)->create();
        $admin = User::factory()->create(['role' => UserRole::ADMIN->value]);

        $this->actingAs($admin)->getJson('/api/users')->assertStatus(200);
    }
    public function test_store_user_success_response()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => UserRole::CUSTOMER->value,
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'created_at',
                ],
            ]);
    }
    public function test_delete_already_deleted_user()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => UserRole::ADMIN->value]);

        // Deleta o usuário
        $this->actingAs($admin)->deleteJson("/api/users/{$user->id}");

        // Tenta deletar novamente
        $response = $this->actingAs($admin)->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Nenhum resultado encontrado.',
                'code' => 404,
            ]);
    }

    public function test_update_nonexistent_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patchJson("/api/users/999999", [
            'name' => 'Nonexistent User',
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'error',
                'message' => 'Nenhum resultado encontrado.',
                'code' => 404
            ]);
    }
    public function test_non_admin_cannot_delete_user()
    {
        $user = User::factory()->create(['role' => UserRole::CUSTOMER->value]);
        $anotherUser = User::factory()->create();

        // Tenta deletar outro usuário sem ser admin
        $response = $this->actingAs($user)->deleteJson("/api/users/{$anotherUser->id}");

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'error',
                'message' => 'Acesso não autorizado.',
                'code' => 403,
            ]);
    }
    public function test_index_order_by_name()
    {
        // Cria 3 usuários, sendo que o primeiro já é um admin
        User::factory()->create(['name' => 'Zebra', 'role' => UserRole::ADMIN->value]);
        User::factory()->create(['name' => 'Apple']);
        User::factory()->create(['name' => 'Banana']);

        // Recupera o admin para autenticar
        $admin = User::where('role', UserRole::ADMIN->value)->first();

        // Ordena por nome
        $response = $this->actingAs($admin)->getJson('/api/users?order_by=name&order=asc');
        $response->assertStatus(200)
            ->assertJsonPath('data.0.name', 'Apple')
            ->assertJsonPath('data.1.name', 'Banana')
            ->assertJsonPath('data.2.name', 'Zebra');
    }


    public function test_index_filter_by_role()
    {
        User::factory()->count(5)->create(['role' => UserRole::CUSTOMER->value]);
        User::factory()->count(3)->create(['role' => UserRole::ADMIN->value]);
        $admin = User::factory()->create(['role' => UserRole::ADMIN->value]);
        // Filtra por role 'admin'
        $response = $this->actingAs($admin)->getJson('/api/users?role=admin');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data'); // 3 admins + 1 admin autenticado
    }
    */
}
