@extends('layouts.app')

@section('title', __('messages.nav_about') . ' — ' . __('messages.store_name'))

@section('content')
<div class="container" style="background-color: transparent; padding: 0;">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <span class="category-badge" style="margin-bottom: 1rem;">{{ __('messages.about_heritage_tag') }}</span>
        <h1 style="font-weight: 480; letter-spacing: 0.015em; font-size: var(--text-heading-lg);">{{ __('messages.about_title') }}</h1>
        <p style="color: var(--color-ash-text); max-width: 620px; margin: 0 auto; font-size: var(--text-body-lg); line-height: 1.7;">
            {{ __('messages.about_subtitle') }}
        </p>
    </div>
    
    <!-- Mission Section (Graphite Card) -->
    <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04); margin-bottom: 2.5rem; text-align: start;">
        <h2 style="font-weight: 480; color: var(--color-ivory-text); font-size: var(--text-heading-sm); margin-bottom: 1.25rem;">
            {{ __('messages.about_mission_title') }}
        </h2>
        <p style="color: var(--color-ash-text); margin-bottom: 1.25rem; font-size: var(--text-body); line-height: 1.7;">
            {{ __('messages.about_mission_p1') }}
        </p>
        <p style="color: var(--color-ash-text); font-size: var(--text-body); line-height: 1.7;">
            {{ __('messages.about_mission_p2') }}
        </p>
    </div>

    <!-- Stats Grid (Graphite Cards) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-bottom: 2.5rem;">
        <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); text-align: center; border: 1px solid rgba(226, 227, 237, 0.04);">
            <div style="font-size: var(--text-heading-lg); font-weight: 480; color: var(--color-pure-white); margin-bottom: 0.5rem; letter-spacing: 0.02em;">{{ __('messages.about_stat_1_val') }}</div>
            <p style="color: var(--color-ash-text); font-size: var(--text-body-sm);">{{ __('messages.about_stat_1_label') }}</p>
        </div>
        <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); text-align: center; border: 1px solid rgba(226, 227, 237, 0.04);">
            <div style="font-size: var(--text-heading-lg); font-weight: 480; color: var(--color-pure-white); margin-bottom: 0.5rem; letter-spacing: 0.02em;">{{ __('messages.about_stat_2_val') }}</div>
            <p style="color: var(--color-ash-text); font-size: var(--text-body-sm);">{{ __('messages.about_stat_2_label') }}</p>
        </div>
        <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); text-align: center; border: 1px solid rgba(226, 227, 237, 0.04);">
            <div style="font-size: var(--text-heading-lg); font-weight: 480; color: var(--color-pure-white); margin-bottom: 0.5rem; letter-spacing: 0.02em;">{{ __('messages.about_stat_3_val') }}</div>
            <p style="color: var(--color-ash-text); font-size: var(--text-body-sm);">{{ __('messages.about_stat_3_label') }}</p>
        </div>
    </div>

    <!-- Contact CTA Banner (Graphite Card) -->
    <div style="background-color: var(--color-graphite-card); padding: 48px var(--card-padding); border-radius: var(--radius-cards); text-align: center; border: 1px solid rgba(226, 227, 237, 0.04);">
        <h3 style="font-weight: 480; color: var(--color-ivory-text); font-size: var(--text-heading-sm); margin-bottom: 0.75rem;">
            {{ __('messages.about_cta_title') }}
        </h3>
        <p style="color: var(--color-ash-text); font-size: var(--text-body); max-width: 520px; margin: 0 auto 2rem;">
            {{ __('messages.about_cta_text') }}
        </p>
        <a href="{{ route('contact') }}" class="btn btn-primary" style="padding: 12px 36px;">
            {{ __('messages.about_cta_btn') }}
        </a>
    </div>
</div>
@endsection
