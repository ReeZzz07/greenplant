<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Создаем необходимые данные
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\SettingSeeder']);
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\RoleSeeder']);
    }

    /** @test */
    public function user_can_create_order_with_valid_data()
    {
        Notification::fake(); // Отключаем отправку реальных email

        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 1000,
            'stock' => 10,
            'is_active' => true
        ]);
        
        // Добавляем товар в корзину
        session()->put('cart', [
            $product->id => [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 2,
            ]
        ]);

        $orderData = [
            'customer_name' => 'Иван Тестов',
            'customer_email' => 'test@example.com',
            'customer_phone' => '+7 999 123-45-67',
            'customer_address' => 'г. Москва, ул. Тестовая, д. 1',
            'customer_comment' => 'Тестовый комментарий',
            'payment_method' => 'cash',
            'delivery_method' => 'delivery',
        ];

        $response = $this->post(route('checkout.store'), $orderData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Проверяем что заказ создан в БД
        $this->assertDatabaseHas('orders', [
            'customer_email' => 'test@example.com',
            'customer_name' => 'Иван Тестов',
            'status' => 'pending',
        ]);

        // Проверяем что товар добавлен в заказ
        $order = Order::where('customer_email', 'test@example.com')->first();
        $this->assertNotNull($order);
        $this->assertEquals(2, $order->items->first()->quantity);
        
        // Проверяем что корзина очищена
        $this->assertEmpty(session('cart'));
        
        // Проверяем что остаток товара уменьшился
        $product->refresh();
        $this->assertEquals(8, $product->stock);
    }

    /** @test */
    public function order_cannot_be_created_with_empty_cart()
    {
        $orderData = [
            'customer_name' => 'Иван Тестов',
            'customer_email' => 'test@example.com',
            'customer_phone' => '+7 999 123-45-67',
            'customer_address' => 'г. Москва, ул. Тестовая, д. 1',
            'payment_method' => 'cash',
            'delivery_method' => 'delivery',
        ];

        $response = $this->post(route('checkout.store'), $orderData);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function order_validation_requires_customer_name()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'is_active' => true
        ]);
        
        session()->put('cart', [
            $product->id => ['name' => $product->name, 'price' => $product->price, 'quantity' => 1]
        ]);

        $orderData = [
            // customer_name отсутствует
            'customer_email' => 'test@example.com',
            'customer_phone' => '+7 999 123-45-67',
            'customer_address' => 'г. Москва, ул. Тестовая, д. 1',
            'payment_method' => 'cash',
            'delivery_method' => 'delivery',
        ];

        $response = $this->post(route('checkout.store'), $orderData);

        $response->assertSessionHasErrors('customer_name');
    }

    /** @test */
    public function admin_can_view_orders_list()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        
        $order = Order::factory()->create();
        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.orders.index'));

        $response->assertStatus(200);
        $response->assertSee($order->order_number);
    }

    /** @test */
    public function order_number_is_generated_correctly()
    {
        $orderNumber = Order::generateOrderNumber();
        
        // Формат: GP-YYYYMMDD-XXXX
        $this->assertMatchesRegularExpression('/^GP-\d{8}-\d{4}$/', $orderNumber);
        $this->assertStringStartsWith('GP-' . date('Ymd'), $orderNumber);
    }
}

