<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class ReportController extends Controller
{
    // Return all reports for admin dashboard
    public function index()
    {
        // Fetch users once
        $users = User::all()->keyBy('id');

        // Emissions
        $emissions = DB::table('emissions')->get()->map(function ($e) use ($users) {
            return [
                'user_id' => $e->user_id,
                'user_name' => $users[$e->user_id]->name ?? 'Unknown',
                'type' => 'Emission',
                'co2' => $e->total_co2 ?? 0,
                'waste' => 0,
                'water' => 0,
                'created_at' => $e->created_at,
                'status' => $e->status ?? 'pending',
            ];
        });

        // Wastes
        $wastes = DB::table('wastes')->get()->map(function ($w) use ($users) {
            return [
                'user_id' => $w->user_id,
                'user_name' => $users[$w->user_id]->name ?? 'Unknown',
                'type' => 'Waste',
                'co2' => 0,
                'waste' => $w->total_waste ?? 0,
                'water' => 0,
                'created_at' => $w->created_at,
                'status' => $w->status ?? 'pending',
            ];
        });

        // Resource usages
        $resources = DB::table('resource_usages')->get()->map(function ($r) use ($users) {
            return [
                'user_id' => $r->user_id,
                'user_name' => $users[$r->user_id]->name ?? 'Unknown',
                'type' => 'Resource Usage',
                'co2' => 0,
                'waste' => 0,
                'water' => $r->water_used ?? 0,
                'created_at' => $r->created_at,
                'status' => $r->status ?? 'pending',
            ];
        });

        // Merge all reports and sort by created_at descending
        $reports = $emissions
            ->merge($wastes)
            ->merge($resources)
            ->sortByDesc('created_at')
            ->values();

        return response()->json([
            'reports' => $reports
        ]);
    }

    // Return totals for dashboard summary
    public function summary()
    {
        $totalCo2 = DB::table('emissions')->sum('total_co2');
        $totalWaste = DB::table('wastes')->sum('total_waste');
        $totalWater = DB::table('resource_usages')->sum('water_used');

        return response()->json([
            'total_co2_tons' => round($totalCo2, 2),
            'total_waste_kg' => round($totalWaste, 2),
            'total_water_l' => round($totalWater, 2),
        ]);
    }
}
