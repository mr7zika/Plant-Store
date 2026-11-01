<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalizationTest extends TestCase
{
    /**
     * Test that Arabic is the default language and RTL is applied.
     */
    public function test_default_locale_is_arabic(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="ar"', false);
        $response->assertSee(__('messages.nav_products'));
    }

    /**
     * Test switching to English sets the session and cookie.
     */
    public function test_can_switch_to_english(): void
    {
        $response = $this->get(route('lang.switch', ['locale' => 'en']));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'en');
        $response->assertCookie('locale', 'en');
    }

    /**
     * Test English layout has LTR direction and English strings.
     */
    public function test_english_layout_has_ltr_direction(): void
    {
        $response = $this->withSession(['locale' => 'en'])->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('dir="ltr"', false);
        $response->assertSee('lang="en"', false);
        $response->assertSee('MERCURY BOTANIC ATELIER');
        $response->assertSee('Refined living through living architecture.');
    }

    /**
     * Test switching back to Arabic preserves RTL.
     */
    public function test_can_switch_back_to_arabic(): void
    {
        $response = $this->withSession(['locale' => 'en'])
            ->get(route('lang.switch', ['locale' => 'ar']));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'ar');

        $homeResponse = $this->withSession(['locale' => 'ar'])->get(route('home'));
        $homeResponse->assertSee('dir="rtl"', false);
        $homeResponse->assertSee('lang="ar"', false);
    }

    /**
     * Test unsupported locales are rejected and fallback to default.
     */
    public function test_invalid_locale_falls_back_to_default(): void
    {
        $response = $this->get(route('lang.switch', ['locale' => 'fr']));

        $response->assertRedirect();
        // Session should not have 'fr'
        $this->assertNotEquals('fr', session('locale'));
    }
}
