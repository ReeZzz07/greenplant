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
        .gallery-preview-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; margin-top: 15px; }
        .gallery-preview-item { position: relative; border-radius: 10px; overflow: hidden; border: 2px dashed #dfe3f6; background: #f6f8ff; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 10px; min-height: 140px; gap: 8px; }
        .gallery-preview-item img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
        .gallery-preview-placeholder { color: #667eea; font-size: 13px; text-align: center; }
        .gallery-preview-item span { display: block; font-size: 12px; color: #555; text-align: center; word-break: break-word; }
        .gallery-remove { margin-top: 8px; display: flex; align-items: center; gap: 6px; font-size: 12px; color: #d9534f; font-weight: 600; }
        .gallery-remove input { margin: 0; }
        .characteristics-wrapper { display: flex; flex-direction: column; gap: 15px; margin-top: 15px; }
        .characteristic-item { border: 2px dashed #dfe3f6; border-radius: 12px; padding: 20px; background: #fdfdff; position: relative; }
        .characteristic-fields { display: flex; flex-direction: column; gap: 12px; }
        .characteristic-fields input,
        .characteristic-fields textarea { width: 100%; }
        .characteristic-fields textarea { min-height: 80px; }
        .btn-add-characteristic { margin-top: 15px; background: #edf1ff; color: #4b5bdc; border: 2px solid #dfe3f6; }
        .btn-add-characteristic:hover { background: #dfe6ff; }
        .btn-remove-characteristic { position: absolute; top: 12px; right: 12px; border: none; background: rgba(220, 53, 69, 0.15); color: #dc3545; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 18px; line-height: 1; display: flex; align-items: center; justify-content: center; }
        .btn-remove-characteristic:hover { background: rgba(220, 53, 69, 0.3); }
        @media (max-width: 640px) {
            .characteristic-item { padding: 15px; }
        }
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

                @php
                    $characteristics = old('characteristics', $product->characteristics ?? []);
                @endphp
                <div class="form-group">
                    <label>Характеристики товара</label>
                    <p class="help-text">Добавьте или отредактируйте характеристики. Они будут показаны на сайте во вкладке «Характеристики».</p>
                    <div class="characteristics-wrapper" data-role="characteristics-container">
                        @forelse($characteristics as $index => $characteristic)
                            <div class="characteristic-item" data-characteristic-index="{{ $index }}">
                                <div class="characteristic-fields">
                                    <input type="text"
                                           name="characteristics[{{ $index }}][title]"
                                           placeholder="Название характеристики"
                                           value="{{ $characteristic['title'] ?? '' }}">
                                    <textarea name="characteristics[{{ $index }}][value]"
                                              placeholder="Описание характеристики"
                                              rows="2">{{ $characteristic['value'] ?? '' }}</textarea>
                                </div>
                                <button type="button" class="btn-remove-characteristic" data-action="remove-characteristic" title="Удалить характеристику">&times;</button>
                            </div>
                        @empty
                            <!-- Items добавятся скриптом -->
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-add-characteristic" data-role="add-characteristic">+ Добавить характеристику</button>
                    @if($errors->has('characteristics'))
                        <div class="error">{{ $errors->first('characteristics') }}</div>
                    @endif
                    @if($errors->has('characteristics.*.title'))
                        <div class="error">{{ $errors->first('characteristics.*.title') }}</div>
                    @endif
                    @if($errors->has('characteristics.*.value'))
                        <div class="error">{{ $errors->first('characteristics.*.value') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="delivery_description">Доставка</label>
                    <textarea id="delivery_description" name="delivery_description" style="min-height: 150px;" placeholder="Введите описание доставки для этого товара. Если оставить пустым, будет использовано общее описание доставки.">{!! old('delivery_description', $product->delivery_description) !!}</textarea>
                    <div class="help-text">Индивидуальное описание доставки для этого товара. Если оставить пустым, на сайте будет показано общее описание доставки. Можно использовать HTML-разметку (теги &lt;p&gt;, &lt;ul&gt;, &lt;li&gt; и т.д.).</div>
                    @error('delivery_description')<div class="error">{{ $message }}</div>@enderror
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
                    <label for="gallery_images">Дополнительные изображения</label>
                    @if(!empty($product->images))
                        <div class="gallery-preview-grid">
                            @foreach($product->images as $index => $path)
                                <div class="gallery-preview-item">
                                    <img src="{{ asset('storage/' . $path) }}" alt="Галерея {{ $index + 1 }}">
                                    <span>{{ basename($path) }}</span>
                                    <label class="gallery-remove">
                                        <input type="checkbox" name="remove_images[]" value="{{ $path }}">
                                        Удалить
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="gallery-preview-placeholder">Дополнительные изображения пока не загружены.</div>
                    @endif
                    <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple style="margin-top: 15px;">
                    @error('gallery_images')<div class="error">{{ $message }}</div>@enderror
                    @error('gallery_images.*')<div class="error">{{ $message }}</div>@enderror
                    <div class="help-text">Можно добавить до 10 файлов по 5 МБ. Новые изображения будут добавлены к текущей галерее.</div>
                    <div class="gallery-preview-grid" data-role="gallery-preview">
                        <div class="gallery-preview-item gallery-preview-placeholder">Выберите файлы для добавления — здесь появится предпросмотр.</div>
                    </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const galleryInput = document.getElementById('gallery_images');
            const previewGrid = document.querySelector('[data-role="gallery-preview"]');

            if (galleryInput && previewGrid) {
                const renderPlaceholder = () => {
                    previewGrid.innerHTML = '<div class="gallery-preview-item gallery-preview-placeholder">Выберите файлы для добавления — здесь появится предпросмотр.</div>';
                };

                const clearPreview = () => {
                    previewGrid.innerHTML = '';
                };

                galleryInput.addEventListener('change', function (event) {
                    const files = Array.from(event.target.files || []);
                    clearPreview();

                    if (!files.length) {
                        renderPlaceholder();
                        return;
                    }

                    files.forEach((file) => {
                        const item = document.createElement('div');
                        item.className = 'gallery-preview-item';

                        const caption = document.createElement('span');
                        caption.textContent = file.name;

                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (loadEvent) => {
                                const img = document.createElement('img');
                                img.src = loadEvent.target.result;
                                img.alt = file.name;
                                item.appendChild(img);
                                item.appendChild(caption);
                            };
                            reader.readAsDataURL(file);
                        } else {
                            item.innerHTML = '<span>Файл не является изображением</span>';
                            item.appendChild(caption);
                        }

                        previewGrid.appendChild(item);
                    });
                });

                renderPlaceholder();
            }

            const characteristicsContainer = document.querySelector('[data-role="characteristics-container"]');
            const addCharacteristicBtn = document.querySelector('[data-role="add-characteristic"]');

            if (characteristicsContainer && addCharacteristicBtn) {
                let characteristicIndex = characteristicsContainer.querySelectorAll('[data-characteristic-index]').length;

                const addCharacteristic = (title = '', value = '') => {
                    const item = document.createElement('div');
                    item.className = 'characteristic-item';
                    item.dataset.characteristicIndex = characteristicIndex;

                    const fields = document.createElement('div');
                    fields.className = 'characteristic-fields';

                    const titleInput = document.createElement('input');
                    titleInput.type = 'text';
                    titleInput.name = `characteristics[${characteristicIndex}][title]`;
                    titleInput.placeholder = 'Название характеристики';
                    titleInput.value = title;

                    const valueTextarea = document.createElement('textarea');
                    valueTextarea.name = `characteristics[${characteristicIndex}][value]`;
                    valueTextarea.placeholder = 'Описание характеристики';
                    valueTextarea.rows = 2;
                    valueTextarea.value = value;

                    fields.appendChild(titleInput);
                    fields.appendChild(valueTextarea);

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn-remove-characteristic';
                    removeBtn.dataset.action = 'remove-characteristic';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.title = 'Удалить характеристику';

                    item.appendChild(fields);
                    item.appendChild(removeBtn);
                    characteristicsContainer.appendChild(item);

                    characteristicIndex += 1;
                };

                if (characteristicIndex === 0) {
                    addCharacteristic();
                }

                addCharacteristicBtn.addEventListener('click', () => addCharacteristic());

                characteristicsContainer.addEventListener('click', (event) => {
                    if (event.target.matches('[data-action="remove-characteristic"]')) {
                        const item = event.target.closest('.characteristic-item');
                        if (item) {
                            item.remove();
                        }

                        if (!characteristicsContainer.querySelector('.characteristic-item')) {
                            addCharacteristic();
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>

