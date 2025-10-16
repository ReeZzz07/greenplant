<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ {{ $order->order_number }} - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; margin-bottom: 20px; }
        .info-row { display: grid; grid-template-columns: 200px 1fr; gap: 15px; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #e9ecef; }
        .info-label { font-weight: 600; color: #666; }
        .info-value { color: #333; }
        .badge { padding: 6px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-sm { padding: 8px 16px; font-size: 13px; }
        .actions { display: flex; gap: 15px; margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { background: #f8f9fa; font-weight: 600; }
        h2, h3 { margin-bottom: 20px; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .status-form { background: #f8f9fa; padding: 20px; border-radius: 10px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.orders.index') }}">← К списку заказов</a>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h2>Заказ {{ $order->order_number }}</h2>
                @switch($order->status)
                    @case('pending')
                        <span class="badge badge-warning">Новый</span>
                        @break
                    @case('processing')
                        <span class="badge badge-info">В обработке</span>
                        @break
                    @case('completed')
                        <span class="badge badge-success">Завершен</span>
                        @break
                    @case('cancelled')
                        <span class="badge badge-danger">Отменен</span>
                        @break
                @endswitch
            </div>

            <h3>Информация о клиенте</h3>
            <div class="info-row">
                <div class="info-label">Имя:</div>
                <div class="info-value">{{ $order->customer_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value"><a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a></div>
            </div>
            <div class="info-row">
                <div class="info-label">Телефон:</div>
                <div class="info-value"><a href="tel:+79889385600">{{ $order->customer_phone }}</a></div>
            </div>
            <div class="info-row">
                <div class="info-label">Адрес доставки:</div>
                <div class="info-value">{{ $order->customer_address }}</div>
            </div>
            @if($order->customer_comment)
            <div class="info-row">
                <div class="info-label">Комментарий:</div>
                <div class="info-value">{{ $order->customer_comment }}</div>
            </div>
            @endif

            <div class="info-row">
                <div class="info-label">Способ оплаты:</div>
                <div class="info-value">
                    @switch($order->payment_method)
                        @case('cash') Наличными @break
                        @case('card') Картой @break
                        @case('online') Онлайн оплата @break
                    @endswitch
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Способ доставки:</div>
                <div class="info-value">
                    {{ $order->delivery_method == 'delivery' ? 'Доставка курьером' : 'Самовывоз' }}
                </div>
            </div>

            <div class="info-row" style="border: none;">
                <div class="info-label">Дата заказа:</div>
                <div class="info-value">{{ $order->created_at->format('d.m.Y H:i') }}</div>
            </div>

            <h3 style="margin-top: 30px;">Состав заказа</h3>
            <table>
                <thead>
                    <tr>
                        <th>Товар</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            @if($item->product)
                                <a href="{{ route('admin.products.show', $item->product) }}">{{ $item->product_name }}</a>
                            @else
                                {{ $item->product_name }}
                            @endif
                        </td>
                        <td>{{ number_format($item->product_price, 0, ',', ' ') }} ₽</td>
                        <td>{{ $item->quantity }} шт.</td>
                        <td><strong>{{ number_format($item->subtotal, 0, ',', ' ') }} ₽</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Итого:</strong></td>
                        <td><strong style="font-size: 20px; color: #28a745;">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Изменение статуса -->
            <div class="status-form">
                <h4 style="margin-bottom: 15px;">Изменить статус заказа</h4>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" style="display: flex; gap: 15px; align-items: center;">
                    @csrf
                    <select name="status" class="form-control" style="width: 200px; padding: 10px;">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Новый</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В обработке</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Завершен</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Обновить статус</button>
                </form>
            </div>

            <div class="actions">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Назад к списку</a>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить заказ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background: #dc3545; color: white;">Удалить заказ</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

