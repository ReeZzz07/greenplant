<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сообщение от {{ $contactMessage->name }} - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 900px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; }
        .info-row { display: grid; grid-template-columns: 150px 1fr; gap: 15px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e9ecef; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { color: #333; }
        .message-content { background: #f8f9fa; padding: 25px; border-radius: 10px; line-height: 1.8; margin: 30px 0; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .actions { display: flex; gap: 15px; margin-top: 30px; }
        .badge { padding: 6px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        h2 { margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.contact-messages.index') }}">← К списку сообщений</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h2>Сообщение от {{ $contactMessage->name }}</h2>
                <span class="badge {{ $contactMessage->is_read ? 'badge-success' : 'badge-warning' }}">
                    {{ $contactMessage->is_read ? 'Прочитано' : 'Новое' }}
                </span>
            </div>

            <div class="info-row">
                <div class="info-label">Дата получения:</div>
                <div class="info-value">{{ $contactMessage->created_at->format('d.m.Y H:i') }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Имя:</div>
                <div class="info-value">{{ $contactMessage->name }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value"><a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></div>
            </div>

            <div class="info-row">
                <div class="info-label">Телефон:</div>
                <div class="info-value">
                    @if($contactMessage->phone)
                        <a href="tel:+79889385600">{{ $contactMessage->phone }}</a>
                    @else
                        Не указан
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">IP адрес:</div>
                <div class="info-value">{{ $contactMessage->ip_address ?? '-' }}</div>
            </div>

            <div style="margin-top: 30px;">
                <h3 style="margin-bottom: 15px;">Сообщение:</h3>
                <div class="message-content">
                    {{ $contactMessage->message }}
                </div>
            </div>

            <div class="actions">
                <a href="mailto:{{ $contactMessage->email }}?subject=RE: Ваше сообщение на GreenPlant" class="btn btn-secondary">
                    📧 Ответить по Email
                </a>
                <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить это сообщение?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

