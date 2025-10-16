// Функция для добавления товара в корзину
function addToCart(productId, quantity = 1, successCallback = null, errorCallback = null) {
    const formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        quantity: quantity
    };

    $.ajax({
        url: `/cart/add/${productId}`,
        method: 'POST',
        data: formData,
        beforeSend: function() {
            // Не блокируем кнопки глобально, это делается в обработчике формы
        },
        success: function(response) {
            // Обновляем счетчик корзины
            updateCartCount(response.cartCount);
            
            // Показываем уведомление
            showNotification(response.message, 'success');
            
            // Вызываем success callback, если он передан
            if (successCallback && typeof successCallback === 'function') {
                successCallback();
            }
        },
        error: function(xhr) {
            console.error('Ошибка при добавлении товара в корзину:', xhr);
            showNotification('Ошибка при добавлении товара в корзину', 'error');
            
            // Вызываем error callback, если он передан
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback();
            }
        }
    });
}

// Функция для обновления счетчика корзины
function updateCartCount(count) {
    $('.cart-count').text(count);
    $('.cart-count-badge').text(count);
}

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
    }, 3000);
}

// Обработчик клика на кнопку "В корзину +"
$(document).ready(function() {
    // Обработчик клика на кнопку "В корзину +" - показывает поле quantity
    $(document).on('click', '.show-quantity-btn', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Предотвращаем всплытие события
        
        const form = $(this).closest('.add-to-cart-form');
        const btnContainer = form.find('.add-to-cart-btn-container');
        const quantityContainer = form.find('.quantity-selector-container');
        
        // Закрываем все другие открытые поля quantity
        $('.quantity-selector-container').each(function() {
            const otherForm = $(this).closest('.add-to-cart-form');
            if (!otherForm.is(form)) {
                const otherBtnContainer = otherForm.find('.add-to-cart-btn-container');
                
                // Сначала скрываем контейнер quantity
                $(this).fadeOut(300);
                
                // Сброс значения quantity
                otherForm.find('.quantity-input').val(1);
                
                // Показываем кнопку "В корзину +" с задержкой
                setTimeout(function() {
                    otherBtnContainer.fadeIn(300);
                }, 300);
            }
        });
        
        // Плавное скрытие кнопки "В корзину +"
        btnContainer.fadeOut(300, function() {
            // Плавное появление поля quantity
            quantityContainer.fadeIn(300);
            // Фокус на поле quantity
            quantityContainer.find('.quantity-input').focus().select();
        });
    });
    
    // Обработчик клика вне карточки товара - закрывает открытое поле quantity
    $(document).on('click', function(e) {
        // Проверяем, не кликнули ли мы на элементы формы добавления в корзину
        if (!$(e.target).closest('.add-to-cart-form').length) {
            // Закрываем все открытые поля quantity
            $('.quantity-selector-container').each(function() {
                const form = $(this).closest('.add-to-cart-form');
                const btnContainer = form.find('.add-to-cart-btn-container');
                
                // Плавно скрываем контейнер quantity
                $(this).fadeOut(300, function() {
                    // Показываем кнопку "В корзину +" после полного скрытия quantity
                    btnContainer.fadeIn(300);
                    
                    // Сброс значения quantity
                    form.find('.quantity-input').val(1);
                });
            });
        }
    });
    
    // Обработчик клика внутри формы - предотвращает закрытие
    $(document).on('click', '.add-to-cart-form', function(e) {
        e.stopPropagation(); // Предотвращаем всплытие события
    });
    
    // Обработчик отправки формы с подтверждением количества
    $(document).on('submit', '.add-to-cart-form', function(e) {
        e.preventDefault();
        e.stopPropagation(); // Предотвращаем всплытие события
        
        const form = $(this);
        const productId = form.find('input[name="product_id"]').val();
        const quantityInput = form.find('.quantity-input');
        const quantity = quantityInput.length > 0 ? parseInt(quantityInput.val()) : 1;
        
        // Валидация количества
        if (quantity < 1) {
            showNotification('Количество должно быть больше 0', 'error');
            quantityInput.focus();
            return;
        }
        
        // Блокируем кнопку подтверждения только для этой формы
        const confirmBtn = form.find('.confirm-quantity-btn');
        confirmBtn.prop('disabled', true);
        
        // Добавляем товар в корзину
        addToCart(productId, quantity, function() {
            // После успешного добавления возвращаем исходное состояние
            const quantityContainer = form.find('.quantity-selector-container');
            const btnContainer = form.find('.add-to-cart-btn-container');
            
            // Плавно скрываем контейнер quantity
            quantityContainer.fadeOut(300, function() {
                // Сброс значения quantity
                quantityInput.val(1);
                
                // Показываем кнопку "В корзину +" после полного скрытия quantity
                btnContainer.fadeIn(300);
                
                // Разблокируем кнопку для этой формы
                confirmBtn.prop('disabled', false);
            });
        }, function() {
            // В случае ошибки разблокируем кнопку
            confirmBtn.prop('disabled', false);
        });
    });
    
    // Обработчик для страницы продукта
    $(document).on('submit', '.product-details form[action*="cart/add"]', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const url = form.attr('action');
        const productId = url.match(/\/cart\/add\/(\d+)/)[1];
        const quantityInput = form.find('input[name="quantity"]');
        const quantity = quantityInput.length > 0 ? parseInt(quantityInput.val()) : 1;
        
        // Валидация количества
        if (quantity < 1) {
            showNotification('Количество должно быть больше 0', 'error');
            return;
        }
        
        addToCart(productId, quantity);
    });
    
    // Обработчик нажатия Enter в поле quantity
    $(document).on('keypress', '.quantity-input', function(e) {
        if (e.which === 13) { // Enter
            e.preventDefault();
            $(this).closest('.add-to-cart-form').submit();
        }
    });
});

