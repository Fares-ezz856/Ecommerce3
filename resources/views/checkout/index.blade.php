@extends('layouts.shop')

@section('content')
    <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 2rem;">Checkout</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;">
        <div>
            <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Shipping Information</h3>
            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Full Name</label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled 
                           style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc;">
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Street Address</label>
                    <textarea name="address" required placeholder="Enter your full delivery address" 
                              style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; min-height: 100px; font-family: inherit;"></textarea>
                </div>
                
                <h3 style="margin-top: 3rem; margin-bottom: 1.5rem; font-weight: 700;">Payment Method</h3>
                <div style="background: #f8fafc; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem;">
                    <input type="radio" checked disabled>
                    <div>
                        <p style="font-weight: 600; margin: 0;">Cash on Delivery</p>
                        <p style="font-size: 0.85rem; color: #64748b; margin: 0;">Pay when you receive your order.</p>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 3rem; padding: 1rem; font-size: 1.1rem;">
                    Complete Order
                </button>
            </form>
        </div>

        <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: var(--card-shadow); height: fit-content;">
            <h3 style="margin-bottom: 2rem; font-weight: 700;">Your Order</h3>
            <div style="margin-bottom: 2rem;">
                @foreach($cartItems as $item)
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; align-items: center;">
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #64748b;">
                                {{ $item->quantity }}x
                            </div>
                            <span style="font-weight: 500;">{{ $item->product->name }}</span>
                        </div>
                        <span style="font-weight: 600;">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>
            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 800;">
                <span>Total</span>
                <span style="color: var(--primary);">${{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>
@endsection
