@extends('layouts.app')

@section('title', __('messages.checkout_title') . ' — ' . __('messages.store_name'))

@section('content')
<div style="max-width: 1100px; margin: 0 auto;">
    <h1 style="font-weight: 480; letter-spacing: 0.015em; margin-bottom: 2.5rem; text-align: center;">{{ __('messages.checkout_title') }}</h1>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px; align-items: start;">
        <!-- Left: Order Summary (Graphite Card) -->
        <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04); text-align: start;">
            <h2 style="font-size: var(--text-heading-sm); font-weight: 480; color: var(--color-ivory-text); margin-bottom: 1.5rem; border-bottom: 1px solid rgba(226, 227, 237, 0.08); padding-bottom: 1rem;">
                {{ __('messages.checkout_order_summary') }}
            </h2>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                @foreach ($items as $item)
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(226, 227, 237, 0.05);">
                    <div>
                        <div style="color: var(--color-ivory-text); font-weight: 480; font-size: var(--text-body);">${{ $item['product']->name }}</div>
                        <small style="color: var(--color-ash-text); font-size: var(--text-caption);">{{ __('messages.checkout_qty') }} {{ $item['quantity'] }}</small>
                    </div>
                    <div style="color: var(--color-pure-white); font-weight: 500;">${{ number_format($item['subtotal'], 2) }}</div>
                </div>
                @endforeach
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1.25rem; border-top: 1px solid rgba(226, 227, 237, 0.1); font-size: var(--text-body-lg);">
                <span style="color: var(--color-ash-text);">{{ __('messages.checkout_total_amount') }}</span>
                <strong style="color: var(--color-pure-white); font-size: 1.5rem; font-weight: 500;">${{ number_format($total, 2) }}</strong>
            </div>
        </div>

        <!-- Right: Authentication / Delivery Form (Graphite Card) -->
        <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04); text-align: start;">
            @if ($isGuest)
                <h2 style="font-size: var(--text-heading-sm); font-weight: 480; color: var(--color-ivory-text); margin-bottom: 1.5rem;">
                    {{ __('messages.checkout_sign_in_title') }}
                </h2>
                
                <div style="display: flex; gap: 0.5rem; margin-bottom: 2rem; background-color: var(--color-onyx-canvas); padding: 4px; border-radius: var(--radius-nav);">
                    <button class="tab-btn" onclick="toggleForm(0)" id="tab-0" style="flex: 1; padding: 10px 16px; border: none; background-color: var(--color-cobalt); color: var(--color-pure-white); border-radius: var(--radius-buttons); font-size: var(--text-body-sm); font-weight: 480; cursor: pointer; transition: all 0.2s;">
                        {{ __('messages.checkout_tab_login') }}
                    </button>
                    <button class="tab-btn" onclick="toggleForm(1)" id="tab-1" style="flex: 1; padding: 10px 16px; border: none; background-color: transparent; color: var(--color-ash-text); border-radius: var(--radius-buttons); font-size: var(--text-body-sm); font-weight: 480; cursor: pointer; transition: all 0.2s;">
                        {{ __('messages.checkout_tab_register') }}
                    </button>
                </div>

                <!-- Sign In Form -->
                <form id="form-0" action="{{ route('checkout.authenticate') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label for="login-email">{{ __('messages.checkout_email_label') }}</label>
                        <input type="email" id="login-email" name="email" placeholder="name@domain.com" required>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label for="login-password">{{ __('messages.checkout_password_label') }}</label>
                        <input type="password" id="login-password" name="password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px 24px;">
                        {{ __('messages.checkout_login_continue') }}
                    </button>
                </form>

                <!-- Register Form -->
                <form id="form-1" style="display: none;" action="{{ route('checkout.store-user') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label for="reg-name">{{ __('messages.checkout_name_label') }}</label>
                        <input type="text" id="reg-name" name="name" placeholder="John Doe" required>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="reg-email">{{ __('messages.checkout_email_label') }}</label>
                        <input type="email" id="reg-email" name="email" placeholder="name@domain.com" required>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="reg-pass">{{ __('messages.checkout_password_label') }}</label>
                        <input type="password" id="reg-pass" name="password" placeholder="••••••••" required>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label for="reg-pass-conf">{{ __('messages.checkout_password_conf_label') }}</label>
                        <input type="password" id="reg-pass-conf" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px 24px;">
                        {{ __('messages.checkout_register_continue') }}
                    </button>
                </form>
            @else
                <h2 style="font-size: var(--text-heading-sm); font-weight: 480; color: var(--color-ivory-text); margin-bottom: 1.5rem;">
                    {{ __('messages.checkout_delivery_title') }}
                </h2>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label>{{ __('messages.checkout_recipient_label') }}</label>
                        <input type="text" value="{{ Auth::user()->name }}" disabled style="opacity: 0.7; background-color: var(--color-obsidian-button);">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label>{{ __('messages.checkout_email_label') }}</label>
                        <input type="email" value="{{ Auth::user()->email }}" disabled style="opacity: 0.7; background-color: var(--color-obsidian-button);">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label for="address">{{ __('messages.checkout_address_label') }}</label>
                        <input type="text" id="address" name="address" placeholder="Street Address, City, Postal Code" required>
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label for="phone">{{ __('messages.checkout_phone_label') }}</label>
                        <input type="tel" id="phone" name="phone" placeholder="+1 (555) 000-0000" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px 24px;">
                        {{ __('messages.checkout_complete_order') }}
                    </button>
                </form>
            @endif

            <div style="margin-top: 1.5rem; text-align: center;">
                <a href="{{ route('products.index') }}" class="btn btn-ghost" style="padding: 10px 24px; font-size: var(--text-body-sm);">
                    {{ __('messages.checkout_continue_shopping') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function toggleForm(index) {
    document.getElementById('form-0').style.display = index === 0 ? 'block' : 'none';
    document.getElementById('form-1').style.display = index === 1 ? 'block' : 'none';
    
    const tab0 = document.getElementById('tab-0');
    const tab1 = document.getElementById('tab-1');
    
    if (tab0 && tab1) {
        tab0.style.backgroundColor = index === 0 ? 'var(--color-cobalt)' : 'transparent';
        tab0.style.color = index === 0 ? 'var(--color-pure-white)' : 'var(--color-ash-text)';
        
        tab1.style.backgroundColor = index === 1 ? 'var(--color-cobalt)' : 'transparent';
        tab1.style.color = index === 1 ? 'var(--color-pure-white)' : 'var(--color-ash-text)';
    }
}
</script>
@endsection
