<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\InfusionController;

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

Route::get('/ping', function() {
    Artisan::call('schedule:run');
    echo date('Y-m-d H:i:s');
});

Route::get('/infusionsoft/callback', 'InfusionsoftController@callback');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user-profile', [UserController::class, 'profile'])->name('user-profile');
    Route::post('/user-profile', [UserController::class, 'profileUpdate']);

    Route::get('/data-entry/staff', [DataController::class, 'show'])->name('data-entry-staff');
    Route::get('/data-entry/staff/{date}/{quarter}', [DataController::class, 'getEntry']);
    Route::post('/data-entry/staff/{date}/{quarter}', [DataController::class, 'saveEntry']);

    Route::get('/data-entry/leads', [LeadController::class, 'show'])->name('data-entry-leads');
    Route::get('/data-entry/leads/{date}', [LeadController::class, 'getEntry']);
    Route::post('/data-entry/leads/{date}', [LeadController::class, 'saveEntry']);

    Route::get('/data-entry/infusion', [InfusionController::class, 'show'])->name('data-entry-infusion');
    Route::get('/data-entry/infusion/{date}/{staff}', [InfusionController::class, 'getEntry']);
    Route::post('/data-entry/infusion/{date}/{staff}', [InfusionController::class, 'saveEntry']);

    Route::get('/data-entry/financials', [FinancialController::class, 'show'])->name('data-entry-financials');
    Route::get('/data-entry/financials/{date}', [FinancialController::class, 'getEntry']);
    Route::post('/data-entry/financials/{date}', [FinancialController::class, 'saveEntry']);

    Route::middleware(['admin'])->group(function(){
        Route::get('/user-list', [UserController::class, 'list'])->name('user-list');
        Route::get('/user-show/{user?}', [UserController::class, 'show'])->name('user-show');
        Route::post('/user-save', [UserController::class, 'save']);
        Route::delete('/user-delete', [UserController::class, 'delete']);
    });

});





require __DIR__.'/auth.php';
