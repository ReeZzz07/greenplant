<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товары - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .header a:hover { background: rgba(255,255,255,0.3); }
        .container { max-width: 1400px; margin: 40px auto; padding: 0 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-header h2 { font-size: 28px; }
        .btn { padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-size: 14px; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-warning { background: #ffc107; color: #333; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8f9fa; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; }
        td { color: #212529; }
        .product-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
        .badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .actions { display: flex; gap: 8px; }
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
        .empty-state-icon { font-size: 64px; margin-bottom: 20px; }
        .pagination { display: flex; gap: 10px; justify-content: center; margin-top: 30px; }
        .pagination a { padding: 8px 16px; background: white; border-radius: 8px; text-decoration: none; color: #667eea; }
        .pagination a:hover { background: #667eea; color: white; }
        .price { font-weight: 600; color: #28a745; }
        .old-price { text-decoration: line-through; color: #999; font-size: 12px; }
        .hero-settings-card { padding: 35px 40px; margin-bottom: 30px; }
        .hero-settings-card h3 { margin-bottom: 15px; font-size: 20px; color: #2f3367; }
        .hero-settings-description { color: #555; margin-bottom: 25px; line-height: 1.6; }
        .hero-settings-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .form-group { margin-bottom: 20px; }
        label { font-weight: 600; color: #2f3367; margin-bottom: 8px; display: block; }
        .help-text { font-size: 13px; color: #6c757d; margin-top: 6px; }
        .preview-box { background: #f8f9fb; border-radius: 12px; padding: 20px; }
        .preview-box h4 { margin-bottom: 15px; font-size: 16px; color: #2f3367; }
        .preview-hero { height: 220px; border-radius: 12px; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 24px; text-align: center; }
        .preview-hero .overlay-layer { position: absolute; inset: 0; pointer-events: none; border-radius: inherit; }
        .range-value { font-weight: 600; color: #667eea; margin-left: 8px; }
        .field-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
        .current-image { border: 1px dashed #dce1f5; border-radius: 12px; padding: 15px; background: #fff; margin-bottom: 15px; }
        .current-image img { max-width: 100%; height: auto; border-radius: 10px; }
        .toggle-group { display: flex; gap: 10px; align-items: center; }
        .toggle-group input[type="color"] { width: 60px; height: 40px; border: none; border-radius: 10px; cursor: pointer; }
        @media (max-width: 768px) {
            .hero-settings-card { padding: 25px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
                <a href="{{ route('admin.settings.index') }}">← Назад к настройкам</a>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Товары</h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Добавить товар</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @php
            $positionValue = old('background_position', $productHeroSetting->background_position);
            $sizeValue = old('background_size', $productHeroSetting->background_size);
            $overlayTypeValue = old('overlay_type', $productHeroSetting->overlay_type);
            $overlayOpacityValue = old('overlay_opacity', $productHeroSetting->overlay_opacity);
            $backgroundColorValue = old('background_color', $productHeroSetting->background_color);
            $isActiveValue = old('is_active', $productHeroSetting->is_active ? 1 : 0);
            $effectiveBackgroundImage = $productHeroSetting->background_image
                ? asset('storage/' . $productHeroSetting->background_image)
                : asset('assets/images/bg_6.jpg');
        @endphp

        <div class="card hero-settings-card">
            <h3>🎨 Настройки hero-секции страницы товара</h3>
            <p class="hero-settings-description">
                Управляйте фоном секции hero, которая отображается на странице просмотра товара. Настройки аналогичны странице «Редактировать настройки Hero-секции».
            </p>

            <form id="product-hero-settings-form" action="{{ route('admin.product-hero-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="background_position" id="background_position" value="{{ $positionValue }}">
                <input type="hidden" name="background_size" id="background_size" value="{{ $sizeValue }}">

                <div class="hero-settings-grid">
                    <div>
                        <div class="form-group">
                            <label for="background_image">Фоновое изображение</label>
                            @if($productHeroSetting->background_image)
                                <div class="current-image">
                                    <img src="{{ asset('storage/' . $productHeroSetting->background_image) }}" alt="Текущее изображение" id="current-background-image">
                                    <div class="help-text">Текущее изображение hero-секции</div>
                                </div>
                            @endif
                            <input type="file" id="background_image" name="background_image" accept="image/*">
                            @error('background_image')
                                <div style="color: #dc3545; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                            @enderror
                            <div class="help-text">Рекомендуемый размер изображения: 1920×600 px</div>
                            @if($productHeroSetting->background_image)
                                <label class="toggle-group" style="margin-top: 10px;">
                                    <input type="checkbox" name="remove_background_image" value="1">
                                    <span>Удалить текущее изображение</span>
                                </label>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="overlay_type">Тип наложения</label>
                            <select id="overlay_type" name="overlay_type" required>
                                <option value="darken" {{ $overlayTypeValue === 'darken' ? 'selected' : '' }}>Затемнение</option>
                                <option value="lighten" {{ $overlayTypeValue === 'lighten' ? 'selected' : '' }}>Осветление</option>
                                <option value="none" {{ $overlayTypeValue === 'none' ? 'selected' : '' }}>Без наложения</option>
                            </select>
                            @error('overlay_type')
                                <div style="color: #dc3545; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="overlay_opacity">Прозрачность наложения: <span class="range-value" id="opacity-value">{{ $overlayOpacityValue }}</span>%</label>
                            <input type="range" id="overlay_opacity" name="overlay_opacity" min="0" max="100" value="{{ $overlayOpacityValue }}">
                            @error('overlay_opacity')
                                <div style="color: #dc3545; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="is_active">Активировать hero-секцию</label>
                            <select id="is_active" name="is_active" required>
                                <option value="1" {{ (int) $isActiveValue === 1 ? 'selected' : '' }}>Да</option>
                                <option value="0" {{ (int) $isActiveValue === 0 ? 'selected' : '' }}>Нет</option>
                            </select>
                            @error('is_active')
                                <div style="color: #dc3545; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="background_position_select">Позиция фонового изображения</label>
                            <select id="background_position_select">
                                <option value="center center">По центру</option>
                                <option value="top center">Сверху по центру</option>
                                <option value="bottom center">Снизу по центру</option>
                                <option value="left center">Слева по центру</option>
                                <option value="right center">Справа по центру</option>
                                <option value="top left">Сверху слева</option>
                                <option value="top right">Сверху справа</option>
                                <option value="bottom left">Снизу слева</option>
                                <option value="bottom right">Снизу справа</option>
                                <option value="custom">Своя позиция</option>
                            </select>
                            <div id="background_position_custom_wrapper" style="display: none; margin-top: 10px;">
                                <input type="text" id="background_position_custom" placeholder="Например: 40% 70%">
                            </div>
                            @error('background_position')
                                <div style="color: #dc3545; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="background_size_select">Размер фонового изображения</label>
                            <select id="background_size_select">
                                <option value="cover">Cover (заполнить)</option>
                                <option value="contain">Contain (вписать)</option>
                                <option value="auto">Auto (оригинал)</option>
                                <option value="100% 100%">Растянуть (100%)</option>
                                <option value="custom">Свой размер</option>
                            </select>
                            <div id="background_size_custom_wrapper" style="display: none; margin-top: 10px;">
                                <input type="text" id="background_size_custom" placeholder="Например: 150% 150%">
                            </div>
                            @error('background_size')
                                <div style="color: #dc3545; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Цвет фона (если нет изображения)</label>
                            <div class="toggle-group">
                                <input type="color" id="background_color_picker" value="{{ $backgroundColorValue ?? '#82ae46' }}">
                                <input type="text" id="background_color" name="background_color" value="{{ $backgroundColorValue ?? '#82ae46' }}" placeholder="#82ae46" style="flex: 1; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px;">
                            </div>
                            @error('background_color')
                                <div style="color: #dc3545; font-size: 13px; margin-top: 6px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="preview-box">
                            <h4>Предпросмотр hero-секции</h4>
                            <div
                                class="preview-hero"
                                id="product-hero-preview"
                                style="background-color: {{ $backgroundColorValue ?? '#82ae46' }};
                                    @if($productHeroSetting->background_image)
                                        background-image: url('{{ asset('storage/' . $productHeroSetting->background_image) }}');
                                        background-position: {{ $positionValue }};
                                        background-size: {{ $sizeValue }};
                                        background-repeat: no-repeat;
                                    @endif
                                "
                            >
                                <div
                                    class="overlay-layer"
                                    id="product-hero-overlay"
                                    style="
                                        @if($overlayTypeValue === 'none')
                                            display: none;
                                        @else
                                            background: {{ $overlayTypeValue === 'darken'
                                                ? 'rgba(0, 0, 0, ' . ($overlayOpacityValue / 100) . ')'
                                                : 'rgba(255, 255, 255, ' . ($overlayOpacityValue / 100) . ')' }};
                                        @endif
                                    "
                                ></div>
                                <span style="position: relative; z-index: 1;">Hero товара</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 25px; display: flex; gap: 12px; flex-wrap: wrap;">
                    <button type="submit" class="btn btn-primary">💾 Сохранить настройки</button>
                    <a href="{{ route('admin.hero-settings.index') }}" class="btn btn-secondary">Открыть настройки главного hero</a>
                </div>
            </form>
        </div>

        <div class="card">
            @if($products->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Название</th>
                            <th>Категория</th>
                            <th>Цена</th>
                            <th>Остаток</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-img">
                                @else
                                    <div style="width: 60px; height: 60px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">🌲</div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->is_featured)
                                    <span class="badge badge-warning">Хит</span>
                                @endif
                            </td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>
                                <div class="price">{{ number_format($product->price, 0, ',', ' ') }} ₽</div>
                                @if($product->old_price)
                                    <div class="old-price">{{ number_format($product->old_price, 0, ',', ' ') }} ₽</div>
                                @endif
                            </td>
                            <td>{{ $product->stock ?? 0 }} шт.</td>
                            <td>
                                <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $product->is_active ? 'Активен' : 'Скрыт' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">Изменить</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить товар?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $products->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3>Пока нет товаров</h3>
                    <p>Добавьте первый товар, чтобы начать работу</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="margin-top: 20px;">+ Добавить товар</a>
                </div>
            @endif
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('product-hero-settings-form');
        if (!form) {
            return;
        }

        const initialPosition = @json($positionValue);
        const initialSize = @json($sizeValue);
        const initialColor = @json($backgroundColorValue ?? '#82ae46');
        const storedImage = @json($productHeroSetting->background_image ? asset('storage/' . $productHeroSetting->background_image) : null);
        const fallbackImage = @json($effectiveBackgroundImage);

        const positionHidden = document.getElementById('background_position');
        const sizeHidden = document.getElementById('background_size');
        const positionSelect = document.getElementById('background_position_select');
        const sizeSelect = document.getElementById('background_size_select');
        const positionCustomWrapper = document.getElementById('background_position_custom_wrapper');
        const positionCustomInput = document.getElementById('background_position_custom');
        const sizeCustomWrapper = document.getElementById('background_size_custom_wrapper');
        const sizeCustomInput = document.getElementById('background_size_custom');
        const overlayTypeSelect = document.getElementById('overlay_type');
        const overlayOpacityInput = document.getElementById('overlay_opacity');
        const opacityValue = document.getElementById('opacity-value');
        const colorPicker = document.getElementById('background_color_picker');
        const colorInput = document.getElementById('background_color');
        const fileInput = document.getElementById('background_image');
        const removeCheckbox = form.querySelector('input[name="remove_background_image"]');
        const preview = document.getElementById('product-hero-preview');
        const overlayLayer = document.getElementById('product-hero-overlay');

        const optionValues = Array.from(positionSelect.options).map(option => option.value);
        const sizeOptionValues = Array.from(sizeSelect.options).map(option => option.value);

        function applyBackgroundImage(url) {
            if (url) {
                preview.style.backgroundImage = `url('${url}')`;
                preview.style.backgroundRepeat = 'no-repeat';
                preview.style.backgroundPosition = positionHidden.value || 'center center';
                preview.style.backgroundSize = sizeHidden.value || 'cover';
            } else {
                preview.style.backgroundImage = 'none';
            }
        }

        function updateOverlay() {
            const overlayType = overlayTypeSelect.value;
            const opacity = Number(overlayOpacityInput.value || 0) / 100;

            if (overlayType === 'none') {
                overlayLayer.style.display = 'none';
            } else {
                overlayLayer.style.display = 'block';
                if (overlayType === 'darken') {
                    overlayLayer.style.background = `rgba(0, 0, 0, ${opacity})`;
                } else {
                    overlayLayer.style.background = `rgba(255, 255, 255, ${opacity})`;
                }
            }
            opacityValue.textContent = overlayOpacityInput.value;
        }

        function syncPosition(value) {
            const matched = optionValues.includes(value);
            if (matched) {
                positionSelect.value = value;
                positionCustomWrapper.style.display = 'none';
                positionCustomInput.value = '';
            } else {
                positionSelect.value = 'custom';
                positionCustomWrapper.style.display = 'block';
                positionCustomInput.value = value || '';
            }
            positionHidden.value = value || 'center center';
            preview.style.backgroundPosition = positionHidden.value;
        }

        function syncSize(value) {
            const matched = sizeOptionValues.includes(value);
            if (matched) {
                sizeSelect.value = value;
                sizeCustomWrapper.style.display = 'none';
                sizeCustomInput.value = '';
            } else {
                sizeSelect.value = 'custom';
                sizeCustomWrapper.style.display = 'block';
                sizeCustomInput.value = value || '';
            }
            sizeHidden.value = value || 'cover';
            preview.style.backgroundSize = sizeHidden.value;
        }

        function updateBackgroundColor(color) {
            if (color && /^#([0-9a-f]{3}){1,2}$/i.test(color)) {
                preview.style.backgroundColor = color;
                if (colorPicker.value !== color) {
                    colorPicker.value = color;
                }
            }
        }

        // Initialize values
        syncPosition(initialPosition);
        syncSize(initialSize);
        updateBackgroundColor(initialColor || '#82ae46');
        applyBackgroundImage(storedImage || fallbackImage);
        updateOverlay();

        positionSelect.addEventListener('change', function () {
            if (this.value === 'custom') {
                positionCustomWrapper.style.display = 'block';
                positionCustomInput.focus();
            } else {
                positionCustomWrapper.style.display = 'none';
                positionCustomInput.value = '';
                positionHidden.value = this.value;
                preview.style.backgroundPosition = this.value;
            }
        });

        positionCustomInput.addEventListener('input', function () {
            positionHidden.value = this.value.trim() || 'center center';
            preview.style.backgroundPosition = positionHidden.value;
        });

        sizeSelect.addEventListener('change', function () {
            if (this.value === 'custom') {
                sizeCustomWrapper.style.display = 'block';
                sizeCustomInput.focus();
            } else {
                sizeCustomWrapper.style.display = 'none';
                sizeCustomInput.value = '';
                sizeHidden.value = this.value;
                preview.style.backgroundSize = this.value;
            }
        });

        sizeCustomInput.addEventListener('input', function () {
            sizeHidden.value = this.value.trim() || 'cover';
            preview.style.backgroundSize = sizeHidden.value;
        });

        overlayTypeSelect.addEventListener('change', updateOverlay);
        overlayOpacityInput.addEventListener('input', updateOverlay);

        colorPicker.addEventListener('input', function () {
            colorInput.value = this.value;
            updateBackgroundColor(this.value);
        });

        colorInput.addEventListener('input', function () {
            const value = this.value.trim();
            if (value.startsWith('#') && (value.length === 4 || value.length === 7)) {
                updateBackgroundColor(value);
            }
        });

        if (fileInput) {
            fileInput.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file) {
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    applyBackgroundImage(e.target.result);
                };
                reader.readAsDataURL(file);
                if (removeCheckbox) {
                    removeCheckbox.checked = false;
                }
            });
        }

        if (removeCheckbox) {
            removeCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    applyBackgroundImage(null);
                } else if (!fileInput || !fileInput.files.length) {
                    applyBackgroundImage(storedImage || fallbackImage);
                }
            });
        }
    });
</script>
</html>

