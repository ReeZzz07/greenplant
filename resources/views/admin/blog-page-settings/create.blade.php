<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать настройки страницы "Блог" - GreenPlant</title>
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
        .form-group input[type="file"],
        .form-group textarea,
        .form-group select { width: 100%; padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 14px; transition: all 0.3s; font-family: inherit; }
        .form-group input[type="text"]:focus,
        .form-group textarea:focus,
        .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .form-group small { display: block; margin-top: 5px; color: #6c757d; font-size: 13px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .form-actions { display: flex; gap: 15px; margin-top: 30px; }
        .error { color: #dc3545; font-size: 13px; margin-top: 5px; }
        .preview-box { margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 10px; border: 2px dashed #dee2e6; }
        .preview-box h4 { margin-bottom: 15px; color: #495057; }
        .preview-image { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.blog-page-settings.index') }}">← Назад к списку</a>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Создать настройки страницы "Блог"</h2>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        <strong>Ошибки при сохранении:</strong>
                        <ul style="margin: 10px 0 0 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.blog-page-settings.store') }}" method="POST" enctype="multipart/form-data" id="blogPageSettingsForm">
                    @csrf

                    <div class="form-group">
                        <label for="title">Заголовок страницы *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', 'Блог') }}" required>
                        @error('title')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Подзаголовок</label>
                        <textarea id="subtitle" name="subtitle" rows="2">{{ old('subtitle') }}</textarea>
                        @error('subtitle')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="background_image">Фоновое изображение</label>
                        <input type="file" id="background_image" name="background_image" accept="image/*" onchange="previewImage(this)">
                        <small>Рекомендуемый размер: 1920x600px</small>
                        @error('background_image')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div id="preview-container" style="display: none;">
                        <div class="preview-box">
                            <h4>Предпросмотр фонового изображения:</h4>
                            <img id="preview-image" src="" alt="Preview" class="preview-image">
                            <div id="preview-overlay" style="margin-top: 10px; padding: 10px; background: rgba(0,0,0,0.5); border-radius: 5px; color: white;">
                                <strong>Тип наложения:</strong> <span id="preview-overlay-type">None</span><br>
                                <strong>Прозрачность:</strong> <span id="preview-overlay-opacity">50%</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="overlay_type">Тип наложения</label>
                            <select id="overlay_type" name="overlay_type" onchange="updatePreview()">
                                <option value="none" {{ old('overlay_type', 'none') === 'none' ? 'selected' : '' }}>Нет</option>
                                <option value="darken" {{ old('overlay_type') === 'darken' ? 'selected' : '' }}>Затемнение</option>
                                <option value="lighten" {{ old('overlay_type') === 'lighten' ? 'selected' : '' }}>Осветление</option>
                            </select>
                            @error('overlay_type')<div class="error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="overlay_opacity">Прозрачность наложения (%)</label>
                            <input type="range" id="overlay_opacity" name="overlay_opacity" min="0" max="100" value="{{ old('overlay_opacity', 50) }}" oninput="updateOpacity()">
                            <small>Текущее значение: <span id="opacity-value">50</span>%</small>
                            @error('overlay_opacity')<div class="error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="background_position">Позиция фона</label>
                            <select id="background_position" name="background_position" onchange="updatePreview()">
                                <option value="center center" {{ old('background_position', 'center center') === 'center center' ? 'selected' : '' }}>По центру</option>
                                <option value="center top" {{ old('background_position') === 'center top' ? 'selected' : '' }}>Сверху по центру</option>
                                <option value="center bottom" {{ old('background_position') === 'center bottom' ? 'selected' : '' }}>Снизу по центру</option>
                                <option value="left center" {{ old('background_position') === 'left center' ? 'selected' : '' }}>Слева по центру</option>
                                <option value="right center" {{ old('background_position') === 'right center' ? 'selected' : '' }}>Справа по центру</option>
                                <option value="left top" {{ old('background_position') === 'left top' ? 'selected' : '' }}>Слева сверху</option>
                                <option value="right top" {{ old('background_position') === 'right top' ? 'selected' : '' }}>Справа сверху</option>
                                <option value="left bottom" {{ old('background_position') === 'left bottom' ? 'selected' : '' }}>Слева снизу</option>
                                <option value="right bottom" {{ old('background_position') === 'right bottom' ? 'selected' : '' }}>Справа снизу</option>
                            </select>
                            @error('background_position')<div class="error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="background_size">Размер фона</label>
                            <select id="background_size" name="background_size" onchange="updatePreview()">
                                <option value="cover" {{ old('background_size', 'cover') === 'cover' ? 'selected' : '' }}>Покрывать (Cover)</option>
                                <option value="contain" {{ old('background_size') === 'contain' ? 'selected' : '' }}>Вместить (Contain)</option>
                                <option value="auto" {{ old('background_size') === 'auto' ? 'selected' : '' }}>Автоматически</option>
                                <option value="100% 100%" {{ old('background_size') === '100% 100%' ? 'selected' : '' }}>Растянуть</option>
                            </select>
                            @error('background_size')<div class="error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" style="margin: 0;">Сделать эти настройки активными</label>
                        </div>
                        <small>Активные настройки будут отображаться на странице блога</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить настройки</button>
                        <a href="{{ route('admin.blog-page-settings.index') }}" class="btn btn-secondary">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').style.display = 'block';
                    updatePreview();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateOpacity() {
            const opacity = document.getElementById('overlay_opacity').value;
            document.getElementById('opacity-value').textContent = opacity;
            updatePreview();
        }

        function updatePreview() {
            const overlayType = document.getElementById('overlay_type').value;
            const opacity = document.getElementById('overlay_opacity').value;
            const overlayTypeText = overlayType === 'none' ? 'Нет' : (overlayType === 'darken' ? 'Затемнение' : 'Осветление');
            
            document.getElementById('preview-overlay-type').textContent = overlayTypeText;
            document.getElementById('preview-overlay-opacity').textContent = opacity + '%';

            const previewOverlay = document.getElementById('preview-overlay');
            if (overlayType === 'none') {
                previewOverlay.style.background = 'transparent';
            } else if (overlayType === 'darken') {
                previewOverlay.style.background = `rgba(0, 0, 0, ${opacity / 100})`;
            } else if (overlayType === 'lighten') {
                previewOverlay.style.background = `rgba(255, 255, 255, ${opacity / 100})`;
            }
        }

        // Инициализируем предпросмотр при загрузке страницы
        document.addEventListener('DOMContentLoaded', updatePreview);
    </script>
</body>
</html>

