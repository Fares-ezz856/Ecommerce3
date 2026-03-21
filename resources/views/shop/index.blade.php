@extends('layouts.shop')

@section('content')
    <header style="margin-bottom: 3rem; text-align: center;">
        <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 1rem;">{{ __('Discover Quality.') }}</h1>
        <p style="color: #64748b; font-size: 1.25rem;">{{ __('Upgrade your workspace with our premium ERP solutions.') }}</p>
    </header>

    <div style="max-width: 600px; margin: 0 auto 3rem;">
        <form action="{{ route('shop.index') }}" method="GET" class="search-form">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="search-input-group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search for products...') }}" class="search-input">
                <button type="submit" class="btn btn-primary search-btn">{{ __('Search') }}</button>
            </div>
        </form>
    </div>

    <div style="margin-bottom: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('shop.index') }}" class="btn {{ !request('category') ? 'btn-primary' : '' }}" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.9rem;">{{ __('All') }}</a>
        @foreach($categories as $category)
            <a href="{{ route('shop.index',['category' =>$category->slug]) }}"
               class="btn {{ request('category') == $category->slug ? 'btn-primary' : '' }}"
               style="text-decoration: none; border: 1px solid #e2e8f0; color: #1e293b; padding: 0.5rem 1rem; font-size: 0.9rem; border-radius: 20px;">
               {{ $category->name }}
            </a>
        @endforeach
    </div>

    <div class="product-grid">
        @forelse($products as $product)
            <div class="product-card">
                @if($product->image)
                    <img src="{{ asset('/storage/'.$product->image) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image" style="background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">{{ __('No Image') }}</div>
                @endif
                <div class="product-info">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem; height: 3em; overflow: hidden;">{{ Str::limit($product->description, 60) }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="product-price">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('shop.show', $product->id) }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem; text-decoration: none;">{{ __('View') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <p style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #64748b;">{{ __('No products found.') }}</p>
        @endforelse
    </div>

    {{-- <div style="margin-top: 3rem;"> --}}
        {{ $products->links() }}
    {{-- </div> --}}
@endsection
