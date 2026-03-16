@extends('layouts.shop')

@section('content')
  <div class="product-grid">
        @forelse($category->products as $product)
            <div class="product-card">
                @if($product->image)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image" style="background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">No Image</div>
                @endif
                <div class="product-info">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem; height: 3em; overflow: hidden;">{{ Str::limit($product->description, 60) }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="product-price">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('shop.show', $product->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem; text-decoration: none;">View</a>
                    </div>
                </div>
            </div>
        @empty
            <p style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #64748b;">No products found.</p>
        @endforelse
    </div>
    @endsection
