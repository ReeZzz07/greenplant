@php
    $product = $product ?? null;
    $allowRemove = $allowRemove ?? false;

    $positionOptions = [
        'center center' => 'По центру',
        'top center' => 'Сверху по центру',
        'bottom center' => 'Снизу по центру',
        'left center' => 'Слева по центру',
        'right center' => 'Справа по центру',
        'top left' => 'Сверху слева',
        'top right' => 'Сверху справа',
        'bottom left' => 'Снизу слева',
        'bottom right' => 'Снизу справа',
    ];

    $sizeOptions = [
        'cover' => 'Cover (заполнить)',
        'contain' => 'Contain (вписать)',
        'auto' => 'Auto (оригинал)',
        '100% 100%' => 'Растянуть (100%)',
    ];

    $defaultColor = '#82ae46';

    $heroBackgroundPositionValue = trim((string) old('hero_background_position', $product->hero_background_position ?? 'center center'));
    if ($heroBackgroundPositionValue === '') {
        $heroBackgroundPositionValue = 'center center';
    }
    $hasCustomPosition = !array_key_exists($heroBackgroundPositionValue, $positionOptions);
    $positionSelectValue = $hasCustomPosition ? 'custom' : $heroBackgroundPositionValue;
    $positionCustomValue = $hasCustomPosition ? $heroBackgroundPositionValue : '';

    $heroBackgroundSizeValue = trim((string) old('hero_background_size', $product->hero_background_size ?? 'cover'));
    if ($heroBackgroundSizeValue === '') {
        $heroBackgroundSizeValue = 'cover';
    }
    $hasCustomSize = !array_key_exists($heroBackgroundSizeValue, $sizeOptions);
    $sizeSelectValue = $hasCustomSize ? 'custom' : $heroBackgroundSizeValue;
    $sizeCustomValue = $hasCustomSize ? $heroBackgroundSizeValue : '';

    $heroBackgroundColor = old('hero_background_color', $product->hero_background_color ?? $defaultColor);
    if (empty($heroBackgroundColor)) {
        $heroBackgroundColor = $defaultColor;
    }
    $heroBackgroundColor = '#' . ltrim($heroBackgroundColor, '#');

    $heroOverlayType = old('hero_overlay_type', $product->hero_overlay_type ?? 'darken');
    $heroOverlayType = in_array($heroOverlayType, ['darken', 'lighten', 'none'], true) ? $heroOverlayType : 'darken';

    $heroOverlayOpacity = (int) old('hero_overlay_opacity', $product->hero_overlay_opacity ?? 40);
    $heroOverlayOpacity = max(0, min(100, $heroOverlayOpacity));

    $existingHeroImageUrl = $product && $product->hero_background_image
        ? asset('storage/' . $product->hero_background_image)
        : '';

    $fieldPrefix = 'hero_' . uniqid();
    $imageFieldId = $fieldPrefix . '_background_image';
    $positionSelectId = $fieldPrefix . '_background_position_select';
    $positionCustomId = $fieldPrefix . '_background_position_custom';
    $sizeSelectId = $fieldPrefix . '_background_size_select';
    $sizeCustomId = $fieldPrefix . '_background_size_custom';
    $colorPickerId = $fieldPrefix . '_background_color_picker';
    $colorInputId = $fieldPrefix . '_background_color_input';
    $overlayTypeId = $fieldPrefix . '_overlay_type';
    $opacityRangeId = $fieldPrefix . '_overlay_opacity';
@endphp

