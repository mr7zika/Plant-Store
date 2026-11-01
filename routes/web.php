<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderManagementController;

// Language switch route
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session()->put('locale', $locale);
        cookie()->queue(cookie()->forever('locale', $locale));
    }
    return redirect()->back(fallback: route('home'));
})->name('lang.switch');

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// About page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Cart view page
Route::get('/cart', function () {
    return view('cart');
})->name('cart.view');

// Add to cart (POST from product page) - redirects to cart
Route::post('/cart/add-item', [CartController::class, 'addItem'])->name('cart.add-item');

// Products CRUD
Route::resource('products', ProductController::class);

// Cart API Routes
Route::prefix('api/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{productId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Checkout routes - guests can view, but must auth to process
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Profile routes - protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/logout', [ProfileController::class, 'logout'])->name('profile.logout');
    
    // مسار إلغاء الطلب (يحذف الطلب وتلقائياً هيトーرجع المخزون بفضل الـ booted في الـ Order model)
    Route::delete('/profile/orders/{order}/cancel', [ProfileController::class, 'cancelOrder'])->name('profile.orders.cancel');
});

// Auth routes (guest checkout flow - login/register during checkout)
Route::middleware('guest')->group(function () {
    Route::get('/checkout/login', [CheckoutController::class, 'showLoginForm'])->name('checkout.login');
    Route::post('/checkout/authenticate', [CheckoutController::class, 'authenticate'])->name('checkout.authenticate');
    Route::get('/checkout/register', [CheckoutController::class, 'showRegisterForm'])->name('checkout.register');
    Route::post('/checkout/store-user', [CheckoutController::class, 'storeUser'])->name('checkout.store-user');
});

// Admin routes (Order Management)
Route::patch('/admin/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('admin.orders.status');