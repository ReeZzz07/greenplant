<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header h1 { font-size: 24px; }
        .header-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .stat-card .label {
            color: #666;
            font-size: 14px;
        }
        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .menu-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }
        .menu-card h3 {
            margin-bottom: 10px;
            color: #667eea;
        }
        .menu-card p {
            font-size: 14px;
            color: #666;
        }
        .badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌲 GreenPlant CMS</h1>
        <div class="header-right">
            <div class="user-info">
                <span>{{ auth()->user()->name }}</span>
                <span class="badge">{{ auth()->user()->roles->first()->name ?? 'User' }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Выход</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            <h2>Добро пожаловать в панель управления!</h2>
            <p style="margin-top: 10px; color: #666;">Управляйте контентом вашего сайта GreenPlant</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="number">{{ $stats['products'] ?? 0 }}</div>
                <div class="label">Товаров</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $stats['categories'] ?? 0 }}</div>
                <div class="label">Категорий</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $stats['blog_posts'] ?? 0 }}</div>
                <div class="label">Статей</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $stats['testimonials'] ?? 0 }}</div>
                <div class="label">Отзывов</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $stats['messages'] ?? 0 }}</div>
                <div class="label">Сообщений</div>
            </div>
            <div class="stat-card">
                <div class="number">{{ $stats['orders'] ?? 0 }}</div>
                <div class="label">Заказов</div>
            </div>
            @if(($stats['unread_messages'] ?? 0) > 0)
            <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: white;">
                <div class="number" style="color: white;">{{ $stats['unread_messages'] }}</div>
                <div class="label" style="color: white;">Новых сообщений</div>
            </div>
            @endif
            @if(($stats['pending_orders'] ?? 0) > 0)
            <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                <div class="number" style="color: white;">{{ $stats['pending_orders'] }}</div>
                <div class="label" style="color: white;">Новых заказов</div>
            </div>
            @endif
        </div>

        <h3 style="margin-bottom: 20px;">Управление</h3>
        <div class="menu">
            <a href="{{ route('admin.products.index') }}" class="menu-card">
                <h3>🌲 Товары</h3>
                <p>Управление товарами (туи)</p>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="menu-card">
                <h3>📁 Категории</h3>
                <p>Категории товаров</p>
            </a>
            <a href="{{ route('admin.blog.index') }}" class="menu-card">
                <h3>📝 Блог</h3>
                <p>Статьи и публикации</p>
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="menu-card">
                <h3>💬 Отзывы</h3>
                <p>Отзывы клиентов</p>
            </a>
            <a href="{{ route('admin.contact-messages.index') }}" class="menu-card">
                <h3>📧 Сообщения</h3>
                <p>Обратная связь с сайта</p>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="menu-card">
                <h3>📦 Заказы</h3>
                <p>Управление заказами</p>
            </a>
            @can('view settings')
            <a href="{{ route('admin.users.index') }}" class="menu-card">
                <h3>👥 Пользователи</h3>
                <p>Управление пользователями</p>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="menu-card">
                <h3>⚙️ Настройки</h3>
                <p>Настройки сайта</p>
            </a>
            @endcan
            <a href="{{ route('home') }}" class="menu-card">
                <h3>🌐 Сайт</h3>
                <p>Перейти на сайт</p>
            </a>
        </div>
    </div>
</body>
</html>

