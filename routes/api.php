<?php

use App\Http\Controllers\Api\AuthTokensController;
use App\Http\Controllers\Api\ProjectsController;
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

Route::get('auth/tokens', [AuthTokensController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('auth/tokens', [AuthTokensController::class, 'login'])->middleware(['guest:sanctum']);
Route::delete('auth/tokens/{id}', [AuthTokensController::class, 'destroy'])->middleware(['auth:sanctum']);
Route::post('auth/tokens/logout', [AuthTokensController::class, 'logout'])->middleware(['auth:sanctum']);

Route::group([
    'middleware' => 'auth:sanctum',
], function () {
    Route::apiResource('projects', ProjectsController::class);
});
