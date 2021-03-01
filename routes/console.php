<?php

use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Mail;
use App\Mail\DataEntryNotification;
use Illuminate\Support\Facades\Http;


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
    dispatch_now(new App\Jobs\SendDataEntryNotification(date('Y-m-d'), '15:30'));
});

Artisan::command('notify-sherwin', function () {
    Mail::to('production@sitesnstores.com.au')->queue(new DataEntryNotification('Sherwin de Jeus', date('Y-m-d'), '15:00'));
});

Artisan::command('test', function(){
    $infusionsoft = new App\Classes\Infusionsoft;
    $data = $infusionsoft::getSearchResults(3574);
    // dump($data);
});

Artisan::command('test2', function ()
{
    // $infusionsoft = new \Infusionsoft\Infusionsoft(array(
    //     'clientId'     => 'eSfbAwymYs0JVt9tAnQJkkURekv7FW2A',
    //     'clientSecret' => 'pxFllcKqrA7olfAZ',
    //     'redirectUri'  => 'http://example.com/',
    // ));
    // $token = $infusionsoft->requestAccessToken('igm-dashboard');

    // access token: UQnUtWx9WH0AD8OSsvvgtcOUqP0n

    // \Log::debug($token);
    $client = new GuzzleHttp\Client();

    // &since=2019-01-01T00:00:00.000Z
    $token = '0KA0JiCbrK6k0r1joAGaBVoJJ637';
    $url = '/tasks/search/?user_id=205&since=2021-01-01T00:00:00.000Z';
    //$url = '/oauth/connect/userinfo';
    $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('https://api.infusionsoft.com/crm/rest/v1' . $url);


    echo $response->body();
});
