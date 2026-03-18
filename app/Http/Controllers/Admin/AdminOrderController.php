<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function convertToInvoice(Order $order)
    {
        if ($order->status == 'processing') {
            return back()->with('error', 'This order has already been processed.');
        }

        return DB::transaction(function () use ($order) {
            // 1. Find or Create ERP Customer
            $customer = Customer::where('email', $order->user->email ?? '')
                                ->orWhere('phone', $order->user->phone ?? '')
                                ->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => $order->user->name ?? 'Web Site User #' . $order->user_id,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone,
                    'address' => $order->address,
                    'type' => 'individual',
                    'balance' => 0
                ]);
            }

            // 2. Create ERP Invoice
            $invoice = Invoice::create([
                'invoice_number' => 'INV-WEB-' . strtoupper(Str::random(6)),
                'customer_id' => $customer->id,
                'type' => 'sale',
                'status' => 'pending',
                'discount' => 0,
                'payment_method' => 'cash', // Default for web orders
                'total_amount' => $order->total_price,
            ]);

            // 3. Map Order Items to Invoice Items
            foreach ($order->orderItems as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->unit_price * $item->quantity
                ]);
            }

            $order->update(['status' => 'processing']);

            return redirect()->route('admin.invoices.show', $invoice->id)->with('success', 'Order converted to ERP Invoice successfully!');
        });
    }
}
