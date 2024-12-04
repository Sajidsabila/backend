<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
*/

// Rute login tidak memerlukan middleware
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);

// Rute dengan autentikasi token menggunakan middleware 'auth:sanctum'
Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('category', CategoryController::class);
    Route::apiResource('product', ProductController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});
