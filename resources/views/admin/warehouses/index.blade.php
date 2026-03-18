@extends('layouts.admin')

@section('page-title', 'Manage Warehouses')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700;">Local Warehouses</h2>
    <a href="{{ route('admin.warehouses.create') }}" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-plus"></i> Add Warehouse
    </a>
</div>

<div class="table-card" style="background: white; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Name</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Location</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Activity Count</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($warehouses as $warehouse)
            <tr style="border-bottom: 1px solid #edf2f7;">
                <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $warehouse->name }}</td>
                <td style="padding: 1rem 1.5rem; color: var(--text-muted);">{{ $warehouse->location ?? 'Not Specified' }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;">
                        {{ $warehouse->stock_movements_count }} Movements
                    </span>
                </td>
                <td style="padding: 1rem 1.5rem; display: flex; gap: 0.5rem;">
                    <a href="{{ route('admin.warehouses.edit', $warehouse->id) }}" style="color: #0369a1;"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.warehouses.destroy', $warehouse->id) }}" method="POST" onsubmit="return confirm('Delete this warehouse?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #991b1b; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
