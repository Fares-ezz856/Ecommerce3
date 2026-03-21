@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: var(--card-bg);
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1.5rem;
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-info h3 {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-info p {
        margin: 5px 0 0 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--secondary-color);
    }

    .bg-blue { background: #4a90e2; }
    .bg-green { background: #2ecc71; }
    .bg-purple { background: #9b59b6; }
    .bg-orange { background: #e67e22; }
    .bg-red { background: #e74c3c; }

    .welcome-card {
        background: linear-gradient(to right, var(--primary-color), #3498db);
        color: white;
        padding: 2.5rem;
        border-radius: 16px;
        margin-bottom: 3rem;
    }

    .welcome-card h2 { margin: 0 0 10px 0; }
    .welcome-card p { margin: 0; opacity: 0.9; }
</style>
@endsection

@section('content')
<div class="welcome-card">
    <h2>{{ __('Welcome back') }} {{auth('admin-web')->user()->name}} </h2>
    <p>{{ __("Here's what's happening in your store today") }}.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon bg-blue">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-info">
            <h3>{{ __('Products') }}</h3>
            <p>{{ $stats['total_products'] }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon bg-green">
            <i class="fas fa-list"></i>
        </div>
        <div class="stat-info">
            <h3>{{ __('Categories') }}</h3>
            <p>{{ $stats['total_categories'] }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon bg-purple">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-info">
            <h3>{{ __('Orders') }}</h3>
            <p>{{ $stats['total_orders'] }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon bg-orange">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ __('Users') }}</h3>
            <p>{{ $stats['total_users'] }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon bg-red">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-info">
            <h3>{{ __('Reviews') }}</h3>
            <p>{{ $stats['total_reviews'] }}</p>
        </div>
    </div>
</div>
<h2 style="margin-bottom: 1.5rem; font-weight: 700; color: #1e293b;">{{ __('Quick Actions') }}</h2>
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 4rem;">
    <a href="{{ route('admin.products.create') }}" style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1.2rem; border-radius: 12px; text-decoration: none; color: #1e293b; box-shadow: var(--shadow); border: 1px solid #e2e8f0; transition: transform 0.2s;">
        <i class="fas fa-plus-circle" style="color: #4a90e2; font-size: 1.2rem;"></i>
        <span style="font-weight: 600;">{{ __('Add New Product') }}</span>
    </a>

      <a href="{{ route('admin.categories.create') }}" style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1.2rem; border-radius: 12px; text-decoration: none; color: #1e293b; box-shadow: var(--shadow); border: 1px solid #e2e8f0; transition: transform 0.2s;">
        <i class="fas fa-plus-circle" style="color: #4a90e2; font-size: 1.2rem;"></i>
        <span style="font-weight: 600;">{{ __('Add New Category')}}</span>
    </a>

    <a href="{{ route('admin.invoices.create') }}" style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1.2rem; border-radius: 12px; text-decoration: none; color: #1e293b; box-shadow: var(--shadow); border: 1px solid #e2e8f0; transition: transform 0.2s;">
        <i class="fas fa-file-invoice-dollar" style="color: #2ecc71; font-size: 1.2rem;"></i>
        <span style="font-weight: 600;">{{ __('Create Sale Invoice') }}</span>
    </a>
    <a href="{{ route('admin.customers.create') }}" style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1.2rem; border-radius: 12px; text-decoration: none; color: #1e293b; box-shadow: var(--shadow); border: 1px solid #e2e8f0; transition: transform 0.2s;">
        <i class="fas fa-user-plus" style="color: #9b59b6; font-size: 1.2rem;"></i>
        <span style="font-weight: 600;">{{ __('Add New Customer') }}</span>
    </a>
        <a href="{{ route('admin.admins.create') }}" style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1.2rem; border-radius: 12px; text-decoration: none; color: #1e293b; box-shadow: var(--shadow); border: 1px solid #e2e8f0; transition: transform 0.2s;">
        <i class="fas fa-user-plus" style="color: #9b59b6; font-size: 1.2rem;"></i>
        <span style="font-weight: 600;">{{ __('Add New Admin') }}</span>
    </a>
    <a href="{{ route('admin.warehouses.create') }}" style="display: flex; align-items: center; gap: 1rem; background: white; padding: 1.2rem; border-radius: 12px; text-decoration: none; color: #1e293b; box-shadow: var(--shadow); border: 1px solid #e2e8f0; transition: transform 0.2s;">
        <i class="fas fa-warehouse" style="color: #e67e22; font-size: 1.2rem;"></i>
        <span style="font-weight: 600;">{{ __('Define Warehouse') }}</span>
    </a>
</div>
@endsection
