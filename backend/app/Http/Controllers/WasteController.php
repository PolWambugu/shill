<?php

namespace App\Http\Controllers;

use App\Models\Waste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WasteController extends Controller
{
    public function index()
    {
        return Waste::where('user_id', Auth::id())->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plastic_kg'   => 'required|numeric',
            'paper_kg'     => 'required|numeric',
            'organic_kg'   => 'required|numeric',
            'recorded_at'  => 'required|date',
        ]);

        $data['user_id'] = Auth::id();
        $waste = Waste::create($data);

        return response()->json($waste, 201);
    }

    public function show(Waste $waste)
    {
        if ($waste->user_id !== Auth::id()) abort(403);
        return $waste;
    }

    public function destroy(Waste $waste)
    {
        if ($waste->user_id !== Auth::id()) abort(403);
        $waste->delete();
        return response()->json(null, 204);
    }
}