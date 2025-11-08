<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderConfirmationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    /**
     * Показать форму оформления заказа
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $deliveryCost = $total >= \App\Models\Setting::get('free_delivery_from', 10000) ? 0 : 500;
        
        // Получаем адреса пользователя если авторизован
        $addresses = auth()->check() ? auth()->user()->addresses : collect();
        $defaultAddress = auth()->check() ? auth()->user()->defaultAddress : null;
        
        return view('frontend.checkout', compact('cart', 'total', 'deliveryCost', 'addresses', 'defaultAddress'));
    }

    /**
     * Обработать заказ
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_comment' => 'nullable|string',
            'payment_method' => 'required|in:cash,card,online',
            'delivery_method' => 'required|in:delivery,pickup',
        ], [
            'customer_name.required' => 'Укажите ваше имя',
            'customer_email.required' => 'Укажите email',
            'customer_phone.required' => 'Укажите телефон',
            'customer_address.required' => 'Укажите адрес доставки',
            'payment_method.required' => 'Выберите способ оплаты',
            'delivery_method.required' => 'Выберите способ доставки',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Добавляем стоимость доставки
        $deliveryCost = $total >= \App\Models\Setting::get('free_delivery_from', 10000) ? 0 : 500;
        $total += $deliveryCost;

        DB::beginTransaction();
        
        try {
            // Создаем заказ
            $order = Order::create([
                'user_id' => auth()->id(), // Связываем с пользователем если авторизован
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'customer_comment' => $validated['customer_comment'],
                'total_amount' => $total,
                'payment_method' => $validated['payment_method'],
                'delivery_method' => $validated['delivery_method'],
                'ip_address' => $request->ip(),
                'status' => 'pending',
            ]);

            // Создаем позиции заказа
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $item['name'],
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
                
                // Уменьшаем остаток товара
                $product = Product::find($id);
                if ($product && $product->stock >= $item['quantity']) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();

            // Отправляем уведомления
            try {
                // Уведомление клиенту
                Notification::route('mail', $order->customer_email)
                    ->notify(new OrderConfirmationNotification($order));
                
                // Уведомление отделу обработки заказов
                Notification::route('mail', 'orders@g-plant.ru')
                    ->notify(new NewOrderNotification($order));

                // Уведомление администраторам (для истории в админке)
                $admins = User::role('admin')->get();
                Notification::send($admins, new NewOrderNotification($order));
            } catch (\Exception $e) {
                // Логируем ошибку, но не прерываем процесс
                \Log::error('Ошибка отправки email: ' . $e->getMessage());
            }

            // Очищаем корзину
            session()->forget('cart');

            return redirect()->route('order.success', $order->id)
                ->with('success', 'Заказ успешно оформлен! Номер заказа: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ошибка при оформлении заказа. Попробуйте еще раз.');
        }
    }

    /**
     * Страница успешного заказа
     */
    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        
        return view('frontend.order-success', compact('order'));
    }
}

