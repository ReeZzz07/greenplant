@extends('frontend.layout')

@section('title', 'Мои заказы - GreenPlant')

@section('content')
@include('frontend.account.partials.hero', ['title' => 'Мои заказы'])

<!-- Breadcrumbs Section -->
<section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="breadcrumbs mb-0">
                    <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                    <span class="mr-2"><a href="{{ route('account.dashboard') }}">Кабинет</a></span>
                    <span>Заказы</span>
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

            <!-- Orders List -->
            <div class="col-md-9">
                <div class="card p-4" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                    <h4 class="mb-4"><i class="fas fa-shopping-bag"></i> История заказов</h4>
                    
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                            <div class="card mb-3" style="border: 1px solid #e0e0e0; border-radius: 8px;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <h6 style="margin: 0;">{{ $order->order_number }}</h6>
                                            <small class="text-muted">{{ $order->created_at->format('d.m.Y в H:i') }}</small>
                                        </div>
                                        <div class="col-md-2">
                                            <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong>
                                        </div>
                                        <div class="col-md-3">
                                            @if($order->status === 'pending')
                                                <span class="badge badge-warning">Новый</span>
                                            @elseif($order->status === 'processing')
                                                <span class="badge badge-primary">В обработке</span>
                                            @elseif($order->status === 'completed')
                                                <span class="badge badge-success">Завершен</span>
                                            @else
                                                <span class="badge badge-danger">Отменен</span>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <small class="text-muted">{{ $order->items->count() }} товар(ов)</small>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <a href="{{ route('account.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Подробнее</a>
                                        </div>
                                    </div>
                                    
                                    <!-- Товары в заказе -->
                                    <hr class="mt-3 mb-3">
                                    <div class="row">
                                        @foreach($order->items->take(3) as $item)
                                            <div class="col-md-4 mb-2">
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                             alt="{{ $item->product_name }}" 
                                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; margin-right: 10px;">
                                                    @endif
                                                    <div>
                                                        <small><strong>{{ $item->product_name }}</strong></small><br>
                                                        <small class="text-muted">{{ $item->quantity }} шт. × {{ number_format($item->product_price, 0, ',', ' ') }} ₽</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 3)
                                            <div class="col-md-12">
                                                <small class="text-muted">и ещё {{ $order->items->count() - 3 }} товар(ов)...</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag" style="font-size: 64px; color: #ccc;"></i>
                            <p class="text-muted mt-3">У вас пока нет заказов</p>
                            <a href="{{ route('catalog') }}" class="btn btn-primary">Начать покупки</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

