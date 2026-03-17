<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class AdminWarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::withCount('stockMovements')->get();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('admin.warehouses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string'
        ]);

        Warehouse::create($data);
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse created successfully');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string'
        ]);

        $warehouse->update($data);
        return redirect()->route('admin.warehouses.index')->with('success', 'Warehouse updated successfully');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return back()->with('success', 'Warehouse deleted successfully');
    }
}
