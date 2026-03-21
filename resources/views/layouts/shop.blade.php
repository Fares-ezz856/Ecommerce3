<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Modern E-Shop') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/ecommerce.css') }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [dir="rtl"] { font-family: 'Cairo', 'Inter', sans-serif; }
        
        .lang-switch-shop {
            display: flex;
            gap: 1rem;
            margin-right: 1rem;
        }
        
        [dir="rtl"] .lang-switch-shop {
            margin-right: 0;
            margin-left: 1rem;
        }

        .lang-link {
            text-decoration: none;
            color: #64748b;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .lang-link.active {
            color: #6366f1;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('shop.index') }}" class="logo">ECO-ERP</a>
        <div class="nav-links">
            <div class="lang-switch-shop">
                <a href="{{ route('lang.switch', 'en') }}" class="lang-link {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                <a href="{{ route('lang.switch', 'ar') }}" class="lang-link {{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
            </div>
            <a href="{{ route('shop.index') }}">{{ __('Products') }}</a>
            <a href="{{ route('cart.index') }}">{{ __('Cart') }}</a>
            @auth
                <a href="{{ route('orders.index') }}">{{ __('My Orders') }}</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
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
