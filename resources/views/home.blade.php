@extends('layouts.app')

@section('title', 'Home - Plant Store')

@section('extra-css')
<style>
    .hero-section {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        padding: 80px 20px;
        text-align: center;
        border-radius: 8px;
        margin-bottom: 3rem;
    }
    .hero-title {
        font-size: 3rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }
    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }
    .hero-cta {
        display: inline-block;
        background-color: #3b82f6;
        color: white;
        padding: 15px 40px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .hero-cta:hover {
        background-color: white;
        color: #1e3a8a;
        transform: translateY(-2px);
    }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    .feature-card {
        background: linear-gradient(135deg, #eff6ff 0%, #f0f7ff 100%);
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        border: 1px solid #dbeafe;
        transition: all 0.3s ease;
    }
    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.1);
    }
    .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    .feature-title {
        color: #1e3a8a;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .feature-text {
        color: #666;
        line-height: 1.6;
    }
    .benefits-section {
        background-color: white;
        padding: 3rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
    .benefits-title {
        text-align: center;
        color: #1e3a8a;
        font-size: 2rem;
        margin-bottom: 2rem;
    }
    .benefit-item {
        background-color: white;
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 4px solid #2563eb;
        margin-bottom: 1rem;
    }
    .benefit-item:last-child {
        margin-bottom: 0;
    }
    .benefit-icon {
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }
    .benefit-title {
        color: #1e3a8a;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .benefit-text {
        color: #666;
        line-height: 1.6;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <h1 class="hero-title">🌱 Welcome to Plant Store</h1>
    <p class="hero-subtitle">Transform Your Space with Beautiful, Healthy Plants</p>
    <a href="{{ route('products.index') }}" class="hero-cta">Explore Our Collection →</a>
</div>

<!-- Features Section -->
<div class="features-grid">
    <div class="feature-card">
        <div class="feature-icon">🌿</div>
        <h3 class="feature-title">Fresh & Healthy</h3>
        <p class="feature-text">Carefully curated selection of healthy, vibrant plants for every skill level</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">🚚</div>
        <h3 class="feature-title">Fast Delivery</h3>
        <p class="feature-text">Quick and safe shipping right to your doorstep with proper packaging</p>
    </div>

    <div class="feature-card">
        <div class="feature-icon">💙</div>
        <h3 class="feature-title">Expert Support</h3>
        <p class="feature-text">Get care tips and advice from our experienced plant experts</p>
    </div>
</div>

<!-- Benefits Section -->
<div class="benefits-section">
    <h2 class="benefits-title">Why Choose Plant Store?</h2>
    
    <div class="benefit-item">
        <h3 class="benefit-title"><span class="benefit-icon">🌱</span>Premium Quality Plants</h3>
        <p class="benefit-text">Every plant is handpicked and checked for health before shipment. We source from trusted growers and nurseries to ensure you receive the best.</p>
    </div>

    <div class="benefit-item">
        <h3 class="benefit-title"><span class="benefit-icon">📖</span>Care Instructions Included</h3>
        <p class="benefit-text">Each plant comes with detailed care instructions specific to its species, helping you keep it thriving in your home or office.</p>
    </div>

    <div class="benefit-item">
        <h3 class="benefit-title"><span class="benefit-icon">💯</span>Satisfaction Guaranteed</h3>
        <p class="benefit-text">We stand behind every plant we sell. If you're not satisfied with your purchase, we'll make it right.</p>
    </div>
</div>

<!-- Call to Action -->
<div style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: white; padding: 3rem; border-radius: 8px; text-align: center;">
    <h2 style="color: #93c5fd; margin-bottom: 1rem;">Ready to Start Your Green Journey?</h2>
    <p style="margin-bottom: 1.5rem; font-size: 1.1rem;">Browse our collection and find the perfect plant for your space</p>
    <a href="{{ route('products.index') }}" class="hero-cta" style="display: inline-block;">Shop Now 🛒</a>
</div>
@endsection
