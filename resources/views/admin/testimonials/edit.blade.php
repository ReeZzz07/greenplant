<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать отзыв - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 800px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; }
        input, select, textarea { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.3s; font-family: inherit; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #667eea; }
        textarea { min-height: 120px; resize: vertical; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .form-actions { display: flex; gap: 15px; margin-top: 30px; }
        .error { color: #dc3545; font-size: 13px; margin-top: 5px; }
        .help-text { font-size: 13px; color: #666; margin-top: 5px; }
        .current-image { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-top: 10px; }
        h2 { margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.testimonials.index') }}">← К списку отзывов</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>Редактировать отзыв: {{ $testimonial->name }}</h2>

            <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Имя клиента *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $testimonial->name) }}" required>
                    @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="position">Должность / Описание</label>
                    <input type="text" id="position" name="position" value="{{ old('position', $testimonial->position) }}">
                    @error('position')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="content">Текст отзыва *</label>
                    <textarea id="content" name="content" required>{{ old('content', $testimonial->content) }}</textarea>
                    @error('content')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="rating">Рейтинг *</label>
                    <select id="rating" name="rating" required>
                        <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                        <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                        <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>⭐⭐ (2)</option>
                        <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>⭐ (1)</option>
                    </select>
                    @error('rating')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="image">Фото клиента</label>
                    @if($testimonial->image)
                        <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="current-image">
                    @endif
                    <input type="file" id="image" name="image" accept="image/*" style="margin-top: 10px;">
                    @error('image')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="sort_order">Порядок отображения</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}">
                    @error('sort_order')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                        <label for="is_active" style="margin: 0;">Отзыв активен</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

