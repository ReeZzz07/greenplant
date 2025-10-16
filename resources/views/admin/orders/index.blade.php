<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1400px; margin: 40px auto; padding: 0 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-header h2 { font-size: 28px; }
        .btn { padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s; border: none; cursor: pointer; font-size: 14px; }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8f9fa; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; }
        .badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #d1ecf1; color: #0c5460; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .actions { display: flex; gap: 8px; }
        .filters { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>🌲 GreenPlant CMS</h1>
            <a href="{{ route('admin.dashboard') }}">← Назад в панель</a>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>📦 Заказы</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        <!-- Filters -->
        <div class="filters">
            <strong>Фильтр:</strong>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : '' }}">Все</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : '' }}">Новые</a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="btn btn-sm {{ request('status') == 'processing' ? 'btn-primary' : '' }}">В обработке</a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="btn btn-sm {{ request('status') == 'completed' ? 'btn-primary' : '' }}">Завершенные</a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="btn btn-sm {{ request('status') == 'cancelled' ? 'btn-primary' : '' }}">Отмененные</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Номер заказа</th>
                        <th>Дата</th>
                        <th>Клиент</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            {{ $order->customer_name }}<br>
                            <small style="color: #666;">{{ $order->customer_phone }}</small>
                        </td>
                        <td><strong>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong></td>
                        <td>
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
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">Открыть</a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display: inline;" onsubmit="return confirm('Удалить заказ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                            Заказов пока нет
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="padding: 20px;">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</body>
</html>

