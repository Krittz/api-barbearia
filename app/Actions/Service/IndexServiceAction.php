<?php

namespace App\Actions\Service;

use App\Models\Barbershop;
use Illuminate\Contracts\Pagination\Paginator;

class IndexServiceAction
{

    public function __invoke(Barbershop $barbershop, array $filters = []): Paginator
    {
        $query = $barbershop->services()->with('barbershop');
        if (isset($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        $sortBy = $filters['sort_by'] ?? 'name';
        $order = $filters['order'] ?? 'asc';
        $query->orderBy($sortBy, $order);

        return $query->paginate(10);
    }
}
