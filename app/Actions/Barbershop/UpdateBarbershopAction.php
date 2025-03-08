<?php

namespace App\Actions\Barbershop;

use App\Models\Barbershop;

class UpdateBarbershopAction
{
    
    public function __invoke(Barbershop $barbershop, array $data)
    {
        $barbershop->update($data);
        return $barbershop;
    }
}
