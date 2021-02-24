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
        $return = [];
        $records = DataEntry::whereYear('entry_date', date('Y'))
                            ->whereMonth('entry_date', date('m'))
                            ->with('user')
                            ->get();

        foreach ($records as $de) {
            $meta = json_decode($de->meta_data);
            $return[] = [
                'date' => $de->entry_date,
                'staff' => $de->user->name,
                'calls_dialed' => $meta->calls_dialed,
                'calls_dialed_target' => 100,
                'conversations' => $meta->conversations,
                'conversations_target' => 100,
                'rating_questions_asked' => $meta->rating_questions_asked,
                'dollars_taken' => $meta->dollars_taken,
                'units_sold' => $meta->units_sold,
                'google_uploads' => $meta->google_uploads,
                'product_review_uploads' => $meta->product_review_uploads,
            ];
        }

        return $return;

    });
});
