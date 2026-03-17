<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStockMovementController extends Controller
{
    public function index()
    {
        $movements = StockMovement::with(['product', 'warehouse'])->latest()->paginate(20);
        return view('admin.movements.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('admin.movements.create', compact('products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:in,out',
            'reason' => 'required|string',
            'reference' => 'nullable|string'
        ]);

        DB::transaction(function () use ($data) {
            StockMovement::create($data);

            $product = Product::find($data['product_id']);
            if ($data['type'] == 'in') {
                $product->increment('stock_quantity', $data['quantity']);
            } else {
                $product->decrement('stock_quantity', $data['quantity']);
            }
        });

        return redirect()->route('admin.movements.index')->with('success', 'Stock movement recorded and inventory updated');
    }
}
