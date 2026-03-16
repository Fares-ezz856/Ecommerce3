@extends('layouts.shop')

@section('content')
    <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 2rem;">Order History</h1>

    @if($orders->isEmpty())
        <div style="text-align: center; padding: 5rem; background: white; border-radius: 12px; border: 1px dashed #cbd5e1;">
            <p style="color: #64748b; font-size: 1.25rem;">You haven't placed any orders yet.</p>
        </div>
    @else
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            @foreach($orders as $order)
                <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--card-shadow); border: 1px solid #e2e8f0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <div>
                            <h3 style="font-weight: 700; margin: 0;">Order #{{ $order->id }}</h3>
                            <p style="color: #64748b; font-size: 0.9rem; margin-top: 0.25rem;">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <span style="padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; 
                                       background: {{ $order->status === 'delivered' ? '#dcfce7' : '#fef9c3' }}; 
                                       color: {{ $order->status === 'delivered' ? '#166534' : '#854d0e' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">${{ number_format($order->total_price, 2) }}</span>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #f1f5f9; padding-top: 1.5rem;">
                        <p style="font-weight: 600; margin-bottom: 1rem;">Shipping Address:</p>
                        <p style="color: #475569; font-size: 0.95rem;">{{ $order->address }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $orders->links() }}
        </div>
    @endif
@endsection
