@extends('layouts.shop')

@section('content')
    <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 2rem;">Your Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div style="text-align: center; padding: 5rem; background: white; border-radius: 12px; border: 1px dashed #cbd5e1;">
            <p style="color: #64748b; font-size: 1.25rem; margin-bottom: 2rem;">Your cart is empty.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary" style="text-decoration: none;">Go Shopping</a>
        </div>
    @else
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <div>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        @if($item->product->image)
                                            <img src="{{ asset('/storage/'.$item->product->image)}}" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                                        @endif
                                        <span style="font-weight: 600;">{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; gap: 0.5rem; align-items: center;">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                               style="width: 60px; padding: 0.4rem; border: 1px solid #e2e8f0; border-radius: 6px;">
                                        <button type="submit" class="btn" style="padding: 0.4rem; background: #f1f5f9; font-size: 0.8rem;">Update</button>
                                    </form>
                                </td>
                                <td>${{ number_format($item->product->price, 2) }}</td>
                                <td style="font-weight: 600;">${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.8rem; font-weight: 600;">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--card-shadow); height: fit-content;">
                <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Order Summary</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <span>Subtotal</span>
                    <span style="font-weight: 600;">${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem;">
                    <span>Shipping</span>
                    <span style="color: #166534; font-weight: 600;">Free</span>
                </div>
                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 1.25rem; font-weight: 800;">
                    <span>Total</span>
                    <span style="color: var(--primary);">${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="display: block; text-decoration: none; padding: 1rem;">Proceed to Checkout</a>
            </div>
        </div>
    @endif
@endsection
