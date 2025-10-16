<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Перенаправляем в зависимости от роли
            if ($user->hasRole(['admin', 'content-manager'])) {
                return redirect()->intended('/admin');
            } elseif ($user->hasRole('customer')) {
                return redirect()->intended(route('account.dashboard'));
            }
            
            // По умолчанию на главную
            return redirect()->intended('/');
        }

        throw ValidationException::withMessages([
            'email' => ['Неверный email или пароль.'],
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $wasCustomer = Auth::user() && Auth::user()->hasRole('customer');
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Покупатели возвращаются на главную, админы - на login
        if ($wasCustomer) {
            return redirect()->route('home')->with('success', 'Вы вышли из системы');
        }
        
        return redirect()->route('login')->with('success', 'Вы вышли из системы');
    }
}

