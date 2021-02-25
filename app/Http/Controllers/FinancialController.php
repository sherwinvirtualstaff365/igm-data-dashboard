<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Financial;

class FinancialController extends Controller
{
    /**
     * show the data entry form
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('data-entry.financials', ['date'=>$request->date ?? date('Y-m-d')]);
    }

/**
     * returns json containing data entry
     *
     * @return \Illuminate\Http\Response
     */
    public function getEntry(Request $request)
    {
        $data = Financial::where('user_id', Auth()->user()->id)
                            ->where('entry_date', $request->date)
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
        $entryDate = $request->date;

        // check if entry already exist (user_id, entry_date, meta_data->quarter)
        Financial::where('user_id', Auth()->user()->id)
                            ->where('entry_date', $entryDate)
                            ->delete();

        $entry = new Financial();
        $entry->entry_date = $entryDate;
        $entry->user_id = Auth()->user()->id;
        $entry->meta_data = json_encode([
            'funds_transfer_analysis' => $request->funds_transfer_analysis,
            'new_schedules_added' => $request->new_schedules_added,
            'schedules_moved_down' => $request->schedules_moved_down,
            'schedules_moved_up' => $request->schedules_moved_up,
            'schedules_cancelled' => $request->schedules_cancelled,
            'sns_paids_approved' => $request->sns_paids_approved,
        ]);

        // save
        $entry->save();

        return response()->json();
    }
}
