<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Показать корзину
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('frontend.cart', compact('cart', 'total'));
    }

    /**
     * Добавить товар в корзину
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $quantity = max(1, (int)$request->input('quantity', 1));
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
            ];
        }
        
        session()->put('cart', $cart);
        
        // Если это AJAX запрос, возвращаем JSON
        if ($request->ajax() || $request->expectsJson()) {
            $cartCount = $this->getCartCount();
            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен в корзину!',
                'cartCount' => $cartCount,
                'productName' => $product->name,
            ]);
        }
        
        return redirect()->back()->with('success', 'Товар добавлен в корзину!');
    }

    /**
     * Обновить количество товара
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $quantity = max(1, (int)$request->quantity);
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }
        
        // Если это AJAX запрос, возвращаем JSON
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Корзина обновлена!',
                'cartCount' => $this->getCartCount(),
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Корзина обновлена!');
    }

    /**
     * Удалить товар из корзины
     */
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        // Если это AJAX запрос, возвращаем JSON
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар удален из корзины!',
                'cartCount' => $this->getCartCount(),
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины!');
    }

    /**
     * Очистить корзину
     */
    public function clear(Request $request)
    {
        session()->forget('cart');
        
        // Если это AJAX запрос, возвращаем JSON
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Корзина очищена!',
                'cartCount' => 0,
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Корзина очищена!');
    }

    /**
     * Получить количество товаров в корзине
     */
    public static function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        
        return $count;
    }
}

