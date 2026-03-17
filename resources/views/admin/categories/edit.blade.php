@extends('layouts.admin')

@section('page-title', 'Edit Category: ' . $category->name)

@section('content')
<div class="card" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); max-width: 600px; margin: 0 auto;">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Category Name *</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
            <textarea name="description" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">{{ $category->description }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.categories.index') }}" style="padding: 10px 20px; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #64748b;">Cancel</a>
            <button type="submit" style="padding: 10px 25px; background: var(--primary); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Update Category</button>
        </div>
    </form>
</div>
@endsection
