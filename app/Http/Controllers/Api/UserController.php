<?php

namespace App\Http\Controllers\Api;

use App\Actions\User\DeleteUserAction;
use App\Actions\User\IndexUserAction;
use App\Actions\User\ShowUserAction;
use App\Actions\User\UpdateUserAction;
use App\Actions\User\StoreUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function index(UserIndexRequest $request, IndexUserAction $action)
    {
        Gate::authorize('viewAny', User::class);
        $users = $action($request);
        return UserResource::collection($users);
    }


    public function store(StoreUserRequest $request, StoreUserAction $action)
    {
        $user = $action($request->validated());
        return new UserResource($user);
    }



    public function show(int $id, ShowUserAction $action)
    {
        $user = $action($id);
        Gate::authorize('show', $user);
        return new UserResource($user);
    }




    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action)
    {

        Gate::authorize('update', $user);
        $updatedUser = $action($user, $request->validated());
        return new UserResource($updatedUser);
    }

    public function destroy(User $user, DeleteUserAction $action)
    {
        Gate::authorize('delete', $user);
        $action($user);
        return response()->json(['status' => 'success', 'message' => 'Usuário excluído com sucesso.'], 200);
    }
}
