<?php

namespace App\Actions\Barbershop;

use App\Models\Barbershop;

class UpdateBarbershopAction
{
    /**
     * Create a new class instance.
     */
    public function __invoke(Barbershop $barbershop, array $data)
    {
        $barbershop->update($data);
        return $barbershop;
    }
}
