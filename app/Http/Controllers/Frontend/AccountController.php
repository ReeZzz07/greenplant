<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Главная страница личного кабинета
     */
    public function dashboard()
    {
        $user = auth()->user();
        $orders = $user->orders()->with('items.product')->latest()->paginate(10);
        $addresses = $user->addresses;
        
        return view('frontend.account.dashboard', compact('user', 'orders', 'addresses'));
    }

    /**
     * Профиль пользователя
     */
    public function profile()
    {
        return view('frontend.account.profile');
    }

    /**
     * Обновление профиля
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Укажите ваше имя',
            'email.required' => 'Укажите email',
            'email.email' => 'Укажите корректный email',
            'email.unique' => 'Этот email уже используется',
        ]);

        $user->update($validated);

        return redirect()->route('account.profile')
            ->with('success', 'Профиль успешно обновлен!');
    }

    /**
     * Изменение пароля
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Укажите текущий пароль',
            'password.required' => 'Укажите новый пароль',
            'password.min' => 'Пароль должен содержать минимум 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = auth()->user();

        // Проверяем текущий пароль
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Неверный текущий пароль']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('account.profile')
            ->with('success', 'Пароль успешно изменен!');
    }

    /**
     * Мои заказы
     */
    public function orders()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('frontend.account.orders', compact('orders'));
    }

    /**
     * Детали заказа
     */
    public function orderShow($id)
    {
        $order = auth()->user()->orders()->with('items.product')->findOrFail($id);
        return view('frontend.account.order-show', compact('order'));
    }

    /**
     * Мои адреса
     */
    public function addresses()
    {
        $addresses = auth()->user()->addresses;
        return view('frontend.account.addresses', compact('addresses'));
    }

    /**
     * Добавить адрес
     */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
            'comment' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        $user = auth()->user();

        // Если это первый адрес или установлен как основной
        if ($user->addresses()->count() == 0 || ($validated['is_default'] ?? false)) {
            // Снимаем флаг "основной" со всех адресов
            $user->addresses()->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $user->addresses()->create($validated);

        return redirect()->route('account.addresses')
            ->with('success', 'Адрес успешно добавлен!');
    }

    /**
     * Обновить адрес
     */
    public function updateAddress(Request $request, $id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
            'comment' => 'nullable|string',
            'is_default' => 'boolean',
        ]);

        // Если устанавливается как основной
        if ($validated['is_default'] ?? false) {
            auth()->user()->addresses()->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $address->update($validated);

        return redirect()->route('account.addresses')
            ->with('success', 'Адрес успешно обновлен!');
    }

    /**
     * Удалить адрес
     */
    public function destroyAddress($id)
    {
        $address = auth()->user()->addresses()->findOrFail($id);
        $address->delete();

        return redirect()->route('account.addresses')
            ->with('success', 'Адрес удален!');
    }

    /**
     * Установить адрес как основной
     */
    public function setDefaultAddress($id)
    {
        $user = auth()->user();
        
        // Снимаем флаг со всех адресов
        $user->addresses()->update(['is_default' => false]);
        
        // Устанавливаем для выбранного
        $address = $user->addresses()->findOrFail($id);
        $address->update(['is_default' => true]);

        return redirect()->route('account.addresses')
            ->with('success', 'Адрес установлен как основной!');
    }
}

