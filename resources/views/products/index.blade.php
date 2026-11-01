@extends('layouts.app')

@section('title', 'Products - Plant Store')

@section('extra-css')
<style>
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .product-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        box-shadow: 0 8px 20px rgba(30, 58, 138, 0.12);
        transform: translateY(-4px);
    }
    .category-badge {
        display: inline-block;
        background-color: #2563eb;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        margin-bottom: 12px;
        width: fit-content;
        font-weight: 500;
    }
    .product-name {
        color: #1e3a8a;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 8px;
        transition: color 0.3s ease;
    }
    .product-name:hover {
        color: #2563eb;
    }
    .product-price {
        color: #2563eb;
        font-weight: bold;
        font-size: 1.4rem;
        margin-bottom: 8px;
    }
    .product-stock {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 12px;
    }
    .product-stock.low {
        color: #e74c3c;
        font-weight: 600;
    }
    .product-description {
        color: #64748b;
        font-size: 0.85rem;
        margin-bottom: 16px;
        flex-grow: 1;
        line-height: 1.5;
    }
    .view-details {
        color: #2563eb;
        text-decoration: none;
        font-weight: bold;
        font-size: 0.95rem;
        margin-bottom: 15px;
        display: inline-block;
        transition: color 0.3s ease;
    }
    .view-details:hover {
        color: #1e3a8a;
        text-decoration: underline;
    }
    .btn-add-cart {
        background-color: #2563eb;
        color: white;
        padding: 12px 24px;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
        font-size: 1rem;
        cursor: pointer;
        border: none;
        transition: all 0.3s ease;
        font-weight: 600;
        width: 100%;
    }
    .btn-add-cart:hover {
        background-color: #1e3a8a;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(30, 58, 138, 0.25);
    }
    .btn-add-cart:active {
        transform: translateY(0);
    }
    .btn-add-cart:disabled {
        background-color: #ccc;
        cursor: not-allowed;
        transform: none;
    }
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background-color: #f8faff;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
    }
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    .empty-state-text {
        font-size: 1.2rem;
        color: #64748b;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h1 style="margin: 0 0 2rem 0; text-align: center;">🌱 Our Beautiful Plant Collection</h1>

    @if ($products->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🪴</div>
            <p class="empty-state-text">No plants available at the moment. Please check back soon!</p>
        </div>
    @else
        <div class="products-grid">
            @foreach ($products as $product)
                <div class="product-card">
                    @if($product->category)
                        <span class="category-badge">{{ $product->category->name }}</span>
                    @endif
                    
                    <!-- رابط لصفحة تفاصيل المنتج عبر الاسم -->
                    <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none;">
                        <h3 class="product-name">{{ $product->name }}</h3>
                    </a>
                    
                    <p class="product-price">${{ number_format($product->price, 2) }}</p>
                    
                    <p class="product-stock @if($product->quantity < 5) low @endif">
                        @if($product->quantity > 0)
                            ✓ In Stock @if($product->quantity < 5)(Only {{ $product->quantity }} left)@endif
                        @else
                            ✗ Out of Stock
                        @endif
                    </p>
                    
                    @if($product->description)
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                    @endif
                    
                    <!-- رابط صريح لعرض التفاصيل (show.blade.php) -->
                    <a href="{{ route('products.show', $product->id) }}" class="view-details">
                        View Details ➔
                    </a>
                    
                    <form action="{{ route('cart.add-item') }}" method="POST" style="margin-top: auto;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-add-cart" @if($product->quantity <= 0) disabled @endif>
                            @if($product->quantity > 0)
                                🛒 Add to Cart
                            @else
                                Out of Stock
                            @endif
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
