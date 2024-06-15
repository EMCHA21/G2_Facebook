<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FriendshipController;
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

Route::prefix('/user')->group(function () {
    Route::post("/register", [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
    Route::get("/list", [UserController::class, 'index'])->middleware('auth:sanctum');
    Route::get("/show/{id}", [UserController::class, 'show'])->middleware('auth:sanctum');
    Route::put("/update/{id}", [UserController::class, 'update'])->middleware('auth:sanctum');
    Route::post("/update/profile/{id}", [UserController::class, 'uploadProfile'])->middleware('auth:sanctum');
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
    Route::delete("/delete/{id}", [UserController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::prefix('/post')->middleware('auth:sanctum')->group(function () {
    Route::get("/list", [PostController::class, 'index']);
    Route::post("/create", [PostController::class, 'store']);
    Route::get("/show/{id}", [PostController::class, 'show']);
    Route::put("/update/{id}", [PostController::class, 'update']);
    Route::delete("/delete/{id}", [PostController::class, 'destroy']);
});

Route::prefix('/like')->middleware('auth:sanctum')->group(function () {
    Route::get('/list', [LikeController::class, 'index']);
    Route::post('/like', [LikeController::class, 'addLike']);
});
Route::prefix('/comment')->middleware('auth:sanctum')->group(function () {
    Route::get("/list", [CommentController::class, 'index']);
    Route::post("/create", [CommentController::class, 'store']);
    Route::get("/show/{id}", [CommentController::class, 'show']);
    Route::put("/update/{id}", [CommentController::class, 'update']);
    Route::delete("/delete/{id}", [CommentController::class, 'destroy']);
});

Route::prefix('/friends')->middleware('auth:sanctum')->group(function () {
    Route::post('/send-friend', [FriendshipController::class, 'addFried']);
    Route::post('/confirm-friend', [FriendshipController::class, 'confirmFriend']);
    Route::get('/friend-confirmed', [FriendshipController::class, 'list_friend_accepted']);
    Route::get('/friend-unaccepted', [FriendshipController::class, 'list_friend_unaccepted']);
    Route::delete('/unaccepted-friend/{id}', [FriendshipController::class, 'unaccepted']);
    Route::delete('/unfriend/{id}', [FriendshipController::class, 'unfriend']);
});
