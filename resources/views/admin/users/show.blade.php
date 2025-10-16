<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр пользователя - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header-actions { display: flex; gap: 10px; }
        .back-link, .edit-link { background: rgba(255,255,255,0.2); color: white; padding: 8px 20px; border-radius: 8px; text-decoration: none; }
        .back-link:hover, .edit-link:hover { background: rgba(255,255,255,0.3); }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
        table { width: 100%; }
        th, td { padding: 15px 10px; text-align: left; }
        th { color: #999; font-weight: 500; width: 30%; }
        .badge { display: inline-block; padding: 6px 16px; border-radius: 12px; font-size: 14px; font-weight: 600; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-primary { background: #007bff; color: white; }
        .badge-info { background: #17a2b8; color: white; }
        .btn { padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; font-size: 14px; font-weight: 500; border: none; cursor: pointer; width: 100%; margin-bottom: 10px; text-align: center; }
        .btn-warning { background: #ffc107; color: #000; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>👤 {{ $user->name }}</h1>
            <div class="header-actions">
                <a href="{{ route('admin.users.edit', $user) }}" class="edit-link">✏️ Редактировать</a>
                <a href="{{ route('admin.users.index') }}" class="back-link">← Назад</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h3 style="margin-bottom: 20px;">Информация о пользователе</h3>
            <table>
                <tr>
                    <th>ID:</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th>Имя:</th>
                    <td>
                        <strong>{{ $user->name }}</strong>
                        @if($user->id === auth()->id())
                            <span class="badge badge-info">Вы</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                </tr>
                <tr>
                    <th>Роль:</th>
                    <td>
                        @if($user->hasRole('admin'))
                            <span class="badge badge-danger">👑 Администратор</span>
                            <p style="margin-top: 10px; color: #999; font-size: 14px;">Полный доступ ко всем функциям системы</p>
                        @elseif($user->hasRole('content-manager'))
                            <span class="badge badge-primary">✏️ Контент-менеджер</span>
                            <p style="margin-top: 10px; color: #999; font-size: 14px;">Управление контентом без доступа к заказам и настройкам</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Создан:</th>
                    <td>{{ $user->created_at->format('d.m.Y в H:i') }}</td>
                </tr>
                <tr>
                    <th>Обновлен:</th>
                    <td>{{ $user->updated_at->format('d.m.Y в H:i') }}</td>
                </tr>
            </table>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 20px;">🎯 Действия</h3>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">✏️ Редактировать пользователя</a>
            
            @if($user->id !== auth()->id())
                <button type="button" class="btn btn-danger" 
                        onclick="if(confirm('Вы уверены что хотите удалить пользователя {{ $user->name }}?\n\nЭто действие нельзя отменить!')) { document.getElementById('delete-form').submit(); }">
                    🗑️ Удалить пользователя
                </button>
                <form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @else
                <button type="button" class="btn btn-secondary" disabled>🚫 Нельзя удалить себя</button>
            @endif
        </div>
    </div>
</body>
</html>
