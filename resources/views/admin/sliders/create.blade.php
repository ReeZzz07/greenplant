<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать слайд - GreenPlant</title>
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
                <a href="{{ route('admin.sliders.index') }}">← Назад</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Создать новый слайд</h2>
        </div>

        <div class="card">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="title">Заголовок *</label>
                    <input type="text" class="@error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subtitle">Подзаголовок</label>
                    <input type="text" class="@error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle') }}">
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="@error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="button_text">Текст кнопки</label>
                        <input type="text" class="@error('button_text') is-invalid @enderror" id="button_text" name="button_text" value="{{ old('button_text') }}">
                    </div>
                    <div class="form-group">
                        <label for="button_link">Ссылка кнопки</label>
                        <input type="text" class="@error('button_link') is-invalid @enderror" id="button_link" name="button_link" value="{{ old('button_link') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input type="file" class="@error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Рекомендуемый размер: 1920x1080px. Максимальный размер: 5MB</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="image_width">Ширина изображения (px)</label>
                        <input type="number" class="@error('image_width') is-invalid @enderror" id="image_width" name="image_width" value="{{ old('image_width') }}" placeholder="1920">
                        @error('image_width')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Укажите ширину изображения в пикселях (1-5000)</div>
                    </div>
                    <div class="form-group">
                        <label for="image_height">Высота изображения (px)</label>
                        <input type="number" class="@error('image_height') is-invalid @enderror" id="image_height" name="image_height" value="{{ old('image_height') }}" placeholder="1080">
                        @error('image_height')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Укажите высоту изображения в пикселях (1-5000)</div>
                    </div>
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
                    <button type="submit" class="btn btn-primary">Создать слайд</button>
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
