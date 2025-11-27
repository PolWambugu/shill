<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function summary()
    {
        $userId = Auth::id();

        $totalCo2 = DB::table('emissions')->where('user_id', $userId)->sum('total_co2');
        $totalWaste = DB::table('waste')->where('user_id', $userId)->sum('plastic_kg') 
                     + DB::table('waste')->where('user_id', $userId)->sum('paper_kg')
                     + DB::table('waste')->where('user_id', $userId)->sum('organic_kg');

        return response()->json([
            'total_co2_tons' => round($totalCo2, 2),
            'total_waste_kg' => round($totalWaste, 2),
        ]);
    }
}