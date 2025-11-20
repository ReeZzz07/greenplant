@extends('frontend.layout')

@section('title', 'Контакты - GreenPlant')

@section('content')
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden;">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ $contactSettings && $contactSettings->background_image ? asset('storage/' . $contactSettings->background_image) : asset('assets/images/bg_6.jpg') }}'); background-size: {{ $contactSettings && $contactSettings->background_size ? $contactSettings->background_size : 'cover' }}; background-position: {{ $contactSettings && $contactSettings->background_position ? $contactSettings->background_position : 'center center' }}; background-repeat: no-repeat; z-index: 0;"></div>
        @if($contactSettings && $contactSettings->overlay_type !== 'none')
            <div class="overlay-layer" style="background: @if($contactSettings->overlay_type === 'darken') rgba(0, 0, 0, {{ $contactSettings->overlay_opacity / 100 }}) @elseif($contactSettings->overlay_type === 'lighten') rgba(255, 255, 255, {{ $contactSettings->overlay_opacity / 100 }}) @endif; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        @endif
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ $contactSettings && $contactSettings->title ? $contactSettings->title : 'Свяжитесь с нами' }}</h1>
                    @if($contactSettings && $contactSettings->subtitle)
                        <p class="mt-3" style="color: rgba(255, 255, 255, 0.9); font-size: 18px;">{{ $contactSettings->subtitle }}</p>
                    @endif
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
                        <span>Контакты</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section contact-section bg-light">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success mb-4" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; border: 1px solid #c3e6cb;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <div class="row d-flex mb-5 contact-info">
                <div class="w-100"></div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Адрес:</span> {{ $address }}</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Телефон:</span> <a href="tel:+79889385600">{{ $phone }}</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Email:</span> <a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Режим работы:</span>
                        {{ \App\Models\Setting::get('work_days', 'Пн-Пт: 9:00 - 18:00') }}<br>
                        {{ \App\Models\Setting::get('weekend_hours', 'Сб-Вс: 10:00 - 16:00') }}</p>
                    </div>
                </div>
            </div>

            <div class="row block-9">
                <div class="col-md-6 order-md-last d-flex">
                    <form action="{{ route('contact.send') }}" method="POST" class="bg-white contact-form">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Ваше имя *" value="{{ old('name') }}" required>
                            @error('name')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email *" value="{{ old('email') }}" required>
                            @error('email')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" placeholder="Телефон" value="{{ old('phone') }}">
                            @error('phone')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <textarea name="message" cols="30" rows="7" class="form-control" placeholder="Сообщение *" required>{{ old('message') }}</textarea>
                            @error('message')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <div id="cf-turnstile-widget"></div>
                            <input type="hidden" name="cf-turnstile-response" id="cf-turnstile-response">
                            @error('cf-turnstile-response')<div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Отправить сообщение" class="btn btn-primary py-3 px-5" id="contact-submit-btn">
                        </div>
                    </form>
                </div>

                <div class="col-md-6 d-flex">
                    <div class="bg-white">
                        <h3 class="p-4">{{ $contactSettings && $contactSettings->contact_section_title ? $contactSettings->contact_section_title : 'Свяжитесь с нами' }}</h3>
                        <div class="p-4">
                            @if($contactSettings && $contactSettings->contact_section_content)
                                {!! nl2br($contactSettings->contact_section_content) !!}
                            @else
                                <p>Мы всегда рады ответить на ваши вопросы о наших растениях, помочь с выбором сорта туи или проконсультировать по посадке и уходу.</p>
                                
                                <p><strong>Телефон:</strong> <a href="tel:+79889385600">{{ $phone }}</a><br>
                                <strong>Email:</strong> <a href="mailto:{{ $email }}">{{ $email }}</a><br>
                                <strong>Адрес:</strong> <a href="https://yandex.ru/maps/11013/the-kabardino-balkar-republic/house/ulitsa_lenina_161/YEoYcAdjTEwCQFppfXl4cnpnYw==/?ll=43.603595%2C43.593648&z=17.6" target="_blank">{{ $address }}</a><br>
                                <strong>Режим работы:</strong><br>
                                {{ \App\Models\Setting::get('work_days', 'Пн-Пт: 9:00 - 18:00') }}<br>
                                {{ \App\Models\Setting::get('weekend_hours', 'Сб-Вс: 10:00 - 16:00') }}</p>

                                <p>Вы также можете посетить наш питомник лично. Мы покажем все растения, расскажем о каждом сорте и поможем сделать правильный выбор.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Яндекс Карта -->
    @if($contactSettings && $contactSettings->map_embed_code)
        <section class="ftco-section" style="padding: 0;">
            <div style="width: 100%; min-height: 500px; position: relative;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                    {!! $contactSettings->map_embed_code !!}
                </div>
            </div>
        </section>
        <style>
            /* Автоматическая подстройка iframe карты */
            .ftco-section iframe {
                width: 100% !important;
                height: 500px !important;
                border: 0;
            }
        </style>
    @elseif($contactSettings && $contactSettings->map_latitude && $contactSettings->map_longitude)
        <!-- Резервный вариант с API (если указаны координаты, но не указан код вставки) -->
        <section class="ftco-section" style="padding: 0;">
            <div id="map" style="width: 100%; height: 500px;"></div>
        </section>

        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <script type="text/javascript">
            ymaps.ready(function () {
                var latitude = {{ $contactSettings->map_latitude }};
                var longitude = {{ $contactSettings->map_longitude }};
                var zoom = {{ $contactSettings->map_zoom ?? 10 }};
                var description = '{{ $contactSettings->map_description ?? $address }}';

                var myMap = new ymaps.Map('map', {
                    center: [latitude, longitude],
                    zoom: zoom
                });

                // Добавляем метку
                var myPlacemark = new ymaps.Placemark([latitude, longitude], {
                    balloonContent: description
                }, {
                    preset: 'islands#greenDotIcon'
                });

                myMap.geoObjects.add(myPlacemark);
            });
        </script>
    @endif
