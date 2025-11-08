<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать слайд - GreenPlant</title>
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
        .preview-wrapper { margin-top: 15px; }
        .preview-controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; gap: 10px; flex-wrap: wrap; }
        .preview-indicators { display: flex; gap: 12px; font-size: 13px; color: #555; }
        .preview-badge { background: #eef1ff; color: #4f5eff; padding: 3px 8px; border-radius: 6px; font-weight: 600; }
        .image-preview-frame { --frame-width: 400px; --frame-height: 225px; width: var(--frame-width); height: var(--frame-height); border-radius: 12px; border: 2px dashed #cbd5f5; background: repeating-linear-gradient(45deg, #f5f7ff, #f5f7ff 10px, #eff2ff 10px, #eff2ff 20px); overflow: hidden; position: relative; display: none; align-items: center; justify-content: center; cursor: grab; transition: border-color 0.2s ease, background 0.2s ease; }
        .image-preview-frame.is-visible { display: flex; }
        .image-preview-frame.is-dragging { cursor: grabbing; border-color: #667eea; background: #eef1ff; }
        .image-preview-frame img { width: 100%; height: 100%; object-fit: cover; object-position: 50% 50%; user-select: none; pointer-events: none; transition: object-position 0.1s ease-out; }
        .preview-placeholder { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; text-align: center; font-size: 14px; color: #667eea; padding: 20px; }
        .image-preview-frame.is-visible .preview-placeholder { display: none; }
        .btn-light { background: #f8f9fa; color: #333; border: 1px solid #dee2e6; }
        .btn-light:hover { background: #e2e6ea; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <div>
                <a href="{{ route('admin.sliders.index') }}">← Назад</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Редактировать слайд #{{ $slider->id }}</h2>
        </div>

        <div class="card">
            <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Заголовок *</label>
                    <input type="text" class="@error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $slider->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subtitle">Подзаголовок</label>
                    <input type="text" class="@error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}">
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="@error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $slider->description) }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="button_text">Текст кнопки</label>
                        <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $slider->button_text) }}">
                    </div>
                    <div class="form-group">
                        <label for="button_link">Ссылка кнопки</label>
                        <input type="text" id="button_link" name="button_link" value="{{ old('button_link', $slider->button_link) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <div class="help-text">Рекомендуемый размер: 1920x1080px. Максимальный размер: 5MB</div>
                </div>

                <input type="hidden" id="image_position_x" name="image_position_x" value="{{ old('image_position_x', $slider->image_position_x ?? 50) }}">
                <input type="hidden" id="image_position_y" name="image_position_y" value="{{ old('image_position_y', $slider->image_position_y ?? 50) }}">

                <div class="form-group">
                    <label>Предпросмотр и позиционирование</label>
                    <div class="preview-wrapper">
                        <div class="preview-controls">
                            <div class="preview-indicators">
                                <span>Позиция по горизонтали: <span class="preview-badge" data-role="pos-x-display">50%</span></span>
                                <span>Позиция по вертикали: <span class="preview-badge" data-role="pos-y-display">50%</span></span>
                            </div>
                            <button type="button" class="btn btn-light" data-action="reset-position">Центровать</button>
                        </div>
                        <div class="image-preview-frame" id="imagePreviewFrame">
                            <div class="preview-placeholder" data-role="preview-placeholder">
                                Загрузите изображение или используйте текущее, чтобы настроить позицию. Зажмите и перетащите его внутри рамки.
                            </div>
                            <img id="imagePreview" alt="Предпросмотр слайда" data-initial-src="{{ $slider->image ? asset('storage/' . $slider->image) : '' }}">
                        </div>
                        <div class="help-text">Рамка отображает пропорции, основываясь на введённых ширине и высоте. Перетаскивайте изображение, чтобы выбрать видимую область.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="image_width">Ширина изображения (px)</label>
                        <input type="number" class="@error('image_width') is-invalid @enderror" id="image_width" name="image_width" value="{{ old('image_width', $slider->image_width) }}" placeholder="1920">
                        @error('image_width')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Укажите ширину изображения в пикселях (1-5000)</div>
                    </div>
                    <div class="form-group">
                        <label for="image_height">Высота изображения (px)</label>
                        <input type="number" class="@error('image_height') is-invalid @enderror" id="image_height" name="image_height" value="{{ old('image_height', $slider->image_height) }}" placeholder="1080">
                        @error('image_height')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Укажите высоту изображения в пикселях (1-5000)</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="order">Порядок отображения</label>
                        <input type="number" id="order" name="order" value="{{ old('order', $slider->order) }}">
                    </div>
                    <div class="form-group">
                        <label for="is_active">Статус</label>
                        <select id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', $slider->is_active) == 1 ? 'selected' : '' }}>Активен</option>
                            <option value="0" {{ old('is_active', $slider->is_active) == 0 ? 'selected' : '' }}>Неактивен</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const frame = document.getElementById('imagePreviewFrame');
            const previewImage = document.getElementById('imagePreview');
            const fileInput = document.getElementById('image');
            const widthInput = document.getElementById('image_width');
            const heightInput = document.getElementById('image_height');
            const posXInput = document.getElementById('image_position_x');
            const posYInput = document.getElementById('image_position_y');
            const posXDisplay = document.querySelector('[data-role="pos-x-display"]');
            const posYDisplay = document.querySelector('[data-role="pos-y-display"]');
            const resetButton = document.querySelector('[data-action="reset-position"]');
            const placeholder = frame ? frame.querySelector('[data-role="preview-placeholder"]') : null;
            const DEFAULT_POS = 50;
            const MAX_FRAME_WIDTH = 480;
            const MAX_FRAME_HEIGHT = 320;
            let activeObjectUrl = null;
            let isDragging = false;
            let lastPointer = { x: 0, y: 0 };

            if (!frame || !previewImage || !posXInput || !posYInput || !posXDisplay || !posYDisplay || !resetButton) {
                return;
            }

            const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

            const parsePosition = (value) => {
                const parsed = parseFloat(value);
                return Number.isFinite(parsed) ? parsed : DEFAULT_POS;
            };

            const updateFrameDimensions = () => {
                const width = parseInt(widthInput.value, 10);
                const height = parseInt(heightInput.value, 10);

                if (width > 0 && height > 0) {
                    const aspectRatio = width / height;
                    let frameWidth = MAX_FRAME_WIDTH;
                    let frameHeight = frameWidth / aspectRatio;

                    if (frameHeight > MAX_FRAME_HEIGHT) {
                        frameHeight = MAX_FRAME_HEIGHT;
                        frameWidth = frameHeight * aspectRatio;
                    }

                    frame.style.setProperty('--frame-width', `${Math.max(frameWidth, 120).toFixed(2)}px`);
                    frame.style.setProperty('--frame-height', `${Math.max(frameHeight, 120).toFixed(2)}px`);
                } else {
                    frame.style.setProperty('--frame-width', '400px');
                    frame.style.setProperty('--frame-height', '225px');
                }
            };

            const applyPosition = () => {
                const posX = clamp(parsePosition(posXInput.value), 0, 100);
                const posY = clamp(parsePosition(posYInput.value), 0, 100);

                posXInput.value = posX.toFixed(2);
                posYInput.value = posY.toFixed(2);
                previewImage.style.objectPosition = `${posX}% ${posY}%`;
                posXDisplay.textContent = `${Math.round(posX)}%`;
                posYDisplay.textContent = `${Math.round(posY)}%`;
            };

            const showPreview = () => {
                frame.classList.add('is-visible');
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            };

            const hidePreview = () => {
                frame.classList.remove('is-visible');
                if (placeholder) {
                    placeholder.style.display = '';
                }
            };

            const handleFile = (file) => {
                if (!file) {
                    if (!previewImage.dataset.initialSrc) {
                        hidePreview();
                    } else {
                        previewImage.src = previewImage.dataset.initialSrc;
                        applyPosition();
                        showPreview();
                    }

                    if (activeObjectUrl) {
                        URL.revokeObjectURL(activeObjectUrl);
                        activeObjectUrl = null;
                    }
                    return;
                }

                if (activeObjectUrl) {
                    URL.revokeObjectURL(activeObjectUrl);
                }

                const objectUrl = URL.createObjectURL(file);
                activeObjectUrl = objectUrl;
                previewImage.onload = () => {
                    applyPosition();
                    showPreview();
                };
                previewImage.src = objectUrl;
            };

            const resetPosition = () => {
                posXInput.value = DEFAULT_POS;
                posYInput.value = DEFAULT_POS;
                applyPosition();
            };

            fileInput.addEventListener('change', (event) => {
                const [file] = event.target.files || [];
                handleFile(file);
            });

            widthInput.addEventListener('input', updateFrameDimensions);
            heightInput.addEventListener('input', updateFrameDimensions);

            resetButton.addEventListener('click', resetPosition);

            frame.addEventListener('pointerdown', (event) => {
                if (!previewImage.src) {
                    return;
                }
                isDragging = true;
                frame.setPointerCapture(event.pointerId);
                frame.classList.add('is-dragging');
                lastPointer = { x: event.clientX, y: event.clientY };
            });

            frame.addEventListener('pointermove', (event) => {
                if (!isDragging) {
                    return;
                }

                const deltaX = event.clientX - lastPointer.x;
                const deltaY = event.clientY - lastPointer.y;
                lastPointer = { x: event.clientX, y: event.clientY };

                const frameWidth = frame.offsetWidth || 1;
                const frameHeight = frame.offsetHeight || 1;

                const posX = clamp(parsePosition(posXInput.value) - (deltaX / frameWidth) * 100, 0, 100);
                const posY = clamp(parsePosition(posYInput.value) - (deltaY / frameHeight) * 100, 0, 100);

                posXInput.value = posX.toFixed(2);
                posYInput.value = posY.toFixed(2);
                applyPosition();
            });

            const stopDragging = (event) => {
                if (!isDragging) {
                    return;
                }
                isDragging = false;
                frame.releasePointerCapture(event.pointerId);
                frame.classList.remove('is-dragging');
            };

            frame.addEventListener('pointerup', stopDragging);
            frame.addEventListener('pointerleave', stopDragging);
            frame.addEventListener('pointercancel', stopDragging);

            // Initial state
            updateFrameDimensions();
            applyPosition();

            const initialSrc = previewImage.dataset.initialSrc;
            if (initialSrc) {
                previewImage.onload = () => {
                    applyPosition();
                    showPreview();
                };
                previewImage.src = initialSrc;
            } else {
                hidePreview();
            }
        });
    </script>
</body>
</html>
