<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\CarController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    Route::prefix('auth')->group(function (){
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware('auth:sanctum')->group(function (){
       Route::prefix('cars')->group(function (){
          Route::get('/', [CarController::class, 'index']);
          Route::get('{id}', [CarController::class, 'show']);
          Route::post('addcar', [CarController::class, 'addCar']);
          Route::post('editcar', [CarController::class, 'editCar']);
          Route::get('delete/{id}', [CarController::class, 'deleteCar']);
       });
       Route::get('users', [UserController::class, 'index']);
    });
});
