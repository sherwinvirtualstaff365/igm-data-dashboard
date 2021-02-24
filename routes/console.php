<?php

use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Mail;
use App\Mail\DataEntryNotification;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('data-entry:notification:send', function () {
    dispatch_now(new SendDataEntryNotification(date('Y-m-d'), '15:30'));
});

Artisan::command('notify-sherwin', function () {
    Mail::to('sherwin@virtualstaff365.com.au')->queue(new DataEntryNotification('Sherwin de Jeus', date('Y-m-d'), '15:00'));
});
