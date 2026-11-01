<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction ?? (app()->getLocale() === 'ar' ? 'rtl' : 'ltr') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.site_title'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('extra-css')
</head>
<body>
    <!-- Transparent Frosted Glass Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <span class="navbar-brand-icon">🌱</span>
                <span>{{ __('messages.store_name') }}</span>
            </a>
            <button class="navbar-toggle" id="navbar-toggle" aria-label="Toggle Navigation">☰</button>
            <ul class="navbar-menu" id="navbar-menu">
                <li class="navbar-menu-item">
                    <a href="{{ route('home') }}" @if(Route::currentRouteName() === 'home') class="active" @endif>
                        {{ __('messages.nav_home') }}
                    </a>
                </li>
                <li class="navbar-menu-item">
                    <a href="{{ route('products.index') }}" @if(Route::currentRouteName() === 'products.index') class="active" @endif>
                        {{ __('messages.nav_products') }}
                    </a>
                </li>
                <li class="navbar-menu-item">
                    <a href="{{ route('about') }}" @if(Route::currentRouteName() === 'about') class="active" @endif>
                        {{ __('messages.nav_about') }}
                    </a>
                </li>
                <li class="navbar-menu-item">
                    <a href="{{ route('contact') }}" @if(Route::currentRouteName() === 'contact') class="active" @endif>
                        {{ __('messages.nav_contact') }}
                    </a>
                </li>
                <li class="navbar-menu-item">
                    <a href="{{ route('cart.view') }}" class="navbar-cart" id="cart-link">
                        <span>🛒</span>
                        <span class="cart-count hidden" id="cart-count">0</span>
                    </a>
                </li>
                <!-- Language Switcher Pill Button -->
                <li class="navbar-menu-item">
                    <a href="{{ route('lang.switch', app()->getLocale() === 'ar' ? 'en' : 'ar') }}" class="btn-obsidian" style="padding: 0.45rem 1rem; border-radius: 40px; font-size: 0.825rem; border: 1px solid rgba(226, 227, 237, 0.15);">
                        🌐 {{ __('messages.switch_language') }}
                    </a>
                </li>
                @auth
                    <li class="navbar-menu-item">
                        <a href="{{ route('profile.index') }}" class="btn-obsidian" style="padding: 0.45rem 1.1rem; border-radius: 40px; font-size: 0.85rem;">
                            👤 {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li class="navbar-menu-item">
                        <form action="{{ route('profile.logout') }}" method="POST" style="margin: 0; display: inline;">
                            @csrf
                            <button type="submit" class="btn-obsidian" style="padding: 0.45rem 1rem; border-radius: 40px; font-size: 0.85rem; cursor: pointer; color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.2);">
                                🚪 {{ __('messages.nav_logout') }}
                            </button>
                        </form>
                    </li>
                @else
                    <li class="navbar-menu-item">
                        <a href="{{ route('checkout.login') }}" class="btn-primary" style="padding: 0.45rem 1.3rem; border-radius: 32px; font-size: 0.85rem;">
                            🔐 {{ __('messages.nav_login') }}
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        @if ($message = session('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        @if ($message = session('error'))
            <div class="alert alert-error">{{ $message }}</div>
        @endif

        @if ($message = session('warning'))
            <div class="alert alert-error" style="border-left-color: #f59e0b; color: #fcd34d; background-color: rgba(245, 158, 11, 0.1);">{{ $message }}</div>
        @endif

        @yield('content')
    </div>

    <!-- Minimalist Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>{{ __('messages.footer_about_title') }}</h3>
                <p>{{ __('messages.footer_about_text') }}</p>
            </div>
            <div class="footer-section">
                <h3>{{ __('messages.footer_quick_links') }}</h3>
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('messages.nav_home') }}</a></li>
                    <li><a href="{{ route('products.index') }}">{{ __('messages.nav_products') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('messages.nav_about') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('messages.nav_contact') }}</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>{{ __('messages.footer_contact_info') }}</h3>
                <ul>
                    <li>Email: info@plantstore.com</li>
                    <li>Phone: +1 (555) 123-4567</li>
                    <li>{{ __('messages.contact_location_title') }}: {{ __('messages.contact_location_val') }}</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>{{ __('messages.footer_rights') }}</p>
        </div>
    </footer>

    <script>
        // Navbar Toggle for Mobile
        const navbarToggle = document.getElementById('navbar-toggle');
        const navbarMenu = document.getElementById('navbar-menu');

        if (navbarToggle) {
            navbarToggle.addEventListener('click', () => {
                navbarMenu.classList.toggle('active');
            });

            document.querySelectorAll('.navbar-menu-item a').forEach(link => {
                link.addEventListener('click', () => {
                    navbarMenu.classList.remove('active');
                });
            });
        }

        // Update Cart Count from API
        async function updateCartCount() {
            try {
                const response = await fetch('{{ route("cart.index") }}');
                const data = await response.json();
                const cartCount = document.getElementById('cart-count');

                if (data.count && data.count > 0) {
                    cartCount.textContent = data.count;
                    cartCount.classList.remove('hidden');
                } else {
                    cartCount.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error fetching cart:', error);
            }
        }

        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', updateCartCount);

        // Listen for cart updates
        window.addEventListener('cartUpdated', updateCartCount);
    </script>
    @yield('extra-js')
</body>
</html>
