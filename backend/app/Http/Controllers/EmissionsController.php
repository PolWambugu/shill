<?php

namespace App\Http\Controllers;

use App\Models\Emission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmissionsController extends Controller
{
    public function index()
    {
        return Emission::where('user_id', Auth::id())->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'electricity_kwh' => 'required|numeric',
            'mileage_km' => 'required|numeric',
            'flights' => 'required|integer',
            'total_co2' => 'required|numeric',
        ]);

        $data['user_id'] = Auth::id();
        $emission = Emission::create($data);

        return response()->json($emission, 201);
    }

    public function show(Emission $emission)
    {
        if ($emission->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $emission;
    }

    public function destroy(Emission $emission)
    {
        if ($emission->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $emission->delete();
        return response()->json(null, 204);
    }
}