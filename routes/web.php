<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user-profile', [UserController::class, 'profile'])->name('user-profile');
    Route::post('/user-profile', [UserController::class, 'profileUpdate']);

    Route::get('/data-entry', [DataController::class, 'show'])->name('data-entry-form');
    Route::get('/data-entry/{date}/{quarter}', [DataController::class, 'getEntry']);
    Route::post('/data-entry/{date}/{quarter}', [DataController::class, 'saveEntry']);

    Route::get('/data-summary', [DataController::class, 'summary']);

    Route::middleware(['admin'])->group(function(){
        Route::get('/user-list', [UserController::class, 'list'])->name('user-list');
        Route::get('/user-show/{user?}', [UserController::class, 'show'])->name('user-show');
        Route::post('/user-save', [UserController::class, 'save']);
        Route::delete('/user-delete', [UserController::class, 'delete']);
    });

});





require __DIR__.'/auth.php';
