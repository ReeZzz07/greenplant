<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; margin-bottom: 20px; }
        .product-image { max-width: 400px; border-radius: 15px; margin-bottom: 30px; }
        .info-row { display: grid; grid-template-columns: 200px 1fr; gap: 15px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e9ecef; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { color: #333; }
        .badge { padding: 6px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-secondary { background: #6c757d; color: white; }
        .actions { display: flex; gap: 15px; margin-top: 30px; }
        h2 { margin-bottom: 30px; }
        .price { font-size: 32px; color: #28a745; font-weight: 600; }
        .old-price { text-decoration: line-through; color: #999; font-size: 20px; margin-right: 15px; }
        .description-box { background: #f8f9fa; padding: 25px; border-radius: 10px; margin-top: 20px; line-height: 1.8; }
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
            <h2>{{ $product->name }}</h2>

            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
            @endif

            <div class="info-row">
                <div class="info-label">Цена:</div>
                <div class="info-value">
                    @if($product->old_price)
                        <span class="old-price">{{ number_format($product->old_price, 0, ',', ' ') }} ₽</span>
                    @endif
                    <span class="price">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                    @if($product->discount_percent > 0)
                        <span class="badge badge-warning">Скидка -{{ $product->discount_percent }}%</span>
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Категория:</div>
                <div class="info-value">{{ $product->category->name ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Артикул (SKU):</div>
                <div class="info-value">{{ $product->sku ?? '-' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Остаток:</div>
                <div class="info-value">{{ $product->stock ?? 0 }} шт.</div>
            </div>

            <div class="info-row">
                <div class="info-label">Статус:</div>
                <div class="info-value">
                    <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $product->is_active ? 'Активен' : 'Скрыт' }}
                    </span>
                    @if($product->is_featured)
                        <span class="badge badge-warning">Хит продаж</span>
                    @endif
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">URL:</div>
                <div class="info-value">
                    <a href="{{ route('product', $product->slug) }}" target="_blank">{{ $product->slug }}</a>
                </div>
            </div>

            <div class="info-row" style="border: none;">
                <div class="info-label">Создан:</div>
                <div class="info-value">{{ $product->created_at->format('d.m.Y H:i') }}</div>
            </div>

            @if($product->short_description)
            <div style="margin-top: 20px;">
                <h3 style="margin-bottom: 15px;">Краткое описание:</h3>
                <div class="description-box">
                    {{ $product->short_description }}
                </div>
            </div>
            @endif

            @if($product->description)
            <div style="margin-top: 20px;">
                <h3 style="margin-bottom: 15px;">Полное описание:</h3>
                <div class="description-box">
                    {{ $product->description }}
                </div>
            </div>
            @endif

            <div class="actions">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">Редактировать</a>
                <a href="{{ route('product', $product->slug) }}" target="_blank" class="btn btn-primary">Посмотреть на сайте</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Назад к списку</a>
            </div>
        </div>
    </div>
</body>
</html>

