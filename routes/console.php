<?php

use Illuminate\Support\Facades\Artisan;
use \App\Jobs\SendDataEntryNotification;

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
