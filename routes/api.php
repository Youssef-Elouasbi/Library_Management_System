<?php

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
    // Protected routes for authenticated users

    Route::group(['middleware' => ['admin']], function () {
        // Protected routes for admin users
    });

    Route::group(['middleware' => ['client']], function () {
        // Protected routes for client users
    });
});
