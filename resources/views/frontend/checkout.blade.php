@extends('frontend.layout')

@section('title', 'Оформление заказа - GreenPlant')

@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url('{{ asset('assets/images/bg_6.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">Оформление заказа</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumbs Section -->
    <section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="breadcrumbs mb-0">
                        <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                        <span class="mr-2"><a href="{{ route('cart.index') }}">Корзина</a></span>
                        <span>Оформление заказа</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            @if(session('error'))
                <div class="alert alert-danger mb-4" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="billing-form bg-white p-5 rounded">
                            @auth
                                @if(auth()->user()->hasRole('customer'))
                                    <div class="alert alert-info mb-4">
                                        <i class="fas fa-user"></i> Вы вошли как <strong>{{ auth()->user()->name }}</strong>
                                        @if($addresses->count() > 0)
                                            <span class="ml-3">
                                                <i class="fas fa-map-marker-alt"></i> У вас {{ $addresses->count() }} сохраненных адресов
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-warning mb-4">
                                    💡 <strong>Совет:</strong> <a href="{{ route('customer.auth') }}" style="font-weight: bold;">Войдите или зарегистрируйтесь</a>, чтобы отслеживать заказы и сохранять адреса доставки
                                </div>
                            @endauth

                            @if(auth()->check() && auth()->user()->hasRole('customer') && $addresses->count() > 0)
                                <h3 class="mb-4">Выберите адрес или заполните новый</h3>
                                <div class="mb-4">
                                    <label class="d-block mb-2"><strong>Сохраненные адреса:</strong></label>
                                    @foreach($addresses as $address)
                                        <div class="form-check mb-2 p-3" style="border: 1px solid #e0e0e0; border-radius: 8px;">
                                            <input class="form-check-input" type="radio" name="saved_address_id" id="address_{{ $address->id }}" 
                                                   value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}
                                                   onchange="fillAddressFromSaved({{ $address->id }}, '{{ $address->full_name }}', '{{ $address->phone }}', '{{ $address->full_address }}')">
                                            <label class="form-check-label" for="address_{{ $address->id }}" style="cursor: pointer;">
                                                <strong>{{ $address->label }}</strong> @if($address->is_default) <span class="badge badge-success">Основной</span> @endif<br>
                                                <small>{{ $address->full_name }}, {{ $address->phone }}<br>{{ $address->full_address }}</small>
                                            </label>
                                        </div>
                                    @endforeach
                                    <div class="form-check p-3" style="border: 1px solid #e0e0e0; border-radius: 8px;">
                                        <input class="form-check-input" type="radio" name="saved_address_id" id="new_address" value="" onclick="clearAddressFields()">
                                        <label class="form-check-label" for="new_address" style="cursor: pointer;">
                                            <strong>✏️ Указать новый адрес</strong>
                                        </label>
                                    </div>
                                </div>
                                <hr class="mb-4">
                            @endif

                            <h3 class="mb-4">Контактные данные</h3>
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="customer_name">Ваше имя *</label>
                                        <input type="text" id="customer_name" name="customer_name" class="form-control" 
                                               value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                                        @error('customer_name')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_email">Email *</label>
                                        <input type="email" id="customer_email" name="customer_email" class="form-control" 
                                               value="{{ old('customer_email', auth()->user()->email ?? '') }}" required>
                                        @error('customer_email')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_phone">Телефон *</label>
                                        <input type="tel" id="customer_phone" name="customer_phone" class="form-control" 
                                               value="{{ old('customer_phone', $defaultAddress->phone ?? '') }}" required>
                                        @error('customer_phone')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="customer_address">Адрес доставки *</label>
                                        <textarea id="customer_address" name="customer_address" class="form-control" rows="3" required>{{ old('customer_address', $defaultAddress->full_address ?? '') }}</textarea>
                                        @error('customer_address')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="customer_comment">Комментарий к заказу</label>
                                        <textarea id="customer_comment" name="customer_comment" class="form-control" rows="2">{{ old('customer_comment') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <h3 class="mb-4 mt-5">Способ доставки</h3>
                            <div class="form-group">
                                <div class="select-wrap">
                                    <select name="delivery_method" class="form-control" required>
                                        <option value="delivery" {{ old('delivery_method') == 'delivery' ? 'selected' : '' }}>Доставка курьером</option>
                                        <option value="pickup" {{ old('delivery_method') == 'pickup' ? 'selected' : '' }}>Самовывоз из питомника</option>
                                    </select>
                                </div>
                            </div>

                            <h3 class="mb-4 mt-4">Способ оплаты</h3>
                            <div class="form-group">
                                <div class="select-wrap">
                                    <select name="payment_method" class="form-control" required>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Наличными при получении</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Картой при получении</option>
                                        {{-- Будет доступно позже --}}
                                        {{-- <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Онлайн оплата</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="row mt-5 pt-3">
                            <div class="col-md-12 d-flex mb-5">
                                <div class="cart-detail cart-total bg-light p-4 rounded">
                                    <h3 class="billing-heading mb-4">Итого по заказу</h3>
                                    @foreach($cart as $item)
                                    <p class="d-flex">
                                        <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                                        <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₽</span>
                                    </p>
                                    @endforeach
                                    <hr>
                                    <p class="d-flex">
                                        <span>Товары</span>
                                        <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
                                    </p>
                                    <p class="d-flex">
                                        <span>Доставка</span>
                                        <span>{{ $deliveryCost > 0 ? number_format($deliveryCost, 0, ',', ' ') . ' ₽' : 'Бесплатно' }}</span>
                                    </p>
                                    <hr>
                                    <p class="d-flex total-price">
                                        <span><strong>Итого</strong></span>
                                        <span><strong>{{ number_format($total + $deliveryCost, 0, ',', ' ') }} ₽</strong></span>
                                    </p>

                                    @if($total < \App\Models\Setting::get('free_delivery_from', 10000))
                                    <div style="background: #fff3cd; padding: 10px; border-radius: 8px; margin-top: 15px; font-size: 13px; color: #856404;">
                                        Добавьте товаров еще на {{ number_format(\App\Models\Setting::get('free_delivery_from', 10000) - $total, 0, ',', ' ') }} ₽ для бесплатной доставки
                                    </div>
                                    @endif

                                    <p class="mt-4">
                                        <button type="submit" class="btn btn-primary py-3 px-4" style="width: 100%;">Оформить заказ</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
    function fillAddressFromSaved(id, fullName, phone, address) {
        document.getElementById('customer_name').value = fullName;
        document.getElementById('customer_phone').value = phone;
        document.getElementById('customer_address').value = address;
    }

    function clearAddressFields() {
        document.getElementById('customer_name').value = '{{ auth()->user()->name ?? '' }}';
        document.getElementById('customer_phone').value = '';
        document.getElementById('customer_address').value = '';
    }

    // Автозаполнение при загрузке страницы если выбран адрес по умолчанию
    @if(auth()->check() && $defaultAddress)
        window.addEventListener('DOMContentLoaded', function() {
            fillAddressFromSaved({{ $defaultAddress->id }}, '{{ $defaultAddress->full_name }}', '{{ $defaultAddress->phone }}', '{{ $defaultAddress->full_address }}');
        });
    @endif
    </script>
@endsection

