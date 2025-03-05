<?php

namespace App\Actions\Service;

use App\Models\Service;

class ShowServiceAction
{
    /**
     * Create a new class instance.
     */
    public function __invoke(int $id)
    {
        return Service::with('barbershop')->findOrFail($id);
    }
}
