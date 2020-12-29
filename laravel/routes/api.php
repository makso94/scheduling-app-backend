<?php

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\DocBlock\Serializer;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/services', [ServiceController::class, 'getAll']);
Route::get('/services/{id}', [ServiceController::class, 'get']);
Route::post('/services', [ServiceController::class, 'create']);
Route::put('/services/{id}', [ServiceController::class, 'update']);
Route::delete('/services/{id}', [ServiceController::class, 'delete']);


Route::put('/session', [SessionController::class, 'login']);
Route::get('/session', [SessionController::class, 'checkSession']);
Route::delete('/session', [SessionController::class, 'logout']);


Route::post('/users', [UserController::class, 'create']);
Route::get('/users', [UserController::class, 'getAll']);

