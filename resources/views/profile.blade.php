@extends('layouts.app')

@section('title', __('messages.profile_title') . ' — ' . __('messages.store_name'))

@section('content')
<div style="max-width: 960px; margin: 0 auto; padding-bottom: 2rem;">
    
    <!-- بطاقة بيانات المستخدم (Graphite Card) -->
    <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); margin-bottom: 2rem; border: 1px solid rgba(226, 227, 237, 0.04); text-align: start;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
            <h1 style="color: var(--color-ivory-text); font-size: var(--text-heading-sm); font-weight: 480; margin: 0; letter-spacing: 0.015em;">
                👤 {{ __('messages.profile_title') }}
            </h1>
            <a href="{{ route('profile.logout') }}" class="btn btn-obsidian" style="padding: 8px 18px; font-size: var(--text-body-sm); color: #fca5a5; border-color: rgba(239, 68, 68, 0.2);">
                {{ __('messages.nav_logout') }}
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; border-top: 1px solid rgba(226, 227, 237, 0.06); padding-top: 1.5rem;">
            <div>
                <label style="color: var(--color-ash-text); font-size: var(--text-caption);">{{ __('messages.profile_title') }}</label>
                <div style="color: var(--color-ivory-text); font-size: var(--text-body); font-weight: 480;">{{ $user->name }}</div>
            </div>
            <div>
                <label style="color: var(--color-ash-text); font-size: var(--text-caption);">{{ __('messages.checkout_email_label') }}</label>
                <div style="color: var(--color-ivory-text); font-size: var(--text-body); font-weight: 480;">{{ $user->email }}</div>
            </div>
        </div>
    </div>

    <!-- قسم الطلبات والفواتير (Graphite Card) -->
    <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04); text-align: start;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid rgba(226, 227, 237, 0.08); padding-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
            <h2 style="color: var(--color-ivory-text); font-size: var(--text-heading-sm); font-weight: 480; margin: 0; letter-spacing: 0.015em;">
                📦 {{ __('messages.profile_orders_title') }}
            </h2>
            <button onclick="window.print()" class="btn btn-ghost" style="padding: 8px 20px; font-size: var(--text-body-sm);">
                {{ __('messages.profile_print_btn') }}
            </button>
        </div>

        @if($orders->isEmpty())
            <div style="text-align: center; padding: 48px 20px; background-color: var(--color-onyx-canvas); border-radius: var(--radius-cards); border: 1px dashed rgba(226, 227, 237, 0.1);">
                <p style="color: var(--color-ash-text); font-size: var(--text-body); margin-bottom: 1.5rem;">{{ __('messages.profile_no_orders') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 10px 28px;">
                    {{ __('messages.profile_browse_plants') }}
                </a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($orders as $order)
                    <div style="border: 1px solid rgba(226, 227, 237, 0.08); border-radius: var(--radius-cards); padding: 1.5rem; background-color: var(--color-onyx-canvas);">
                        <!-- رأس الطلب -->
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(226, 227, 237, 0.06); padding-bottom: 1rem; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                            <div>
                                <span style="font-weight: 480; color: var(--color-ivory-text); font-size: var(--text-body);">{{ __('messages.profile_order_num', ['id' => $order->id]) }}</span>
                                <span style="color: var(--color-ash-text); margin-inline-start: 1rem; font-size: var(--text-caption);">{{ __('messages.profile_order_date') }} {{ $order->created_at->format('d/m/Y - h:i A') }}</span>
                            </div>
                            <div>
                                @php
                                    $statusKey = 'messages.status_' . $order->status;
                                    $statusLabel = \Illuminate\Support\Facades\Lang::has($statusKey) ? __($statusKey) : $order->status;
                                @endphp
                                <span class="badge-pill" style="border: 1px solid rgba(226, 227, 237, 0.15);">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- جدول المنتجات داخل الطلب الواحد -->
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: var(--color-obsidian-button);">
                                        <th style="padding: 10px 14px; text-align: start;">{{ __('messages.cart_th_product') }}</th>
                                        <th style="padding: 10px 14px; text-align: center;">{{ __('messages.cart_th_price') }}</th>
                                        <th style="padding: 10px 14px; text-align: center;">{{ __('messages.cart_th_qty') }}</th>
                                        <th style="padding: 10px 14px; text-align: center;">{{ __('messages.cart_th_subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr style="border-bottom: 1px solid rgba(226, 227, 237, 0.05); font-size: var(--text-body-sm);">
                                            <td style="padding: 12px 14px; text-align: start; display: flex; align-items: center; gap: 12px;">
                                                @if($item->product)
                                                    <a href="{{ route('products.show', $item->product->id) }}">
                                                        <img src="{{ asset('storage/' . ($item->product->image ?? 'default.png')) }}" alt="{{ $item->product->name }}" style="width: 44px; height: 44px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(226, 227, 237, 0.1);">
                                                    </a>
                                                    <a href="{{ route('products.show', $item->product->id) }}" style="color: var(--color-ivory-text); font-weight: 480; text-decoration: none;">
                                                        {{ $item->product->name }}
                                                    </a>
                                                @else
                                                    <span style="color: var(--color-ash-text);">{{ __('messages.product_unavailable') }}</span>
                                                @endif
                                            </td>
                                            <td style="padding: 12px 14px; text-align: center; color: var(--color-ash-text);">${{ number_format($item->price, 2) }}</td>
                                            <td style="padding: 12px 14px; text-align: center; color: var(--color-ash-text);">{{ $item->quantity }}</td>
                                            <td style="padding: 12px 14px; text-align: center; font-weight: 500; color: var(--color-pure-white);">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- إجمالي الطلب وأزرار الإجراءات -->
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid rgba(226, 227, 237, 0.06); flex-wrap: wrap; gap: 1rem;">
                            <div style="font-size: var(--text-body); color: var(--color-ash-text);">
                                {{ __('messages.profile_total') }} <strong style="color: var(--color-pure-white); font-size: 1.2rem; font-weight: 500;">${{ number_format($order->total_amount, 2) }}</strong>
                            </div>

                            <div>
                                @if(in_array($order->status, ['pending', 'confirmed']))
                                    <form action="{{ route('profile.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.profile_cancel_confirm') }}');" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-obsidian" style="padding: 6px 16px; border-radius: 32px; font-size: var(--text-caption); cursor: pointer; color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.2);">
                                            {{ __('messages.profile_cancel_order') }}
                                        </button>
                                    </form>
                                @else
                                    <span style="color: var(--color-ash-text); font-size: var(--text-caption);">{{ __('messages.profile_cannot_cancel') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Print Styles for Clean Invoices -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .main-content, .main-content * {
        visibility: visible;
    }
    .main-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white !important;
        color: black !important;
    }
    nav, footer, button, a[href*="logout"], form {
        display: none !important;
    }
    div, table, td, th {
        background: white !important;
        color: black !important;
        border-color: #ddd !important;
    }
}
</style>
@endsection
