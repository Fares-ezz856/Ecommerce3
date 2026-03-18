<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->paginate(20);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('is_visible', true)->where('stock_quantity', '>', 0)->get();
        return view('admin.invoices.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|in:sale,purchase,return',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|string'
        ]);

        return DB::transaction(function () use ($request) {
            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                'customer_id' => $request->customer_id,
                'type' => $request->type,
                'status' => 'pending',
                'discount' => $request->discount ?? 0,
                'payment_method' => $request->payment_method,
                'total_amount' => 0, // Calculated below
            ]);

            $total = 0;
            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['product_id']);
                $subtotal = $product->price * $itemData['quantity'];
                
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal
                ]);
                
                $total += $subtotal;
            }

            $invoice->update(['total_amount' => $total - ($request->discount ?? 0)]);

            return redirect()->route('admin.invoices.show', $invoice->id)->with('success', 'Invoice created as draft');
        });
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items.product']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function confirm(Invoice $invoice)
    {
        if ($invoice->status !== 'pending') {
            return back()->with('error', 'Invoice is already confirmed or cancelled');
        }

        return DB::transaction(function () use ($invoice) {
            foreach ($invoice->items as $item) {
                // 1. Deduct Stock
                $item->product->decrement('stock_quantity', $item->quantity);

                // 2. Record Stock Movement
                StockMovement::create([
                    'product_id' => $item->product_id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'reason' => 'Sale Invoice #' . $invoice->invoice_number,
                    'reference' => $invoice->invoice_number
                ]);
            }

            // 3. Update Customer Balance
            $invoice->customer->increment('balance', $invoice->total_amount);

            $invoice->update(['status' => 'confirmed']);

            return back()->with('success', 'Invoice confirmed, stock deducted, and customer balance updated!');
        });
    }
}
