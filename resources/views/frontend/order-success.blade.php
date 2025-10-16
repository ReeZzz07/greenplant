@extends('frontend.layout')

@section('title', 'Заказ успешно оформлен - GreenPlant')

@section('content')
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="bg-white p-5 rounded text-center" style="box-shadow: 0 2px 20px rgba(0,0,0,0.1);">
                        <div style="font-size: 80px; color: #28a745; margin-bottom: 20px;">✓</div>
                        <h2 class="mb-4">Заказ успешно оформлен!</h2>
                        <p class="lead">Номер заказа: <strong>{{ $order->order_number }}</strong></p>
                        <p>Спасибо за ваш заказ! Мы свяжемся с вами в ближайшее время для подтверждения.</p>

                        <div class="mt-5 mb-4 text-left" style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
                            <h4 class="mb-3">Детали заказа:</h4>
                            <p><strong>Получатель:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p><strong>Телефон:</strong> <a href="tel:+79889385600">{{ $order->customer_phone }}</a></p>
                            <p><strong>Адрес доставки:</strong> {{ $order->customer_address }}</p>
                            @if($order->customer_comment)
                            <p><strong>Комментарий:</strong> {{ $order->customer_comment }}</p>
                            @endif
                            
                            <hr class="my-4">
                            
                            <h5 class="mb-3">Состав заказа:</h5>
                            @foreach($order->items as $item)
                            <p>{{ $item->product_name }} × {{ $item->quantity }} шт. — {{ number_format($item->subtotal, 0, ',', ' ') }} ₽</p>
                            @endforeach
                            
                            <hr class="my-4">
                            
                            <p class="mb-0"><strong>Итого:</strong> <span style="font-size: 24px; color: #28a745;">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span></p>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary py-3 px-5 mr-2">На главную</a>
                            <a href="{{ route('catalog') }}" class="btn btn-outline-primary py-3 px-5">Продолжить покупки</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

