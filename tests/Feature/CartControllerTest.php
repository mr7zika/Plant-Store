<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product1;
    protected Product $product2;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create(['name' => 'نباتات']);
        $this->product1 = Product::factory()->create([
            'name' => 'وردة', 'price' => 50.00, 'quantity' => 100, 'category_id' => $this->category->id,
        ]);
        $this->product2 = Product::factory()->create([
            'name' => 'زهرة', 'price' => 75.00, 'quantity' => 50, 'category_id' => $this->category->id,
        ]);
    }

    public function test_get_empty_cart(): void
    {
        $response = $this->get(route('cart.index'));
        $response->assertStatus(200)->assertJson(['success' => true, 'items' => [], 'total' => 0]);
    }

    public function test_guest_can_get_empty_cart(): void
    {
        // No auth, should still work
        $response = $this->get(route('cart.index'));
        $response->assertStatus(200)->assertJson(['success' => true, 'items' => []]);
    }

    public function test_get_cart_with_items(): void
    {
        $this->session(['cart' => [$this->product1->id => 2, $this->product2->id => 1]]);
        $response = $this->get(route('cart.index'));
        $response->assertStatus(200)->assertJson(['count' => 3, 'total' => 175.00]);
    }

    public function test_add_product_to_cart(): void
    {
        $response = $this->post(route('cart.add'), ['product_id' => $this->product1->id, 'quantity' => 2]);
        $response->assertStatus(201)->assertJson(['success' => true, 'cart_total' => 100.00]);
    }

    public function test_guest_can_add_product_to_cart(): void
    {
        // Guest (not authenticated) should still be able to add
        $response = $this->post(route('cart.add'), ['product_id' => $this->product1->id, 'quantity' => 1]);
        $response->assertStatus(201)->assertJson(['success' => true]);
    }

    public function test_add_product_exceeds_stock(): void
    {
        $response = $this->post(route('cart.add'), ['product_id' => $this->product1->id, 'quantity' => 150]);
        $response->assertStatus(400)->assertJson(['success' => false]);
    }

    public function test_update_product_quantity(): void
    {
        $this->session(['cart' => [$this->product1->id => 2]]);
        $response = $this->patch(route('cart.update', $this->product1->id), ['quantity' => 5]);
        $response->assertStatus(200)->assertJson(['success' => true, 'product' => ['quantity' => 5]]);
    }

    public function test_remove_product_from_cart(): void
    {
        $this->session(['cart' => [$this->product1->id => 2]]);
        $response = $this->delete(route('cart.remove', $this->product1->id));
        $response->assertStatus(200)->assertJson(['success' => true]);
    }

    public function test_clear_cart(): void
    {
        $this->session(['cart' => [$this->product1->id => 2]]);
        $response = $this->delete(route('cart.clear'));
        $response->assertStatus(200)->assertJson(['success' => true, 'items' => []]);
    }
}

