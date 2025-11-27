<?php

namespace App\Http\Controllers;

use App\Models\ResourceUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function index()
    {
        return ResourceUsage::where('user_id', Auth::id())->latest()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'water_liters' => 'required|numeric',
            'fuel_liters'  => 'nullable|numeric',
            'recorded_at'  => 'required|date',
        ]);

        $data['user_id'] = Auth::id();
        $resource = ResourceUsage::create($data);

        return response()->json($resource, 201);
    }

    public function show(ResourceUsage $resource)
    {
        if ($resource->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $resource;
    }

    public function update(Request $request, ResourceUsage $resource)
    {
        if ($resource->user_id !== Auth::id()) abort(403);

        $data = $request->validate([
            'water_liters' => 'sometimes|numeric',
            'fuel_liters'  => 'nullable|numeric',
            'recorded_at'  => 'sometimes|date',
        ]);

        $resource->update($data);
        return $resource;
    }

    public function destroy(ResourceUsage $resource)
    {
        if ($resource->user_id !== Auth::id()) abort(403);
        $resource->delete();
        return response()->json(null, 204);
    }
}