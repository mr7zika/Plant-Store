<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create(['name' => 'Test Category']);
        $this->product = Product::factory()->create([
            'name' => 'Test Plant',
            'price' => 50.00,
            'quantity' => 100,
            'category_id' => $this->category->id,
        ]);
    }

    /**
     * Test that guests can access checkout index without auth.
     */
    public function test_guest_can_access_checkout_index(): void
    {
        $response = $this->withSession(['cart' => [$this->product->id => 1]])->get(route('checkout.index'));
        $response->assertStatus(200);
        $response->assertViewIs('checkout.index');
        $response->assertViewHas('isGuest', true);
    }

    /**
     * Test that unauthenticated users cannot complete checkout (process).
     */
    public function test_unauthenticated_user_cannot_process_checkout(): void
    {
        $response = $this->withSession(['cart' => [$this->product->id => 1]])
            ->post(route('checkout.process'), [
                'address' => 'Test Address',
                'phone' => '1234567890',
            ]);

        $response->assertRedirect(route('checkout.index'));
        $response->assertSessionHas('warning');
    }

    /**
     * Test that authenticated users can access checkout index.
     */
    public function test_authenticated_user_can_access_checkout_index(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['cart' => [$this->product->id => 1]])
            ->get(route('checkout.index'));

        $response->assertStatus(200);
        $response->assertViewIs('checkout.index');
        $response->assertViewHas('isGuest', false);
    }

    /**
     * Test that authenticated users can process checkout with empty cart.
     */
    public function test_authenticated_user_checkout_with_empty_cart(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->post(route('checkout.process'), [
                'address' => 'Test Address',
                'phone' => '1234567890',
            ]);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('error', 'السلة فارغة');
    }

    /**
     * Test that authenticated users can process checkout with cart items.
     */
    public function test_authenticated_user_can_process_checkout_with_cart(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['cart' => [$this->product->id => 1]])
            ->post(route('checkout.process'), [
                'address' => 'Test Address',
                'phone' => '1234567890',
            ]);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success', 'تم إتمام الشراء بنجاح!');
    }

    /**
     * Test guest login during checkout.
     */
    public function test_guest_can_login_during_checkout(): void
    {
        $user = User::factory()->create([
            'email' => 'guest@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('checkout.authenticate'), [
            'email' => 'guest@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('checkout.index'));
        $response->assertSessionHas('success', 'Logged in successfully!');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test guest registration during checkout.
     */
    public function test_guest_can_register_during_checkout(): void
    {
        $response = $this->post(route('checkout.store-user'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('checkout.index'));
        $response->assertSessionHas('success', 'Account created and logged in successfully!');
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertAuthenticated();
    }

    /**
     * Test that authenticated users cannot access login form.
     */
    public function test_authenticated_users_cannot_access_login_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('checkout.login'));

        $response->assertRedirect();
    }

    /**
     * Test that authenticated users cannot access register form.
     */
    public function test_authenticated_users_cannot_access_register_form(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('checkout.register'));

        $response->assertRedirect();
    }
}
