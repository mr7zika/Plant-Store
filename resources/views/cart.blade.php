@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 2rem;">🛒 Shopping Cart</h1>
    <div id="cart-content"><p>Loading...</p></div>
</div>

@section('extra-js')
<script>
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
            cont.innerHTML = '<div style="text-align:center;padding:60px;"><div style="font-size:3rem;margin-bottom:1rem;">🛒</div><p>Your cart is empty</p><a href="{{ route("products.index") }}" style="display:inline-block;background:#2563eb;color:white;padding:12px 30px;margin-top:1rem;border-radius:4px;text-decoration:none;font-weight:600;">Continue Shopping</a></div>';
            return;
        }
        
        let html = '<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;"><thead><tr style="background:#1e3a8a;color:white;"><th style="padding:1rem;text-align:left;">Product</th><th style="text-align:center;">Price</th><th style="text-align:center;">Qty</th><th style="text-align:right;">Subtotal</th><th style="text-align:center;">Action</th></tr></thead><tbody>';
        
        data.items.forEach(item => {
            // مسار الصورة (يتم جلبها من الكارد أو الـ API، مع وضع صورة افتراضية في حال عدم توفرها)
            let imageUrl = item.image ? `/storage/${item.image}` : '/storage/default.png';
            let productUrl = `/products/${item.id}`;

            html += `<tr style="border-bottom:1px solid #eee;">
                <td style="padding:1rem; display:flex; align-items:center; gap:15px;">
                    <!-- صورة مصغرة تضغط عليها تحولك لصفحة المنتج -->
                    <a href="${productUrl}">
                        <img src="${imageUrl}" alt="${item.name}" style="width:55px; height:55px; object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                    </a>
                    <!-- اسم المنتج يضغط عليه يحوله لصفحة المنتج -->
                    <a href="${productUrl}" style="color:#1e3a8a; text-decoration:none; font-weight:600;">
                        ${item.name}
                    </a>
                </td>
                <td style="text-align:center;">$${parseFloat(item.price).toFixed(2)}</td>
                <td style="text-align:center;"><input type="number" min="1" value="${item.quantity}" style="width:60px;padding:0.5rem; text-align:center; border:1px solid #ddd; border-radius:4px;" onchange="updateQty(${item.id},this.value)"></td>
                <td style="text-align:right;color:#2563eb;font-weight:600;">$${parseFloat(item.subtotal).toFixed(2)}</td>
                <td style="text-align:center;"><button onclick="removeItem(${item.id})" style="background:#ef4444;color:white;border:none;padding:0.5rem 1rem;border-radius:4px;cursor:pointer;font-weight:600;">Remove</button></td>
            </tr>`;
        });
        
        html += '</tbody></table></div>';
        html += `<div style="margin-top:2rem;text-align:right;"><h2 style="color:#1e3a8a;">Total: $${parseFloat(data.total).toFixed(2)}</h2><button onclick="checkout()" style="background:#2563eb;color:white;padding:12px 40px;border:none;border-radius:4px;font-size:1rem;font-weight:600;cursor:pointer;margin-right:1rem;transition:all 0.3s;">Checkout</button><a href="{{ route('products.index') }}" style="background:#3b82f6;color:white;padding:12px 30px;text-decoration:none;border-radius:4px;display:inline-block;font-weight:600;transition:all 0.3s;">Continue Shopping</a></div>`;
        
        cont.innerHTML = html;
    } catch (error) {
        console.error('Error loading cart:', error);
        const cont = document.getElementById('cart-content');
        cont.innerHTML = '<div style="color:red;padding:20px;"><strong>Error loading cart:</strong> ' + error.message + '</div>';
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
    if (!confirm('Remove this item?')) return;
    
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
