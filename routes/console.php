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
    Mail::to('sherwin@virtualstaff365.com.au')->queue(new DataEntryNotification('Sherwin de Jeus', date('Y-m-d'), '15:00'));
});

Artisan::command('test', function(){
    $infusionsoft = new App\Classes\Infusionsoft;
    $data = $infusionsoft::getSearchResults(3574);
    // dump($data);
});

Artisan::command('test2', function ()
{
    // clientId: eSfbAwymYs0JVt9tAnQJkkURekv7FW2A
    // clientSecret: pxFllcKqrA7olfAZ

    // \Log::debug($token);
    $client = new GuzzleHttp\Client();

    // &since=2019-01-01T00:00:00.000Z
    $token = '2GQc2dhSBv57bFmyL2Dfr58Eu2NR';

    $url = '/tasks/search/?user_id=205&since=2021-01-01T00:00:00.000Z';
    //$url = '/tasks/search/?user_id=205&order=_StartTime';
    //$url = '/notes/?user_id=205&limit=10';
    //$url ='/notes/model';
    //$url = '/users';
    // $url = '/oauth/connect/userinfo';

    $response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('https://api.infusionsoft.com/crm/rest/v1' . $url);

    dump($response->status());
    dump($response->body());
});

// Ben - 205
// Brenden - 207
Artisan::command('test-xml', function(){
    $infusionsoft = new \Infusionsoft\Infusionsoft(array(
        'clientId'     => 'eSfbAwymYs0JVt9tAnQJkkURekv7FW2A',
        'clientSecret' => 'pxFllcKqrA7olfAZ',
        'redirectUri'  => 'http://example.com/',
        'debug'        => true
    ));

    // dump($infusionsoft->getClientId(), $infusionsoft->getClientSecret());
    $token = new Infusionsoft\Token(['access_token'=>'bdJTQzgg3cAjyxsL3BQac5hL1W7V',
                                    'refresh_token'=>'zvnKBBZVqopbvDERfY8J8kb5taJyqDuo',
                                    'expires_in'=>strtotime(now()->addDay(1))]);
    $infusionsoft->setToken($token);

    // ben
    //$savedSearchID = 3720;
    //$userID = 205;
    // brenden
    $savedSearchID = 3722;
    $userID = 207;

    // $return = $infusionsoft->search()->getSavedSearchResults($savedSearchID, $userID, 1, ['Id','ContactID','Title','Custom_Duration','Custom_CallRecording']);
    // $return = $infusionsoft->search()->getSavedSearchResultsAllFields($savedSearchID, $userID,1);
    // $return = $infusionsoft->search()->getAllReportColumns($savedSearchID, $userID);
    // $return = $infusionsoft->search()->getSavedSearchResultsAllFields($savedSearchID, $userID, 1);
    // $return = $infusionsoft->search()->getSavedSearchResultsAllFields($savedSearchID, $userID, 1);
    $return = $infusionsoft->tasks()->create(['title' => 'Task for '.date('Y-m-d H:i:s'), 'description' => 'Better get it done!']);
    // $return = $infusionsoft->tasks()->all();

    dump($return);

});
