<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth']], function () {

    Route::get('logout', [UserController::class, "logout"]);
    Route::get('books', BookController::class);
    Route::get('books/{book}', BookController::class);

    Route::group(['middleware' => ['admin']], function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('users', UserController::class);
        Route::post('books', BookController::class);
        Route::put('books/{book}', BookController::class);
        Route::delete('books/{book}', BookController::class);
    });

    Route::group(['middleware' => ['client']], function () {
        // Protected routes for client users
    });
});



Route::post('login', [UserController::class, "login"]);
Route::post('register', [UserController::class, "store"]);
