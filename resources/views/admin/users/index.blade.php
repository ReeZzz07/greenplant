<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .back-link { background: rgba(255,255,255,0.2); color: white; padding: 8px 20px; border-radius: 8px; text-decoration: none; }
        .back-link:hover { background: rgba(255,255,255,0.3); }
        .container { max-width: 1400px; margin: 40px auto; padding: 0 20px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .top-bar h2 { font-size: 28px; }
        .btn { padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; font-size: 14px; font-weight: 500; border: none; cursor: pointer; }
        .btn-primary { background: #667eea; color: white; }
        .btn-primary:hover { background: #5568d3; }
        .btn-warning { background: #ffc107; color: #000; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8f9fa; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { font-weight: 600; color: #495057; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-primary { background: #007bff; color: white; }
        .badge-info { background: #17a2b8; color: white; }
        .badge-secondary { background: #6c757d; color: white; }
        .btn-group { display: inline-flex; gap: 5px; }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .info-box { background: #e7f3ff; padding: 20px; border-radius: 10px; border-left: 4px solid #007bff; }
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
        .empty-state i { font-size: 48px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant - Управление пользователями</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-link">← Назад в панель</a>
        </div>
    </div>

    <div class="container">
        <div class="top-bar">
            <h2>👥 Пользователи системы</h2>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">➕ Добавить пользователя</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif

        <div class="card">
            @if($users->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 25%">Имя</th>
                            <th style="width: 25%">Email</th>
                            <th style="width: 15%">Роль</th>
                            <th style="width: 15%">Создан</th>
                            <th style="width: 15%" class="text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->id === auth()->id())
                                        <span class="badge badge-info">Вы</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->hasRole('admin'))
                                        <span class="badge badge-danger">👑 Администратор</span>
                                    @elseif($user->hasRole('content-manager'))
                                        <span class="badge badge-primary">✏️ Контент-менеджер</span>
                                    @else
                                        <span class="badge badge-secondary">Нет роли</span>
                                    @endif
                                </td>
                                <td><small style="color: #999;">{{ $user->created_at->format('d.m.Y H:i') }}</small></td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm" title="Просмотр">👁️</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm" title="Редактировать">✏️</a>
                                        @if($user->id !== auth()->id())
                                            <button type="button" class="btn btn-danger btn-sm" title="Удалить"
                                                    onclick="if(confirm('Вы уверены что хотите удалить пользователя {{ $user->name }}?\n\nЭто действие нельзя отменить!')) { document.getElementById('delete-form-{{ $user->id }}').submit(); }">
                                                🗑️
                                            </button>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm" title="Нельзя удалить себя" disabled>🚫</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($users->hasPages())
                    <div style="margin-top: 20px;">{{ $users->links() }}</div>
                @endif
            @else
                <div class="empty-state">
                    <div style="font-size: 64px; margin-bottom: 20px;">👥</div>
                    <p style="font-size: 18px; color: #999; margin-bottom: 20px;">Пользователи не найдены</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Добавить первого пользователя</a>
                </div>
            @endif
        </div>

        <div class="info-box">
            <h4 style="margin-bottom: 15px;">ℹ️ Информация о ролях</h4>
            <ul style="margin-left: 20px; line-height: 1.8;">
                <li><strong>Администратор</strong> - полный доступ ко всем функциям, включая управление пользователями, заказами и настройками</li>
                <li><strong>Контент-менеджер</strong> - управление товарами, категориями, блогом и отзывами (без доступа к заказам, пользователям и настройкам)</li>
            </ul>
        </div>
    </div>
</body>
</html>
