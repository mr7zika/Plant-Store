@extends('layouts.app')

@section('title', 'Contact Us - Plant Store')

@section('content')
<div class="container">
    <h1 style="text-align: center; margin-bottom: 2rem;">📞 Contact Us</h1>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem;">
        <!-- Contact Form -->
        <div>
            <h2 style="margin-bottom: 1.5rem;">Get In Touch</h2>
            <form style="display: flex; flex-direction: column; gap: 1rem;">
                <div>
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Name</label>
                    <input type="text" id="name" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                </div>

                <div>
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email</label>
                    <input type="email" id="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                </div>

                <div>
                    <label for="subject" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Subject</label>
                    <input type="text" id="subject" name="subject" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                </div>

                <div>
                    <label for="message" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Message</label>
                    <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; font-family: inherit;"></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="align-self: flex-start;">
                    Send Message
                </button>
            </form>
        </div>

        <!-- Contact Info -->
        <div>
            <h2 style="margin-bottom: 1.5rem;">Contact Information</h2>
            
            <div style="background-color: #f8faff; border: 1px solid #e2e8f0; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <h3 style="color: #1e3a8a; margin-bottom: 0.5rem;">📍 Address</h3>
                <p>123 Green Street<br>Plant City, PC 12345<br>United States</p>
            </div>

            <div style="background-color: #f8faff; border: 1px solid #e2e8f0; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <h3 style="color: #1e3a8a; margin-bottom: 0.5rem;">📧 Email</h3>
                <p><a href="mailto:info@plantstore.com" style="color: #2563eb; text-decoration: none;">info@plantstore.com</a></p>
                <p><a href="mailto:support@plantstore.com" style="color: #2563eb; text-decoration: none;">support@plantstore.com</a></p>
            </div>

            <div style="background-color: #f8faff; border: 1px solid #e2e8f0; padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem;">
                <h3 style="color: #1e3a8a; margin-bottom: 0.5rem;">📞 Phone</h3>
                <p><a href="tel:+15551234567" style="color: #2563eb; text-decoration: none;">+1 (555) 123-4567</a></p>
                <p>Monday - Friday: 9 AM - 5 PM EST</p>
            </div>

            <div style="background-color: #f8faff; border: 1px solid #e2e8f0; padding: 1.5rem; border-radius: 8px;">
                <h3 style="color: #1e3a8a; margin-bottom: 0.5rem;">🕐 Business Hours</h3>
                <p>Monday - Friday: 9 AM - 6 PM EST<br>Saturday: 10 AM - 4 PM EST<br>Sunday: Closed</p>
            </div>
        </div>
    </div>

    <div style="background-color: #1e3a8a; color: white; padding: 2rem; border-radius: 8px; text-align: center;">
        <h2 style="color: #93c5fd; margin-bottom: 1rem;">Frequently Asked Questions</h2>
        <p>Visit our FAQ section for quick answers to common questions about ordering, shipping, and plant care.</p>
    </div>
</div>
@endsection
