<?php

namespace App\Actions\Barbershop;

use App\Models\Barbershop;

class DeleteBarbershopAction
{
    /**
     * Create a new class instance.
     */
    public function __invoke(Barbershop $barbershop)
    {
        $barbershop->delete();
    }
}
