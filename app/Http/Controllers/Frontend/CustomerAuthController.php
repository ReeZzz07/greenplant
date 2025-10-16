<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends Controller
{
    /**
     * Показать страницу входа/регистрации для покупателей
     */
    public function showAuthPage()
    {
        return view('frontend.customer-auth');
    }

    /**
     * Обработка входа покупателя
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Пожалуйста, укажите email',
            'email.email' => 'Укажите корректный email',
            'password.required' => 'Пожалуйста, укажите пароль',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Проверяем роль пользователя
            if ($user->hasRole('customer')) {
                return redirect()->intended(route('account.dashboard'));
            }
            
            // Если это не покупатель (админ/менеджер), выходим и показываем ошибку
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Этот вход только для покупателей. Используйте <a href="/login">вход в админ-панель</a>.',
                ]);
        }

        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Неверный email или пароль.',
            ]);
    }
}

