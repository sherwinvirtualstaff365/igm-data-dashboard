<?php

use App\Models\DataEntry;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    /**
     * returns json data of current years dataentry
     */
    Route::get('data-entry', function () {
        \Log::debug(request()->all());

        $return = [];
        $records = DataEntry::whereYear('entry_date', date('Y'))
                            ->whereMonth('entry_date', date('m'))
                            ->with('user')
                            ->get();

        foreach ($records as $de) {
            $meta = json_decode($de->meta_data);
            $return[] = [
                'Date' => $de->entry_date,
                'Staff' => $de->user->name,
                'Calls Dialed' => $meta->calls_dialed,
                'Target Calls Dialed' => 100,
                'Conversations' => $meta->conversations,
                'Target Conversations' => 100,
                'Rating Questions Asked' => $meta->rating_questions_asked,
                'Dollars Taken' => $meta->dollars_taken,
                'Units Sold' => $meta->units_sold,
                'Google Uploads' => $meta->google_uploads,
                'Product Review Uploads' => $meta->product_review_uploads,
            ];
        }

        return $return;

    });
});
