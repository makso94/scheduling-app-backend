<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingDaysController;
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


Route::get('/users', [UserController::class, 'getAll']);
Route::post('/users', [UserController::class, 'create']);
Route::get('/users/{id}/approve', [UserController::class, 'approve']);
Route::get('/users/{id}/deactive', [UserController::class, 'deactive']);

Route::get('/working-days', [WorkingDaysController::class, 'getByMonthYear']);
Route::post('/working-days', [WorkingDaysController::class, 'createByMonthYear']);
Route::put('/working-days/{id}', [WorkingDaysController::class, 'update']);


Route::get('/appointments', [AppointmentsController::class, 'getAppoitmentsByDate']);
