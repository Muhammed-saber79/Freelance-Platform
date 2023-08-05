<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => '/dashboard',
    'middleware' => ['auth'],
    'as' => 'dashboard.'
], function () {
    // Dashboard Index...
    Route::get('/', [UsersController::class, 'index'])->name('index');

    // Categories...
    Route::resource('/categories', CategoriesController::class);
   
    // Users...
    Route::group([
        'as' => 'users.'
    ], function () {
        Route::get('/user/add', [UsersController::class, 'create'])->name('add');
        Route::post('/user/store', [UsersController::class, 'store'])->name('store');
        
        Route::get('/user/edit/{id}', [UsersController::class, 'edit'])->name('edit');
        Route::put('/user/update/{id}', [UsersController::class, 'update'])->name('update');
        
        // Route::get('/user/details/{id}', [UsersController::class, 'details'])->name('details');
        // Details Route but this time by using Model-Route Binding concept...
        Route::get('/user/details/{user}', [UsersController::class, 'show'])->name('details');
        Route::get('/user/delete/{id}', [UsersController::class, 'destroy'])->name('delete');
    });

    Route::get('profile', function () {
        return 'Secret Profile Page...!';
    })->middleware('password.confirm');
});