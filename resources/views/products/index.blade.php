@extends('layouts.app')

@section('title', __('messages.catalog_title') . ' — ' . __('messages.store_name'))

@section('extra-css')
<style>
    .catalog-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    .catalog-title {
        font-size: var(--text-heading);
        font-weight: 480;
        color: var(--color-ivory-text);
        letter-spacing: 0.015em;
        margin-bottom: 0.75rem;
    }
    .catalog-subtitle {
        color: var(--color-ash-text);
        font-size: var(--text-body);
        max-width: 540px;
        margin: 0 auto;
    }
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }
    .product-card {
        background-color: var(--color-graphite-card);
        border-radius: var(--radius-cards);
        padding: var(--card-padding);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(226, 227, 237, 0.04);
        transition: background-color 0.2s ease;
        text-align: start;
    }
    .product-card:hover {
        background-color: #232332;
    }
    .category-badge {
        display: inline-block;
        background-color: var(--color-obsidian-button);
        color: var(--color-ash-text);
        padding: 5px 14px;
        border-radius: var(--radius-tags);
        font-size: var(--text-caption);
        letter-spacing: 0.02em;
        margin-bottom: 1rem;
        width: fit-content;
        border: 1px solid rgba(226, 227, 237, 0.06);
    }
    .product-name {
        color: var(--color-ivory-text);
        font-size: var(--text-subheading);
        font-weight: 480;
        margin-bottom: 0.5rem;
        letter-spacing: 0.01em;
        line-height: 1.3;
        transition: color 0.2s ease;
    }
    .product-name:hover {
        color: var(--color-pure-white);
    }
    .product-price {
        color: var(--color-ivory-text);
        font-size: 1.35rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
    }
    .product-stock {
        font-size: var(--text-caption);
        letter-spacing: 0.02em;
        color: var(--color-ash-text);
        margin-bottom: 1rem;
    }
    .product-stock.low {
        color: #fca5a5;
    }
    .product-description {
        color: var(--color-ash-text);
        font-size: var(--text-body-sm);
        margin-bottom: 1.5rem;
        flex-grow: 1;
        line-height: 1.6;
    }
    .view-details {
        color: var(--color-ivory-text);
        text-decoration: none;
        font-size: var(--text-body-sm);
        margin-bottom: 1.25rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: opacity 0.2s ease;
    }
    .view-details:hover {
        opacity: 0.8;
    }
    .btn-add-cart {
        background-color: var(--color-cobalt);
        color: var(--color-pure-white);
        padding: 12px 24px;
        text-decoration: none;
        border-radius: var(--radius-buttons);
        text-align: center;
        font-size: var(--text-body-sm);
        cursor: pointer;
        border: none;
        transition: background-color 0.2s ease;
        font-weight: 480;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-add-cart:hover {
        background-color: var(--color-cobalt-hover);
    }
    .btn-add-cart:disabled {
        background-color: var(--color-obsidian-button);
        color: var(--color-ash-text);
        cursor: not-allowed;
        opacity: 0.7;
    }
    .empty-state {
        text-align: center;
        padding: 80px 24px;
        background-color: var(--color-graphite-card);
        border-radius: var(--radius-cards);
        border: 1px solid rgba(226, 227, 237, 0.06);
    }
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.7;
    }
    .empty-state-text {
        font-size: var(--text-body);
        color: var(--color-ash-text);
    }
</style>
@endsection

@section('content')
<div class="catalog-header">
    <h1 class="catalog-title">{{ __('messages.catalog_title') }}</h1>
    <p class="catalog-subtitle">{{ __('messages.catalog_subtitle') }}</p>
</div>

@if ($products->isEmpty())
    <div class="empty-state">
        <div class="empty-state-icon">🪴</div>
        <p class="empty-state-text">{{ __('messages.catalog_empty') }}</p>
    </div>
@else
    <div class="products-grid">
        @foreach ($products as $product)
            <div class="product-card">
                @if($product->category)
                    <span class="category-badge">{{ $product->category->name }}</span>
                @endif
                
                <!-- Link to Product Details Page via Name -->
                <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none;">
                    <h3 class="product-name">{{ $product->name }}</h3>
                </a>
                
                <p class="product-price">${{ number_format($product->price, 2) }}</p>
                
                <p class="product-stock @if($product->quantity < 5) low @endif">
                    @if($product->quantity > 0)
                        ✓ {{ __('messages.catalog_in_stock') }} @if($product->quantity < 5)({{ __('messages.catalog_only_left', ['count' => $product->quantity]) }})@endif
                    @else
                        ✗ {{ __('messages.catalog_out_of_stock') }}
                    @endif
                </p>
                
                @if($product->description)
                    <p class="product-description">{{ Str::limit($product->description, 110) }}</p>
                @endif
                
                <!-- Link to Product Details Page -->
                <a href="{{ route('products.show', $product->id) }}" class="view-details">
                    <span>{{ __('messages.catalog_view_details') }}</span>
                    <span>{{ app()->getLocale() === 'ar' ? '←' : '→' }}</span>
                </a>
                
                <form action="{{ route('cart.add-item') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-add-cart" @if($product->quantity <= 0) disabled @endif>
                        @if($product->quantity > 0)
                            {{ __('messages.catalog_add_to_cart') }}
                        @else
                            {{ __('messages.catalog_out_of_stock') }}
                        @endif
                    </button>
                </form>
            </div>
        @endforeach
    </div>
@endif
@endsection
