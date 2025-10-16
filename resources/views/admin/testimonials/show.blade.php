<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отзыв: {{ $testimonial->name }} - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 800px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 800px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; }
        .testimonial-image { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin: 20px auto; display: block; }
        .info-row { display: grid; grid-template-columns: 150px 1fr; gap: 15px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e9ecef; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { color: #333; }
        .badge { padding: 6px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-secondary { background: #6c757d; color: white; }
        .actions { display: flex; gap: 15px; margin-top: 30px; }
        .content-box { background: #f8f9fa; padding: 25px; border-radius: 10px; margin-top: 20px; line-height: 1.8; font-style: italic; }
        .rating { color: #ffc107; font-size: 24px; }
        h2 { margin-bottom: 30px; text-align: center; }
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
            <h2>Отзыв клиента</h2>

            @if($testimonial->image)
                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="testimonial-image">
            @else
                <div style="width: 150px; height: 150px; border-radius: 50%; background: #e9ecef; margin: 20px auto; display: flex; align-items: center; justify-content: center; font-size: 64px;">👤</div>
            @endif

            <div class="info-row">
                <div class="info-label">Имя:</div>
                <div class="info-value"><strong>{{ $testimonial->name }}</strong></div>
            </div>

            <div class="info-row">
                <div class="info-label">Должность:</div>
                <div class="info-value">{{ $testimonial->position ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Рейтинг:</div>
                <div class="info-value rating">
                    @for($i = 0; $i < $testimonial->rating; $i++)⭐@endfor
                    ({{ $testimonial->rating }}/5)
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Порядок:</div>
                <div class="info-value">{{ $testimonial->sort_order }}</div>
            </div>

            <div class="info-row" style="border: none;">
                <div class="info-label">Статус:</div>
                <div class="info-value">
                    <span class="badge {{ $testimonial->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $testimonial->is_active ? 'Активен' : 'Скрыт' }}
                    </span>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <h3 style="margin-bottom: 15px;">Текст отзыва:</h3>
                <div class="content-box">
                    "{{ $testimonial->content }}"
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-warning">Редактировать</a>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Назад к списку</a>
            </div>
        </div>
    </div>
</body>
</html>

