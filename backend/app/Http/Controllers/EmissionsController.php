<?php

namespace App\Http\Controllers;

use App\Models\Emissions;   // ← Correct model (plural)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmissionsController extends Controller
{
    public function index()
    {
        return Emissions::where('user_id', Auth::id())->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'electricity_kwh' => 'required|numeric',
            'mileage_km'      => 'required|numeric',
            'flights'         => 'required|numeric',
            'total_co2'       => 'required|numeric',
        ]);

        // This now works — no red error
        $emission = Auth::user()->emissions()->create($validated);

        return response()->json($emission, 201);
    }

    public function show(Emissions $emission)
    {
        if ($emission->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $emission;
    }

    public function destroy(Emissions $emission)
    {
        if ($emission->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $emission->delete();
        return response()->json(null, 204);
    }
}