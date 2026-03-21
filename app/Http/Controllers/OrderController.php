<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:cash,stripe',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index');
        }

        $orderId = null;

        DB::transaction(function () use ($request, $cartItems, &$orderId) {
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total,
                'status' => 'pending',
                'address' => $request->address,
                'payment_status' => 'Unpaid',
                'payment_method' => $request->payment_method,
            ]);

            $orderId = $order->id;

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);

                $item->product->decrement('stock_quantity', $item->quantity);
            }

            Cart::where('user_id', Auth::id())->delete();
        });

        if ($request->payment_method === 'stripe') {
            return redirect()->route('stripe.order.checkout', $orderId);
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
