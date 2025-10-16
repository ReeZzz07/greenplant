<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Показать форму запроса ссылки для сброса пароля
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Отправить ссылку для сброса пароля на email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Пожалуйста, укажите email',
            'email.email' => 'Укажите корректный email адрес',
        ]);

        // Попытка отправить ссылку для сброса пароля
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => 'Ссылка для восстановления пароля отправлена на ваш email'])
            : back()->withErrors(['email' => 'Не удалось отправить ссылку для восстановления. Проверьте правильность email адреса.']);
    }
}

