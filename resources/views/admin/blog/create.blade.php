<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить статью - GreenPlant</title>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; }
        input, textarea { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.3s; font-family: inherit; }
        input:focus, textarea:focus { outline: none; border-color: #667eea; }
        textarea { min-height: 120px; resize: vertical; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: auto; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .form-actions { display: flex; gap: 15px; margin-top: 30px; }
        .error { color: #dc3545; font-size: 13px; margin-top: 5px; }
        .help-text { font-size: 13px; color: #666; margin-top: 5px; }
        h2 { margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.blog.index') }}">← К списку статей</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>Добавить новую статью</h2>

            @if ($errors->any())
                <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                    <strong>Ошибки при сохранении:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                @csrf

                <div class="form-group">
                    <label for="title">Заголовок *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="slug">URL (slug)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}">
                    <div class="help-text">Оставьте пустым для автоматической генерации</div>
                    @error('slug')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="excerpt">Краткое описание (для превью)</label>
                    <textarea id="excerpt" name="excerpt">{{ old('excerpt') }}</textarea>
                    @error('excerpt')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="content">Содержание статьи *</label>
                    <textarea id="content" name="content" style="min-height: 300px;">{{ old('content') }}</textarea>
                    @error('content')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="image">Изображение</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    @error('image')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="published_at">Дата публикации</label>
                    <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at') }}">
                    <div class="help-text">Оставьте пустым для автоматической установки при публикации</div>
                    @error('published_at')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <label for="is_published" style="margin: 0;">Опубликовать статью</label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Сохранить статью</button>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let formSubmitted = false;
        
        tinymce.init({
            selector: '#content',
            height: 500,
            menubar: 'file edit view insert format tools table help',
            readonly: false,
            promotion: false,
            branding: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'visualchars', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'emoticons', 'codesample', 'help', 'wordcount',
                'pagebreak', 'nonbreaking', 'directionality', 'quickbars'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                     'forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify | ' +
                     'bullist numlist outdent indent | link image media table | ' +
                     'code visualblocks visualchars codesample | emoticons charmap | ' +
                     'searchreplace fullscreen preview | pagebreak nonbreaking anchor | ' +
                     'insertdatetime | help',
            toolbar_mode: 'sliding',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif; font-size: 14px; padding: 20px; }' +
                          '.image-carousel { padding: 30px; margin: 40px 0; background: #f9f9f9; border-radius: 15px; border: 2px dashed #82ae46; position: relative; }' +
                          '.image-carousel::before { content: "🎠 СЛАЙДЕР ИЗОБРАЖЕНИЙ"; display: block; text-align: center; color: #82ae46; font-weight: bold; margin-bottom: 15px; }' +
                          '.image-carousel img { display: inline-block !important; max-width: 200px !important; height: auto !important; border-radius: 10px !important; margin: 5px !important; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }',
            language: 'ru',
            
            // Загрузка изображений
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function(resolve, reject) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route("admin.blog.upload-image") }}');
                    
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                    
                    xhr.upload.addEventListener('progress', function(e) {
                        progress(e.loaded / e.total * 100);
                    });
                    
                    xhr.addEventListener('load', function() {
                        if (xhr.status === 200) {
                            const json = JSON.parse(xhr.responseText);
                            resolve(json.location);
                        } else {
                            reject('Ошибка загрузки: ' + xhr.status);
                        }
                    });
                    
                    xhr.addEventListener('error', function() {
                        reject('Ошибка загрузки изображения');
                    });
                    
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    
                    xhr.send(formData);
                });
            },
            
            image_advtab: true,
            image_caption: true,
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            convert_urls: false,
            
            // Возможность вставлять изображения через drag & drop
            paste_data_images: true
        });

        // Обработка отправки формы
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('blogForm');
            
            form.addEventListener('submit', function(e) {
                if (formSubmitted) {
                    return true;
                }
                
                e.preventDefault();
                
                console.log('Форма отправляется...');
                
                // Сохраняем содержимое TinyMCE
                tinymce.triggerSave();
                
                // Проверяем наличие контента
                const content = document.getElementById('content').value;
                console.log('Длина контента:', content.length);
                
                if (!content || content.trim() === '') {
                    alert('Пожалуйста, заполните содержание статьи');
                    return false;
                }
                
                formSubmitted = true;
                form.submit();
            });
        });
    </script>
</body>
</html>

