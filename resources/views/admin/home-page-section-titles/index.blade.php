<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заголовки секций - GreenPlant</title>
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
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .card-header { padding: 20px 30px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; }
        .card-body { padding: 30px; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8f9fa; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; }
        td { color: #212529; }
        .badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-secondary { background: #e2e3e5; color: #383d41; }
        .actions { display: flex; gap: 8px; }
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
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
            <h2>📝 Заголовки секций главной страницы</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="card">
            @if($sectionTitles->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Секция</th>
                            <th>Заголовок</th>
                            <th>Подзаголовок</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sectionTitles as $sectionTitle)
                            <tr>
                                <td>
                                    @if($sectionTitle->section_key === 'services')
                                        ⭐ Блоки преимуществ
                                    @elseif($sectionTitle->section_key === 'products')
                                        🛍️ Популярные товары
                                    @elseif($sectionTitle->section_key === 'testimonials')
                                        💬 Отзывы клиентов
                                    @elseif($sectionTitle->section_key === 'gallery')
                                        📸 Instagram галерея
                                    @else
                                        {{ $sectionTitle->section_key }}
                                    @endif
                                </td>
                                <td>{{ $sectionTitle->title ?? '—' }}</td>
                                <td>{{ Str::limit($sectionTitle->subtitle ?? '—', 60) }}</td>
                                <td>
                                    @if($sectionTitle->is_active)
                                        <span class="badge badge-success">Активен</span>
                                    @else
                                        <span class="badge badge-secondary">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.home-page-section-titles.edit', $sectionTitle->id) }}" class="btn btn-sm btn-primary">✏️ Редактировать</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div style="font-size: 64px; margin-bottom: 20px;">📝</div>
                    <h3>Заголовки секций не найдены</h3>
                    <p style="margin-top: 10px;">Запустите миграцию и сидер</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

