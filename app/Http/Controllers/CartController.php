<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, $productId)
    {
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->input('quantity', 1));
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->input('quantity', 1),
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        Cart::where('user_id', Auth::id())->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}
