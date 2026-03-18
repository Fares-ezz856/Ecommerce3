@extends('layouts.admin')

@section('page-title', 'Manage Orders')

@section('styles')
<style>
    .table-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid #edf2f7;
    }

    th {
        background: #f8fafc;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    .bg-warning { background: #fef3c7; color: #92400e; }
    .bg-green { background: #d1fae5; color: #065f46; }

    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .bg-info { background: #e0f2fe; color: #0369a1; }
</style>
@endsection

@section('content')
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @forelse ( $orders as $order )


                <td style="font-weight: 700;">#{{ $order->id }}</td>
                <td>
                    {{ $order->user->name ?? 'Guest User' }}<br>
                    <small style="color: #64748b;">{{ $order->user->email ?? '' }}</small>
                </td>
                <td style="font-weight: 600;">${{ number_format($order->total_price, 2) }}</td>
                <td>
                    <span class="badge {{ $order->status == 'completed' ? 'bg-green' : 'bg-warning' }}">
                        {{ strtoupper($order->status ?? 'pending') }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-icon" style="color: #0369a1;"><i class="fas fa-eye"></i></a>
                    @if($order->status != 'completed')
                    <form action="{{ route('admin.orders.convert', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" title="Convert to ERP Invoice" style="background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: 4px 8px; border-radius: 6px; cursor: pointer;">
                            <i class="fas fa-file-invoice"></i> Convert
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $orders->links() }}
</div>
@endsection
