<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\StatusesController;
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

Route::middleware(['auth:sanctum'])->group(function() {
	Route::get('/patients', [PatientsController::class, 'index'])->middleware('auth:sanctum');
	Route::get('/patients/{id}', [PatientsController::class, 'show']);
	Route::post('/patients', [PatientsController::class, 'store']);
	Route::put('/patients/{id}', [PatientsController::class, 'update']);
	Route::delete('/patients/{id}', [PatientsController::class, 'destroy']);
	
	Route::get('/patients/search/{name}', [PatientsController::class, 'search']);
	Route::get('/patients/status/positive', [PatientsController::class, 'positive']);
	Route::get('/patients/status/recovered', [PatientsController::class, 'recovered']);
	Route::get('/patients/status/dead', [PatientsController::class, 'dead']);

	Route::get('/status', [StatusesController::class, 'autoFill']);
});

// Endpoint Register dan Login
Route::post ('/register', [AuthController::class, 'register']);
Route::post ('/login', [AuthController::class, 'login']);



