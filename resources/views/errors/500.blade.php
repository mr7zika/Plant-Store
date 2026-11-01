@extends('layouts.app')

@section('title', __('messages.error_500_title'))

@section('content')
<div style="display: flex; align-items: center; justify-content: center; min-height: 60vh;">
    <div style="text-align: center; max-width: 500px; padding: 2rem;">
        <div style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.6;">⚙️</div>
        <h1 style="color: var(--color-pure-white); font-size: var(--text-heading-lg); font-weight: 480; margin-bottom: 1rem; letter-spacing: 0.015em;">
            {{ __('messages.error_500_title') }}
        </h1>
        <p style="color: var(--color-ash-text); font-size: var(--text-body); margin-bottom: 2.5rem; line-height: 1.6;">
            {{ __('messages.error_500_text') }}
        </p>
        
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}" class="btn btn-ghost" style="padding: 12px 28px;">
                {{ __('messages.error_return_home') }}
            </a>
            <a href="{{ route('contact') }}" class="btn btn-primary" style="padding: 12px 28px;">
                {{ __('messages.error_contact_support') }}
            </a>
        </div>
    </div>
</div>
@endsection
