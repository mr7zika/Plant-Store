@extends('layouts.app')

@section('title', __('messages.checkout_register_btn') . ' — ' . __('messages.store_name'))

@section('content')
<div style="max-width: 440px; margin: 3rem auto;">
    <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04); text-align: start;">
        <h2 style="font-weight: 480; text-align: center; margin-bottom: 2rem; color: var(--color-ivory-text); letter-spacing: 0.015em;">
            📝 {{ __('messages.checkout_register_btn') }}
        </h2>

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>{{ __('messages.msg_validation_error') }}</strong>
                <ul style="margin: 0.5rem 1rem 0; font-size: var(--text-body-sm);">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.store-user') }}" method="POST">
            @csrf

            <div style="margin-bottom: 1.25rem;">
                <label for="name">{{ __('messages.checkout_name_label') }}:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="John Doe">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label for="email">{{ __('messages.checkout_email_label') }}:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="name@domain.com">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label for="password">{{ __('messages.checkout_password_label') }}:</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <div style="margin-bottom: 2rem;">
                <label for="password_confirmation">{{ __('messages.checkout_password_conf_label') }}:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px 24px; margin-bottom: 1.5rem;">
                {{ __('messages.checkout_register_continue') }}
            </button>
        </form>

        <div style="text-align: center; border-top: 1px solid rgba(226, 227, 237, 0.08); padding-top: 1.5rem; margin-bottom: 1.25rem;">
            <p style="color: var(--color-ash-text); font-size: var(--text-body-sm); margin-bottom: 1rem;">{{ __('messages.checkout_already_have_account') }}</p>
            <a href="{{ route('checkout.login') }}" class="btn btn-obsidian" style="width: 100%; padding: 12px 24px; font-size: var(--text-body-sm);">
                {{ __('messages.nav_login') }}
            </a>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('cart.view') }}" style="color: var(--color-ash-text); font-size: var(--text-body-sm);">
                {{ __('messages.checkout_back_to_cart') }}
            </a>
        </div>
    </div>
</div>
@endsection
