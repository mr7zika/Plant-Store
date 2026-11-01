@extends('layouts.app')

@section('title', $product->name . ' — ' . __('messages.store_name'))

@section('content')
<style>
    .product-detail-container {
        max-width: 1000px;
        margin: 20px auto;
        background-color: var(--color-graphite-card);
        padding: var(--card-padding);
        border-radius: var(--radius-cards);
        display: flex;
        flex-wrap: wrap;
        gap: 36px;
        border: 1px solid rgba(226, 227, 237, 0.04);
        text-align: start;
    }
    .product-media {
        flex: 1;
        min-width: 300px;
    }
    .product-info {
        flex: 1;
        min-width: 300px;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: transparent;
        color: var(--color-ivory-text);
        border: 1px solid rgba(226, 227, 237, 0.2);
        padding: 8px 20px;
        border-radius: var(--radius-nav);
        font-size: var(--text-body-sm);
        text-decoration: none;
        margin-bottom: 24px;
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        background-color: var(--color-obsidian-button);
        border-color: var(--color-ivory-text);
        color: var(--color-pure-white);
    }
    .product-name {
        font-size: var(--text-heading);
        font-weight: 480;
        color: var(--color-ivory-text);
        margin-bottom: 12px;
        letter-spacing: 0.015em;
    }
    .product-price {
        font-size: 26px;
        color: var(--color-pure-white);
        font-weight: 500;
        margin-bottom: 20px;
    }
    .category-badge {
        display: inline-block;
        background-color: var(--color-obsidian-button);
        color: var(--color-ash-text);
        padding: 5px 16px;
        border-radius: var(--radius-tags);
        font-size: var(--text-caption);
        margin-bottom: 16px;
        border: 1px solid rgba(226, 227, 237, 0.08);
    }
    .product-desc {
        color: var(--color-ash-text);
        line-height: 1.7;
        margin-bottom: 24px;
        font-size: var(--text-body);
    }
    .video-placeholder {
        margin-top: 20px;
        width: 100%;
        height: 200px;
        background-color: var(--color-onyx-canvas);
        color: var(--color-ash-text);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--radius-cards);
        border: 1px dashed rgba(226, 227, 237, 0.15);
        font-size: var(--text-body-sm);
    }
    .cart-form {
        background-color: var(--color-obsidian-button);
        padding: 24px;
        border-radius: var(--radius-cards);
        margin-top: 24px;
        border: 1px solid rgba(226, 227, 237, 0.06);
    }
    .qty-input {
        width: 90px;
        padding: 10px;
        text-align: center;
        background-color: var(--color-onyx-canvas);
        color: var(--color-ivory-text);
        border: 1px solid rgba(226, 227, 237, 0.2);
        border-radius: var(--radius-inputs);
        margin: 0 12px;
        font-size: var(--text-body);
    }
    .btn-add-cart {
        background-color: var(--color-cobalt);
        color: var(--color-pure-white);
        border: none;
        padding: 14px 24px;
        border-radius: var(--radius-buttons);
        cursor: pointer;
        font-size: var(--text-body);
        font-weight: 480;
        width: 100%;
        margin-top: 16px;
        transition: background-color 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-add-cart:hover {
        background-color: var(--color-cobalt-hover);
    }
    .btn-add-cart:disabled {
        background-color: rgba(39, 39, 53, 0.6);
        color: var(--color-ash-text);
        cursor: not-allowed;
    }
</style>

<div class="product-detail-container">
    <div style="width: 100%;">
        <a href="{{ route('products.index') }}" class="btn-back">
            <span>{{ app()->getLocale() === 'ar' ? '→' : '←' }}</span>
            <span>{{ __('messages.product_back') }}</span>
        </a>
    </div>

    <!-- قسم الميديا (الصورة والفيديو) -->
    <div class="product-media">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.08);">
        @else
            <div style="width: 100%; height: 350px; background-color: var(--color-onyx-canvas); display: flex; align-items: center; justify-content: center; border-radius: var(--radius-cards); color: var(--color-ash-text); font-size: 16px; border: 1px solid rgba(226, 227, 237, 0.06);">
                {{ __('messages.product_no_image') }}
            </div>
        @endif

        <div class="video-placeholder">
            @if($product->video)
                <a href="{{ $product->video }}" target="_blank" style="color: var(--color-ivory-text); text-decoration: underline;">
                    {{ __('messages.product_watch_video') }}
                </a>
            @else
                {{ __('messages.product_video_placeholder') }}
            @endif
        </div>
    </div>

    <!-- قسم التفاصيل والسلة -->
    <div class="product-info">
        @if($product->category)
            <span class="category-badge">{{ $product->category->name }}</span>
        @endif
        
        <h1 class="product-name">{{ $product->name }}</h1>
        <div class="product-price">${{ number_format($product->price, 2) }}</div>
        
        <div class="product-desc">
            {{ $product->description ?? __('messages.product_no_desc') }}
        </div>

        <p style="color: {{ $product->quantity > 0 ? 'var(--color-ivory-text)' : '#fca5a5' }}; font-size: var(--text-body-sm); margin-bottom: 12px;">
            {{ __('messages.product_stock_status') }}
            @if($product->quantity > 0)
                {{ __('messages.product_available_count', ['count' => $product->quantity]) }}
            @else
                {{ __('messages.catalog_out_of_stock') }}
            @endif
        </p>

        <!-- نموذج الإضافة للسلة للعملاء -->
        <form action="{{ route('cart.add-item') }}" method="POST" class="cart-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <div style="display: flex; align-items: center; justify-content: center;">
                <label for="quantity" style="color: var(--color-ivory-text); margin-bottom: 0;">{{ __('messages.product_qty_label') }}</label>
                <input type="number" name="quantity" id="quantity" class="qty-input" value="1" min="1" max="{{ $product->quantity > 0 ? $product->quantity : 1 }}">
            </div>
            
            <button type="submit" class="btn-add-cart" {{ $product->quantity < 1 ? 'disabled' : '' }}>
                {{ $product->quantity > 0 ? __('messages.product_add_cart_btn') : __('messages.product_unavailable') }}
            </button>
        </form>
        
        <div style="font-size: var(--text-caption); color: var(--color-ash-text); margin-top: 24px; text-align: center;">
            {{ __('messages.product_added_date') }} {{ $product->created_at->format('Y-m-d') }}
        </div>
    </div>
</div>
@endsection
