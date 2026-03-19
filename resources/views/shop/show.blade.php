@extends('layouts.shop')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-top: 2rem;">
        <div>
            @if($product->image)
                <img src="{{asset('/storage/'.$product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: 20px; box-shadow: var(--card-shadow);">
            @else
                <div style="width: 100%; height: 400px; background: #f1f5f9; border-radius: 20px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">No Image</div>
            @endif
        </div>
        <div>
            <nav style="margin-bottom: 1rem; color: #64748b; font-size: 0.9rem;">
                <a href="{{ route('shop.index') }}" style="text-decoration: none; color: inherit;">Shop</a> /
                <span style="color: var(--primary);">{{ $product->category->name }}</span>
            </nav>
            <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">{{ $product->name }}</h1>
            <p style="font-size: 1.5rem; color: var(--primary); font-weight: 700; margin-bottom: 2rem;">${{ number_format($product->price, 2) }}</p>

            <div style="background: white; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #e2e8f0;">
                <p style="color: #475569; line-height: 1.7;">{{ $product->description }}</p>
            </div>

            <p style="margin-bottom: 0.5rem; font-weight: 600;">Availability:
                <span style="color: {{ $product->stock_quantity > 0 ? '#166534' : '#991b1b' }};">
                    {{ $product->stock_quantity > 0 ? 'In Stock (' . $product->stock_quantity . ')' : 'Out of Stock' }}
                </span>
            </p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-top: 2rem;">
                @csrf
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                           style="width: 80px; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; font-weight: 600;">
                    <button type="submit" class="btn btn-primary" style="flex: 1; padding: 1rem;" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                        Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div style="margin-top: 5rem;">
        <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 2rem;">Customer Reviews</h2>
        @forelse($product->reviews as $review)
            <div style="background: white; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid #e2e8f0;">
                <p style="font-weight: 600; margin-bottom: 0.5rem;">{{ $review->user->name }}</p>
                <p style="color: #475569;">{{ $review->comment }}</p>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 1rem;">{{ $review->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p style="color: #64748b;">No reviews yet. Be the first to share your thoughts!</p>
        @endforelse
    </div>
@endsection
