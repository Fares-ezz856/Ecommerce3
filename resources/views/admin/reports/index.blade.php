@extends('layouts.admin')

@section('page-title', 'Financial & Inventory Reports')

@section('content')
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: var(--shadow); border-left: 5px solid #059669;">
        <h4 style="color: #64748b; margin: 0; font-size: 0.9rem;">Total Sales (Confirmed)</h4>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.5rem;">${{ number_format($stats['total_sales'], 2) }}</div>
    </div>
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: var(--shadow); border-left: 5px solid #0369a1;">
        <h4 style="color: #64748b; margin: 0; font-size: 0.9rem;">Total Payments Collected</h4>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.5rem;">${{ number_format($stats['total_payments'], 2) }}</div>
    </div>
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: var(--shadow); border-left: 5px solid #e11d48;">
        <h4 style="color: #64748b; margin: 0; font-size: 0.9rem;">Low Stock Alerts</h4>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.5rem; color: #e11d48;">{{ $stats['low_stock_products'] }} Items</div>
    </div>
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: var(--shadow); border-left: 5px solid #475569;">
        <h4 style="color: #64748b; margin: 0; font-size: 0.9rem;">Total Stock Movements</h4>
        <div style="font-size: 1.5rem; font-weight: 800; margin-top: 0.5rem;">{{ $stats['recent_movements'] }} Logs</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow);">
        <h3 style="margin-bottom: 2rem; font-weight: 700;">Sales Performance (Last 7 Days)</h3>
        <div style="height: 300px; display: flex; align-items: flex-end; gap: 1rem; padding-bottom: 2rem; border-bottom: 1px solid #f1f5f9;">
            @foreach($sales_by_day as $day)
                @php $height = ($stats['total_sales'] > 0) ? ($day->total / $stats['total_sales'] * 400 + 20) : 20; @endphp
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                    <div style="width: 100%; max-width: 60px; background: var(--primary); border-radius: 4px 4px 0 0; height: {{ $height }}px; transition: height 0.5s;"></div>
                    <span style="font-size: 0.75rem; color: #64748b; transform: rotate(-45deg); margin-top: 10px;">{{ $day->date }}</span>
                    <strong style="font-size: 0.8rem;">${{ number_format($day->total, 0) }}</strong>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow);">
        <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Quick Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <a href="{{ route('admin.invoices.create') }}" style="display: block; padding: 1rem; background: #f8fafc; border-radius: 8px; text-decoration: none; color: #1e293b; border: 1px solid #e2e8f0;">
                <i class="fas fa-file-invoice" style="margin-right: 0.5rem; color: var(--primary);"></i> Create Sale Invoice
            </a>
            <a href="{{ route('admin.payments.create') }}" style="display: block; padding: 1rem; background: #f8fafc; border-radius: 8px; text-decoration: none; color: #1e293b; border: 1px solid #e2e8f0;">
                <i class="fas fa-money-bill-wave" style="margin-right: 0.5rem; color: #059669;"></i> Record Receipt
            </a>
            <a href="{{ route('admin.movements.create') }}" style="display: block; padding: 1rem; background: #f8fafc; border-radius: 8px; text-decoration: none; color: #1e293b; border: 1px solid #e2e8f0;">
                <i class="fas fa-exchange-alt" style="margin-right: 0.5rem; color: #0369a1;"></i> Stock Entry
            </a>
        </div>
    </div>
</div>
@endsection
