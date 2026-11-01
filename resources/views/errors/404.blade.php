@extends('layouts.app')

@section('title', 'الصفحة غير موجودة')

@section('content')
<div style="display: flex; align-items: center; justify-content: center; min-height: 60vh;">
    <div style="text-align: center; padding: 2rem;">
        <div style="font-size: 5rem; margin-bottom: 1rem;">🌾</div>
        <h1 style="color: #1e3a8a; font-size: 2.5rem; margin-bottom: 0.5rem;">عذراً! الصفحة غير موجودة</h1>
        <p style="color: #64748b; font-size: 1.2rem; margin-bottom: 2rem;">يبدو أنك حاولت الوصول إلى صفحة لا توجد أو تم نقلها.</p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" style="background: #1e3a8a; color: white; padding: 0.75rem 2rem; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background 0.3s;">
                🏠 العودة للرئيسية
            </a>
            <a href="{{ route('products.index') }}" style="background: #2563eb; color: white; padding: 0.75rem 2rem; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background 0.3s;">
                🛍️ تصفح المنتجات
            </a>
        </div>
    </div>
</div>
@endsection
