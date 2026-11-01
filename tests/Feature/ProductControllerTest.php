<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_view_with_products(): void
    {
        // إنشاء فئة ومنتجات
        $products = Product::factory(3)->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
        $response->assertViewHas('products');
    }

    public function test_create_returns_view_with_categories(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertViewIs('products.create');
        $response->assertViewHas('categories');
    }

    public function test_store_creates_product_with_category(): void
    {
        $category = Category::factory()->create();
        
        $data = [
            'name' => 'نبات جديد',
            'price' => 99.99,
            'quantity' => 10,
            'category_id' => $category->id,
            'description' => 'وصف المنتج الجديد',
        ];

        $response = $this->post(route('products.store'), $data);

        $this->assertDatabaseHas('products', [
            'name' => 'نبات جديد',
            'price' => 99.99,
            'quantity' => 10,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('products.index'));
    }

    public function test_show_returns_view_with_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertViewIs('products.show');
        $response->assertViewHas('product', $product);
    }

    public function test_edit_returns_view_with_product_and_categories(): void
    {
        $product = Product::factory()->create();
        Category::factory(3)->create();

        $response = $this->get(route('products.edit', $product));

        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
        $response->assertViewHas('product', $product);
        $response->assertViewHas('categories');
    }

    public function test_update_modifies_product_with_category(): void
    {
        $product = Product::factory()->create();
        $newCategory = Category::factory()->create();

        $updatedData = [
            'name' => 'اسم محدث',
            'price' => 150.00,
            'quantity' => 20,
            'category_id' => $newCategory->id,
            'description' => 'وصف محدث',
        ];

        $response = $this->put(route('products.update', $product), $updatedData);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'اسم محدث',
            'price' => 150.00,
            'category_id' => $newCategory->id,
        ]);

        $response->assertRedirect(route('products.show', $product));
    }

    public function test_destroy_deletes_product(): void
    {
        $product = Product::factory()->create();
        $productId = $product->id;

        $response = $this->delete(route('products.destroy', $product));

        $this->assertDatabaseMissing('products', [
            'id' => $productId,
        ]);

        $response->assertRedirect(route('products.index'));
    }

    public function test_store_validates_category_id(): void
    {
        $data = [
            'name' => 'نبات جديد',
            'price' => 99.99,
            'quantity' => 10,
            'category_id' => 999, // فئة غير موجودة
            'description' => 'وصف المنتج الجديد',
        ];

        $response = $this->post(route('products.store'), $data);

        $response->assertSessionHasErrors('category_id');
    }
}


