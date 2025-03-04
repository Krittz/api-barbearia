<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BarbershopController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);


    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    Route::prefix('/barbershops')->group(function () {
        Route::post('/', [BarbershopController::class, 'store']);
        Route::get('/', [BarbershopController::class, 'index']);
        Route::get('/{barbershop}', [BarbershopController::class, 'show']);
        Route::patch('/{barbershop}', [BarbershopController::class, 'update']);
        Route::delete('/{barbershop}', [BarbershopController::class, 'destroy']);
    });

    Route::prefix('/services')->group(function () {
        Route::post('/', [ServiceController::class, 'store']);
    });
});