@endsection

@section('scripts')
<script>
    var turnstileWidgetId = null;
    var siteKey = '{{ \App\Models\Setting::get("cloudflare_turnstile_site_key", "") }}';
    var isLocalhost = window.location.hostname === 'localhost' || 
                      window.location.hostname === '127.0.0.1' || 
                      window.location.hostname.endsWith('.local') ||
                      window.location.hostname.includes('192.168.') ||
                      window.location.hostname.includes('10.0.') ||
                      window.location.hostname.includes('172.');

    function onTurnstileSuccess(token) {
        // Сохраняем токен в скрытое поле
        document.getElementById('cf-turnstile-response').value = token;
        // Разрешаем отправку формы
        if (document.getElementById('contact-submit-btn')) {
            document.getElementById('contact-submit-btn').disabled = false;
        }
    }

    function onTurnstileExpired() {
        // Токен истек, очищаем поле и обновляем виджет
        document.getElementById('cf-turnstile-response').value = '';
        if (document.getElementById('contact-submit-btn')) {
            document.getElementById('contact-submit-btn').disabled = true;
        }
        // Обновляем виджет
        if (window.turnstile && turnstileWidgetId !== null) {
            window.turnstile.reset(turnstileWidgetId);
        }
    }

    function onTurnstileError(error) {
        // Ошибка загрузки капчи - на локальном домене это нормально
        if (isLocalhost) {
            console.log('Turnstile не работает на локальном домене, пропускаем проверку');
            document.getElementById('cf-turnstile-response').value = 'localhost';
            if (document.getElementById('contact-submit-btn')) {
                document.getElementById('contact-submit-btn').disabled = false;
            }
            return;
        }
        console.error('Turnstile error:', error);
        document.getElementById('cf-turnstile-response').value = '';
        if (document.getElementById('contact-submit-btn')) {
            document.getElementById('contact-submit-btn').disabled = true;
        }
    }

    function initTurnstile() {
        // На локальном домене не инициализируем Turnstile
        if (isLocalhost) {
            document.getElementById('cf-turnstile-response').value = 'localhost';
            return;
        }

        if (!siteKey || siteKey === '') {
            // Если ключ не настроен, разрешаем отправку формы без капчи
            document.getElementById('cf-turnstile-response').value = 'no-key';
            return;
        }

        // Проверяем, что библиотека Turnstile загружена
        if (typeof window.turnstile === 'undefined') {
            console.error('Turnstile library not loaded');
            document.getElementById('cf-turnstile-response').value = 'no-key';
            return;
        }

        // Блокируем кнопку отправки до прохождения капчи
        if (document.getElementById('contact-submit-btn')) {
            document.getElementById('contact-submit-btn').disabled = true;
        }

        try {
            // Инициализируем Turnstile виджет
            turnstileWidgetId = window.turnstile.render('#cf-turnstile-widget', {
                sitekey: siteKey,
                callback: onTurnstileSuccess,
                'expired-callback': onTurnstileExpired,
                'error-callback': onTurnstileError,
                theme: 'auto',
                language: 'ru'
            });
        } catch (error) {
            console.error('Error initializing Turnstile:', error);
            document.getElementById('cf-turnstile-response').value = 'no-key';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // На локальном домене не загружаем Turnstile
        if (isLocalhost) {
            document.getElementById('cf-turnstile-response').value = 'localhost';
            return;
        }

        // Загружаем скрипт Turnstile только на продакшн домене
        if (siteKey && siteKey !== '') {
            var script = document.createElement('script');
            script.src = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
            script.defer = true;
            script.onload = function() {
                // Ждем немного после загрузки скрипта
                setTimeout(function() {
                    if (typeof window.turnstile !== 'undefined') {
                        initTurnstile();
                    } else {
                        console.error('Turnstile library failed to load');
                        document.getElementById('cf-turnstile-response').value = 'no-key';
                    }
                }, 100);
            };
            script.onerror = function() {
                console.error('Failed to load Turnstile script');
                document.getElementById('cf-turnstile-response').value = 'no-key';
            };
            document.head.appendChild(script);
        } else {
            document.getElementById('cf-turnstile-response').value = 'no-key';
        }

        // Проверка токена перед отправкой формы
        var contactForm = document.querySelector('.contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                var token = document.getElementById('cf-turnstile-response').value;
                if (token !== 'no-key' && token !== 'localhost' && (!token || token === '')) {
                    e.preventDefault();
                    alert('Пожалуйста, пройдите проверку безопасности');
                    return false;
                }
            });
        }
    });
</script>
@endsection

