@extends('layouts.app')

@section('title', __('messages.cart_title') . ' — ' . __('messages.store_name'))

@section('content')
<div class="container">
    <h1 style="font-weight: 480; letter-spacing: 0.015em; margin-bottom: 2rem;">🛒 {{ __('messages.cart_title') }}</h1>
    <div id="cart-content">
        <p style="color: var(--color-ash-text);">{{ __('messages.cart_loading') }}</p>
    </div>
</div>

@section('extra-js')
<script>
const i18n = {
    loading: "{{ __('messages.cart_loading') }}",
    empty_title: "{{ __('messages.cart_empty_title') }}",
    empty_text: "{{ __('messages.cart_empty_text') }}",
    explore_btn: "{{ __('messages.cart_explore_btn') }}",
    th_product: "{{ __('messages.cart_th_product') }}",
    th_price: "{{ __('messages.cart_th_price') }}",
    th_qty: "{{ __('messages.cart_th_qty') }}",
    th_subtotal: "{{ __('messages.cart_th_subtotal') }}",
    th_action: "{{ __('messages.cart_th_action') }}",
    remove: "{{ __('messages.cart_remove') }}",
    remove_confirm: "{{ __('messages.cart_remove_confirm') }}",
    continue_browsing: "{{ __('messages.cart_continue_browsing') }}",
    total: "{{ __('messages.cart_total') }}",
    checkout_btn: "{{ __('messages.cart_checkout_btn') }}",
    isRtl: {{ app()->getLocale() === 'ar' ? 'true' : 'false' }}
};

async function loadCart() {
    try {
        const res = await fetch('{{ route("cart.index") }}');
        
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        
        const data = await res.json();
        const cont = document.getElementById('cart-content');
        
        console.log('Cart data received:', data);
        
        if (!data.items || data.items.length === 0) {
            cont.innerHTML = `
                <div style="text-align: center; padding: 64px 20px;">
                    <div style="font-size: 3rem; margin-bottom: 1.25rem; opacity: 0.6;">🛒</div>
                    <h3 style="font-weight: 480; color: var(--color-ivory-text); margin-bottom: 0.5rem;">${i18n.empty_title}</h3>
                    <p style="color: var(--color-ash-text); margin-bottom: 2rem;">${i18n.empty_text}</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 12px 32px;">
                        ${i18n.explore_btn}
                    </a>
                </div>
            `;
            return;
        }
        
        let html = `
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: var(--color-obsidian-button);">
                            <th style="padding: 14px 18px; text-align: ${i18n.isRtl ? 'right' : 'left'};">${i18n.th_product}</th>
                            <th style="padding: 14px 18px; text-align: center;">${i18n.th_price}</th>
                            <th style="padding: 14px 18px; text-align: center;">${i18n.th_qty}</th>
                            <th style="padding: 14px 18px; text-align: ${i18n.isRtl ? 'left' : 'right'};">${i18n.th_subtotal}</th>
                            <th style="padding: 14px 18px; text-align: center;">${i18n.th_action}</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        data.items.forEach(item => {
            let imageUrl = item.image ? `/storage/${item.image}` : '/storage/default.png';
            let productUrl = `/products/${item.id}`;

            html += `
                <tr style="border-bottom: 1px solid rgba(226, 227, 237, 0.08);">
                    <td style="padding: 16px 18px; display: flex; align-items: center; gap: 16px; text-align: ${i18n.isRtl ? 'right' : 'left'};">
                        <a href="${productUrl}">
                            <img src="${imageUrl}" alt="${item.name}" style="width: 56px; height: 56px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(226, 227, 237, 0.1);">
                        </a>
                        <a href="${productUrl}" style="color: var(--color-ivory-text); font-weight: 480; font-size: var(--text-body); letter-spacing: 0.01em;">
                            ${item.name}
                        </a>
                    </td>
                    <td style="text-align: center; color: var(--color-ash-text); font-size: var(--text-body-sm);">$${parseFloat(item.price).toFixed(2)}</td>
                    <td style="text-align: center;">
                        <input type="number" min="1" value="${item.quantity}" style="width: 72px; padding: 6px 12px; text-align: center; background-color: var(--color-onyx-canvas); color: var(--color-ivory-text); border: 1px solid rgba(226, 227, 237, 0.2); border-radius: 32px;" onchange="updateQty(${item.id}, this.value)">
                    </td>
                    <td style="text-align: ${i18n.isRtl ? 'left' : 'right'}; color: var(--color-pure-white); font-weight: 500;">$${parseFloat(item.subtotal).toFixed(2)}</td>
                    <td style="text-align: center;">
                        <button onclick="removeItem(${item.id})" class="btn-obsidian" style="padding: 6px 14px; border-radius: 32px; font-size: var(--text-caption); cursor: pointer; color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.2);">
                            ${i18n.remove}
                        </button>
                    </td>
                </tr>
            `;
        });
        
        html += `
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem; border-top: 1px solid rgba(226, 227, 237, 0.08); padding-top: 2rem;">
                <a href="{{ route('products.index') }}" class="btn btn-ghost" style="padding: 12px 28px;">
                    ${i18n.continue_browsing}
                </a>
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <div style="font-size: var(--text-body-lg); color: var(--color-ash-text);">
                        ${i18n.total} <strong style="color: var(--color-pure-white); font-size: 1.5rem; font-weight: 500;">$${parseFloat(data.total).toFixed(2)}</strong>
                    </div>
                    <button onclick="checkout()" class="btn btn-primary" style="padding: 12px 36px;">
                        ${i18n.checkout_btn}
                    </button>
                </div>
            </div>
        `;
        
        cont.innerHTML = html;
    } catch (error) {
        console.error('Error loading cart:', error);
        const cont = document.getElementById('cart-content');
        cont.innerHTML = '<div style="color: #fca5a5; padding: 20px;"><strong>Error loading cart:</strong> ' + error.message + '</div>';
    }
}

async function updateQty(id, qty) {
    try {
        const res = await fetch(`/api/cart/update/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: parseInt(qty) })
        });
        
        if (!res.ok) {
            throw new Error(`Failed to update quantity: ${res.status}`);
        }
        
        loadCart();
    } catch (error) {
        console.error('Error updating quantity:', error);
        alert('Failed to update quantity: ' + error.message);
    }
}

async function removeItem(id) {
    if (!confirm(i18n.remove_confirm)) return;
    
    try {
        const res = await fetch(`/api/cart/remove/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (!res.ok) {
            throw new Error(`Failed to remove item: ${res.status}`);
        }
        
        loadCart();
    } catch (error) {
        console.error('Error removing item:', error);
        alert('Failed to remove item: ' + error.message);
    }
}

function checkout() {
    window.location.href = '{{ route("checkout.index") }}';
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadCart);
} else {
    loadCart();
}
</script>
@endsection
@endsection
