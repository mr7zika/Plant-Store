@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="container">
    <div style="max-width: 400px; margin: 3rem auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(30,58,138,0.08); border: 1px solid #e2e8f0;">
        <h2 style="color: #1e3a8a; text-align: center; margin-bottom: 2rem;">🔐 تسجيل الدخول</h2>

        @if ($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <strong>حدث خطأ:</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.authenticate') }}" method="POST">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; color: #1e3a8a; font-weight: 600; margin-bottom: 0.5rem;">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label for="password" style="display: block; color: #1e3a8a; font-weight: 600; margin-bottom: 0.5rem;">كلمة المرور:</label>
                <input type="password" id="password" name="password" required 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 1rem;">
            </div>

            <button type="submit" style="width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: 600; font-size: 1rem; cursor: pointer; margin-bottom: 1rem; transition: background 0.3s;">
                تسجيل الدخول
            </button>
        </form>

        <div style="text-align: center; border-top: 1px solid #eee; padding-top: 1rem;">
            <p style="color: #64748b; margin-bottom: 1rem;">ليس لديك حساب؟</p>
            <a href="{{ route('checkout.register') }}" style="display: inline-block; background: #3b82f6; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background 0.3s;">
                إنشاء حساب جديد
            </a>
        </div>

        <div style="text-align: center; margin-top: 1rem;">
            <a href="{{ route('cart.view') }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">العودة إلى السلة</a>
        </div>
    </div>
</div>
@endsection
