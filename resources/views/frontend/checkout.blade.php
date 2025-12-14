@extends('frontend.layout')

@section('title', 'Оформление заказа - GreenPlant')

@section('content')
    <style>
        .billing-form .form-group label {
            font-weight: 600;
            color: #333;
            font-size: 15px;
            margin-bottom: 10px;
            display: block;
        }
        
        .billing-form .form-control {
            color: #333 !important;
            font-size: 16px !important;
            font-weight: 400 !important;
            padding: 12px 15px !important;
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            background-color: #fff !important;
        }
        
        .billing-form .form-control:focus {
            border-color: #82ae46 !important;
            box-shadow: 0 0 0 0.2rem rgba(130, 174, 70, 0.15) !important;
            outline: none !important;
        }
        
        .billing-form textarea.form-control {
            resize: vertical;
            min-height: 100px;
            line-height: 1.5;
        }
        
        .billing-form select.form-control {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e") !important;
            background-position: right 12px center !important;
            background-repeat: no-repeat !important;
            background-size: 16px !important;
            padding-right: 40px !important;
        }
        
        .billing-form h3 {
            font-weight: 700;
            color: #333;
            font-size: 22px;
            margin-bottom: 20px;
        }
        
        .billing-form .select-wrap {
            position: relative;
        }
    </style>
    <!-- Page Header -->
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden;">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ $catalogSettings && $catalogSettings->background_image ? asset('storage/' . $catalogSettings->background_image) : asset('assets/images/bg_6.jpg') }}'); background-size: {{ $catalogSettings && $catalogSettings->background_size ? $catalogSettings->background_size : 'cover' }}; background-position: {{ $catalogSettings && $catalogSettings->background_position ? $catalogSettings->background_position : 'center center' }}; background-repeat: no-repeat; z-index: 0;"></div>
        @if($catalogSettings && $catalogSettings->overlay_type !== 'none')
            <div class="overlay-layer" style="background: @if($catalogSettings->overlay_type === 'darken') rgba(0, 0, 0, {{ $catalogSettings->overlay_opacity / 100 }}) @elseif($catalogSettings->overlay_type === 'lighten') rgba(255, 255, 255, {{ $catalogSettings->overlay_opacity / 100 }}) @endif; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        @endif
        <div class="container" style="position: relative; z-index: 1;">
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
                                        @forelse($paymentMethods as $method)
                                            <option value="{{ $method['value'] }}" {{ old('payment_method') == $method['value'] ? 'selected' : '' }}>{{ $method['label'] }}</option>
                                        @empty
                                            <option value="">Нет доступных способов оплаты</option>
                                        @endforelse
                                    </select>
                                </div>
                                @if($paymentMethodsText)
                                    <small style="color: #666; display: block; margin-top: 8px;">{!! $paymentMethodsText !!}</small>
                                @endif
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
                                    <div style="background: #fff3cd; padding: 12px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #ffc107;">
                                        <p class="mb-0" style="font-size: 13px; color: #856404; margin: 0;">
                                            <strong>Доставка:</strong> Стоимость доставки рассчитывается менеджером, при подтверждении заказа!
                                        </p>
                                    </div>
                                    <hr>
                                    <p class="d-flex total-price">
                                        <span><strong>Итого</strong></span>
                                        <span><strong>{{ number_format($total, 0, ',', ' ') }} ₽</strong></span>
                                    </p>

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

