<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Plant Store - Fresh Plants for Your Home')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('extra-css')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <span class="navbar-brand-icon">🌱</span>
                <span>Plant Store</span>
            </a>
            <button class="navbar-toggle" id="navbar-toggle">☰</button>
            <ul class="navbar-menu" id="navbar-menu">
                <li class="navbar-menu-item">
                    <a href="{{ route('home') }}" @if(Route::currentRouteName() === 'home') class="active" @endif>
                        Home
                    </a>
                </li>
                <li class="navbar-menu-item">
                    <a href="{{ route('products.index') }}" @if(Route::currentRouteName() === 'products.index') class="active" @endif>
                        Products
                    </a>
                </li>
                <li class="navbar-menu-item">
                    <a href="{{ route('about') }}" @if(Route::currentRouteName() === 'about') class="active" @endif>
                        About Us
                    </a>
                </li>
                <li class="navbar-menu-item">
                    <a href="{{ route('contact') }}" @if(Route::currentRouteName() === 'contact') class="active" @endif>
                        Contact Us
                    </a>
                </li>
                <li class="navbar-menu-item">
                    <a href="{{ route('cart.view') }}" class="navbar-cart" id="cart-link">
                        🛒
                        <span class="cart-count hidden" id="cart-count">0</span>
                    </a>
                </li>
                @auth
                    <li class="navbar-menu-item">
                        <a href="{{ route('profile.index') }}" style="background: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                            👤 {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li class="navbar-menu-item">
                        <form action="{{ route('profile.logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: #e74c3c; color: white; padding: 0.5rem 1rem; border-radius: 4px; border: none; cursor: pointer;">
                                🚪 تسجيل الخروج
                            </button>
                        </form>
                    </li>
                @else
                    <li class="navbar-menu-item">
                        <a href="{{ route('checkout.login') }}" style="background: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                            🔐 تسجيل الدخول
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

        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Plant Store</h3>
                <p>Your one-stop shop for fresh, beautiful plants to bring nature into your home.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul>
                    <li>Email: info@plantstore.com</li>
                    <li>Phone: +1 (555) 123-4567</li>
                    <li>Location: Green City, USA</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Plant Store. All rights reserved. | Bringing nature closer to you.</p>
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
