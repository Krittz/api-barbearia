<?php

namespace App\Actions\Service;

use App\Models\Service;

class DeleteServiceAction
{
    /**
     * Create a new class instance.
     */
    public function __invoke(Service $service)
    {
        $service->delete();
    }
}
