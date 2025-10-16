<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Создаем необходимые данные для тестов
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\SettingSeeder']);
    }

    /** @test */
    public function user_can_add_product_to_cart()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 1000,
            'stock' => 10,
            'is_active' => true
        ]);

        $response = $this->postJson(route('cart.add', $product->id), [
            'quantity' => 2
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Товар добавлен в корзину!'
        ]);
        
        $this->assertNotEmpty(session('cart'));
        $this->assertEquals(2, session('cart')[$product->id]['quantity']);
        $this->assertEquals($product->name, session('cart')[$product->id]['name']);
    }

    /** @test */
    public function user_can_view_cart()
    {
        $response = $this->get(route('cart.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('frontend.cart');
    }

    /** @test */
    public function user_can_update_cart_quantity()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 1500,
            'stock' => 10,
            'is_active' => true
        ]);

        // Сначала добавляем товар
        $this->postJson(route('cart.add', $product->id), ['quantity' => 1]);

        // Обновляем количество
        $response = $this->postJson(route('cart.update', $product->id), [
            'quantity' => 5
        ]);

        $response->assertStatus(200);
        $this->assertEquals(5, session('cart')[$product->id]['quantity']);
    }

    /** @test */
    public function user_can_remove_product_from_cart()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 2000,
            'is_active' => true
        ]);

        // Добавляем товар
        $this->postJson(route('cart.add', $product->id), ['quantity' => 1]);
        $this->assertNotEmpty(session('cart'));

        // Удаляем товар
        $response = $this->deleteJson(route('cart.remove', $product->id));

        $response->assertStatus(200);
        $this->assertEmpty(session('cart'));
    }

    /** @test */
    public function user_can_clear_entire_cart()
    {
        $category = Category::factory()->create();
        $product1 = Product::factory()->create(['category_id' => $category->id, 'is_active' => true]);
        $product2 = Product::factory()->create(['category_id' => $category->id, 'is_active' => true]);

        // Добавляем несколько товаров
        $this->postJson(route('cart.add', $product1->id), ['quantity' => 1]);
        $this->postJson(route('cart.add', $product2->id), ['quantity' => 2]);

        $this->assertCount(2, session('cart'));

        // Очищаем корзину
        $response = $this->postJson(route('cart.clear'));

        $response->assertStatus(200);
        $this->assertEmpty(session('cart'));
    }
}

