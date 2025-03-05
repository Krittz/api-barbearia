<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\Barbershop;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => UserRole::ADMIN,
        ]);
        // User::factory(3)->create();
        Barbershop::factory(1)->create();
        Service::factory(4)->create([
            'barbershop_id' => 1
        ]);
    }
}
