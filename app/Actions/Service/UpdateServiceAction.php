<?php

namespace App\Actions\Service;

use App\Models\Service;

class UpdateServiceAction
{
    /**
     * Create a new class instance.
     */
    public function __invoke(Service $service, array $data)
    {
        $service->update($data);
        return $service;
    }
}
