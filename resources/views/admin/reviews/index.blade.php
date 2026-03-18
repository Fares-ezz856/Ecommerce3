@extends('layouts.admin')

@section('page-title', 'Product Reviews')

@section('styles')
<style>
    .review-card {
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: var(--shadow);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--primary-color);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .reviewer-info h4 { margin: 0; color: var(--secondary-color); }
    .reviewer-info p { margin: 2px 0 0 0; font-size: 0.8rem; color: var(--text-muted); }

    .rating { color: #f1c40f; }

    .review-body { color: #4a5568; line-height: 1.6; }

    .btn-delete-small {
        color: var(--accent-color);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
    }
</style>
@endsection

@section('content')
@foreach($reviews as $review)
<div class="review-card">
    <div class="review-header">
        <div class="reviewer-info">
            <h4>{{ $review->user->name }} on <i>{{ $review->product->name }}</i></h4>
            <p>{{ $review->created_at->format('M d, Y') }}</p>
        </div>
        <div class="actions" style="display: flex; align-items: center; gap: 1rem;">
            <div class="rating">
                @for($i=1; $i<=5; $i++)
                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                @endfor
            </div>
            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-small"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>
    <div class="review-body">
        {{ $review->comment }}
    </div>
</div>
@endforeach

<div style="margin-top: 2rem;">
    {{ $reviews->links() }}
</div>
@endsection
