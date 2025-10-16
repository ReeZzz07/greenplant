<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки личного кабинета - GreenPlant</title>
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
        .form-group input[type="range"],
        .form-group select,
        .form-group textarea { width: 100%; padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 14px; transition: all 0.3s; }
        .form-group input[type="text"]:focus,
        .form-group select:focus,
        .form-group textarea:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-group textarea { min-height: 100px; resize: vertical; }
        .form-group small { display: block; margin-top: 5px; color: #6c757d; font-size: 13px; }
        .btn { padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-size: 14px; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }
        .btn-group { display: flex; gap: 10px; margin-top: 30px; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-info { background: #e7f3ff; color: #004085; border-left: 4px solid #007bff; }
        .image-preview-container { margin-top: 15px; }
        .image-preview { max-width: 100%; max-height: 300px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .current-image { margin-top: 10px; }
        h3.section-title { margin: 30px 0 20px 0; color: #667eea; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; }
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
            <h2>👤 Настройки личного кабинета</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="alert alert-info">
            <h4 style="margin: 0 0 10px 0;">ℹ️ Информация</h4>
            <p style="margin: 0;">Здесь можно настроить фоновое изображение для hero-секции всех страниц личного кабинета покупателя. Настройки применяются ко всем страницам: обзор, заказы, адреса, профиль, вход/регистрация.</p>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.account-page-settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="hero_background_image">🖼️ Фоновое изображение</label>
                        @if($setting->hero_background_image)
                            <div class="current-image">
                                <strong>Текущее изображение:</strong><br>
                                <img src="{{ asset('storage/' . $setting->hero_background_image) }}" alt="Current" class="image-preview" id="current-image">
                                <form action="{{ route('admin.account-page-settings.delete-image') }}" method="POST" style="display: inline; margin-top: 10px;" onsubmit="return confirm('Удалить текущее изображение? Будет использоваться изображение по умолчанию.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="margin-top: 10px;">🗑️ Удалить изображение</button>
                                </form>
                            </div>
                        @endif
                        <input type="file" name="hero_background_image" id="hero_background_image" accept="image/*" onchange="previewImage(this)">
                        <small>Рекомендуемый размер: 1920x400px. Форматы: JPG, PNG, WEBP (макс. 2 МБ)</small>
                        <div class="image-preview-container" id="preview-container" style="display: none;">
                            <strong>Новое изображение:</strong><br>
                            <img id="preview" class="image-preview" src="" alt="Preview">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>👁️ Предпросмотр в реальном времени</label>
                        <div id="preview-box" style="width: 100%; height: 250px; border: 2px solid #e9ecef; border-radius: 10px; position: relative; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                            <div id="preview-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-size: {{ $setting->background_size }}; background-position: {{ $setting->background_position }}; background-repeat: no-repeat; @if($setting->hero_background_image) background-image: url('{{ asset('storage/' . $setting->hero_background_image) }}'); @else background-image: url('{{ asset('assets/images/bg_6.jpg') }}'); @endif"></div>
                            <div id="preview-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
                            <div id="preview-content" style="position: relative; z-index: 1; text-align: center; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                                <h3 style="margin: 0; font-size: 32px; font-weight: bold;">Личный кабинет</h3>
                                <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.95;">Управление заказами и настройками</p>
                            </div>
                        </div>
                        <small>💡 Изменения отображаются мгновенно при настройке параметров ниже</small>
                    </div>

                    <h3 class="section-title">🎨 Настройки наложения</h3>

                    <div class="form-group">
                        <label for="overlay_type">Тип наложения</label>
                        <select name="overlay_type" id="overlay_type">
                            <option value="none" {{ old('overlay_type', $setting->overlay_type) == 'none' ? 'selected' : '' }}>Без наложения</option>
                            <option value="darken" {{ old('overlay_type', $setting->overlay_type) == 'darken' ? 'selected' : '' }}>Затемнение</option>
                            <option value="lighten" {{ old('overlay_type', $setting->overlay_type) == 'lighten' ? 'selected' : '' }}>Осветление</option>
                        </select>
                        <small>Выберите тип наложения для улучшения читаемости текста</small>
                    </div>

                    <div class="form-group">
                        <label for="overlay_opacity">Прозрачность наложения (%)</label>
                        <input type="range" name="overlay_opacity" id="overlay_opacity" min="0" max="100" value="{{ old('overlay_opacity', $setting->overlay_opacity) }}" oninput="document.getElementById('opacity_value').textContent = this.value">
                        <small>Текущее значение: <strong id="opacity_value">{{ old('overlay_opacity', $setting->overlay_opacity) }}</strong>%</small>
                    </div>

                    <h3 class="section-title">📍 Позиционирование фона</h3>

                    <div class="form-group">
                        <label for="background_position">Позиция фона</label>
                        <select name="background_position" id="background_position">
                            <option value="left top" {{ old('background_position', $setting->background_position) == 'left top' ? 'selected' : '' }}>Слева сверху</option>
                            <option value="center top" {{ old('background_position', $setting->background_position) == 'center top' ? 'selected' : '' }}>По центру сверху</option>
                            <option value="right top" {{ old('background_position', $setting->background_position) == 'right top' ? 'selected' : '' }}>Справа сверху</option>
                            <option value="left center" {{ old('background_position', $setting->background_position) == 'left center' ? 'selected' : '' }}>Слева по центру</option>
                            <option value="center center" {{ old('background_position', $setting->background_position) == 'center center' ? 'selected' : '' }}>По центру</option>
                            <option value="right center" {{ old('background_position', $setting->background_position) == 'right center' ? 'selected' : '' }}>Справа по центру</option>
                            <option value="left bottom" {{ old('background_position', $setting->background_position) == 'left bottom' ? 'selected' : '' }}>Слева снизу</option>
                            <option value="center bottom" {{ old('background_position', $setting->background_position) == 'center bottom' ? 'selected' : '' }}>По центру снизу</option>
                            <option value="right bottom" {{ old('background_position', $setting->background_position) == 'right bottom' ? 'selected' : '' }}>Справа снизу</option>
                        </select>
                        <small>Выберите позицию фонового изображения</small>
                    </div>

                    <div class="form-group">
                        <label for="background_size">Размер фона</label>
                        <select name="background_size" id="background_size">
                            <option value="cover" {{ old('background_size', $setting->background_size) == 'cover' ? 'selected' : '' }}>Покрыть всю область (рекомендуется)</option>
                            <option value="contain" {{ old('background_size', $setting->background_size) == 'contain' ? 'selected' : '' }}>Вместить полностью</option>
                            <option value="auto" {{ old('background_size', $setting->background_size) == 'auto' ? 'selected' : '' }}>Автоматически</option>
                            <option value="100% 100%" {{ old('background_size', $setting->background_size) == '100% 100%' ? 'selected' : '' }}>Растянуть</option>
                        </select>
                        <small>Выберите как изображение должно масштабироваться</small>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">💾 Сохранить настройки</button>
                    </div>
                </form>
            </div>
        </div>

        <div style="background: #fff3cd; padding: 20px; border-radius: 12px; border-left: 4px solid #ffc107; margin-top: 20px;">
            <h4 style="margin: 0 0 10px 0; color: #856404;">📝 Где используется</h4>
            <p style="margin: 0 0 10px; color: #856404;">Фоновое изображение и настройки применяются ко всем страницам личного кабинета:</p>
            <ul style="margin: 0; padding-left: 20px; color: #856404;">
                <li><code>/account</code> - Обзор личного кабинета</li>
                <li><code>/account/orders</code> - Мои заказы</li>
                <li><code>/account/addresses</code> - Адреса доставки</li>
                <li><code>/account/profile</code> - Настройки профиля</li>
                <li><code>/customer-login</code> - Вход/Регистрация покупателей</li>
            </ul>
            <p style="margin: 15px 0 0; color: #856404;"><strong>Примечание:</strong> Если изображение не загружено, используется изображение по умолчанию <code>/assets/images/bg_6.jpg</code></p>
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
            const fileInput = document.getElementById('hero_background_image');
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
                // Используем текущее изображение
                const currentImage = document.getElementById('current-image');
                if (currentImage) {
                    previewBackground.style.backgroundImage = 'url(' + currentImage.src + ')';
                } else {
                    // Используем изображение по умолчанию
                    previewBackground.style.backgroundImage = 'url({{ asset('assets/images/bg_6.jpg') }})';
                }
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
