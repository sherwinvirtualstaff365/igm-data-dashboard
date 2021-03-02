<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Infusion;
use Carbon\Carbon;

class InfusionController extends Controller
{
    /**
     * show the data entry form
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('data-entry.infusion', ['date'=>$request->date ?? date('Y-m-d'), 'quarter'=>$request->quarter ?? '']);
    }

    /**
     * returns json containing data entry
     *
     * @return \Illuminate\Http\Response
     */
    public function getEntry(Request $request)
    {
        $data = Infusion::where('user_id', Auth()->user()->id)
                            ->where('entry_date', $request->date)
                            ->where('meta_data->staff',$request->staff)
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
        Infusion::where('user_id', Auth()->user()->id)
                            ->where('entry_date', $entryDate)
                            ->where('meta_data->staff',$request->staff)
                            ->delete();

        $entry = new Infusion();
        $entry->entry_date = $entryDate;
        $entry->user_id = Auth()->user()->id;
        $entry->meta_data = json_encode([
            'staff' =>$request->staff,
            'calls_dialed' => $request->calls_dialed,
            'conversations' => $request->conversations,
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
