<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\DeveloperController;
use App\Models\User;



Route::post('/login', [AuthController::class, 'auth']);
Route::put('/register', [AuthController::class, 'register']);
Route::get('/developer', [DeveloperController::class, 'get']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/users', function (Request $request) {
        return User::get();
    });
});

