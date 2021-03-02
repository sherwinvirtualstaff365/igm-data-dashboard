<?php

use App\Models\DataEntry;
use App\Models\Financial;
use App\Models\Lead;
use App\Models\Infusion;
use App\Models\User;

use Illuminate\Http\Request;
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

Route::prefix('v1')->group(function () {
    /**
     * returns json data of current years dataentry
     */
    Route::get('data-entry/staff', function (Request $request) {
        $return = [];
        $records = DataEntry::whereYear('entry_date', date('Y'))
                            // ->whereMonth('entry_date', date('m'))
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


    Route::get('data-entry/infusion', function (Request $request) {
        $return = [];
        $records = Infusion::whereYear('entry_date', date('Y'))
                            // ->whereMonth('entry_date', date('m'))
                            ->get();

        foreach ($records as $de) {
            $meta = json_decode($de->meta_data);
            $return[] = [
                'Date' => $de->entry_date,
                'Staff' => User::find($meta->staff)->name,
                'Calls Dialed' => $meta->calls_dialed,
            ];
        }

        return $return;
    });


    /**
     * returns json data of leads summary
     */
    Route::get('data-entry/leads', function (Request $request) {
        $return = [];
        $records = Lead::whereYear('entry_date', date('Y'))
                // ->whereMonth('entry_date', date('m'))
                ->get();

        foreach ($records as $de) {
        $meta = json_decode($de->meta_data);
        $return[] = [
                'Date' => date('Y-m-d', strtotime($de->entry_date)),
                'New Leads (1300 Number)' => $meta->new_leads_1300,
                'New Leads (Website)' => $meta->new_leads_website,
                'New Leads (Referral)' => $meta->new_leads_referral,
                'New Leads (Pay Per Click)' => $meta->new_leads_ppc,
                'Ballpark' => $meta->ballpark,
                'Scope' => $meta->scope,
            ];
        }

        return $return;
    });

    /**
     * returns json data of financial summary
     */
    Route::get('data-entry/financials', function (Request $request) {
        $return = [];
        $records = Financial::whereYear('entry_date', date('Y'))
                // ->whereMonth('entry_date', date('m'))
                ->get();

        foreach ($records as $de) {
        $meta = json_decode($de->meta_data);
        $return[] = [
                'Date' => date('Y-m-d', strtotime($de->entry_date)),
                'Funds transfer Analysis' => $meta->funds_transfer_analysis,
                'New Schedules added' => $meta->new_schedules_added,
                'Schedules moved down' => $meta->schedules_moved_down,
                'Schedules moved up' => $meta->schedules_moved_up,
                'Schedules cancelled' => $meta->schedules_cancelled,
                'SnS Paids approved' => $meta->sns_paids_approved,
            ];
        }

        return $return;
    });
});
