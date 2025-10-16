<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать преимущество - GreenPlant</title>
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
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <div>
                <a href="{{ route('admin.home-page-features.index') }}">← Назад</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Создать новое преимущество</h2>
        </div>

        <div class="card">
            <form action="{{ route('admin.home-page-features.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="icon_type">Тип иконки *</label>
                    <select class="@error('icon_type') is-invalid @enderror" id="icon_type" name="icon_type" required onchange="toggleIconFields()">
                        <option value="flaticon" {{ old('icon_type') == 'flaticon' ? 'selected' : '' }}>Flaticon (из набора)</option>
                        <option value="image" {{ old('icon_type') == 'image' ? 'selected' : '' }}>Изображение (PNG/SVG)</option>
                        <option value="custom" {{ old('icon_type') == 'custom' ? 'selected' : '' }}>Кастомный код</option>
                    </select>
                    @error('icon_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Выберите тип иконки для отображения преимущества</div>
                </div>

                <div class="form-group" id="flaticon-field" style="display: none;">
                    <label for="icon">Иконка Flaticon</label>
                    <select class="@error('icon') is-invalid @enderror" id="icon" name="icon">
                        <option value="">Выберите иконку</option>
                        <option value="flaticon-bag" {{ old('icon') == 'flaticon-bag' ? 'selected' : '' }}>🛍️ Корзина (flaticon-bag)</option>
                        <option value="flaticon-customer-service" {{ old('icon') == 'flaticon-customer-service' ? 'selected' : '' }}>📞 Поддержка (flaticon-customer-service)</option>
                        <option value="flaticon-payment-security" {{ old('icon') == 'flaticon-payment-security' ? 'selected' : '' }}>🔒 Безопасность (flaticon-payment-security)</option>
                        <option value="flaticon-heart-box" {{ old('icon') == 'flaticon-heart-box' ? 'selected' : '' }}>❤️ Сердце (flaticon-heart-box)</option>
                    </select>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Выберите иконку из набора Flaticon</div>
                </div>

                <div class="form-group" id="image-field" style="display: none;">
                    <label for="icon_image">Загрузить изображение иконки</label>
                    <input type="file" class="@error('icon_image') is-invalid @enderror" id="icon_image" name="icon_image" accept="image/png,image/svg+xml,image/jpeg">
                    @error('icon_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Загрузите изображение в формате PNG, SVG или JPEG (макс. 2MB)</div>
                </div>

                <div class="form-group" id="custom-field" style="display: none;">
                    <label for="icon">Кастомный код иконки</label>
                    <input type="text" class="@error('icon') is-invalid @enderror" id="icon_custom" name="icon" value="{{ old('icon') }}" placeholder="Например: &lt;i class='fas fa-star'&gt;&lt;/i&gt;">
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Введите HTML код иконки (например, Font Awesome, или любой другой)</div>
                    <div style="margin-top: 10px; padding: 10px; background: #f8f9fa; border-radius: 8px; font-size: 13px;">
                        <strong>Примеры Font Awesome:</strong><br>
                        • Доставка: <code>&lt;i class="fas fa-truck"&gt;&lt;/i&gt;</code><br>
                        • Поддержка: <code>&lt;i class="fas fa-headset"&gt;&lt;/i&gt;</code><br>
                        • Гарантия: <code>&lt;i class="fas fa-shield-alt"&gt;&lt;/i&gt;</code><br>
                        • Качество: <code>&lt;i class="fas fa-award"&gt;&lt;/i&gt;</code><br>
                        • Растение: <code>&lt;i class="fas fa-seedling"&gt;&lt;/i&gt;</code>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="icon_size">Размер иконки</label>
                        <select class="@error('icon_size') is-invalid @enderror" id="icon_size" name="icon_size">
                            <option value="32px" {{ old('icon_size', '48px') == '32px' ? 'selected' : '' }}>Маленький (32px)</option>
                            <option value="48px" {{ old('icon_size', '48px') == '48px' ? 'selected' : '' }}>Средний (48px)</option>
                            <option value="64px" {{ old('icon_size', '48px') == '64px' ? 'selected' : '' }}>Большой (64px)</option>
                            <option value="80px" {{ old('icon_size', '48px') == '80px' ? 'selected' : '' }}>Очень большой (80px)</option>
                            <option value="custom" {{ old('icon_size', '48px') == 'custom' ? 'selected' : '' }}>Свой размер</option>
                        </select>
                        @error('icon_size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group" id="custom-size-field" style="display: none;">
                        <label for="icon_size_custom">Свой размер (например: 56px)</label>
                        <input type="text" class="@error('icon_size') is-invalid @enderror" id="icon_size_custom" name="icon_size" value="{{ old('icon_size') }}" placeholder="56px">
                        @error('icon_size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="icon_color">Цвет иконки (необязательно)</label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <input type="color" id="icon_color_picker" value="{{ old('icon_color', '#82ae46') }}" style="width: 60px; height: 40px; border: none; border-radius: 8px; cursor: pointer;">
                            <input type="text" class="@error('icon_color') is-invalid @enderror" id="icon_color" name="icon_color" value="{{ old('icon_color', '#82ae46') }}" placeholder="#82ae46" style="flex: 1;">
                        </div>
                        @error('icon_color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Выберите цвет иконки или оставьте пустым для цвета по умолчанию</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="title">Заголовок *</label>
                    <input type="text" class="@error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Описание *</label>
                    <textarea class="@error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="order">Порядок отображения</label>
                        <input type="number" class="@error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', 0) }}">
                    </div>
                    <div class="form-group">
                        <label for="is_active">Статус</label>
                        <select class="@error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Активен</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Неактивен</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Создать преимущество</button>
                    <a href="{{ route('admin.home-page-features.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleIconFields() {
            const iconType = document.getElementById('icon_type').value;
            
            // Скрываем все поля
            document.getElementById('flaticon-field').style.display = 'none';
            document.getElementById('image-field').style.display = 'none';
            document.getElementById('custom-field').style.display = 'none';
            
            // Показываем нужное поле
            if (iconType === 'flaticon') {
                document.getElementById('flaticon-field').style.display = 'block';
            } else if (iconType === 'image') {
                document.getElementById('image-field').style.display = 'block';
            } else if (iconType === 'custom') {
                document.getElementById('custom-field').style.display = 'block';
            }
        }

        function toggleCustomSize() {
            const iconSize = document.getElementById('icon_size').value;
            const customSizeField = document.getElementById('custom-size-field');
            
            if (iconSize === 'custom') {
                customSizeField.style.display = 'block';
            } else {
                customSizeField.style.display = 'none';
            }
        }

        // Синхронизация color picker и текстового поля
        function syncColorPicker() {
            const picker = document.getElementById('icon_color_picker');
            const textField = document.getElementById('icon_color');
            
            if (picker && textField) {
                picker.addEventListener('input', function() {
                    textField.value = this.value;
                });
                
                textField.addEventListener('input', function() {
                    if (this.value.match(/^#[0-9A-F]{6}$/i)) {
                        picker.value = this.value;
                    }
                });
            }
        }

        // Вызываем при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            toggleIconFields();
            toggleCustomSize();
            syncColorPicker();
            
            // Добавляем обработчики событий
            document.getElementById('icon_size').addEventListener('change', toggleCustomSize);
        });
    </script>
</body>
</html>
