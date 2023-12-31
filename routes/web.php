<?php

use App\Models\Message;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProjectsController;

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

Route::get('/', function () {
    return view('home');
})->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__.'/auth.php';

// Route::group([
//     'prefix' => 'admin',
//     'as' => 'admin.',
// ], function () {
//     require __DIR__.'/auth.php';
// });

Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectsController::class, 'show'])->name('projects.show');

/**
 * Messages...
 */
Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('messages', [MessagesController::class, 'create'])->name('messages');
    Route::post('messages', [MessagesController::class, 'store']);
});

/**
 * OTP...
 */
Route::get('otp/request', [OtpController::class, 'create'])->name('otp.create');
Route::post('otp/request', [OtpController::class, 'store']);
Route::get('otp/verify', [OtpController::class, 'verifyForm'])->name('otp.verify');
Route::post('otp/verify', [OtpController::class, 'verify']);

require __DIR__.'/dashboard.php';
require __DIR__.'/freelancer.php';
require __DIR__.'/client.php';
