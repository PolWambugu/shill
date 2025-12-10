<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ResourceUsage;

class ResourceUsageController extends Controller
{
    public function index()
    {
        return Auth::user()->resourceUsages()->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'water_liters' => 'required|numeric',
            'fuel_liters'  => 'required|numeric',
        ]);

        $total = $validated['water_liters'] + $validated['fuel_liters'];

        $record = Auth::user()->resourceUsages()->create([
            'water_liters' => $validated['water_liters'],
            'fuel_liters'  => $validated['fuel_liters'],
            'total_usage'  => $total,
        ]);

        return response()->json($record, 201);
    }
}