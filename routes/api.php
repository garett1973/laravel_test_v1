<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Public routes

Route::post('/register', [UserController::class, 'register']);
Route::middleware('throttle:3, 1')->post('/login', [UserController::class, 'login']);

//Route::middleware('throttle:3, 30')->group(function () {
//    Route::middleware('throttle:2, 20')->group(function () {
//        Route:: middleware('throttle:1, 10')->post('/login', [UserController::class, 'login']);
//    });
//});
