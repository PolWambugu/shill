<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return Supplier::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'contact_person'  => 'nullable|string',
            'email'           => 'nullable|email|unique:suppliers',
            'phone'           => 'nullable|string',
            'address'         => 'nullable|string',
        ]);

        $supplier = Supplier::create($data);
        return response()->json($supplier, 201);
    }

    public function show(Supplier $supplier)
    {
        return $supplier;
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name'           => 'sometimes|string|max:255',
            'contact_person' => 'nullable|string',
            'email'          => 'nullable|email|unique:suppliers,email,'.$supplier->id,
            'phone'          => 'nullable|string',
            'address'        => 'nullable|string',
        ]);

        $supplier->update($data);
        return $supplier;
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(null, 204);
    }
}