<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать настройки страницы каталога - GreenPlant</title>
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
        .image-preview-container { margin-top: 15px; }
        .image-preview { max-width: 100%; max-height: 300px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <div>
                <a href="{{ route('admin.catalog-page-settings.index') }}">← Назад к списку</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>➕ Создать настройки страницы каталога</h2>
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
                <form action="{{ route('admin.catalog-page-settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="background_image">Фоновое изображение</label>
                        <input type="file" name="background_image" id="background_image" accept="image/*" onchange="previewImage(this)">
                        <small>Рекомендуемый размер: 1920x300px. Форматы: JPG, PNG, GIF (макс. 2 МБ)</small>
                        <div class="image-preview-container" id="preview-container" style="display: none;">
                            <img id="preview" class="image-preview" src="" alt="Preview">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Предпросмотр</label>
                        <div id="preview-box" style="width: 100%; height: 200px; border: 2px solid #e9ecef; border-radius: 10px; position: relative; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                            <div id="preview-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-size: cover; background-position: center; background-repeat: no-repeat;"></div>
                            <div id="preview-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
                            <div id="preview-content" style="position: relative; z-index: 1; text-align: center; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                <h3 style="margin: 0; font-size: 24px;">Каталог товаров</h3>
                                <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Предпросмотр</p>
                            </div>
                        </div>
                        <small>Предпросмотр изменений в реальном времени</small>
                    </div>

                    <h3 style="margin: 30px 0 20px 0; color: #667eea; border-bottom: 2px solid #e9ecef; padding-bottom: 10px;">🎨 Настройки наложения</h3>

                    <div class="form-group">
                        <label for="overlay_type">Тип наложения</label>
                        <select name="overlay_type" id="overlay_type" class="form-control">
                            <option value="none" {{ old('overlay_type', 'none') == 'none' ? 'selected' : '' }}>Без наложения</option>
                            <option value="darken" {{ old('overlay_type') == 'darken' ? 'selected' : '' }}>Затемнение</option>
                            <option value="lighten" {{ old('overlay_type') == 'lighten' ? 'selected' : '' }}>Осветление</option>
                        </select>
                        <small>Выберите тип наложения для фонового изображения</small>
                    </div>

                    <div class="form-group">
                        <label for="overlay_opacity">Прозрачность наложения (%)</label>
                        <input type="range" name="overlay_opacity" id="overlay_opacity" min="0" max="100" value="{{ old('overlay_opacity', 50) }}" oninput="document.getElementById('opacity_value').textContent = this.value">
                        <small>Текущее значение: <strong id="opacity_value">50</strong>%</small>
                    </div>

                    <h3 style="margin: 30px 0 20px 0; color: #667eea; border-bottom: 2px solid #e9ecef; padding-bottom: 10px;">📍 Позиционирование фона</h3>

                    <div class="form-group">
                        <label for="background_position">Позиция фона</label>
                        <select name="background_position" id="background_position" class="form-control">
                            <option value="left top" {{ old('background_position', 'center center') == 'left top' ? 'selected' : '' }}>Слева сверху</option>
                            <option value="center top" {{ old('background_position') == 'center top' ? 'selected' : '' }}>По центру сверху</option>
                            <option value="right top" {{ old('background_position') == 'right top' ? 'selected' : '' }}>Справа сверху</option>
                            <option value="left center" {{ old('background_position') == 'left center' ? 'selected' : '' }}>Слева по центру</option>
                            <option value="center center" {{ old('background_position', 'center center') == 'center center' ? 'selected' : '' }}>По центру</option>
                            <option value="right center" {{ old('background_position') == 'right center' ? 'selected' : '' }}>Справа по центру</option>
                            <option value="left bottom" {{ old('background_position') == 'left bottom' ? 'selected' : '' }}>Слева снизу</option>
                            <option value="center bottom" {{ old('background_position') == 'center bottom' ? 'selected' : '' }}>По центру снизу</option>
                            <option value="right bottom" {{ old('background_position') == 'right bottom' ? 'selected' : '' }}>Справа снизу</option>
                        </select>
                        <small>Выберите позицию фонового изображения</small>
                    </div>

                    <div class="form-group">
                        <label for="background_size">Размер фона</label>
                        <select name="background_size" id="background_size" class="form-control">
                            <option value="cover" {{ old('background_size', 'cover') == 'cover' ? 'selected' : '' }}>Покрыть всю область</option>
                            <option value="contain" {{ old('background_size') == 'contain' ? 'selected' : '' }}>Вместить полностью</option>
                            <option value="auto" {{ old('background_size') == 'auto' ? 'selected' : '' }}>Автоматически</option>
                            <option value="100% 100%" {{ old('background_size') == '100% 100%' ? 'selected' : '' }}>Растянуть</option>
                        </select>
                        <small>Выберите как изображение должно масштабироваться</small>
                    </div>

                    <h3 style="margin: 30px 0 20px 0; color: #667eea; border-bottom: 2px solid #e9ecef; padding-bottom: 10px;">📝 Заголовки</h3>

                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input type="text" name="title" id="title" value="{{ old('title', 'Каталог товаров') }}" placeholder="Например: Каталог товаров">
                        <small>Основной заголовок страницы каталога</small>
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Подзаголовок (опционально)</label>
                        <textarea name="subtitle" id="subtitle" placeholder="Например: Широкий ассортимент саженцев и деревьев туи">{{ old('subtitle') }}</textarea>
                        <small>Дополнительное описание под заголовком</small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label for="is_active">Активна</label>
                        </div>
                        <small>Если отключено, настройки не будут применяться к странице каталога</small>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">💾 Создать настройки</button>
                        <a href="{{ route('admin.catalog-page-settings.index') }}" class="btn btn-secondary">❌ Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const previewContainer = document.getElementById('preview-container');
            const preview = document.getElementById('preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                    updatePreview();
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.style.display = 'none';
                updatePreview();
            }
        }

        function updatePreview() {
            const fileInput = document.getElementById('background_image');
            const previewBackground = document.getElementById('preview-background');
            const previewOverlay = document.getElementById('preview-overlay');
            const overlayType = document.getElementById('overlay_type').value;
            const overlayOpacity = document.getElementById('overlay_opacity').value;
            const backgroundPosition = document.getElementById('background_position').value;
            const backgroundSize = document.getElementById('background_size').value;

            // Обновляем фоновое изображение
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewBackground.style.backgroundImage = 'url(' + e.target.result + ')';
                    previewBackground.style.backgroundPosition = backgroundPosition;
                    previewBackground.style.backgroundSize = backgroundSize;
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                previewBackground.style.backgroundImage = 'none';
            }

            // Обновляем наложение
            if (overlayType === 'darken') {
                previewOverlay.style.background = 'rgba(0, 0, 0, ' + (overlayOpacity / 100) + ')';
            } else if (overlayType === 'lighten') {
                previewOverlay.style.background = 'rgba(255, 255, 255, ' + (overlayOpacity / 100) + ')';
            } else {
                previewOverlay.style.background = 'transparent';
            }
        }

        // Обновляем предпросмотр при изменении настроек
        document.getElementById('overlay_type').addEventListener('change', updatePreview);
        document.getElementById('overlay_opacity').addEventListener('input', updatePreview);
        document.getElementById('background_position').addEventListener('change', updatePreview);
        document.getElementById('background_size').addEventListener('change', updatePreview);

        // Инициализируем предпросмотр при загрузке страницы
        document.addEventListener('DOMContentLoaded', updatePreview);
    </script>
</body>
</html>

