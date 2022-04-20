<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Protected Route
Route::middleware('auth:api')->group(function () {

    //Users Routes
    Route::post('/users/logout', [UsersController::class, 'logout']);
    Route::get('/users', [UsersController::class, 'index']);
    Route::get('/users/{user}', [UsersController::class, 'show']);

    //Comments Routes
    Route::get('/posts/{post}/comments', [CommentsController::class, 'index']);
    Route::post('/posts/{post}/comments', [CommentsController::class, 'store']);
    Route::get('/comments/{comment}', [CommentsController::class, 'shows']);

    //Posts Routes
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/users/{user}/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    //Route::apiresource('posts.users', PostsController::class);

    //Tags Routes
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::get('/tags/{tag}', [TagController::class, 'show']);
    Route::put('/tags/{tag}', [TagController::class, 'update']);
    Route::delete('/tags/{tag}', [TagController::class, 'destroy']);


});

//Public Route
Route::post('/users/register', [UsersController::class, 'store']);
Route::post('/users/login', [UsersController::class, 'login']);


