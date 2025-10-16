<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; margin-bottom: 20px; }
        .info-row { display: grid; grid-template-columns: 200px 1fr; gap: 15px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e9ecef; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { color: #333; }
        .badge { padding: 6px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-secondary { background: #6c757d; color: white; }
        .actions { display: flex; gap: 15px; margin-top: 30px; }
        h2 { margin-bottom: 30px; }
        h3 { margin: 30px 0 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { background: #f8f9fa; font-weight: 600; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.categories.index') }}">← К списку категорий</a>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <h2>{{ $category->name }}</h2>

            <div class="info-row">
                <div class="info-label">URL (slug):</div>
                <div class="info-value"><code>{{ $category->slug }}</code></div>
            </div>

            <div class="info-row">
                <div class="info-label">Родительская:</div>
                <div class="info-value">{{ $category->parent->name ?? 'Нет (корневая)' }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Товаров:</div>
                <div class="info-value">{{ $category->products->count() }} шт.</div>
            </div>

            <div class="info-row">
                <div class="info-label">Порядок:</div>
                <div class="info-value">{{ $category->sort_order }}</div>
            </div>

            <div class="info-row" style="border: none;">
                <div class="info-label">Статус:</div>
                <div class="info-value">
                    <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $category->is_active ? 'Активна' : 'Скрыта' }}
                    </span>
                </div>
            </div>

            @if($category->description)
            <div style="margin-top: 20px;">
                <h3>Описание:</h3>
                <p style="line-height: 1.6; color: #666;">{{ $category->description }}</p>
            </div>
            @endif

            @if($category->products->count() > 0)
            <h3>Товары в категории:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Остаток</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->products as $product)
                    <tr>
                        <td><a href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a></td>
                        <td>{{ number_format($product->price, 0, ',', ' ') }} ₽</td>
                        <td>{{ $product->stock }} шт.</td>
                        <td>
                            <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $product->is_active ? 'Активен' : 'Скрыт' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if($category->children->count() > 0)
            <h3>Подкатегории:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Товаров</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->children as $child)
                    <tr>
                        <td><a href="{{ route('admin.categories.show', $child) }}">{{ $child->name }}</a></td>
                        <td>{{ $child->products->count() }}</td>
                        <td>
                            <span class="badge {{ $child->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $child->is_active ? 'Активна' : 'Скрыта' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <div class="actions">
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Редактировать</a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Назад к списку</a>
            </div>
        </div>
    </div>
</body>
</html>