@once
    <style>
        .hero-settings-card {
            margin-top: 40px;
            background: #ffffff;
            border-radius: 15px;
            border: 1px solid #e5e9f4;
            padding: 30px;
            box-shadow: 0 6px 18px rgba(102, 126, 234, 0.08);
        }
        .hero-settings-card h3 {
            margin-bottom: 12px;
            font-size: 20px;
            color: #2f3367;
        }
        .hero-settings-description {
            color: #5c627a;
            font-size: 14px;
            margin-bottom: 25px;
        }
        .hero-preview {
            margin-top: 20px;
            border-radius: 12px;
            height: 220px;
            position: relative;
            overflow: hidden;
            border: 1px solid #dde3f0;
            background-size: cover;
            background-position: center;
            background-color: #82ae46;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 600;
            font-size: 20px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
        }
        .hero-preview-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }
        .hero-preview-text {
            position: relative;
            z-index: 2;
        }
        .hero-color-inputs {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .hero-color-inputs input[type="color"] {
            width: 60px;
            height: 42px;
            border: none;
            border-radius: 10px;
            padding: 0;
            cursor: pointer;
        }
        .hero-color-inputs input[type="text"] {
            flex: 1;
        }
        .hero-remove-checkbox {
            margin-top: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #c0392b;
            font-weight: 600;
        }
        .hero-range-wrapper {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .hero-range-wrapper input[type="range"] {
            width: 100%;
        }
        .hero-current-image {
            margin-bottom: 12px;
            display: inline-block;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e1e5ef;
        }
        .hero-current-image img {
            display: block;
            max-width: 240px;
            height: auto;
        }
        @media (max-width: 768px) {
            .hero-color-inputs {
                flex-direction: column;
                align-items: stretch;
            }
            .hero-color-inputs input[type="color"] {
                width: 100%;
                height: 48px;
            }
        }
    </style>
@endonce

<div
    class="hero-settings-card js-product-hero-settings"
    data-existing-image="{{ e($existingHeroImageUrl) }}"
    data-fallback-image="{{ asset('assets/images/bg_6.jpg') }}"
>
    <h3>🎨 Hero-секция товара</h3>
    <p class="hero-settings-description">
        Настройте фон верхнего блока страницы товара: загрузите изображение, задайте позиционирование, наложение и цветовую подложку.
    </p>

    <div class="form-group">
        <label for="{{ $imageFieldId }}">Фоновое изображение</label>
        @if($existingHeroImageUrl)
            <div class="hero-current-image">
                <img src="{{ $existingHeroImageUrl }}" alt="Текущее фоновое изображение">
            </div>
        @endif
        <input type="file" id="{{ $imageFieldId }}" name="hero_background_image" accept="image/*" data-role="hero-image-input">
        @error('hero_background_image')<div class="error">{{ $message }}</div>@enderror
        <div class="help-text">Рекомендуемый размер 1920×1080px. Поддерживается JPG, PNG, WebP до 4 МБ.</div>
        @if($allowRemove && $existingHeroImageUrl)
            <label class="hero-remove-checkbox">
                <input type="checkbox" name="remove_hero_background" value="1" data-role="hero-remove-checkbox">
                Удалить текущее изображение
            </label>
        @endif
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="{{ $positionSelectId }}">Позиция фона</label>
            <select id="{{ $positionSelectId }}" data-role="hero-position-select">
                @foreach($positionOptions as $value => $label)
                    <option value="{{ $value }}" {{ $positionSelectValue === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
                <option value="custom" {{ $positionSelectValue === 'custom' ? 'selected' : '' }}>Своя позиция</option>
            </select>
            @error('hero_background_position')<div class="error">{{ $message }}</div>@enderror
            <div class="help-text">Определяет видимую область фонового изображения.</div>
        </div>
        <div class="form-group" data-role="hero-position-custom-wrapper" style="{{ $hasCustomPosition ? '' : 'display:none;' }}">
            <label for="{{ $positionCustomId }}">Своя позиция (например: 30% 70%)</label>
            <input type="text" id="{{ $positionCustomId }}" data-role="hero-position-custom" value="{{ $positionCustomValue }}">
            <div class="help-text">Используйте CSS-значения: проценты, пиксели или ключевые слова.</div>
        </div>
    </div>
    <input type="hidden" name="hero_background_position" value="{{ $heroBackgroundPositionValue }}" data-role="hero-position-value">

    <div class="form-row">
        <div class="form-group">
            <label for="{{ $sizeSelectId }}">Размер фона</label>
            <select id="{{ $sizeSelectId }}" data-role="hero-size-select">
                @foreach($sizeOptions as $value => $label)
                    <option value="{{ $value }}" {{ $sizeSelectValue === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
                <option value="custom" {{ $sizeSelectValue === 'custom' ? 'selected' : '' }}>Свой размер</option>
            </select>
            @error('hero_background_size')<div class="error">{{ $message }}</div>@enderror
            <div class="help-text">Определяет, как изображение растягивается внутри блока.</div>
        </div>
        <div class="form-group" data-role="hero-size-custom-wrapper" style="{{ $hasCustomSize ? '' : 'display:none;' }}">
            <label for="{{ $sizeCustomId }}">Свой размер (например: 150% 150%)</label>
            <input type="text" id="{{ $sizeCustomId }}" data-role="hero-size-custom" value="{{ $sizeCustomValue }}">
            <div class="help-text">Допускаются любые значения CSS: проценты, пиксели и т.д.</div>
        </div>
    </div>
    <input type="hidden" name="hero_background_size" value="{{ $heroBackgroundSizeValue }}" data-role="hero-size-value">

    <div class="form-row">
        <div class="form-group">
            <label for="{{ $colorInputId }}">Цвет фона (если нет изображения)</label>
            <div class="hero-color-inputs">
                <input type="color" id="{{ $colorPickerId }}" value="{{ $heroBackgroundColor }}" data-role="hero-color-picker">
                <input type="text" id="{{ $colorInputId }}" name="hero_background_color" value="{{ $heroBackgroundColor }}" data-role="hero-color-input" placeholder="#82AE46">
            </div>
            @error('hero_background_color')<div class="error">{{ $message }}</div>@enderror
            <div class="help-text">Будет использоваться как фон по умолчанию и просвечивать через наложение.</div>
        </div>
        <div class="form-group">
            <label for="{{ $overlayTypeId }}">Тип наложения</label>
            <select id="{{ $overlayTypeId }}" name="hero_overlay_type" data-role="hero-overlay-type">
                <option value="darken" {{ $heroOverlayType === 'darken' ? 'selected' : '' }}>Затемнение</option>
                <option value="lighten" {{ $heroOverlayType === 'lighten' ? 'selected' : '' }}>Осветление</option>
                <option value="none" {{ $heroOverlayType === 'none' ? 'selected' : '' }}>Без наложения</option>
            </select>
            @error('hero_overlay_type')<div class="error">{{ $message }}</div>@enderror
            <div class="help-text">Помогает сделать текст более читаемым.</div>
        </div>
    </div>

    <div class="form-group hero-range-wrapper">
        <label for="{{ $opacityRangeId }}">Прозрачность наложения: <span data-role="hero-opacity-value">{{ $heroOverlayOpacity }}</span>%</label>
        <input type="range" id="{{ $opacityRangeId }}" name="hero_overlay_opacity" min="0" max="100" value="{{ $heroOverlayOpacity }}" data-role="hero-opacity-range">
        @error('hero_overlay_opacity')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div class="hero-preview" data-role="hero-preview">
        <div class="hero-preview-overlay" data-role="hero-preview-overlay"></div>
        <span class="hero-preview-text">Предпросмотр hero</span>
    </div>
</div>

@once
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const heroSections = document.querySelectorAll('.js-product-hero-settings');

            heroSections.forEach(function (section) {
                const imageInput = section.querySelector('[data-role="hero-image-input"]');
                const removeCheckbox = section.querySelector('[data-role="hero-remove-checkbox"]');
                const preview = section.querySelector('[data-role="hero-preview"]');
                const overlayLayer = section.querySelector('[data-role="hero-preview-overlay"]');
                const positionSelect = section.querySelector('[data-role="hero-position-select"]');
                const positionCustomWrapper = section.querySelector('[data-role="hero-position-custom-wrapper"]');
                const positionCustomInput = section.querySelector('[data-role="hero-position-custom"]');
                const positionValueInput = section.querySelector('[data-role="hero-position-value"]');
                const sizeSelect = section.querySelector('[data-role="hero-size-select"]');
                const sizeCustomWrapper = section.querySelector('[data-role="hero-size-custom-wrapper"]');
                const sizeCustomInput = section.querySelector('[data-role="hero-size-custom"]');
                const sizeValueInput = section.querySelector('[data-role="hero-size-value"]');
                const colorPicker = section.querySelector('[data-role="hero-color-picker"]');
                const colorTextInput = section.querySelector('[data-role="hero-color-input"]');
                const overlayTypeSelect = section.querySelector('[data-role="hero-overlay-type"]');
                const opacityRange = section.querySelector('[data-role="hero-opacity-range"]');
                const opacityValue = section.querySelector('[data-role="hero-opacity-value"]');

                const fallbackImage = section.dataset.fallbackImage || '';
                let baseImage = section.dataset.existingImage || '';
                let uploadedImage = '';

                if (!baseImage && fallbackImage) {
                    baseImage = fallbackImage;
                }

                const clampOpacity = function (value) {
                    const number = parseInt(value, 10);
                    if (Number.isNaN(number)) {
                        return 0;
                    }
                    return Math.max(0, Math.min(100, number));
                };

                const ensureColorFormat = function (value) {
                    if (typeof value !== 'string') {
                        return '#82ae46';
                    }
                    const trimmed = value.trim();
                    if (trimmed === '') {
                        return '#82ae46';
                    }
                    return '#' + trimmed.replace(/^#/, '');
                };

                const applyPreview = function () {
                    if (!preview) {
                        return;
                    }

                    const shouldRemoveImage = removeCheckbox ? removeCheckbox.checked : false;
                    const customPosition = positionValueInput ? positionValueInput.value.trim() : 'center center';
                    const customSize = sizeValueInput ? sizeValueInput.value.trim() : 'cover';
                    const colorValue = colorTextInput ? ensureColorFormat(colorTextInput.value) : '#82ae46';
                    const overlayType = overlayTypeSelect ? overlayTypeSelect.value : 'darken';
                    const opacity = opacityRange ? clampOpacity(opacityRange.value) : 40;

                    const backgroundImage = shouldRemoveImage ? '' : (uploadedImage || baseImage);

                    preview.style.backgroundColor = colorValue;
                    preview.style.backgroundRepeat = 'no-repeat';
                    preview.style.backgroundPosition = customPosition !== '' ? customPosition : 'center center';
                    preview.style.backgroundSize = customSize !== '' ? customSize : 'cover';

                    if (backgroundImage) {
                        preview.style.backgroundImage = "url('" + backgroundImage + "')";
                    } else {
                        preview.style.backgroundImage = 'none';
                    }

                    if (overlayLayer) {
                        if (overlayType === 'none') {
                            overlayLayer.style.display = 'none';
                        } else {
                            overlayLayer.style.display = 'block';
                            const opacityValue = opacity / 100;
                            overlayLayer.style.backgroundColor = overlayType === 'lighten'
                                ? 'rgba(255, 255, 255, ' + opacityValue + ')'
                                : 'rgba(0, 0, 0, ' + opacityValue + ')';
                        }
                    }

                    if (opacityValue) {
                        opacityValue.textContent = clampOpacity(opacity);
                    }
                };

                const syncPositionValue = function () {
                    if (!positionSelect || !positionValueInput) {
                        return;
                    }
                    if (positionSelect.value === 'custom') {
                        if (positionCustomWrapper) {
                            positionCustomWrapper.style.display = '';
                        }
                        const customValue = (positionCustomInput ? positionCustomInput.value.trim() : '') || 'center center';
                        positionValueInput.value = customValue;
                    } else {
                        if (positionCustomWrapper) {
                            positionCustomWrapper.style.display = 'none';
                        }
                        positionValueInput.value = positionSelect.value;
                    }
                    applyPreview();
                };

                const syncSizeValue = function () {
                    if (!sizeSelect || !sizeValueInput) {
                        return;
                    }
                    if (sizeSelect.value === 'custom') {
                        if (sizeCustomWrapper) {
                            sizeCustomWrapper.style.display = '';
                        }
                        const customValue = (sizeCustomInput ? sizeCustomInput.value.trim() : '') || 'cover';
                        sizeValueInput.value = customValue;
                    } else {
                        if (sizeCustomWrapper) {
                            sizeCustomWrapper.style.display = 'none';
                        }
                        sizeValueInput.value = sizeSelect.value;
                    }
                    applyPreview();
                };

                if (positionSelect) {
                    positionSelect.addEventListener('change', syncPositionValue);
                }
                if (positionCustomInput) {
                    positionCustomInput.addEventListener('input', syncPositionValue);
                    positionCustomInput.addEventListener('blur', syncPositionValue);
                }

                if (sizeSelect) {
                    sizeSelect.addEventListener('change', syncSizeValue);
                }
                if (sizeCustomInput) {
                    sizeCustomInput.addEventListener('input', syncSizeValue);
                    sizeCustomInput.addEventListener('blur', syncSizeValue);
                }

                if (colorPicker && colorTextInput) {
                    colorPicker.addEventListener('input', function (event) {
                        const value = ensureColorFormat(event.target.value);
                        colorPicker.value = value;
                        colorTextInput.value = value;
                        applyPreview();
                    });

                    colorTextInput.addEventListener('blur', function () {
                        const value = ensureColorFormat(colorTextInput.value);
                        colorTextInput.value = value;
                        try {
                            colorPicker.value = value.length === 7 ? value : colorPicker.value;
                        } catch (error) {
                            // ignore invalid values for color input
                        }
                        applyPreview();
                    });

                    colorTextInput.addEventListener('input', function () {
                        // Update preview live while typing
                        applyPreview();
                    });
                }

                if (overlayTypeSelect) {
                    overlayTypeSelect.addEventListener('change', applyPreview);
                }

                if (opacityRange) {
                    opacityRange.addEventListener('input', function () {
                        if (opacityValue) {
                            opacityValue.textContent = clampOpacity(opacityRange.value);
                        }
                        applyPreview();
                    });
                }

                if (imageInput) {
                    imageInput.addEventListener('change', function (event) {
                        const files = event.target.files;
                        if (files && files[0]) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                uploadedImage = e.target.result;
                                if (removeCheckbox) {
                                    removeCheckbox.checked = false;
                                }
                                applyPreview();
                            };
                            reader.readAsDataURL(files[0]);
                        } else {
                            uploadedImage = '';
                            applyPreview();
                        }
                    });
                }

                if (removeCheckbox) {
                    removeCheckbox.addEventListener('change', applyPreview);
                }

                // Initial sync
                syncPositionValue();
                syncSizeValue();
                if (colorTextInput) {
                    colorTextInput.value = ensureColorFormat(colorTextInput.value);
                }
                if (colorPicker && colorTextInput) {
                    try {
                        colorPicker.value = colorTextInput.value.length === 7 ? colorTextInput.value : colorPicker.value;
                    } catch (error) {
                        // ignore invalid values for color picker
                    }
                }
                if (opacityValue && opacityRange) {
                    opacityValue.textContent = clampOpacity(opacityRange.value);
                }
                applyPreview();
            });
        });
    </script>
@endonce

