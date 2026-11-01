<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartSessionPersistenceTest extends TestCase
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
     * Test that cart persists after guest login during checkout.
     * CRITICAL: This test verifies the core issue is fixed.
     */
    public function test_cart_persists_after_guest_login(): void
    {
        // Create user for login
        $user = User::factory()->create([
            'email' => 'existing@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Guest adds items to cart
        $cartData = [$this->product->id => 2];

        // Login with cart in session
        $response = $this->withSession(['cart' => $cartData])
            ->post(route('checkout.authenticate'), [
                'email' => 'existing@example.com',
                'password' => 'password123',
            ]);

        // Verify redirect to checkout
        $response->assertRedirect(route('checkout.index'));

        // Verify authentication
        $this->assertAuthenticatedAs($user);

        // CRITICAL: Verify cart is still in session after login
        $this->assertEquals($cartData, session('cart'), 'Cart should persist after login');
    }

    /**
     * Test that cart persists after guest registration during checkout.
     * CRITICAL: This test verifies the core issue is fixed.
     */
    public function test_cart_persists_after_guest_registration(): void
    {
        // Guest adds items to cart
        $cartData = [$this->product->id => 3];

        // Guest registers during checkout
        $response = $this->withSession(['cart' => $cartData])
            ->post(route('checkout.store-user'), [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

        // Verify redirect to checkout
        $response->assertRedirect(route('checkout.index'));

        // Verify user was created
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);

        // Verify authentication
        $this->assertAuthenticated();

        // CRITICAL: Verify cart is still in session after registration
        $this->assertEquals($cartData, session('cart'), 'Cart should persist after registration');
    }

    /**
     * Test that cart quantity is preserved exactly after login.
     */
    public function test_cart_quantity_preserved_exactly_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Start with exact cart quantity
        $exactQuantity = 5;
        $cartData = [$this->product->id => $exactQuantity];

        $response = $this->withSession(['cart' => $cartData])
            ->post(route('checkout.authenticate'), [
                'email' => 'test@example.com',
                'password' => 'password123',
            ]);

        // Verify exact quantity is preserved
        $this->assertEquals($exactQuantity, session('cart')[$this->product->id], 
            'Cart quantity should be exactly ' . $exactQuantity);
    }

    /**
     * Test checkout can be completed after login preserves cart.
     */
    public function test_checkout_completes_successfully_with_preserved_cart(): void
    {
        $user = User::factory()->create([
            'email' => 'customer@example.com',
            'password' => bcrypt('password123'),
        ]);

        $cartData = [$this->product->id => 2];

        // Login with cart
        $response = $this->withSession(['cart' => $cartData])
            ->post(route('checkout.authenticate'), [
                'email' => 'customer@example.com',
                'password' => 'password123',
            ]);

        $response->assertRedirect(route('checkout.index'));

        // Access checkout page - cart should still be present
        $response = $this->get(route('checkout.index'));
        $response->assertStatus(200);
        $response->assertViewIs('checkout.index');
        $response->assertSee($this->product->name);

        // Complete purchase
        $response = $this->post(route('checkout.process'), [
            'address' => '123 Main St',
            'phone' => '555-0123',
        ]);

        $response->assertRedirect(route('profile.index'));
        $response->assertSessionHas('success');
    }
}
