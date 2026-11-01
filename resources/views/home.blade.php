@extends('layouts.app')

@section('title', __('messages.site_title'))

@section('extra-css')
<style>
    .hero-container {
        position: relative;
        background: linear-gradient(180deg, rgba(23, 23, 33, 0.4) 0%, rgba(23, 23, 33, 0.95) 100%),
                    radial-gradient(ellipse at 50% 20%, rgba(82, 102, 235, 0.15) 0%, transparent 70%),
                    #171721;
        padding: 100px 24px 80px;
        text-align: center;
        border-radius: var(--radius-cards);
        margin-bottom: var(--section-gap);
        border: 1px solid rgba(226, 227, 237, 0.06);
    }
    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: var(--color-obsidian-button);
        color: var(--color-ivory-text);
        padding: 6px 18px;
        border-radius: var(--radius-tags);
        font-size: var(--text-caption);
        letter-spacing: 0.04em;
        margin-bottom: 2rem;
        border: 1px solid rgba(226, 227, 237, 0.08);
    }
    .hero-title {
        font-size: clamp(2rem, 5vw, var(--text-display));
        font-weight: 480;
        line-height: 1.2;
        letter-spacing: 0.015em;
        color: var(--color-pure-white);
        max-width: 820px;
        margin: 0 auto 1.5rem;
    }
    .hero-subtitle {
        font-size: var(--text-body-lg);
        color: var(--color-ash-text);
        max-width: 620px;
        margin: 0 auto 2.5rem;
        line-height: 1.7;
        font-weight: 400;
    }
    .hero-cta-group {
        display: flex;
        gap: 1rem;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: var(--section-gap);
    }
    .feature-card {
        background-color: var(--color-graphite-card);
        padding: var(--card-padding);
        border-radius: var(--radius-cards);
        text-align: start;
        border: 1px solid rgba(226, 227, 237, 0.04);
        transition: background-color 0.2s ease;
    }
    .feature-card:hover {
        background-color: #232332;
    }
    .feature-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-tags);
        background-color: var(--color-obsidian-button);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .feature-title {
        color: var(--color-ivory-text);
        font-size: var(--text-subheading);
        font-weight: 480;
        margin-bottom: 0.75rem;
        letter-spacing: 0.015em;
    }
    .feature-text {
        color: var(--color-ash-text);
        font-size: var(--text-body);
        line-height: 1.7;
    }
    .benefits-section {
        background-color: var(--color-graphite-card);
        padding: 48px var(--card-padding);
        border-radius: var(--radius-cards);
        margin-bottom: var(--section-gap);
        border: 1px solid rgba(226, 227, 237, 0.04);
    }
    .benefits-title {
        text-align: center;
        color: var(--color-ivory-text);
        font-size: var(--text-heading);
        font-weight: 480;
        margin-bottom: 3rem;
        letter-spacing: 0.015em;
    }
    .benefit-item {
        background-color: var(--color-onyx-canvas);
        padding: 24px;
        border-radius: var(--radius-cards);
        margin-bottom: 1rem;
        border: 1px solid rgba(226, 227, 237, 0.04);
        text-align: start;
    }
    .benefit-item:last-child {
        margin-bottom: 0;
    }
    .benefit-title {
        color: var(--color-ivory-text);
        font-size: var(--text-body-lg);
        font-weight: 480;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .benefit-text {
        color: var(--color-ash-text);
        font-size: var(--text-body-sm);
        line-height: 1.7;
    }
    .cta-banner {
        background: linear-gradient(180deg, var(--color-graphite-card) 0%, rgba(30, 30, 42, 0.6) 100%);
        padding: 64px 32px;
        border-radius: var(--radius-cards);
        text-align: center;
        border: 1px solid rgba(226, 227, 237, 0.06);
    }
    .cta-title {
        font-size: var(--text-heading);
        font-weight: 480;
        color: var(--color-ivory-text);
        margin-bottom: 1rem;
    }
    .cta-text {
        font-size: var(--text-body);
        color: var(--color-ash-text);
        max-width: 540px;
        margin: 0 auto 2rem;
    }
</style>
@endsection

@section('content')
<!-- Atmospheric Alpine Hero Section -->
<div class="hero-container">
    <div class="hero-tag">
        <span>🌱</span>
        <span>{{ __('messages.home_hero_tag') }}</span>
    </div>
    <h1 class="hero-title">{{ __('messages.home_hero_title') }}</h1>
    <p class="hero-subtitle">
        {{ __('messages.home_hero_subtitle') }}
    </p>
    <div class="hero-cta-group">
        <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 14px 36px;">
            {{ __('messages.home_explore_collection') }}
        </a>
        <a href="{{ route('about') }}" class="btn btn-ghost" style="padding: 13px 28px;">
            {{ __('messages.home_about_sourcing') }}
        </a>
    </div>
</div>

<!-- Features Section — Graphite Cards (No Shadows) -->
<div class="features-grid">
    <div class="feature-card">
        <div class="feature-icon-wrap">🌿</div>
        <h3 class="feature-title">{{ __('messages.home_feat_1_title') }}</h3>
        <p class="feature-text">{{ __('messages.home_feat_1_text') }}</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon-wrap">📦</div>
        <h3 class="feature-title">{{ __('messages.home_feat_2_title') }}</h3>
        <p class="feature-text">{{ __('messages.home_feat_2_text') }}</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon-wrap">🧭</div>
        <h3 class="feature-title">{{ __('messages.home_feat_3_title') }}</h3>
        <p class="feature-text">{{ __('messages.home_feat_3_text') }}</p>
    </div>
</div>

<!-- Benefits Section — Graphite Surface -->
<div class="benefits-section">
    <h2 class="benefits-title">{{ __('messages.home_benefits_title') }}</h2>
    
    <div class="benefit-item">
        <h3 class="benefit-title"><span>🌱</span> {{ __('messages.home_benefit_1_title') }}</h3>
        <p class="benefit-text">{{ __('messages.home_benefit_1_text') }}</p>
    </div>

    <div class="benefit-item">
        <h3 class="benefit-title"><span>📖</span> {{ __('messages.home_benefit_2_title') }}</h3>
        <p class="benefit-text">{{ __('messages.home_benefit_2_text') }}</p>
    </div>

    <div class="benefit-item">
        <h3 class="benefit-title"><span>🛡️</span> {{ __('messages.home_benefit_3_title') }}</h3>
        <p class="benefit-text">{{ __('messages.home_benefit_3_text') }}</p>
    </div>
</div>

<!-- Call to Action Banner -->
<div class="cta-banner">
    <h2 class="cta-title">{{ __('messages.home_cta_title') }}</h2>
    <p class="cta-text">{{ __('messages.home_cta_text') }}</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 14px 40px;">
        {{ __('messages.home_cta_btn') }}
    </a>
</div>
@endsection
