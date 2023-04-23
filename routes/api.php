<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BookController;
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
    Route::get('/reservations/{user}', [ReservationController::class, 'getReservationByUser']);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);

    Route::group(['middleware' => ['admin']], function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('users', UserController::class);
        // Route::apiResource('books', BookController::class);
        Route::post('books', [BookController::class, 'store']);
        Route::put('books/{book}', [BookController::class, 'update']);
        Route::delete('books/{book}', [BookController::class, 'destroy']);
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
    });

    Route::group(['middleware' => ['client']], function () {
        Route::post('/reservations', [ReservationController::class, 'store']);
        // Protected routes for client users
    });
});



Route::get('books', [BookController::class, 'index']);
Route::get('books/{book}', [BookController::class, 'show']);

Route::post('login', [UserController::class, "login"]);
Route::post('register', [UserController::class, "store"]);
