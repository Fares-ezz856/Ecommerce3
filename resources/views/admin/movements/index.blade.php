@extends('layouts.admin')

@section('page-title', 'Stock Movement History')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700;">Inventory Movements</h2>
    <a href="{{ route('admin.movements.create') }}" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-plus"></i> Record Movement
    </a>
</div>

<div class="table-card" style="background: white; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Date</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Product</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Warehouse</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Qty</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Type</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Reason</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Ref</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movements as $movement)
            <tr style="border-bottom: 1px solid #edf2f7;">
                <td style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.9rem;">{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <strong>{{ $movement->product->name }}</strong><br>
                    <small style="color: #64748b;">{{ $movement->product->code }}</small>
                </td>
                <td style="padding: 1rem 1.5rem;">{{ $movement->warehouse->name ?? '---' }}</td>
                <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $movement->quantity }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <span class="badge" style="{{ $movement->type == 'in' ? 'background: #d1fae5; color: #065f46;' : 'background: #fee2e2; color: #991b1b;' }} padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; text-transform: uppercase;">
                        {{ $movement->type }}
                    </span>
                </td>
                <td style="padding: 1rem 1.5rem;">{{ $movement->reason }}</td>
                <td style="padding: 1rem 1.5rem; font-family: monospace;">{{ $movement->reference ?? '---' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem;">
    {{ $movements->links() }}
</div>
@endsection
