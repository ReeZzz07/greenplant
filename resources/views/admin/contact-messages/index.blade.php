<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сообщения - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1400px; margin: 40px auto; padding: 0 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-header h2 { font-size: 28px; }
        .btn { padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-size: 14px; }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8f9fa; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; }
        .badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .actions { display: flex; gap: 8px; }
        .unread { font-weight: 600; background: #f0f7ff; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.dashboard') }}">← Назад в панель</a>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>📧 Сообщения с сайта</h2>
            <span class="badge badge-warning">{{ $messages->where('is_read', false)->count() }} новых</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Сообщение</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr class="{{ !$message->is_read ? 'unread' : '' }}">
                        <td>{{ $message->created_at->format('d.m.Y H:i') }}</td>
                        <td><strong>{{ $message->name }}</strong></td>
                        <td><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td>
                        <td>{{ $message->phone ?? '-' }}</td>
                        <td style="max-width: 300px;">{{ Str::limit($message->message, 80) }}</td>
                        <td>
                            <span class="badge {{ $message->is_read ? 'badge-success' : 'badge-warning' }}">
                                {{ $message->is_read ? 'Прочитано' : 'Новое' }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.contact-messages.show', $message) }}" class="btn btn-sm btn-primary">Открыть</a>
                                <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить сообщение?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                            Сообщений пока нет
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="padding: 20px;">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
</body>
</html>

