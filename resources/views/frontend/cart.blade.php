@extends('frontend.layout')

@section('title', 'Корзина - GreenPlant')

@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url('{{ asset('assets/images/bg_6.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">Корзина покупок</h1>
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
                        <span>Корзина</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-cart">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if(count($cart) > 0)
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="cart-list">
                        <table class="table">
                            <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>&nbsp;</th>
                                    <th>Изображение</th>
                                    <th>Товар</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                <tr class="text-center">
                                    <td class="product-remove">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="border: none; background: none; color: #dc3545; cursor: pointer; font-size: 20px;" onclick="return confirm('Удалить товар из корзины?')">×</button>
                                        </form>
                                    </td>
                                    <td class="image-prod">
                                        <div class="img" style="background-image: url({{ $item['image'] ? asset('storage/' . $item['image']) : asset('assets/images/product-1.png') }});"></div>
                                    </td>
                                    <td class="product-name">
                                        <h3>{{ $item['name'] }}</h3>
                                    </td>
                                    <td class="price">{{ number_format($item['price'], 0, ',', ' ') }} ₽</td>
                                    <td class="quantity">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="cart-update-form" style="display: inline-flex; align-items: center; gap: 10px;">
                                            @csrf
                                            <input type="number" name="quantity" class="quantity form-control input-number cart-quantity-input" value="{{ $item['quantity'] }}" min="1" max="100" style="width: 80px; text-align: center;" data-product-id="{{ $id }}">
                                        </form>
                                    </td>
                                    <td class="total">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₽</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col col-lg-3 col-md-6 mt-5 cart-wrap ftco-animate">
                    <div class="cart-total mb-3">
                        <h3>Итого по корзине</h3>
                        <p class="d-flex">
                            <span>Товары</span>
                            <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
                        </p>
                        <p class="d-flex">
                            <span>Доставка</span>
                            <span>
                                @if($total >= (\App\Models\Setting::get('free_delivery_from', 10000)))
                                    Бесплатно
                                @else
                                    500 ₽
                                @endif
                            </span>
                        </p>
                        <hr>
                        <p class="d-flex total-price">
                            <span>Итого</span>
                            <span>
                                @if($total >= (\App\Models\Setting::get('free_delivery_from', 10000)))
                                    {{ number_format($total, 0, ',', ' ') }} ₽
                                @else
                                    {{ number_format($total + 500, 0, ',', ' ') }} ₽
                                @endif
                            </span>
                        </p>
                    </div>
                    <p class="text-center">
                        <a href="{{ route('checkout') }}" class="btn btn-primary">Оформить заказ</a>
                    </p>
                    <p class="text-center mt-2">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary" onclick="return confirm('Очистить корзину?')">Очистить корзину</button>
                        </form>
                    </p>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12">
                    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 15px;">
                        <div style="font-size: 64px; margin-bottom: 20px;">🛒</div>
                        <h3>Ваша корзина пуста</h3>
                        <p style="color: #666; margin: 20px 0;">Добавьте товары в корзину, чтобы оформить заказ</p>
                        <a href="{{ route('catalog') }}" class="btn btn-primary py-3 px-4">Перейти в каталог</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Автоматическое обновление корзины при изменении количества
    $('.cart-quantity-input').on('change', function() {
        const $input = $(this);
        const productId = $input.data('product-id');
        const quantity = $input.val();
        const form = $input.closest('form');
        const row = $input.closest('tr');
        
        // Сохраняем исходное значение
        const originalValue = $input.val();
        
        // Задержка перед блокировкой поля (2 секунды)
        const blockTimeout = setTimeout(function() {
            $input.prop('disabled', true);
        }, 2000);
        
        // Отправляем AJAX запрос
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                quantity: quantity
            },
            success: function(response) {
                // Отменяем блокировку, если она еще не произошла
                clearTimeout(blockTimeout);
                
                // Обновляем сумму товара в строке
                const price = parseFloat(row.find('.price').text().replace(/\s/g, '').replace('₽', ''));
                const newTotal = price * quantity;
                row.find('.total').text(newTotal.toLocaleString('ru-RU') + ' ₽');
                
                // Обновляем общую сумму корзины
                let totalCart = 0;
                $('.total').each(function() {
                    const totalText = $(this).text().replace(/\s/g, '').replace('₽', '');
                    totalCart += parseFloat(totalText);
                });
                
                // Обновляем итоговые суммы
                $('.cart-total p:contains("Товары") span:last').text(totalCart.toLocaleString('ru-RU') + ' ₽');
                
                // Обновляем итоговую сумму с доставкой
                const freeDeliveryFrom = {{ \App\Models\Setting::get('free_delivery_from', 10000) }};
                const deliveryCost = totalCart >= freeDeliveryFrom ? 0 : 500;
                const finalTotal = totalCart + deliveryCost;
                
                $('.total-price span:last').text(finalTotal.toLocaleString('ru-RU') + ' ₽');
                
                // Обновляем стоимость доставки
                $('.cart-total p:contains("Доставка") span:last').text(
                    deliveryCost === 0 ? 'Бесплатно' : '500 ₽'
                );
                
                // Гарантированно разблокируем поле ввода
                $input.prop('disabled', false);
                
                // Показываем уведомление об успехе
                showNotification('Корзина обновлена', 'success');
            },
            error: function(xhr) {
                // Отменяем блокировку, если она еще не произошла
                clearTimeout(blockTimeout);
                
                // Восстанавливаем исходное значение
                $input.val(originalValue);
                
                // Гарантированно разблокируем поле ввода
                $input.prop('disabled', false);
                
                showNotification('Ошибка при обновлении корзины', 'error');
            }
        });
    });
    
    // Функция для показа уведомлений
    function showNotification(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? '✓' : '✗';
        
        const notification = $('<div class="alert ' + alertClass + '" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; background: ' + 
            (type === 'success' ? '#d4edda' : '#f8d7da') + '; color: ' + 
            (type === 'success' ? '#155724' : '#721c24') + '; padding: 15px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">' +
            icon + ' ' + message + 
            '</div>');
        
        $('body').append(notification);
        
        setTimeout(function() {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 2000);
    }
});
</script>
@endsection

