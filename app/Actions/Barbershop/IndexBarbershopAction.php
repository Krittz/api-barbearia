<?php

namespace App\Actions\Barbershop;

use App\Models\Barbershop;
use Illuminate\Http\Request;

class IndexBarbershopAction
{
    public function __invoke(Request $request)
    {
        $query = Barbershop::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        $sortBy = $request->input('sort_by', 'name');
        $order = $request->input('order', 'asc');
        $query->orderBy($sortBy, $order);

        return $query->paginate(10);
    }
}
