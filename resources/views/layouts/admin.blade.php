<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ERP</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --bg-color: #f8f9fa;
            --sidebar-bg: #1a252f;
            --card-bg: #ffffff;
            --text-main: #333333;
            --text-muted: #7f8c8d;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: #ecf0f1;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h2 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--primary-color);
        }

        .nav-links {
            flex: 1;
            padding: 1.5rem 0;
            list-style: none;
            margin: 0;
        }

        .nav-links li {
            padding: 0.5rem 1.5rem;
        }

        .nav-links a {
            color: #bdc3c7;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-links a i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .nav-links a:hover, .nav-links a.active {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logout-btn {
            background: none;
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: var(--accent-color);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            .sidebar-header h2, .nav-links span {
                display: none;
            }
            .nav-links a i {
                margin-right: 0;
            }
        }
        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 2rem 0;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination li a, .pagination li span {
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-main);
            background: white;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
        }

        .pagination li.active span {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .pagination li.disabled span {
            color: #94a3b8;
            background: #f8fafc;
            cursor: not-allowed;
        }

        .pagination li a:hover:not(.active) {
            background-color: #f1f5f9;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .pagination svg {
            width: 20px;
            height: 20px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>ERP ADMIN</h2>
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-th-large"></i> <span>Dashboard</span></a></li>

            <li class="sidebar-header" style="padding: 10px 20px; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-top: 1rem;">Catalog</li>
            <li><a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="fas fa-box"></i> <span>Products</span></a></li>
            <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="fas fa-list"></i> <span>Categories</span></a></li>

            <li class="sidebar-header" style="padding: 10px 20px; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-top: 1rem;">Warehouse & Stock</li>
            <li><a href="{{ route('admin.warehouses.index') }}" class="{{ request()->routeIs('admin.warehouses.*') ? 'active' : '' }}"><i class="fas fa-warehouse"></i> <span>Warehouses</span></a></li>
            <li><a href="{{ route('admin.movements.index') }}" class="{{ request()->routeIs('admin.movements.*') ? 'active' : '' }}"><i class="fas fa-exchange-alt"></i> <span>Movements</span></a></li>

            <li class="sidebar-header" style="padding: 10px 20px; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-top: 1rem;">Sales & CRM</li>
            <li><a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"><i class="fas fa-user-friends"></i> <span>Customers</span></a></li>
            <li><a href="{{ route('admin.invoices.index') }}" class="{{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}"><i class="fas fa-file-invoice-dollar"></i> <span>Invoices</span></a></li>
            <li><a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> <span>Payments</span></a></li>
            <li><a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> <span>Orders</span></a></li>
            <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i> <span>Users</span></a></li>
            <li><a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}"><i class="fas fa-star"></i> <span>Reviews</span></a></li>
            <li><a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}"><i class="fas fa-envelope"></i> <span>Support</span></a></li>

            <li class="sidebar-header" style="padding: 10px 20px; font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-top: 1rem;">System & Reports</li>
            <li><a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> <span>Reports</span></a></li>
            <li><a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> <span>Profile</span></a></li>
            <li><a href="{{ route('admin.audit.index') }}" class="{{ request()->routeIs('admin.audit.*') ? 'active' : '' }}"><i class="fas fa-history"></i> <span>Audit Log</span></a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>@yield('page-title', 'Dashboard')</h1>
            <div class="user-profile">
                <span>{{ Auth::guard('admin-web')->user()->name ?? 'Admin' }}</span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </header>

        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>
