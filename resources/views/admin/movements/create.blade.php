@extends('layouts.admin')

@section('page-title', 'Record Stock Movement')

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.movements.store') }}" method="POST">
        @csrf
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Product *</label>
            <select name="product_id" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code ?? 'No Code' }}) - Current: {{ $product->stock_quantity }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Warehouse</label>
            <select name="warehouse_id" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                <option value="">None / External</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Quantity *</label>
                <input type="number" name="quantity" class="form-control" required min="1" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
            <div class="form-group">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Movement Type *</label>
                <select name="type" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="in">In (Addition)</option>
                    <option value="out">Out (Deduction)</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Reason *</label>
            <input type="text" name="reason" placeholder="E.g. Supplier Purchase, Initial Stock, Sale" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Reference (Optional)</label>
            <input type="text" name="reference" placeholder="E.g. Invoice #123" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.movements.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">Cancel</a>
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Record Movement</button>
        </div>
    </form>
</div>
@endsection
