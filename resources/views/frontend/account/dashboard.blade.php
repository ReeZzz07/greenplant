@extends('frontend.layout')

@section('title', 'Мой кабинет - GreenPlant')

@section('content')
@include('frontend.account.partials.hero', ['title' => 'Мой кабинет'])

<!-- Breadcrumbs Section -->
<section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="breadcrumbs mb-0">
                    <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                    <span>Личный кабинет</span>
                </p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                @include('frontend.account.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Статистика -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card p-4 text-center" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 10px;">
                            <h2 style="color: white; margin: 0; font-size: 36px;">{{ $orders->total() }}</h2>
                            <p style="margin: 5px 0 0; color: rgba(255,255,255,0.9);">Всего заказов</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card p-4 text-center" style="background: linear-gradient(135deg, #82ae46, #6a9237); color: white; border-radius: 10px;">
                            <h2 style="color: white; margin: 0; font-size: 36px;">{{ $addresses->count() }}</h2>
                            <p style="margin: 5px 0 0; color: rgba(255,255,255,0.9);">Адресов</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card p-4 text-center" style="background: linear-gradient(135deg, #ffc107, #ff9800); color: white; border-radius: 10px;">
                            <h2 style="color: white; margin: 0; font-size: 36px;">{{ $orders->where('status', 'pending')->count() }}</h2>
                            <p style="margin: 5px 0 0; color: rgba(255,255,255,0.9);">В обработке</p>
                        </div>
                    </div>
                </div>

                <!-- Последние заказы -->
                <div class="card p-4 mb-4" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                    <h4 class="mb-3"><i class="fas fa-shopping-bag"></i> Последние заказы</h4>
                    
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Номер заказа</th>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders->take(5) as $order)
                                        <tr>
                                            <td><strong>{{ $order->order_number }}</strong></td>
                                            <td><small class="text-muted">{{ $order->created_at->format('d.m.Y') }}</small></td>
                                            <td><strong>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</strong></td>
                                            <td>
                                                @if($order->status === 'pending')
                                                    <span class="badge badge-warning">Новый</span>
                                                @elseif($order->status === 'processing')
                                                    <span class="badge badge-primary">В обработке</span>
                                                @elseif($order->status === 'completed')
                                                    <span class="badge badge-success">Завершен</span>
                                                @else
                                                    <span class="badge badge-danger">Отменен</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('account.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Детали</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($orders->total() > 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('account.orders') }}" class="btn btn-primary">Показать все заказы</a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag" style="font-size: 48px; color: #ccc;"></i>
                            <p class="text-muted mt-3">У вас пока нет заказов</p>
                            <a href="{{ route('catalog') }}" class="btn btn-primary">Начать покупки</a>
                        </div>
                    @endif
                </div>

                <!-- Быстрые действия -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('catalog') }}" class="card p-4 d-block" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-decoration: none; color: #333;">
                            <h5><i class="fas fa-shopping-cart"></i> Каталог товаров</h5>
                            <p class="text-muted mb-0">Посмотреть все товары</p>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('account.addresses') }}" class="card p-4 d-block" style="background: white; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); text-decoration: none; color: #333;">
                            <h5><i class="fas fa-map-marker-alt"></i> Адреса доставки</h5>
                            <p class="text-muted mb-0">Управление адресами</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

