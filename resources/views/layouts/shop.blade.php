<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern E-Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ecommerce.css') }}">
    <style>
        /* Fallback if file doesn't load immediately */
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('shop.index') }}" class="logo">ECO-ERP</a>
        <div class="nav-links">
            <a href="{{ route('shop.index') }}">Products</a>
            <a href="{{ route('cart.index') }}">Cart</a>
            @auth
                <a href="{{ route('orders.index') }}">My Orders</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <footer style="text-align: center; padding: 2rem; color: #64748b;">
        &copy; {{ date('Y') }} Modern E-Shop. Built with passion.
    </footer>
</body>
</html>
