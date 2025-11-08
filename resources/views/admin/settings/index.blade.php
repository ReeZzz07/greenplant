<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки - GreenPlant</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f7fa; color: #333; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header a { color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 8px; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .page-header { margin-bottom: 30px; }
        .page-header h2 { font-size: 28px; }
        
        /* Tabs */
        .tabs { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px; }
        .tabs-header { display: flex; background: #f8f9fa; border-bottom: 2px solid #e9ecef; overflow-x: auto; }
        .tab-button { padding: 15px 25px; background: none; border: none; cursor: pointer; font-size: 14px; font-weight: 600; color: #666; transition: all 0.3s; white-space: nowrap; position: relative; }
        .tab-button:hover { background: #e9ecef; color: #333; }
        .tab-button.active { background: white; color: #667eea; border-bottom: 3px solid #667eea; }
        .tab-content { display: none; padding: 40px; }
        .tab-content.active { display: block; }
        
        .card { background: white; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 40px; margin-bottom: 20px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #333; }
        input, textarea, select { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; transition: all 0.3s; font-family: inherit; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #667eea; }
        .btn { padding: 12px 24px; border-radius: 10px; font-weight: 600; display: inline-block; border: none; cursor: pointer; font-size: 14px; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .section-title { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #667eea; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; }
        .help-text { font-size: 13px; color: #666; margin-top: 5px; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        a[href*="admin"] div { transition: all 0.3s ease; }
        a[href*="admin"]:hover div { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important; }
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
            <h2>⚙️ Настройки сайта</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="tabs">
            <div class="tabs-header">
                <button class="tab-button active" data-tab="homepage">🏠 Главная страница</button>
                <button class="tab-button" data-tab="general">⚙️ Основные</button>
                <button class="tab-button" data-tab="delivery">🚚 Доставка</button>
                <button class="tab-button" data-tab="integrations">🔗 Интеграции</button>
                <button class="tab-button" data-tab="legal">⚖️ Юридическое</button>
                <button class="tab-button" data-tab="catalog">📦 Каталог</button>
                <button class="tab-button" data-tab="notifications">🔔 Уведомления</button>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @php $index = 0; @endphp

                <!-- Tab: Главная страница -->
                <div class="tab-content active" id="tab-homepage">
                    <div style="background: #f8f9fa; padding: 30px; border-radius: 15px; margin-bottom: 30px;">
                        <h3 style="margin-bottom: 20px; color: #667eea;">📋 Управление контентом главной страницы</h3>
                        <p style="color: #666; margin-bottom: 25px;">Управляйте всеми элементами главной страницы: фон hero-секции, слайдеры, блоки преимуществ, товары, отзывы и Instagram галерея.</p>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                            <a href="{{ route('admin.hero-settings.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.hero-settings.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #4ecdc4;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">🎨</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Фон Hero-секции</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка фона и наложения для hero-секции</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.sliders.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.sliders.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #667eea;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">🎠</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Слайдер</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Управление слайдами на главной странице</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.home-page-features.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.home-page-features.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #82ae46;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">⭐</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Блоки преимуществ</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка блоков с преимуществами компании</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.products.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.products.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #ff6b6b;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">🌲</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Товары</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Управление каталогом товаров</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.testimonials.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.testimonials.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #ffd93d;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">💬</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Отзывы клиентов</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Управление отзывами клиентов</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.home-page-galleries.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.home-page-galleries.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #e056fd;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">📸</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Instagram Галерея</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Управление изображениями Instagram</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.home-page-section-titles.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.home-page-section-titles.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #7b2cbf;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">📝</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Заголовки секций</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка заголовков и подзаголовков секций</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.catalog-page-settings.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.catalog-page-settings.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #20c997;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">📦</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Страница каталога</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка фона и заголовков страницы каталога</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.about-page-settings.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.about-page-settings.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #fd7e14;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">🏢</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Страница "О компании"</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка фона, заголовков и контента страницы "О компании"</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.blog-page-settings.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.blog-page-settings.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #6f42c1;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">📝</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Страница "Блог"</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка фона, заголовков страницы блога</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.contact-page-settings.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.contact-page-settings.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #dc3545;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">📞</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Страница "Контакты"</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка фона, заголовков и карты страницы контактов</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.account-page-settings.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.account-page-settings.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #20c997;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">👤</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Личный кабинет</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка фона личного кабинета покупателя</p>
                                </div>
                            </a>

                            <a href="{{ route('admin.info-page-settings.edit') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.info-page-settings.edit') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #4ecdc4;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">📘</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Страница "Информация"</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Управление вкладками Оплата, Доставка, Гарантии, FAQ</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div style="background: #fff3cd; padding: 20px; border-radius: 12px; border-left: 4px solid #ffc107;">
                        <h4 style="margin: 0 0 10px 0; color: #856404;">💡 Полезная информация</h4>
                        <ul style="margin: 0; padding-left: 20px; color: #856404;">
                            <li>Все элементы главной страницы управляются через соответствующие разделы</li>
                            <li>Слайдеры отображаются в порядке, указанном в поле "Порядок"</li>
                            <li>Блоки преимуществ автоматически адаптируются под количество активных блоков</li>
                            <li>Instagram галерея отображает до 6 активных изображений</li>
                            <li>Товары на главной странице берутся с флагом "Популярный"</li>
                        </ul>
                    </div>
                </div>

                <!-- Tab: Основные настройки -->
                <div class="tab-content" id="tab-general">
                    <h3 class="section-title">🏠 Основные настройки сайта</h3>
                    @forelse($settings['general'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'site_name') Название сайта
                            @elseif($setting->key == 'site_tagline') Слоган сайта
                            @elseif($setting->key == 'site_description') Описание сайта (SEO)
                            @elseif($setting->key == 'site_keywords') Ключевые слова (SEO)
                            @elseif($setting->key == 'site_author') Автор сайта
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        @if($setting->type == 'textarea')
                            <textarea id="{{ $setting->key }}" name="settings[{{ $index }}][value]">{{ $setting->value }}</textarea>
                        @else
                            <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                        @endif
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Настройки пока не добавлены</p>
                    @endforelse

                    <h3 class="section-title" style="margin-top: 40px;">📞 Контактная информация</h3>
                    <div class="form-row">
                        @forelse($settings['contacts'] ?? [] as $setting)
                        <div class="form-group">
                            <label for="{{ $setting->key }}">
                                @if($setting->key == 'phone') Телефон
                                @elseif($setting->key == 'email') Email
                                @elseif($setting->key == 'address') Адрес
                                @elseif($setting->key == 'admin_email') Email администратора
                                @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                                @endif
                            </label>
                            <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                            <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                            @php $index++; @endphp
                        </div>
                        @empty
                        <p style="color: #999;">Контактная информация пока не добавлена</p>
                        @endforelse
                    </div>

                    <h3 class="section-title" style="margin-top: 40px;">⏰ Режим работы</h3>
                    @forelse($settings['working_hours'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'work_days') 📅 Рабочие дни (пн-пт)
                            @elseif($setting->key == 'weekend_hours') 🏖️ Выходные (сб-вс)
                            @elseif($setting->key == 'working_hours_text') 💬 Текст режима работы
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}" placeholder="Например: Пн-Пт: 9:00 - 18:00">
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @if($setting->key == 'working_hours_text')
                            <div class="help-text">Краткий текст, который будет отображаться на сайте</div>
                        @endif
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Настройки режима работы пока не добавлены</p>
                    @endforelse

                    <h3 class="section-title" style="margin-top: 40px;">📱 Социальные сети</h3>
                    @forelse($settings['social'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'instagram_url') 📸 Instagram
                            @elseif($setting->key == 'whatsapp_url') 💬 WhatsApp
                            @elseif($setting->key == 'telegram_url') ✈️ Telegram
                            @else {{ ucfirst(str_replace(['_', 'url'], [' ', ''], $setting->key)) }}
                            @endif
                        </label>
                        <input type="{{ $setting->type ?? 'url' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}" placeholder="https://">
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @if($setting->key == 'whatsapp_url')
                            <div class="help-text">Формат: https://wa.me/79889385600 (номер без +)</div>
                        @elseif($setting->key == 'telegram_url')
                            <div class="help-text">Формат: https://t.me/ваш_username</div>
                        @endif
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Ссылки на социальные сети пока не добавлены</p>
                    @endforelse
                </div>

                <!-- Tab: Доставка -->
                <div class="tab-content" id="tab-delivery">
                    <h3 class="section-title">🚚 Настройки доставки</h3>
                    @forelse($settings['delivery'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'free_delivery_from') Минимальная сумма для бесплатной доставки (₽)
                            @elseif($setting->key == 'delivery_cost') Стоимость доставки (₽)
                            @elseif($setting->key == 'delivery_text') Текст о доставке
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Настройки доставки пока не добавлены</p>
                    @endforelse
                </div>

                <!-- Tab: Интеграции -->
                <div class="tab-content" id="tab-integrations">
                    <h3 class="section-title">🔍 SEO и аналитика</h3>
                    @forelse($settings['seo'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'google_analytics_id') Google Analytics ID
                            @elseif($setting->key == 'yandex_metrika_id') Яндекс.Метрика ID
                            @elseif($setting->key == 'google_tag_manager_id') Google Tag Manager ID
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}" placeholder="UA-XXXXXXXXX-X">
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">SEO настройки пока не добавлены</p>
                    @endforelse

                    <h3 class="section-title" style="margin-top: 40px;">📝 TinyMCE редактор</h3>
                    @forelse($settings['tinymce'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'tinymce_api_key') TinyMCE API ключ
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}" placeholder="Введите ваш TinyMCE API ключ">
                        <small>Получите бесплатный API ключ на <a href="https://www.tiny.cloud/" target="_blank">tiny.cloud</a></small>
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">TinyMCE настройки пока не добавлены</p>
                    @endforelse

                    <h3 class="section-title" style="margin-top: 40px;">📍 Коды интеграции карт</h3>
                    @forelse($settings['integrations'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'google_maps_api_key') Google Maps API ключ
                            @elseif($setting->key == 'yandex_maps_api_key') Яндекс.Карты API ключ
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Интеграции пока не настроены</p>
                    @endforelse
                </div>

                <!-- Tab: Юридическое -->
                <div class="tab-content" id="tab-legal">
                    <h3 class="section-title">⚖️ Юридическая информация</h3>
                    @forelse($settings['legal'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'company_inn') ИНН
                            @elseif($setting->key == 'company_ogrn') ОГРН
                            @elseif($setting->key == 'company_legal_address') Юридический адрес
                            @elseif($setting->key == 'company_bank_details') Банковские реквизиты
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        @if($setting->type == 'textarea')
                            <textarea id="{{ $setting->key }}" name="settings[{{ $index }}][value]">{{ $setting->value }}</textarea>
                        @else
                            <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                        @endif
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Юридическая информация пока не добавлена</p>
                    @endforelse

                    <h3 class="section-title" style="margin-top: 40px;">📄 Политики и документы</h3>
                    @forelse($settings['policies'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'privacy_policy_url') Политика конфиденциальности
                            @elseif($setting->key == 'terms_of_service_url') Пользовательское соглашение
                            @elseif($setting->key == 'return_policy_url') Политика возврата
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        <input type="{{ $setting->type ?? 'url' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}" placeholder="https://">
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Политики пока не добавлены</p>
                    @endforelse
                </div>

                <!-- Tab: Каталог -->
                <div class="tab-content" id="tab-catalog">
                    <h3 class="section-title">📦 Настройки каталога</h3>
                    @forelse($settings['catalog'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'products_per_page') Товаров на странице
                            @elseif($setting->key == 'show_stock') Показывать остатки на складе
                            @elseif($setting->key == 'show_prices') Показывать цены
                            @elseif($setting->key == 'min_order_amount') Минимальная сумма заказа (₽)
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        @if($setting->type == 'checkbox')
                            <div style="margin-top: 8px;">
                                <input type="hidden" name="settings[{{ $index }}][value]" value="0">
                                <input type="checkbox" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="1" {{ $setting->value ? 'checked' : '' }}>
                                <label for="{{ $setting->key }}" style="margin-left: 8px; font-weight: normal;">Включено</label>
                            </div>
                        @else
                            <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                        @endif
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Настройки каталога пока не добавлены</p>
                    @endforelse

                    <h3 class="section-title" style="margin-top: 40px;">💰 Настройки валюты</h3>
                    @forelse($settings['currency'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'currency') Код валюты
                            @elseif($setting->key == 'currency_symbol') Символ валюты
                            @elseif($setting->key == 'currency_position') Положение символа
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        @if($setting->key == 'currency_position')
                            <select id="{{ $setting->key }}" name="settings[{{ $index }}][value]">
                                <option value="before" {{ $setting->value == 'before' ? 'selected' : '' }}>Перед суммой (₽ 1000)</option>
                                <option value="after" {{ $setting->value == 'after' ? 'selected' : '' }}>После суммы (1000 ₽)</option>
                            </select>
                        @else
                            <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                        @endif
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Настройки валют пока не добавлены</p>
                    @endforelse
                </div>

                <!-- Tab: Уведомления -->
                <div class="tab-content" id="tab-notifications">
                    <h3 class="section-title">🔔 Уведомления на сайте</h3>
                    @forelse($settings['notifications'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'show_banner') Показывать баннер акции
                            @elseif($setting->key == 'banner_text') Текст баннера
                            @elseif($setting->key == 'footer_text') Текст в футере
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        @if($setting->type == 'checkbox')
                            <div style="margin-top: 8px;">
                                <input type="hidden" name="settings[{{ $index }}][value]" value="0">
                                <input type="checkbox" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="1" {{ $setting->value ? 'checked' : '' }}>
                                <label for="{{ $setting->key }}" style="margin-left: 8px; font-weight: normal;">Включено</label>
                            </div>
                        @elseif($setting->type == 'textarea')
                            <textarea id="{{ $setting->key }}" name="settings[{{ $index }}][value]">{{ $setting->value }}</textarea>
                        @else
                            <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                        @endif
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Уведомления пока не настроены</p>
                    @endforelse

                    <h3 class="section-title" style="margin-top: 40px;">📧 Email уведомления</h3>
                    @forelse($settings['email'] ?? [] as $setting)
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'order_notification_email') Email для уведомлений о заказах
                            @elseif($setting->key == 'order_email_subject') Тема письма о заказе
                            @elseif($setting->key == 'admin_order_notification') Уведомлять администратора о заказах
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        @if($setting->type == 'checkbox')
                            <div style="margin-top: 8px;">
                                <input type="hidden" name="settings[{{ $index }}][value]" value="0">
                                <input type="checkbox" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="1" {{ $setting->value ? 'checked' : '' }}>
                                <label for="{{ $setting->key }}" style="margin-left: 8px; font-weight: normal;">Включено</label>
                            </div>
                        @else
                            <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}">
                        @endif
                        <input type="hidden" name="settings[{{ $index }}][key]" value="{{ $setting->key }}">
                        @php $index++; @endphp
                    </div>
                    @empty
                    <p style="color: #999;">Email настройки пока не добавлены</p>
                    @endforelse
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary">💾 Сохранить все настройки</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                const tabId = button.dataset.tab;
                
                // Remove active class from all buttons and tabs
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked button and corresponding tab
                button.classList.add('active');
                document.getElementById('tab-' + tabId).classList.add('active');
            });
        });
    </script>
</body>
</html>
