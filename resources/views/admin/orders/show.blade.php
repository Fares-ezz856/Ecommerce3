@extends('layouts.admin')

@section('page-title', 'Order Details #' . $order->id)

@section('content')
<div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
    @if($order->status != 'completed')
        <form action="{{ route('admin.orders.convert', $order->id) }}" method="POST">
            @csrf
            <button type="submit" style="padding: 10px 20px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                <i class="fas fa-file-invoice"></i> Convert to ERP Invoice
            </button>
        </form>
    @endif
    <a href="{{ route('admin.orders.index') }}" style="padding: 10px 20px; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none;">Back to Orders</a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow);">
        <h3 style="margin-bottom: 1.5rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.5rem;">Order Items</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; color: #64748b; font-size: 0.9rem;">
                    <th style="padding: 1rem 0;">Product</th>
                    <th style="padding: 1rem 0; text-align: center;">Price</th>
                    <th style="padding: 1rem 0; text-align: center;">Qty</th>
                    <th style="padding: 1rem 0; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 1rem 0;">
                        <span style="font-weight: 600;">{{ $item->product->name ?? 'Unknown Product' }}</span>
                    </td>
                    <td style="padding: 1rem 0; text-align: center;">${{ number_format($item->price, 2) }}</td>
                    <td style="padding: 1rem 0; text-align: center;">{{ $item->quantity }}</td>
                    <td style="padding: 1rem 0; text-align: right; font-weight: 600;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="font-size: 1.2rem; font-weight: 800;">
                    <td colspan="3" style="padding-top: 2rem; text-align: right;">Grand Total:</td>
                    <td style="padding-top: 2rem; text-align: right; color: var(--primary);">${{ number_format($order->total_price, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div>
        <div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Customer Information</h3>
            <p style="margin: 0.5rem 0;"><strong>Name:</strong> {{ $order->user->name ?? 'Guest' }}</p>
            <p style="margin: 0.5rem 0;"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            <p style="margin: 0.5rem 0;"><strong>Phone:</strong> {{ $order->user->phone ?? 'N/A' }}</p>
            <p style="margin: 0.5rem 0;"><strong>Address:</strong> {{ $order->address }}</p>
        </div>

        <div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow);">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Order Status</h3>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span class="badge" style="padding: 8px 15px; border-radius: 20px; font-weight: 700;
                    {{ $order->status == 'completed' ? 'background: #d1fae5; color: #065f46;' : 'background: #fef3c7; color: #92400e;' }}">
                    {{ strtoupper($order->status ?? 'pending') }}
                </span>
                <span style="color: #64748b; font-size: 0.9rem;">Placed on {{ $order->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
