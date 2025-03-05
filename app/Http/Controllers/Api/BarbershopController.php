<?php

namespace App\Http\Controllers\Api;

use App\Actions\Barbershop\DeleteBarbershopAction;
use App\Actions\Barbershop\IndexBarbershopAction;
use App\Actions\Barbershop\ShowBarbershopAction;
use App\Actions\Barbershop\StoreBarbershopAction;
use App\Actions\Barbershop\UpdateBarbershopAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Barbershop\IndexBarbershopRequest;
use App\Http\Requests\Barbershop\StoreBarbershopRequest;
use App\Http\Requests\Barbershop\UpdateBarbershopRequest;
use App\Http\Resources\BarbershopResource;
use App\Models\Barbershop;
use Illuminate\Support\Facades\Gate;

class BarbershopController extends Controller
{

    public function index(IndexBarbershopRequest $request, IndexBarbershopAction $action)
    {
        $barbershops = $action($request);
        return BarbershopResource::collection($barbershops);
    }
    public function store(StoreBarbershopRequest $request, StoreBarbershopAction $action)
    {
        Gate::authorize('store', Barbershop::class);
        $barbershop = $action($request->validated(), $request->user());
        return new BarbershopResource($barbershop);
    }
    public function show(int $id, ShowBarbershopAction $action)
    {
        $barbershop = $action($id);
        return new BarbershopResource($barbershop);
    }
    public function update(UpdateBarbershopRequest $request, Barbershop $barbershop, UpdateBarbershopAction $action)
    {
        Gate::authorize('update', $barbershop);

        $updatedBarbershop = $action($barbershop, $request->validated());
        return new BarbershopResource($updatedBarbershop);
    }
    public function destroy(DeleteBarbershopAction $action, Barbershop $barbershop)
    {
        Gate::authorize('delete', $barbershop);
        $action($barbershop);
        return response()->json([
            'status' => 'success',
            'message' => 'Barbearia excluída com sucesso.',
        ]);
    }
}
