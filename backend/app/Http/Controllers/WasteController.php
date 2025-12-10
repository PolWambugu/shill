<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WasteController extends Controller
{
    public function index()
    {
        return Auth::user()->wastes()->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plastic_kg'  => 'required|numeric',
            'paper_kg'    => 'required|numeric',
            'organic_kg'  => 'required|numeric',
        ]);

        $total = $validated['plastic_kg'] + $validated['paper_kg'] + $validated['organic_kg'];

        $waste = Auth::user()->wastes()->create([
            'plastic_kg'   => $validated['plastic_kg'],
            'paper_kg'     => $validated['paper_kg'],
            'organic_kg'   => $validated['organic_kg'],
            // You can add total if you want, or calculate it later
        ]);

        return response()->json($waste, 201);
    }
}