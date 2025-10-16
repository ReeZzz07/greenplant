<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать товар - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .header a:hover { background: rgba(255,255,255,0.3); }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; }
        input[type="text"], input[type="number"], select, textarea {
            width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px;
            font-size: 14px; transition: all 0.3s; font-family: inherit;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #667eea; }
        textarea { min-height: 120px; resize: vertical; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        .btn { padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600;
               display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-size: 14px; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); }
        .btn-secondary { background: #6c757d; color: white; }
        .form-actions { display: flex; gap: 15px; margin-top: 30px; }
        .error { color: #dc3545; font-size: 13px; margin-top: 5px; }
        .help-text { font-size: 13px; color: #666; margin-top: 5px; }
        h2 { margin-bottom: 30px; color: #333; }
        .current-image { max-width: 200px; border-radius: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.products.index') }}">← К списку товаров</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>Редактировать товар: {{ $product->name }}</h2>

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Название товара *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="slug">URL (slug)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}">
                    @error('slug')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Категория *</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="short_description">Краткое описание</label>
                    <textarea id="short_description" name="short_description">{{ old('short_description', $product->short_description) }}</textarea>
                    @error('short_description')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Полное описание</label>
                    <textarea id="description" name="description" style="min-height: 200px;">{{ old('description', $product->description) }}</textarea>
                    @error('description')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="price">Цена * (₽)</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" required>
                        @error('price')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="old_price">Старая цена (₽)</label>
                        <input type="number" id="old_price" name="old_price" value="{{ old('old_price', $product->old_price) }}" step="0.01">
                        @error('old_price')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="stock">Остаток (шт)</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
                        @error('stock')<div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="sku">Артикул</label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                        @error('sku')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Изображение</label>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="current-image">
                        <div class="help-text">Загрузите новое изображение, чтобы заменить текущее</div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*" style="margin-top: 10px;">
                    @error('image')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label for="is_active" style="margin: 0;">Товар активен (виден на сайте)</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label for="is_featured" style="margin: 0;">Отметить как "Хит продаж"</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

