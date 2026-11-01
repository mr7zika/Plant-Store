@extends('layouts.app')

@section('title', 'About Us - Plant Store')

@section('content')
<div class="container">
    <h1 style="text-align: center; margin-bottom: 2rem;">🌱 About Plant Store</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: center; margin-bottom: 3rem;">
        <div>
            <h2>Our Mission</h2>
            <p style="margin-bottom: 1rem;">
                At Plant Store, we believe that bringing plants into your home or office can transform your space and improve your well-being. Our mission is to make quality plants accessible to everyone, regardless of their gardening experience.
            </p>
            <p style="margin-bottom: 1rem;">
                We're passionate about sustainability and responsible plant sourcing. Every plant we offer has been grown with care and attention to quality standards.
            </p>
            <p>
                Our team of experienced horticulturists is dedicated to helping you find the perfect plants for your lifestyle and providing the support you need to succeed.
            </p>
        </div>
        <div style="text-align: center; font-size: 5rem; background-color: #eff6ff; border: 1px solid #dbeafe; padding: 2rem; border-radius: 8px;">
            🌿
        </div>
    </div>

    <div style="background-color: #1e3a8a; color: white; padding: 3rem; border-radius: 8px; margin-bottom: 3rem;">
        <h2 style="color: #93c5fd; margin-bottom: 2rem; text-align: center;">Our Story</h2>
        <p style="margin-bottom: 1rem;">
            Plant Store was founded by a group of plant enthusiasts who wanted to share their passion for greenery with the world. What started as a small local nursery has grown into a thriving online destination for plant lovers everywhere.
        </p>
        <p style="margin-bottom: 1rem;">
            We've served thousands of happy customers and helped people create their dream gardens and indoor jungles. Each year, we expand our selection and improve our services to better serve our community.
        </p>
        <p>
            Today, Plant Store continues to uphold the values of quality, sustainability, and customer satisfaction that have made us successful from the start.
        </p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
        <div style="background: #f8faff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 8px; text-align: center;">
            <h3 style="font-size: 2.5rem; color: #2563eb; margin-bottom: 0.5rem;">10K+</h3>
            <p>Happy Customers</p>
        </div>
        <div style="background: #f8faff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 8px; text-align: center;">
            <h3 style="font-size: 2.5rem; color: #2563eb; margin-bottom: 0.5rem;">500+</h3>
            <p>Plant Varieties</p>
        </div>
        <div style="background: #f8faff; border: 1px solid #e2e8f0; padding: 2rem; border-radius: 8px; text-align: center;">
            <h3 style="font-size: 2.5rem; color: #2563eb; margin-bottom: 0.5rem;">99%</h3>
            <p>Satisfaction Rate</p>
        </div>
    </div>

    <h2 style="text-align: center; margin-bottom: 2rem;">Our Team</h2>
    <p style="text-align: center; margin-bottom: 2rem;">
        Our passionate team of plant experts is here to help you every step of your plant journey.
    </p>

    <div style="background-color: #eff6ff; border: 1px solid #dbeafe; padding: 2rem; border-radius: 8px; text-align: center;">
        <p style="font-size: 1.1rem; color: #475569;">
            Have questions? Want to join our team? Get in touch with us!
        </p>
        <a href="{{ route('contact') }}" class="btn btn-primary" style="margin-top: 1rem;">
            Contact Us
        </a>
    </div>
</div>
@endsection
