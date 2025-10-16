<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->title }} - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; }
        .post-image { max-width: 100%; border-radius: 15px; margin: 30px 0; }
        .info-row { display: grid; grid-template-columns: 200px 1fr; gap: 15px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e9ecef; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { color: #333; }
        .badge { padding: 6px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-secondary { background: #6c757d; color: white; }
        .actions { display: flex; gap: 15px; margin-top: 30px; }
        .content-box { line-height: 1.8; margin-top: 30px; }
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
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h2>{{ $blog->title }}</h2>
                <span class="badge {{ $blog->is_published ? 'badge-success' : 'badge-warning' }}">
                    {{ $blog->is_published ? 'Опубликована' : 'Черновик' }}
                </span>
            </div>

            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="post-image">
            @endif

            <div class="info-row">
                <div class="info-label">Автор:</div>
                <div class="info-value">{{ $blog->author->name }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Дата публикации:</div>
                <div class="info-value">{{ $blog->published_at ? $blog->published_at->format('d.m.Y H:i') : 'Не опубликована' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">URL:</div>
                <div class="info-value">
                    @if($blog->is_published)
                        <a href="{{ route('blog.post', $blog->slug) }}" target="_blank">{{ $blog->slug }}</a>
                    @else
                        <code>{{ $blog->slug }}</code>
                    @endif
                </div>
            </div>

            <div class="info-row" style="border: none;">
                <div class="info-label">Создана:</div>
                <div class="info-value">{{ $blog->created_at->format('d.m.Y H:i') }}</div>
            </div>

            @if($blog->excerpt)
            <div style="margin-top: 20px;">
                <h3>Краткое описание:</h3>
                <p style="line-height: 1.6; color: #666; margin-top: 10px;">{{ $blog->excerpt }}</p>
            </div>
            @endif

            <div class="content-box">
                <h3>Содержание:</h3>
                <div style="margin-top: 15px; padding: 25px; background: #f8f9fa; border-radius: 10px;">
                    {!! $blog->content !!}
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-warning">Редактировать</a>
                @if($blog->is_published)
                    <a href="{{ route('blog.post', $blog->slug) }}" target="_blank" class="btn btn-primary">Посмотреть на сайте</a>
                @endif
                <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Назад к списку</a>
            </div>
        </div>
    </div>
</body>
</html>

