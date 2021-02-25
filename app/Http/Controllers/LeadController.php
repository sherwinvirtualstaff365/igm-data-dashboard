<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lead;

class LeadController extends Controller
{
    /**
     * show the data entry form
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('data-entry.leads', ['date'=>$request->date ?? date('Y-m-d')]);
    }

/**
     * returns json containing data entry
     *
     * @return \Illuminate\Http\Response
     */
    public function getEntry(Request $request)
    {
        $data = Lead::where('user_id', Auth()->user()->id)
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
        Lead::where('user_id', Auth()->user()->id)
                            ->where('entry_date', $entryDate)
                            ->delete();

        $entry = new Lead();
        $entry->entry_date = $entryDate;
        $entry->user_id = Auth()->user()->id;
        $entry->meta_data = json_encode([
            'new_leads_1300' => $request->new_leads_1300,
            'new_leads_website' => $request->new_leads_website,
            'new_leads_referral' => $request->new_leads_referral,
            'new_lead_ppc' => $request->new_lead_ppc,
            'ballpark' => $request->ballpark,
            'scope' => $request->scope,
        ]);

        // save
        $entry->save();

        return response()->json();
    }
}
