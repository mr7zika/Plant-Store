@extends('layouts.app')

@section('title', $product->name)

@section('content')
<style>
    .product-container { max-width: 1000px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; flex-wrap: wrap; gap: 30px; direction: rtl; }
    .product-media { flex: 1; min-width: 300px; }
    .product-info { flex: 1; min-width: 300px; }
    .btn-back { background-color: #64748b; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; display: inline-block; margin-bottom: 20px; font-weight: bold; transition: background 0.3s; }
    .btn-back:hover { background-color: #1e3a8a; }
    .product-name { font-size: 32px; color: #1e3a8a; margin-bottom: 15px; font-weight: 700; }
    .product-price { font-size: 28px; color: #2563eb; font-weight: bold; margin-bottom: 20px; }
    .category-badge { display: inline-block; background-color: #2563eb; color: white; padding: 6px 15px; border-radius: 20px; font-size: 14px; margin-bottom: 20px; }
    .product-desc { color: #555; line-height: 1.8; margin-bottom: 25px; font-size: 16px; }
    .video-placeholder { margin-top: 20px; width: 100%; height: 220px; background: #1e293b; color: #ecf0f1; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: 2px dashed #475569; }
    
    .cart-form { background: #f8faff; padding: 25px; border-radius: 8px; margin-top: 20px; border: 1px solid #dbeafe; }
    .qty-input { width: 80px; padding: 10px; text-align: center; border: 1px solid #ced4da; border-radius: 6px; margin: 0 15px; font-size: 16px; }
    .btn-add-cart { background-color: #2563eb; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; width: 100%; margin-top: 15px; transition: all 0.3s; }
    .btn-add-cart:hover { background-color: #1e3a8a; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(30, 58, 138, 0.25); }
    .btn-add-cart:disabled { background-color: #95a5a6; cursor: not-allowed; transform: none; box-shadow: none; }
</style>

<div class="product-container">
    <div style="width: 100%;">
        <a href="{{ route('products.index') }}" class="btn-back">← العودة للمنتجات</a>
    </div>

    <!-- قسم الميديا (الصورة والفيديو) -->
    <div class="product-media">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        @else
            <div style="width: 100%; height: 350px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #64748b; font-size: 18px;">
                لا توجد صورة لهذا المنتج
            </div>
        @endif

        <div class="video-placeholder">
            @if($product->video)
                <a href="{{ $product->video }}" target="_blank" style="color: #60a5fa; text-decoration: none;">▶ مشاهدة فيديو المنتج</a>
            @else
                ▶ مساحة مخصصة لفيديو استعراضي للمنتج (قريباً)
            @endif
        </div>
    </div>

    <!-- قسم التفاصيل والسلة -->
    <div class="product-info">
        @if($product->category)
            <span class="category-badge">{{ $product->category->name }}</span>
        @endif
        
        <h1 class="product-name">{{ $product->name }}</h1>
        <div class="product-price">{{ number_format($product->price, 2) }} ريال</div>
        
        <div class="product-desc">
            {{ $product->description ?? 'لا يوجد وصف متاح حالياً لهذا المنتج.' }}
        </div>

        <p style="color: {{ $product->quantity > 0 ? '#16a34a' : '#ef4444' }}; font-weight: bold; margin-bottom: 10px;">
            حالة المخزون: {{ $product->quantity > 0 ? 'متوفر (' . $product->quantity . ')' : 'نفدت الكمية' }}
        </p>

        <!-- نموذج الإضافة للسلة للعملاء -->
        <form action="{{ route('cart.add-item') }}" method="POST" class="cart-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <div style="display: flex; align-items: center; justify-content: center;">
                <label for="quantity" style="font-weight: bold; color: #1e3a8a;">الكمية المطلوبة:</label>
                <input type="number" name="quantity" id="quantity" class="qty-input" value="1" min="1" max="{{ $product->quantity > 0 ? $product->quantity : 1 }}">
            </div>
            
            <button type="submit" class="btn-add-cart" {{ $product->quantity < 1 ? 'disabled' : '' }}>
                {{ $product->quantity > 0 ? 'إضافة إلى السلة 🛒' : 'غير متوفر حالياً' }}
            </button>
        </form>
        
        <div style="font-size: 12px; color: #94a3b8; margin-top: 20px; text-align: center;">
            أُضيف بتاريخ: {{ $product->created_at->format('Y-m-d') }}
        </div>
    </div>
</div>
@endsection
