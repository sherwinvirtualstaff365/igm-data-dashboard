<?php

use Illuminate\Support\Facades\Route;

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

    Route::get('/user-profile', [App\Http\Controllers\UserController::class, 'profile'])->name('user-profile');
    Route::post('/user-profile', [App\Http\Controllers\UserController::class, 'profileUpdate']);


    Route::middleware(['admin'])->group(function(){
        Route::get('/user-list', [App\Http\Controllers\UserController::class, 'list'])->name('user-list');
        Route::get('/user-show/{user?}', [App\Http\Controllers\UserController::class, 'show'])->name('user-show');
        Route::post('/user-save', [App\Http\Controllers\UserController::class, 'save']);
        Route::delete('/user-delete', [App\Http\Controllers\UserController::class, 'delete']);
    });

});





require __DIR__.'/auth.php';
