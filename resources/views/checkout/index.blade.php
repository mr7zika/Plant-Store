@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container">
    <h1 style="text-align: center; color: #1e3a8a; margin-bottom: 2rem;">Checkout</h1>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; max-width: 1200px; margin: 0 auto;">
        <!-- Left: Order Summary -->
        <div style="background: #f8faff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 8px;">
            <h2 style="color: #1e3a8a; margin-bottom: 1.5rem; border-bottom: 2px solid #2563eb; padding-bottom: 0.5rem;">Order Summary</h2>
            
            @foreach ($items as $item)
            <div style="display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0;">
                <div>
                    <strong style="color: #1e3a8a;">{{ $item['product']->name }}</strong>
                    <br><small style="color: #64748b;">Qty: {{ $item['quantity'] }}</small>
                </div>
                <div style="color: #2563eb; font-weight: 600;">${{ number_format($item['subtotal'], 2) }}</div>
            </div>
            @endforeach

            <div style="text-align: right; padding: 1rem; margin-top: 1rem; border-top: 2px solid #2563eb; font-size: 1.3rem; color: #1e3a8a;">
                Total: <strong>${{ number_format($total, 2) }}</strong>
            </div>
        </div>

        <!-- Right: Authentication/Checkout -->
        <div style="background: #f8faff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 8px;">
            @if ($isGuest)
                <h2 style="color: #1e3a8a; margin-bottom: 1.5rem;">Login or Register</h2>
                
                <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
                    <button class="tab-btn" onclick="toggleForm(0)" style="flex: 1; padding: 0.75rem; border: 2px solid #2563eb; background: #2563eb; color: white; border-radius: 4px; font-weight: 600; cursor: pointer; transition: all 0.3s;">Login</button>
                    <button class="tab-btn" onclick="toggleForm(1)" style="flex: 1; padding: 0.75rem; border: 2px solid #2563eb; background: white; color: #1e3a8a; border-radius: 4px; font-weight: 600; cursor: pointer; transition: all 0.3s;">Register</button>
                </div>

                <form id="form-0" action="{{ route('checkout.authenticate') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Email Address" required style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <input type="password" name="password" placeholder="Password" required style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <button type="submit" style="width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background 0.3s;">Login & Continue</button>
                </form>

                <form id="form-1" style="display: none;" action="{{ route('checkout.store-user') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Full Name" required style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <input type="email" name="email" placeholder="Email Address" required style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <input type="password" name="password" placeholder="Password" required style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <button type="submit" style="width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background 0.3s;">Register & Continue</button>
                </form>
            @else
                <h2 style="color: #1e3a8a; margin-bottom: 1.5rem;">Delivery Information</h2>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <input type="text" value="{{ Auth::user()->name }}" disabled style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; background: #e9ecef; box-sizing: border-box;">
                    <input type="email" value="{{ Auth::user()->email }}" disabled style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; background: #e9ecef; box-sizing: border-box;">
                    <input type="text" name="address" placeholder="Delivery Address" required style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <input type="tel" name="phone" placeholder="Phone Number" required style="width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <button type="submit" style="width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background 0.3s;">Complete Purchase</button>
                </form>
            @endif

            <a href="{{ route('products.index') }}" style="display: inline-block; margin-top: 1rem; background: #3b82f6; color: white; padding: 0.75rem 1rem; text-decoration: none; border-radius: 4px; font-weight: 600; transition: background 0.3s;">Continue Shopping</a>
        </div>
    </div>
</div>

<script>
function toggleForm(index) {
    document.getElementById('form-0').style.display = index === 0 ? 'block' : 'none';
    document.getElementById('form-1').style.display = index === 1 ? 'block' : 'none';
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach((btn, i) => {
        btn.style.background = i === index ? '#2563eb' : 'white';
        btn.style.color = i === index ? 'white' : '#1e3a8a';
    });
}
</script>
@endsection
