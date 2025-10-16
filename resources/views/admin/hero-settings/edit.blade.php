<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать настройки Hero-секции - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .page-header { margin-bottom: 30px; }
        .page-header h2 { font-size: 28px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; }
        input, textarea, select { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.3s; font-family: inherit; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #667eea; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .help-text { font-size: 13px; color: #666; margin-top: 5px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .invalid-feedback { color: #dc3545; font-size: 13px; margin-top: 5px; }
        .preview-box { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .preview-box h3 { margin-bottom: 15px; font-size: 16px; }
        .preview-demo { height: 200px; border-radius: 8px; position: relative; overflow: hidden; background: #82ae46; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; }
        .preview-demo .overlay-layer { position: absolute; top: 0; left: 0; right: 0; bottom: 0; pointer-events: none; }
        .range-input { width: 100%; }
        .range-value { display: inline-block; margin-left: 10px; font-weight: bold; color: #667eea; }
        .current-image { margin-bottom: 15px; }
        .current-image img { max-width: 100%; height: auto; border-radius: 8px; max-height: 300px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <div>
                <a href="{{ route('admin.hero-settings.index') }}">← Назад</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Редактировать настройки Hero-секции</h2>
        </div>

        <div class="card">
            <form action="{{ route('admin.hero-settings.update', $heroSetting->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="background_image">Фоновое изображение</label>
                    @if($heroSetting->background_image)
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $heroSetting->background_image) }}" alt="Current Background">
                            <p style="font-size: 12px; color: #666; margin-top: 5px;">Текущее изображение</p>
                        </div>
                    @endif
                    <input type="file" class="@error('background_image') is-invalid @enderror" id="background_image" name="background_image" accept="image/*" onchange="previewImage(this)">
                    @error('background_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Загрузите новое изображение для фона hero-секции (рекомендуемый размер: 1920x1080px)</div>
                    <div id="image-preview" style="margin-top: 15px; display: none;">
                        <img id="preview-img" src="" alt="Preview" style="max-width: 100%; height: auto; border-radius: 8px; max-height: 300px;">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="background_position">Позиция фона</label>
                        <select class="@error('background_position') is-invalid @enderror" id="background_position" name="background_position" onchange="updatePreview()">
                            <option value="center center" {{ old('background_position', $heroSetting->background_position) == 'center center' ? 'selected' : '' }}>По центру</option>
                            <option value="top center" {{ old('background_position', $heroSetting->background_position) == 'top center' ? 'selected' : '' }}>Сверху по центру</option>
                            <option value="bottom center" {{ old('background_position', $heroSetting->background_position) == 'bottom center' ? 'selected' : '' }}>Снизу по центру</option>
                            <option value="left center" {{ old('background_position', $heroSetting->background_position) == 'left center' ? 'selected' : '' }}>Слева по центру</option>
                            <option value="right center" {{ old('background_position', $heroSetting->background_position) == 'right center' ? 'selected' : '' }}>Справа по центру</option>
                            <option value="top left" {{ old('background_position', $heroSetting->background_position) == 'top left' ? 'selected' : '' }}>Сверху слева</option>
                            <option value="top right" {{ old('background_position', $heroSetting->background_position) == 'top right' ? 'selected' : '' }}>Сверху справа</option>
                            <option value="bottom left" {{ old('background_position', $heroSetting->background_position) == 'bottom left' ? 'selected' : '' }}>Снизу слева</option>
                            <option value="bottom right" {{ old('background_position', $heroSetting->background_position) == 'bottom right' ? 'selected' : '' }}>Снизу справа</option>
                            <option value="custom" {{ old('background_position', $heroSetting->background_position) == 'custom' ? 'selected' : '' }}>Своя позиция</option>
                        </select>
                        @error('background_position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Выберите позицию фонового изображения</div>
                    </div>
                    <div class="form-group" id="custom-position-field" style="display: none;">
                        <label for="background_position_custom">Своя позиция (например: 30% 70%)</label>
                        <input type="text" class="@error('background_position') is-invalid @enderror" id="background_position_custom" name="background_position" value="{{ old('background_position', $heroSetting->background_position) }}" placeholder="30% 70%">
                        @error('background_position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="background_size">Размер фона</label>
                        <select class="@error('background_size') is-invalid @enderror" id="background_size" name="background_size" onchange="updatePreview()">
                            <option value="cover" {{ old('background_size', $heroSetting->background_size) == 'cover' ? 'selected' : '' }}>Cover (заполнить)</option>
                            <option value="contain" {{ old('background_size', $heroSetting->background_size) == 'contain' ? 'selected' : '' }}>Contain (вписать)</option>
                            <option value="auto" {{ old('background_size', $heroSetting->background_size) == 'auto' ? 'selected' : '' }}>Auto (оригинал)</option>
                            <option value="100% 100%" {{ old('background_size', $heroSetting->background_size) == '100% 100%' ? 'selected' : '' }}>Растянуть (100%)</option>
                            <option value="custom" {{ old('background_size', $heroSetting->background_size) == 'custom' ? 'selected' : '' }}>Свой размер</option>
                        </select>
                        @error('background_size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Выберите размер фонового изображения</div>
                    </div>
                    <div class="form-group" id="custom-size-field" style="display: none;">
                        <label for="background_size_custom">Свой размер (например: 150% 150%)</label>
                        <input type="text" class="@error('background_size') is-invalid @enderror" id="background_size_custom" name="background_size" value="{{ old('background_size', $heroSetting->background_size) }}" placeholder="150% 150%">
                        @error('background_size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="background_color">Цвет фона (если нет изображения)</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="color" id="background_color_picker" value="{{ old('background_color', $heroSetting->background_color) }}" style="width: 60px; height: 40px; border: none; border-radius: 8px; cursor: pointer;">
                            <input type="text" class="@error('background_color') is-invalid @enderror" id="background_color" name="background_color" value="{{ old('background_color', $heroSetting->background_color) }}" placeholder="#82ae46" style="flex: 1;">
                        </div>
                        @error('background_color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="is_active">Активировать</label>
                        <select class="@error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', $heroSetting->is_active) == 1 ? 'selected' : '' }}>Да</option>
                            <option value="0" {{ old('is_active', $heroSetting->is_active) == 0 ? 'selected' : '' }}>Нет</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="overlay_type">Тип наложения</label>
                    <select class="@error('overlay_type') is-invalid @enderror" id="overlay_type" name="overlay_type" required onchange="updatePreview()">
                        <option value="darken" {{ old('overlay_type', $heroSetting->overlay_type) == 'darken' ? 'selected' : '' }}>Затемнение</option>
                        <option value="lighten" {{ old('overlay_type', $heroSetting->overlay_type) == 'lighten' ? 'selected' : '' }}>Осветление</option>
                        <option value="none" {{ old('overlay_type', $heroSetting->overlay_type) == 'none' ? 'selected' : '' }}>Без наложения</option>
                    </select>
                    @error('overlay_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Выберите тип наложения для фонового изображения</div>
                </div>

                <div class="form-group">
                    <label for="overlay_opacity">Прозрачность наложения: <span class="range-value" id="opacity-value">{{ old('overlay_opacity', $heroSetting->overlay_opacity) }}</span>%</label>
                    <input type="range" class="range-input @error('overlay_opacity') is-invalid @enderror" id="overlay_opacity" name="overlay_opacity" min="0" max="100" value="{{ old('overlay_opacity', $heroSetting->overlay_opacity) }}" oninput="updateOpacity(this.value)">
                    @error('overlay_opacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Отрегулируйте прозрачность наложения (0% - полностью прозрачно, 100% - полностью непрозрачно)</div>
                </div>

                <div class="preview-box">
                    <h3>Предпросмотр</h3>
                    <div class="preview-demo" id="preview-demo" style="background: {{ $heroSetting->background_color }}; @if($heroSetting->background_image) background-image: url('{{ asset('storage/' . $heroSetting->background_image) }}'); background-size: cover; background-position: center; @endif">
                        <div class="overlay-layer" id="overlay-layer"></div>
                        <span style="position: relative; z-index: 1;">Hero Section</span>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    <a href="{{ route('admin.hero-settings.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                    updatePreview();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function toggleCustomFields() {
            const positionValue = document.getElementById('background_position').value;
            const sizeValue = document.getElementById('background_size').value;
            
            // Показываем/скрываем поле кастомной позиции
            const customPositionField = document.getElementById('custom-position-field');
            if (positionValue === 'custom') {
                customPositionField.style.display = 'block';
            } else {
                customPositionField.style.display = 'none';
            }
            
            // Показываем/скрываем поле кастомного размера
            const customSizeField = document.getElementById('custom-size-field');
            if (sizeValue === 'custom') {
                customSizeField.style.display = 'block';
            } else {
                customSizeField.style.display = 'none';
            }
        }

        function updateOpacity(value) {
            document.getElementById('opacity-value').textContent = value;
            updatePreview();
        }

        function updatePreview() {
            const preview = document.getElementById('preview-demo');
            const overlayType = document.getElementById('overlay_type').value;
            const opacity = document.getElementById('overlay_opacity').value;
            const overlayLayer = document.getElementById('overlay-layer');
            const backgroundPosition = document.getElementById('background_position').value;
            const backgroundSize = document.getElementById('background_size').value;
            
            // Обновляем фоновое изображение
            const fileInput = document.getElementById('background_image');
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.style.backgroundImage = 'url(' + e.target.result + ')';
                    preview.style.backgroundPosition = backgroundPosition;
                    preview.style.backgroundSize = backgroundSize;
                    preview.style.backgroundRepeat = 'no-repeat';
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                // Используем текущее изображение если есть
                @if($heroSetting->background_image)
                preview.style.backgroundImage = 'url({{ asset('storage/' . $heroSetting->background_image) }})';
                preview.style.backgroundPosition = backgroundPosition;
                preview.style.backgroundSize = backgroundSize;
                preview.style.backgroundRepeat = 'no-repeat';
                @endif
            }
            
            // Скрываем overlay если выбран "none"
            if (overlayType === 'none') {
                overlayLayer.style.display = 'none';
            } else {
                overlayLayer.style.display = 'block';
                
                // Устанавливаем цвет и прозрачность
                if (overlayType === 'darken') {
                    overlayLayer.style.background = `rgba(0, 0, 0, ${opacity / 100})`;
                } else if (overlayType === 'lighten') {
                    overlayLayer.style.background = `rgba(255, 255, 255, ${opacity / 100})`;
                }
            }
        }

        // Синхронизация color picker и текстового поля
        document.addEventListener('DOMContentLoaded', function() {
            const picker = document.getElementById('background_color_picker');
            const textField = document.getElementById('background_color');
            
            if (picker && textField) {
                picker.addEventListener('input', function() {
                    textField.value = this.value;
                    document.getElementById('preview-demo').style.backgroundColor = this.value;
                });
                
                textField.addEventListener('input', function() {
                    if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                        picker.value = this.value;
                        document.getElementById('preview-demo').style.backgroundColor = this.value;
                    }
                });
            }

            // Инициализируем предпросмотр
            toggleCustomFields();
            updatePreview();
            
            // Добавляем обработчики событий
            document.getElementById('background_position').addEventListener('change', function() {
                toggleCustomFields();
                updatePreview();
            });
            document.getElementById('background_size').addEventListener('change', function() {
                toggleCustomFields();
                updatePreview();
            });
        });
    </script>
</body>
</html>

