<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать заголовок секции - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .page-header { margin-bottom: 30px; }
        .page-header h2 { font-size: 28px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .card-body { padding: 30px; }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #495057; }
        .form-group input[type="text"],
        .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 14px; transition: all 0.3s; }
        .form-group input[type="text"]:focus,
        .form-group textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .form-group small { display: block; margin-top: 5px; color: #6c757d; font-size: 13px; }
        .form-check { display: flex; align-items: center; gap: 10px; }
        .form-check input[type="checkbox"] { width: 20px; height: 20px; cursor: pointer; }
        .btn { padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-size: 14px; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #5a6268; }
        .btn-group { display: flex; gap: 10px; margin-top: 30px; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .section-info { background: #e7f3ff; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #667eea; }
        .section-info strong { display: block; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <div>
                <a href="{{ route('admin.home-page-section-titles.index') }}">← Назад к списку</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>✏️ Редактировать заголовок секции</h2>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="section-info">
                    <strong>📍 Секция:</strong>
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
                </div>

                <form action="{{ route('admin.home-page-section-titles.update', $sectionTitle->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Заголовок секции</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $sectionTitle->title) }}" placeholder="Например: Популярные сорта туи">
                        <small>Основной заголовок секции, отображаемый на главной странице</small>
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Подзаголовок секции</label>
                        <textarea name="subtitle" id="subtitle" placeholder="Например: Широкий ассортимент саженцев и взрослых деревьев туи различных сортов для вашего сада">{{ old('subtitle', $sectionTitle->subtitle) }}</textarea>
                        <small>Дополнительное описание под заголовком</small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $sectionTitle->is_active) ? 'checked' : '' }}>
                            <label for="is_active">Активна</label>
                        </div>
                        <small>Если отключено, заголовок не будет отображаться на главной странице</small>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">💾 Сохранить изменения</button>
                        <a href="{{ route('admin.home-page-section-titles.index') }}" class="btn btn-secondary">❌ Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
