<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/profile/change-password', [UserController::class, 'reset_Password'])->middleware('auth:sanctum');

Route::prefix('/user')->group(function () {
    Route::post("/register", [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
    Route::get("/list", [UserController::class, 'index']);
    Route::get("/show/{id}", [UserController::class, 'show']);
    Route::put("/update/{id}", [UserController::class, 'update']);
    Route::put("/update/profile/{id}", [UserController::class, 'uploadProfile']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::delete("/delete/{id}", [UserController::class, 'destroy']);
});

// Route::prefix('prefix')->group(function () {
//     // Define routes here
// });
