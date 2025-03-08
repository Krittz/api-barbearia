<?php

namespace App\Policies;

use App\Enum\UserRole;
use App\Exceptions\UnauthorizedException;
use App\Models\Barbershop;
use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function store(User $user, array $data): bool
    {
        $barbershop = Barbershop::findOrFail($data['barbershop_id']);
        if ($user->role === UserRole::ADMIN || $user->id === $barbershop->owner_id) {
            return true;
        }
        throw new UnauthorizedException('Ação não permitida.');
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
