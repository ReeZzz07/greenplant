<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки Hero-секции - GreenPlant</title>
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
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-danger { background: #dc3545; color: white; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .card-header { padding: 20px 30px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; }
        .card-body { padding: 30px; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .settings-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .setting-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .setting-card.active { border: 2px solid #82ae46; }
        .setting-image { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; }
        .badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-secondary { background: #e2e3e5; color: #383d41; }
        .actions { display: flex; gap: 8px; margin-top: 15px; }
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
        .preview-box { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 10px; }
        .preview-box h4 { margin-bottom: 10px; font-size: 14px; }
        .preview-box p { margin: 5px 0; font-size: 13px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <div>
                <a href="{{ route('admin.settings.index') }}">← Назад к настройкам</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>🎨 Настройки Hero-секции</h2>
            <a href="{{ route('admin.hero-settings.create') }}" class="btn btn-primary">+ Создать настройки</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="card">
            @if($heroSettings->count() > 0)
                <div class="settings-grid">
                    @foreach($heroSettings as $setting)
                        <div class="setting-card {{ $setting->is_active ? 'active' : '' }}">
                            @if($setting->background_image)
                                <img src="{{ asset('storage/' . $setting->background_image) }}" alt="Hero Background" class="setting-image">
                            @else
                                <div style="width: 100%; height: 200px; background: {{ $setting->background_color }}; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    Цветной фон
                                </div>
                            @endif
                            
                            <div class="preview-box">
                                <h4>Параметры:</h4>
                                <p><strong>Тип наложения:</strong> 
                                    @if($setting->overlay_type === 'darken')
                                        Затемнение
                                    @elseif($setting->overlay_type === 'lighten')
                                        Осветление
                                    @else
                                        Без наложения
                                    @endif
                                </p>
                                <p><strong>Прозрачность:</strong> {{ $setting->overlay_opacity }}%</p>
                                <p><strong>Цвет фона:</strong> {{ $setting->background_color }}</p>
                                <p><strong>Статус:</strong> 
                                    @if($setting->is_active)
                                        <span class="badge badge-success">Активен</span>
                                    @else
                                        <span class="badge badge-secondary">Неактивен</span>
                                    @endif
                                </p>
                            </div>

                            <div class="actions">
                                <a href="{{ route('admin.hero-settings.edit', $setting->id) }}" class="btn btn-sm btn-primary">✏️ Редактировать</a>
                                <form action="{{ route('admin.hero-settings.destroy', $setting->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Вы уверены?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️ Удалить</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div style="font-size: 64px; margin-bottom: 20px;">🎨</div>
                    <h3>Настройки не найдены</h3>
                    <p style="margin-top: 10px;">Создайте настройки для hero-секции главной страницы</p>
                    <a href="{{ route('admin.hero-settings.create') }}" class="btn btn-primary" style="margin-top: 20px;">Создать настройки</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

