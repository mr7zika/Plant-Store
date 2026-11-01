@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 900px; margin: 0 auto;">
        
        <!-- بطاقة بيانات المستخدم -->
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h1 style="color: #1e3a8a; margin: 0;">👤 بيانات حسابي</h1>
                <a href="{{ route('profile.logout') }}" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">تسجيل الخروج</a>
            </div>

            <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 1.5rem;">
                <div style="margin-bottom: 1rem;">
                    <label style="color: #64748b; font-weight: 600;">الاسم:</label>
                    <p style="color: #1e3a8a; font-size: 1.1rem; margin: 0.5rem 0 0 0; font-weight: 600;">{{ $user->name }}</p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="color: #64748b; font-weight: 600;">البريد الإلكتروني:</label>
                    <p style="color: #1e3a8a; font-size: 1.1rem; margin: 0.5rem 0 0 0; font-weight: 600;">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <!-- قسم الطلبات والفواتير -->
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #2563eb; padding-bottom: 0.5rem;">
                <h2 style="color: #1e3a8a; margin: 0;">📦 طلباتي وفواتيري</h2>
                <!-- زر طباعة الصفحة بالكامل أو الفواتير -->
                <button onclick="window.print()" style="background: #1e3a8a; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; font-size: 0.9rem; font-weight: 600; transition: background 0.3s;">
                    🖨️ طباعة الطلبات
                </button>
            </div>

            @if($orders->isEmpty())
                <div style="text-align: center; padding: 2rem; background: #f8faff; border: 1px dashed #cbd5e1; border-radius: 4px;">
                    <p style="color: #64748b; font-size: 1.1rem;">لم تقم بأي طلبات حتى الآن</p>
                    <a href="{{ route('products.index') }}" style="display: inline-block; background: #2563eb; color: white; padding: 0.75rem 1.5rem; border-radius: 4px; text-decoration: none; margin-top: 1rem; font-weight: 600;">ابدأ التسوق الآن</a>
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 2rem;">
                    @foreach($orders as $order)
                        <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.5rem; background: #fafcff;">
                            <!-- رأس الطلب -->
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 1rem; margin-bottom: 1rem;">
                                <div>
                                    <span style="font-weight: bold; color: #1e3a8a; font-size: 1.1rem;">طلب #{{ $order->id }}</span>
                                    <span style="color: #64748b; margin-right: 1rem; font-size: 0.9rem;">التاريخ: {{ $order->created_at->format('d/m/Y - h:i A') }}</span>
                                </div>
                                <div>
                                    @php
                                        $status_colors = ['pending' => '#f39c12', 'confirmed' => '#2563eb', 'shipped' => '#8b5cf6', 'delivered' => '#16a34a', 'cancelled' => '#ef4444'];
                                        $status_labels = ['pending' => 'قيد الانتظار', 'confirmed' => 'مؤكد', 'shipped' => 'مرسل', 'delivered' => 'تم التسليم', 'cancelled' => 'ملغى'];
                                    @endphp
                                    <span style="background: {{ $status_colors[$order->status] ?? '#999' }}; color: white; padding: 0.3rem 0.8rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                                        {{ $status_labels[$order->status] ?? $order->status }}
                                    </span>
                                </div>
                            </div>

                            <!-- جدول المنتجات داخل الطلب الواحد -->
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 4px;">
                                    <thead>
                                        <tr style="background: #f1f5f9; color: #1e293b; font-size: 0.9rem;">
                                            <th style="padding: 0.75rem; text-align: right;">المنتج</th>
                                            <th style="padding: 0.75rem; text-align: center;">السعر</th>
                                            <th style="padding: 0.75rem; text-align: center;">الكمية</th>
                                            <th style="padding: 0.75rem; text-align: center;">الإجمالي الفرعي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                             <tr style="border-bottom: 1px solid #f1f5f9; font-size: 0.9rem;">
                                                <td style="padding: 0.75rem; text-align: right; display: flex; align-items: center; gap: 10px;">
                                                    @if($item->product)
                                                        <!-- صورة مصغرة للمنتج تضغط عليها تحولك لصفحة المنتج -->
                                                        <a href="{{ route('products.show', $item->product->id) }}">
                                                            <img src="{{ asset('storage/' . ($item->product->image ?? 'default.png')) }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                                        </a>
                                                        <a href="{{ route('products.show', $item->product->id) }}" style="color: #1e3a8a; text-decoration: none; font-weight: 600;">
                                                            {{ $item->product->name }}
                                                        </a>
                                                    @else
                                                        <span style="color: #999;">منتج محذوف</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 0.75rem; text-align: center;">${{ number_format($item->price, 2) }}</td>
                                                <td style="padding: 0.75rem; text-align: center;">{{ $item->quantity }}</td>
                                                <td style="padding: 0.75rem; text-align: center; font-weight: 600; color: #2563eb;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- إجمالي الطلب وأزرار الإجراءات -->
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 0.5rem;">
                                <div style="font-size: 1.1rem; font-weight: bold; color: #1e3a8a;">
                                    الإجمالي الكلي: <span style="color: #2563eb;">${{ number_format($order->total_amount, 2) }}</span>
                                </div>

                                <div>
                                    @if(in_array($order->status, ['pending', 'confirmed']))
                                        <form action="{{ route('profile.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من رغبتك في إلغاء هذا الطلب وإرجاع المنتجات للمخزون؟');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #ef4444; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                                                إلغاء الطلب
                                            </button>
                                        </form>
                                    @else
                                        <span style="color: #999; font-size: 0.85rem;">لا يمكن الإلغاء</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- تنسيق خاص بالطباعة عشان يخفي أزرار الخروج والإلغاء ويطبع الفاتورة بشكل نظيف -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .container, .container * {
        visibility: visible;
    }
    .container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    button, a[href*="logout"], form {
        display: none !important;
    }
}

@media print {
    /* إخفاء الهيدر والفوتر والأزرار التي لا نحتاجها في الطباعة */
    nav, footer, .btn-print, header, a[href*="logout"], form button {
        display: none !important;
    }
    
    /* ضبط الصفحة وخلفيتها لتبدو كفاتورة نظيفة */
    body {
        background: white !important;
        color: black !important;
        font-size: 12pt;
        margin: 0;
        padding: 0;
    }

    /* حصر المحتوى في مساحة ضيقة ومنظمة بدون مسافات فارغة */
    .container {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* تقليل الهوامش والمسافات الكبيرة بين الصناديق */
    div[style*="margin-bottom"] {
        margin-bottom: 1rem !important;
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }

    /* منع انقسام العناصر بين الورقتين */
    tr, .invoice-card, div {
        page-break-inside: avoid;
    }
}
</style>
@endsection
