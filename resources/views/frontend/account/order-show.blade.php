@extends('frontend.layout')

@section('title', 'Заказ ' . $order->order_number . ' - GreenPlant')

@section('content')
@include('frontend.account.partials.hero', ['title' => 'Заказ ' . $order->order_number])

<!-- Breadcrumbs Section -->
<section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="breadcrumbs mb-0">
                    <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                    <span class="mr-2"><a href="{{ route('account.dashboard') }}">Кабинет</a></span>
                    <span class="mr-2"><a href="{{ route('account.orders') }}">Заказы</a></span>
                    <span>{{ $order->order_number }}</span>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                @include('frontend.account.partials.sidebar')
            </div>

            <!-- Order Details -->
            <div class="col-md-9">
                <!-- Статус заказа -->
                <div class="card p-4 mb-4" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 style="margin: 0;">{{ $order->order_number }}</h4>
                            <small class="text-muted">от {{ $order->created_at->format('d.m.Y в H:i') }}</small>
                        </div>
                        <div class="col-md-6 text-right">
                                            @if($order->status === 'pending')
                                                <span class="badge badge-warning" style="font-size: 16px; padding: 8px 16px;">Новый</span>
                                            @elseif($order->status === 'processing')
                                                <span class="badge badge-primary" style="font-size: 16px; padding: 8px 16px;">В обработке</span>
                                            @elseif($order->status === 'completed')
                                                <span class="badge badge-success" style="font-size: 16px; padding: 8px 16px;">Завершен</span>
                                            @else
                                                <span class="badge badge-danger" style="font-size: 16px; padding: 8px 16px;">Отменен</span>
                                            @endif
                        </div>
                    </div>
                </div>

                <!-- Товары в заказе -->
                <div class="card p-4 mb-4" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                    <h5 class="mb-4"><i class="fas fa-box"></i> Состав заказа</h5>
                    
                    <div class="table-responsive">
                        <table class="table">
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
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                         alt="{{ $item->product_name }}" 
                                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                                                @endif
                                                <div>
                                                    <strong>{{ $item->product_name }}</strong>
                                                    @if($item->product)
                                                        <br><small><a href="{{ route('product', $item->product->slug) }}" target="_blank">Посмотреть товар</a></small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ number_format($item->product_price, 0, ',', ' ') }} ₽</td>
                                        <td>{{ $item->quantity }} шт.</td>
                                        <td><strong>{{ number_format($item->subtotal, 0, ',', ' ') }} ₽</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Итого:</strong></td>
                                    <td><strong style="font-size: 18px;">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Информация о доставке -->
                <div class="card p-4" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                    <h5 class="mb-4"><i class="fas fa-truck"></i> Информация о доставке</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Получатель:</strong><br>{{ $order->customer_name }}</p>
                            <p><strong>Телефон:</strong><br><a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a></p>
                            <p><strong>Email:</strong><br>{{ $order->customer_email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Адрес доставки:</strong><br>{{ $order->customer_address }}</p>
                            <p><strong>Способ доставки:</strong><br>
                                @if($order->delivery_method === 'delivery')
                                    Доставка курьером
                                @else
                                    Самовывоз
                                @endif
                            </p>
                            <p><strong>Способ оплаты:</strong><br>
                                @if($order->payment_method === 'cash')
                                    Наличными
                                @elseif($order->payment_method === 'card')
                                    Картой курьеру
                                @else
                                    Онлайн-оплата
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($order->customer_comment)
                        <hr>
                        <p><strong>Комментарий к заказу:</strong><br>{{ $order->customer_comment }}</p>
                    @endif
                </div>

                <div class="mt-4">
                    <a href="{{ route('account.orders') }}" class="btn btn-secondary">← Назад к заказам</a>
                    @if($order->status === 'pending')
                        <span class="badge badge-info" style="font-size: 14px; padding: 10px 20px;"><i class="fas fa-info-circle"></i> Наш менеджер скоро свяжется с вами</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

