<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Если пользователь не авторизован, пропускаем (сработает auth middleware)
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Проверяем роль пользователя
        if ($user->hasRole(['admin', 'content-manager'])) {
            // Админы и менеджеры - пропускаем
            return $next($request);
        }

        // Если это покупатель или пользователь без роли - блокируем доступ
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->withErrors([
            'email' => 'У вас нет прав для доступа к админ-панели. Пожалуйста, войдите с учетной записью администратора или контент-менеджера.',
        ])->with('warning', 'Доступ запрещен. Войдите с учетной записью, имеющей права администратора.');
    }
}
