<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Exceptions\UnauthorizedException;
use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ServicePolicy
{
    public function store(User $user): bool
    {
        if ($user->role !== UserRole::OWNER && $user->role !== UserRole::ADMIN) {
            throw new UnauthorizedException('Ação não permitida.');
        }
        return true;
    }

    public function update(User $user, Service $service)
    {
        if ($user->role !== UserRole::ADMIN && $user->id !== $service->barbershop->owner_id) {
            throw new UnauthorizedException('Ação não permitida.');
        }
        return true;
    }
    public function delete(User $user, Service $service)
    {
        if ($user->role !== UserRole::ADMIN && $user->id !== $service->barbershop->owner_id) {
            throw new UnauthorizedException('Ação não permitida.');
        }
        return true;
    }
}
