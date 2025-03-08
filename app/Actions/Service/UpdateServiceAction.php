<?php

namespace App\Actions\Service;

use App\Models\Service;

class UpdateServiceAction
{
    public function __invoke(Service $service, array $data)
    {
        $service->update($data);
        return $service;
    }
}
