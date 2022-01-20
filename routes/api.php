<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
#import AnimalContorller
use App\Http\Controllers\AnimalController;

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

#method get, endpoint animals
Route::get('/animals', [AnimalController::class, 'index']);

#method post
Route::post('/animals', [AnimalController::class, 'store']);

#method put
Route::put('/animals/{id}', [AnimalController::class, 'update']);

#method delete
Route::delete('/animals/{id}', [AnimalController::class, 'destroy']);