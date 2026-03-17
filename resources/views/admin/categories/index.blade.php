@extends('layouts.admin')

@section('page-title', 'Manage Categories')

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
    }

    .btn-edit { background: #e0f2fe; color: #0369a1; }
    .btn-delete { background: #fee2e2; color: #991b1b; }
</style>
@endsection

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="font-weight: 700;">Categories</h2>
    <a href="{{ route('admin.categories.create') }}" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
        <i class="fas fa-plus"></i> Add Category
    </a>
</div>

<div class="table-card" style="background: white; border-radius: 12px; box-shadow: var(--shadow); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; text-align: left;">
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Name</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Slug</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Products</th>
                <th style="padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr style="border-bottom: 1px solid #edf2f7;">
                <td style="padding: 1rem 1.5rem; font-weight: 600;">{{ $category->name }}</td>
                <td style="padding: 1rem 1.5rem; color: var(--text-muted); font-family: monospace;">{{ $category->slug }}</td>
                <td style="padding: 1rem 1.5rem;">
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;">
                        {{ $category->products_count }} Products
                    </span>
                </td>
                <td style="padding: 1rem 1.5rem; display: flex; gap: 0.5rem;">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" style="color: #0369a1;"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?')">
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
