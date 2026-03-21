@extends('layouts.admin')

@section('page-title', 'Manage Products')

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

    .product-img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .bg-success { background: #d1fae5; color: #065f46; }
    .bg-danger { background: #fee2e2; color: #991b1b; }

    .actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    .btn-edit { background: #e0f2fe; color: #0369a1; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
</style>
@endsection

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700;">Products Inventory</h2>
    <a href="{{ route('admin.products.create') }}" class="btn-create" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>{{ __('Code') }}</th>
                <th>{{ __('Image') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('Price (Pcs/Pkg)') }}</th>
                <th>{{ __('Stock') }}</th>
                <th>{{ __('Visible') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td style="font-family: monospace; font-weight: 600;">{{ $product->code ?? '---' }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('/storage/'. $product->image) }}" class="product-img" alt="">
                    @else
                        <div style="width: 50px; height: 50px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                <td>
                    ${{ number_format($product->price, 2) }} /
                    <span style="color: var(--text-muted); font-size: 0.85rem;">${{ number_format($product->package_price, 2) }}</span>
                </td>
                <td>
                    <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                        {{ $product->stock_quantity }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $product->is_visible ? 'bg-info' : '' }}" style="{{ !$product->is_visible ? 'background: #f1f5f9; color: #64748b;' : 'background: #e0f2fe; color: #0369a1;' }}">
                        {{ $product->is_visible ? 'Visible' : 'Hidden' }}
                    </span>
                </td>
                <td class="actions">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-icon btn-edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon btn-delete"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top: 2rem; display: flex; justify-content: center;">
    {{ $products->links() }}
</div>
@endsection
