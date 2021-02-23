<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $daySummary = [
            'calls_dialed' => ['label'=>'Calles Dialed'],
            'conversations' => ['label'=>'Conversations'],
            'rating_questions_asked'=>['label'=>'Rating Questions Asked'],
            'dollars_taken'=>['label'=>'Dollars Taken'],
            'Units Sold',
            'Google Uploads',
            'Product Review Uploads'
        ];
    }
}
