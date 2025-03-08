<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;

class IndexUserAction
{
    public function __invoke(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $sortBy = $request->input('sort_by', 'name');
        $order = $request->input('order', 'asc');
        $query->orderBy($sortBy, $order);

        return $query->paginate(10);
    }
}
