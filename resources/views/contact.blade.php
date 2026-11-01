@extends('layouts.app')

@section('title', __('messages.nav_contact') . ' — ' . __('messages.store_name'))

@section('content')
<div class="container" style="background-color: transparent; padding: 0;">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <span class="category-badge" style="margin-bottom: 1rem;">{{ __('messages.contact_concierge_tag') }}</span>
        <h1 style="font-weight: 480; letter-spacing: 0.015em; font-size: var(--text-heading-lg);">{{ __('messages.contact_title') }}</h1>
        <p style="color: var(--color-ash-text); max-width: 540px; margin: 0 auto; font-size: var(--text-body);">
            {{ __('messages.contact_subtitle') }}
        </p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px; margin-bottom: 3rem;">
        <!-- Contact Form (Graphite Card) -->
        <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04); text-align: start;">
            <h2 style="font-weight: 480; font-size: var(--text-heading-sm); margin-bottom: 1.5rem; color: var(--color-ivory-text);">
                {{ __('messages.contact_send_msg_title') }}
            </h2>
            <form style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div>
                    <label for="name">{{ __('messages.contact_name_label') }}</label>
                    <input type="text" id="name" name="name" required placeholder="Alex Morgan">
                </div>

                <div>
                    <label for="email">{{ __('messages.contact_email_label') }}</label>
                    <input type="email" id="email" name="email" required placeholder="alex@domain.com">
                </div>

                <div>
                    <label for="subject">{{ __('messages.contact_subject_label') }}</label>
                    <input type="text" id="subject" name="subject" required placeholder="Botanical consultation">
                </div>

                <div>
                    <label for="message">{{ __('messages.contact_message_label') }}</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Detail your room exposure, lighting, or specific questions..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="align-self: flex-start; padding: 12px 32px;">
                    {{ __('messages.contact_send_btn') }}
                </button>
            </form>
        </div>

        <!-- Contact Info (Graphite Card) -->
        <div style="background-color: var(--color-graphite-card); padding: var(--card-padding); border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04); display: flex; flex-direction: column; gap: 1.25rem; text-align: start;">
            <h2 style="font-weight: 480; font-size: var(--text-heading-sm); margin-bottom: 0.5rem; color: var(--color-ivory-text);">
                {{ __('messages.contact_coords_title') }}
            </h2>
            
            <div style="background-color: var(--color-onyx-canvas); padding: 20px; border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04);">
                <h3 style="color: var(--color-ivory-text); font-size: var(--text-body); font-weight: 480; margin-bottom: 0.5rem;">{{ __('messages.contact_location_title') }}</h3>
                <p style="font-size: var(--text-body-sm); color: var(--color-ash-text); white-space: pre-line;">{{ __('messages.contact_location_val') }}</p>
            </div>

            <div style="background-color: var(--color-onyx-canvas); padding: 20px; border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04);">
                <h3 style="color: var(--color-ivory-text); font-size: var(--text-body); font-weight: 480; margin-bottom: 0.5rem;">{{ __('messages.contact_email_title') }}</h3>
                <p style="font-size: var(--text-body-sm);"><a href="mailto:info@plantstore.com" style="color: var(--color-ivory-text);">info@plantstore.com</a></p>
                <p style="font-size: var(--text-body-sm);"><a href="mailto:support@plantstore.com" style="color: var(--color-ash-text);">support@plantstore.com</a></p>
            </div>

            <div style="background-color: var(--color-onyx-canvas); padding: 20px; border-radius: var(--radius-cards); border: 1px solid rgba(226, 227, 237, 0.04);">
                <h3 style="color: var(--color-ivory-text); font-size: var(--text-body); font-weight: 480; margin-bottom: 0.5rem;">{{ __('messages.contact_phone_title') }}</h3>
                <p style="font-size: var(--text-body-sm);"><a href="tel:+15551234567" style="color: var(--color-ivory-text);">{{ __('messages.contact_phone_val') }}</a></p>
                <p style="font-size: var(--text-caption); color: var(--color-ash-text); margin-top: 0.25rem;">{{ __('messages.contact_hours_val') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
