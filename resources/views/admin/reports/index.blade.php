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
        <div style="height: 350px; position: relative;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow);">
        <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Quick Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <a href="{{ route('admin.invoices.create') }}" style="display: block; padding: 1rem; background: #f8fafc; border-radius: 8px; text-decoration: none; color: #1e293b; border: 1px solid #e2e8f0;">
                <i class="fas fa-file-invoice" style="margin-right: 0.5rem; color: var(--primary-color);"></i> Create Sale Invoice
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim() || '#4a90e2';
        
        const salesData = @json($sales_by_day->reverse()->values());
        const labels = salesData.map(item => item.date);
        const values = salesData.map(item => item.total);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Sales ($)',
                    data: values,
                    backgroundColor: primaryColor,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Sales: $' + new Intl.NumberFormat().format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: '#f1f5f9'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            },
                            font: { size: 11, color: '#64748b' }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 11, color: '#64748b' }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
