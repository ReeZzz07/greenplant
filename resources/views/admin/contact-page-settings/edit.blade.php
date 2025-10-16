<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать настройки страницы "Контакты" - GreenPlant</title>
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
        #map_embed_code { font-family: 'Courier New', monospace; font-size: 13px; }
        .form-group small { display: block; margin-top: 5px; color: #6c757d; font-size: 13px; }
        .form-check { display: flex; align-items: center; gap: 10px; }
        .form-check input[type="checkbox"] { width: 20px; height: 20px; cursor: pointer; }
        .btn { padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-size: 14px; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #5a6268; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }
        .btn-group { display: flex; gap: 10px; margin-top: 30px; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .image-preview-container { margin-top: 15px; }
        .image-preview { max-width: 100%; max-height: 300px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h3 { margin: 30px 0 20px 0; color: #667eea; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .current-image { margin-top: 10px; }
        .current-image img { max-width: 200px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <div>
                <a href="{{ route('admin.contact-page-settings.index') }}">← Назад к списку</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>✏️ Редактировать настройки страницы "Контакты"</h2>
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
                <form action="{{ route('admin.contact-page-settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h3>🎨 Hero-секция</h3>

                    <div class="form-group">
                        <label for="background_image">Фоновое изображение</label>
                        @if($setting->background_image)
                            <div class="current-image">
                                <p style="font-size: 13px; color: #6c757d; margin-bottom: 8px;">Текущее изображение:</p>
                                <img src="{{ asset('storage/' . $setting->background_image) }}" alt="Current background">
                            </div>
                        @endif
                        <input type="file" name="background_image" id="background_image" accept="image/*" onchange="previewImage(this)">
                        <small>Рекомендуемый размер: 1920x300px. Форматы: JPG, PNG, GIF (макс. 2 МБ)</small>
                        <div class="image-preview-container" id="preview-container" style="display: none;">
                            <img id="preview" class="image-preview" src="" alt="Preview">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Предпросмотр</label>
                        <div id="preview-box" style="width: 100%; height: 200px; border: 2px solid #e9ecef; border-radius: 10px; position: relative; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                            <div id="preview-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-size: {{ $setting->background_size }}; background-position: {{ $setting->background_position }}; background-repeat: no-repeat; background-image: url('{{ $setting->background_image ? asset('storage/' . $setting->background_image) : '' }}');"></div>
                            <div id="preview-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
                            <div id="preview-content" style="position: relative; z-index: 1; text-align: center; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                <h3 style="margin: 0; font-size: 24px;">{{ $setting->title }}</h3>
                                @if($setting->subtitle)
                                    <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">{{ $setting->subtitle }}</p>
                                @endif
                            </div>
                        </div>
                        <small>Предпросмотр изменений в реальном времени</small>
                    </div>

                    <h3>🎨 Настройки наложения</h3>

                    <div class="form-group">
                        <label for="overlay_type">Тип наложения</label>
                        <select name="overlay_type" id="overlay_type" class="form-control">
                            <option value="none" {{ $setting->overlay_type == 'none' ? 'selected' : '' }}>Без наложения</option>
                            <option value="darken" {{ $setting->overlay_type == 'darken' ? 'selected' : '' }}>Затемнение</option>
                            <option value="lighten" {{ $setting->overlay_type == 'lighten' ? 'selected' : '' }}>Осветление</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="overlay_opacity">Прозрачность наложения (%)</label>
                        <input type="range" name="overlay_opacity" id="overlay_opacity" min="0" max="100" value="{{ $setting->overlay_opacity }}" oninput="document.getElementById('opacity_value').textContent = this.value">
                        <small>Текущее значение: <strong id="opacity_value">{{ $setting->overlay_opacity }}</strong>%</small>
                    </div>

                    <h3>📍 Позиционирование фона</h3>

                    <div class="form-group">
                        <label for="background_position">Позиция фона</label>
                        <select name="background_position" id="background_position" class="form-control">
                            <option value="left top" {{ $setting->background_position == 'left top' ? 'selected' : '' }}>Слева сверху</option>
                            <option value="center top" {{ $setting->background_position == 'center top' ? 'selected' : '' }}>По центру сверху</option>
                            <option value="right top" {{ $setting->background_position == 'right top' ? 'selected' : '' }}>Справа сверху</option>
                            <option value="left center" {{ $setting->background_position == 'left center' ? 'selected' : '' }}>Слева по центру</option>
                            <option value="center center" {{ $setting->background_position == 'center center' ? 'selected' : '' }}>По центру</option>
                            <option value="right center" {{ $setting->background_position == 'right center' ? 'selected' : '' }}>Справа по центру</option>
                            <option value="left bottom" {{ $setting->background_position == 'left bottom' ? 'selected' : '' }}>Слева снизу</option>
                            <option value="center bottom" {{ $setting->background_position == 'center bottom' ? 'selected' : '' }}>По центру снизу</option>
                            <option value="right bottom" {{ $setting->background_position == 'right bottom' ? 'selected' : '' }}>Справа снизу</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="background_size">Размер фона</label>
                        <select name="background_size" id="background_size" class="form-control">
                            <option value="cover" {{ $setting->background_size == 'cover' ? 'selected' : '' }}>Покрыть всю область</option>
                            <option value="contain" {{ $setting->background_size == 'contain' ? 'selected' : '' }}>Вместить полностью</option>
                            <option value="auto" {{ $setting->background_size == 'auto' ? 'selected' : '' }}>Автоматически</option>
                            <option value="100% 100%" {{ $setting->background_size == '100% 100%' ? 'selected' : '' }}>Растянуть</option>
                        </select>
                    </div>

                    <h3>📝 Заголовки</h3>

                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input type="text" name="title" id="title" value="{{ $setting->title }}" placeholder="Например: Свяжитесь с нами">
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Подзаголовок (опционально)</label>
                        <textarea name="subtitle" id="subtitle" placeholder="Например: Мы всегда рады ответить на ваши вопросы">{{ $setting->subtitle }}</textarea>
                    </div>

                    <h3>🗺️ Настройки карты</h3>

                    <div class="form-group">
                        <label for="map_embed_code">Код для вставки карты</label>
                        <textarea name="map_embed_code" id="map_embed_code" rows="6" placeholder='Например: <iframe src="https://yandex.ru/map-widget/..." width="100%" height="400"></iframe>'>{{ $setting->map_embed_code }}</textarea>
                        <small>Вставьте HTML-код карты от Яндекс.Карт, Google Maps, 2GIS или другого сервиса. Если оставить пустым, карта не будет отображаться.</small>
                        
                        <div style="margin-top: 10px; padding: 12px; background: #e7f3ff; border-left: 3px solid #2196F3; border-radius: 5px;">
                            <strong style="color: #1976D2;">💡 Как получить код карты:</strong>
                            <ul style="margin: 8px 0 0 20px; color: #1976D2; font-size: 13px;">
                                <li><strong>Яндекс.Карты:</strong> Откройте <a href="https://yandex.ru/map-constructor/" target="_blank" style="color: #1976D2;">Конструктор карт</a> → Укажите адрес → Нажмите "Сохранить и продолжить" → Скопируйте код</li>
                                <li><strong>Google Maps:</strong> Найдите место → Нажмите "Поделиться" → "Встроить карту" → Скопируйте код</li>
                                <li><strong>2GIS:</strong> Найдите место → "Поделиться" → "Встроить на сайт" → Скопируйте код</li>
                            </ul>
                        </div>
                    </div>

                    <details style="margin-top: 15px; padding: 15px; background: #f8f9fa; border-radius: 10px;">
                        <summary style="cursor: pointer; font-weight: 600; color: #667eea; margin-bottom: 10px;">📍 Альтернативные настройки (устаревшие, для Яндекс.Карт API)</summary>
                        
                        <div class="form-row" style="margin-top: 15px;">
                            <div class="form-group">
                                <label for="map_latitude">Широта (Latitude)</label>
                                <input type="text" name="map_latitude" id="map_latitude" value="{{ $setting->map_latitude }}" placeholder="Например: 55.751574">
                                <small>Координата широты для центра карты</small>
                            </div>

                            <div class="form-group">
                                <label for="map_longitude">Долгота (Longitude)</label>
                                <input type="text" name="map_longitude" id="map_longitude" value="{{ $setting->map_longitude }}" placeholder="Например: 37.573856">
                                <small>Координата долготы для центра карты</small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="map_zoom">Масштаб карты</label>
                            <input type="range" name="map_zoom" id="map_zoom" min="1" max="20" value="{{ $setting->map_zoom }}" oninput="document.getElementById('zoom_value').textContent = this.value">
                            <small>Текущее значение: <strong id="zoom_value">{{ $setting->map_zoom }}</strong></small>
                        </div>

                        <div class="form-group">
                            <label for="map_description">Описание для метки на карте</label>
                            <textarea name="map_description" id="map_description" rows="2" placeholder="Например: Наш питомник GreenPlant">{{ $setting->map_description }}</textarea>
                            <small>Текст, который будет отображаться при клике на метку</small>
                        </div>
                    </details>

                    <h3>📞 Секция "Свяжитесь с нами"</h3>

                    <div class="form-group">
                        <label for="contact_section_title">Заголовок секции</label>
                        <input type="text" name="contact_section_title" id="contact_section_title" value="{{ $setting->contact_section_title }}" placeholder="Например: Свяжитесь с нами">
                        <small>Заголовок секции с контактной информацией</small>
                    </div>

                    <div class="form-group">
                        <label for="contact_section_content">Контент секции</label>
                        <textarea name="contact_section_content" id="contact_section_content" rows="8" placeholder="Например: Мы всегда рады ответить на ваши вопросы...">{{ $setting->contact_section_content }}</textarea>
                        <small>Текст, который будет отображаться в секции с контактами. Можно использовать HTML-теги для форматирования.</small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $setting->is_active ? 'checked' : '' }}>
                            <label for="is_active">Активна</label>
                        </div>
                        <small>Если отключено, настройки не будут применяться к странице</small>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">💾 Сохранить изменения</button>
                        <a href="{{ route('admin.contact-page-settings.index') }}" class="btn btn-secondary">❌ Отмена</a>
                        <button type="button" class="btn btn-danger" onclick="if(confirm('Вы уверены, что хотите удалить эти настройки?')) { document.getElementById('delete-form').submit(); }">🗑️ Удалить</button>
                    </div>
                </form>

                <form id="delete-form" action="{{ route('admin.contact-page-settings.destroy', $setting->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
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
                // Если новое изображение не выбрано, используем существующее
                previewBackground.style.backgroundPosition = backgroundPosition;
                previewBackground.style.backgroundSize = backgroundSize;
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

