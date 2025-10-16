<div class="card p-3" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
    <div class="text-center mb-3">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #82ae46, #6a9237); border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 28px; color: white; font-weight: bold;">
            @php
                $nameParts = explode(' ', trim(auth()->user()->name));
                $initials = '';
                if (count($nameParts) >= 2) {
                    // Имя и Фамилия - берем первые буквы
                    $initials = mb_strtoupper(mb_substr($nameParts[0], 0, 1)) . mb_strtoupper(mb_substr($nameParts[1], 0, 1));
                } else {
                    // Только одно слово - берем первые 2 буквы
                    $initials = mb_strtoupper(mb_substr(auth()->user()->name, 0, 2));
                }
            @endphp
            {{ $initials }}
        </div>
        <h5 style="margin: 0;">{{ auth()->user()->name }}</h5>
        <small class="text-muted">{{ auth()->user()->email }}</small>
    </div>
    
    <hr>
    
    <ul class="list-unstyled" style="margin: 0;">
        <li class="mb-2">
            <a href="{{ route('account.dashboard') }}" 
               class="d-block p-2" 
               style="text-decoration: none; {{ request()->routeIs('account.dashboard') ? 'background: #82ae46; color: white; font-weight: bold;' : 'color: #333;' }} border-radius: 5px;">
                <i class="fas fa-chart-line"></i> Обзор
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('account.orders') }}" 
               class="d-block p-2" 
               style="text-decoration: none; {{ request()->routeIs('account.orders*') ? 'background: #82ae46; color: white; font-weight: bold;' : 'color: #333;' }} border-radius: 5px;">
                <i class="fas fa-shopping-bag"></i> Мои заказы
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('account.addresses') }}" 
               class="d-block p-2" 
               style="text-decoration: none; {{ request()->routeIs('account.addresses') ? 'background: #82ae46; color: white; font-weight: bold;' : 'color: #333;' }} border-radius: 5px;">
                <i class="fas fa-map-marker-alt"></i> Адреса доставки
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('account.profile') }}" 
               class="d-block p-2" 
               style="text-decoration: none; {{ request()->routeIs('account.profile') ? 'background: #82ae46; color: white; font-weight: bold;' : 'color: #333;' }} border-radius: 5px;">
                <i class="fas fa-cog"></i> Настройки профиля
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link d-block w-100 text-left p-2" 
                        style="text-decoration: none; color: #dc3545; border: none; background: none;">
                    <i class="fas fa-sign-out-alt"></i> Выход
                </button>
            </form>
        </li>
    </ul>
</div>

