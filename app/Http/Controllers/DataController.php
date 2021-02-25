<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\DataEntry;
use Carbon\Carbon;

class DataController extends Controller
{
    /**
     * show the data entry form
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('data-entry.staff', ['date'=>$request->date ?? date('Y-m-d'), 'quarter'=>$request->quarter ?? '']);
    }

    /**
     * returns json containing data entry
     *
     * @return \Illuminate\Http\Response
     */
    public function getEntry(Request $request)
    {
        $data = DataEntry::where('user_id', Auth()->user()->id)
                            ->where('entry_date', $request->date . ' ' . $request->quarter . ':00')
                            ->first();
        return response()->json($data);
    }

    /**
     * save passed entry
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function saveEntry(Request $request)
    {
        $entryDate = $request->date . ' ' . $request->quarter . ':00';

        // check if entry already exist (user_id, entry_date, meta_data->quarter)
        DataEntry::where('user_id', Auth()->user()->id)
                            ->where('entry_date', $entryDate)
                            ->delete();

        $entry = new DataEntry();
        $entry->entry_date = $entryDate;
        $entry->user_id = Auth()->user()->id;
        $entry->meta_data = json_encode([
            'calls_dialed' => $request->calls_dialed,
            'conversations' => $request->conversations,
            'rating_questions_asked' => $request->rating_questions_asked,
            'dollars_taken' => $request->dollars_taken,
            'units_sold' => $request->units_sold,
            'google_uploads' => $request->google_uploads,
            'product_review_uploads' => $request->product_review_uploads
        ]);

        // save
        $entry->save();

        return response()->json();
    }

    /**
     * returns json data of data entry summary in current day, week & month
     */
    public function summary(Request $request)
    {
        // $date = $request->date;
        // $weekDateFrom = ;
        // $weekDateTo = ;
    }
}
