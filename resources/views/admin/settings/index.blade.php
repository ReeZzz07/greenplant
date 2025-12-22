<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки - GreenPlant</title>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
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
        .image-preview-card {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 14px;
            padding: 18px;
            border: 2px dashed #e3e7ef;
            border-radius: 14px;
            background: #fdfdff;
        }
        .image-preview-card img {
            display: block;
            max-height: 72px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(82, 111, 173, 0.2);
        }
        .image-preview-card .favicon-frame {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            background: #f5f7fa;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 0 1px rgba(102, 126, 234, 0.18);
        }
        .image-preview-card .favicon-frame img {
            max-width: 48px;
            max-height: 48px;
            box-shadow: none;
        }
        .remove-checkbox {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            font-size: 14px;
            color: #c0392b;
        }
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
                <button class="tab-button" data-tab="delivery">💳 Оплата и доставка</button>
                <button class="tab-button" data-tab="integrations">🔗 Интеграции</button>
                <button class="tab-button" data-tab="legal">⚖️ Юридическое</button>
                <button class="tab-button" data-tab="catalog">📦 Каталог</button>
                <button class="tab-button" data-tab="notifications">🔔 Уведомления</button>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
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

                            <a href="{{ route('admin.wholesale-settings.index') }}" onclick="event.preventDefault(); window.location.href='{{ route('admin.wholesale-settings.index') }}';" style="text-decoration: none; color: inherit;">
                                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; border-left: 4px solid #ffc107;">
                                    <p style="font-size: 32px; margin-bottom: 12px;">💰</p>
                                    <h4 style="margin: 0 0 8px 0; color: #333;">Страница "Оптовым покупателям"</h4>
                                    <p style="margin: 0; color: #666; font-size: 14px;">Настройка фона, калькулятора и контента страницы оптовым покупателям</p>
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
                    @continue(in_array($setting->key, ['site_favicon', 'site_logo', 'site_og_image']))
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

                    @php
                        $siteFavicon = \App\Models\Setting::get('site_favicon');
                        $siteLogo = \App\Models\Setting::get('site_logo');
                    @endphp

                    <h3 class="section-title" style="margin-top: 40px;">🖼️ Брендирование</h3>
                    <div class="form-group">
                        <label for="site_favicon">Favicon сайта</label>
                        @if($siteFavicon)
                            <div class="image-preview-card">
                                <div class="favicon-frame">
                                    <img src="{{ asset('storage/' . $siteFavicon) }}" alt="Текущий favicon">
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: #2f3367;">Текущий файл</div>
                                    <div class="help-text">{{ $siteFavicon }}</div>
                                </div>
                            </div>
                        @endif
                        <input type="file" id="site_favicon" name="site_favicon" accept=".png,.jpg,.jpeg,.svg,.ico">
                        <div class="help-text">PNG / JPG / SVG / ICO, до 2 МБ. Рекомендуемый размер: 64×64 или 512×512.</div>
                        @if($siteFavicon)
                            <label class="remove-checkbox">
                                <input type="checkbox" name="remove_site_favicon" value="1">
                                Удалить текущий favicon
                            </label>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="site_logo">Логотип сайта</label>
                        @if($siteLogo)
                            <div class="image-preview-card">
                                <img src="{{ asset('storage/' . $siteLogo) }}" alt="Текущий логотип">
                                <div>
                                    <div style="font-weight: 600; color: #2f3367;">Текущий файл</div>
                                    <div class="help-text">{{ $siteLogo }}</div>
                                </div>
                            </div>
                        @endif
                        <input type="file" id="site_logo" name="site_logo" accept=".png,.jpg,.jpeg,.svg">
                        <div class="help-text">PNG / JPG / SVG, до 4 МБ. Желательно прозрачный фон, высота до 80px.</div>
                        @if($siteLogo)
                            <label class="remove-checkbox">
                                <input type="checkbox" name="remove_site_logo" value="1">
                                Удалить текущий логотип
                            </label>
                        @endif
                    </div>

                    @php
                        $siteOgImage = \App\Models\Setting::get('site_og_image');
                    @endphp
                    <div class="form-group">
                        <label for="site_og_image">Изображение для соцсетей (Open Graph)</label>
                        <div class="help-text" style="margin-bottom: 10px;">Изображение, которое отображается при отправке ссылки на сайт в мессенджерах и соцсетях (Telegram, WhatsApp, Facebook и т.д.)</div>
                        @if($siteOgImage)
                            <div class="image-preview-card">
                                <img src="{{ asset('storage/' . $siteOgImage) }}" alt="Текущее изображение для соцсетей" style="max-width: 200px;">
                                <div>
                                    <div style="font-weight: 600; color: #2f3367;">Текущий файл</div>
                                    <div class="help-text">{{ $siteOgImage }}</div>
                                </div>
                            </div>
                        @endif
                        <input type="file" id="site_og_image" name="site_og_image" accept=".png,.jpg,.jpeg">
                        <div class="help-text">PNG / JPG, до 5 МБ. Рекомендуемый размер: 1200×630 пикселей (соотношение 1.91:1).</div>
                        @if($siteOgImage)
                            <label class="remove-checkbox">
                                <input type="checkbox" name="remove_site_og_image" value="1">
                                Удалить текущее изображение
                            </label>
                        @endif
                    </div>

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

                <!-- Tab: Оплата и доставка -->
                <div class="tab-content" id="tab-delivery">
                    <h3 class="section-title">💳 Способы оплаты</h3>
                    @php
                        $paymentMethodsJson = \App\Models\Setting::get('payment_methods_json', '[]');
                        $paymentMethods = json_decode($paymentMethodsJson, true) ?: [];
                        $paymentMethodsText = \App\Models\Setting::get('payment_methods_text', '');
                    @endphp
                    
                    <div class="form-group">
                        <label>Доступные способы оплаты</label>
                        <div id="payment-methods-list" style="margin-bottom: 15px;">
                            @foreach($paymentMethods as $methodIndex => $method)
                                <div class="payment-method-item" data-index="{{ $methodIndex }}" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                    <div style="flex: 1;">
                                        <input type="text" class="payment-method-value" placeholder="Значение (например: bank_transfer)" value="{{ $method['value'] ?? '' }}" style="width: 100%; margin-bottom: 8px; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                                        <input type="text" class="payment-method-label" placeholder="Название (например: Банковский перевод)" value="{{ $method['label'] ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                                    </div>
                                    <button type="button" class="remove-payment-method" style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">Удалить</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-payment-method" style="padding: 12px 24px; background: #28a745; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">+ Добавить способ оплаты</button>
                        <input type="hidden" name="settings[{{ $index }}][key]" value="payment_methods_json" id="payment_methods_json_key">
                        <input type="hidden" name="settings[{{ $index }}][value]" value="{{ $paymentMethodsJson }}" id="payment_methods_json_value">
                        <small style="color: #666; display: block; margin-top: 10px;">Добавьте способы оплаты, которые будут доступны при оформлении заказа. Значение используется в системе, название отображается пользователю.</small>
                        @php $index++; @endphp
                    </div>
                    
                    <div class="form-group">
                        <label for="payment_methods_text">Дополнительная информация о способах оплаты</label>
                        <textarea id="payment_methods_text" name="settings[{{ $index }}][value]" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">{{ $paymentMethodsText }}</textarea>
                        <input type="hidden" name="settings[{{ $index }}][key]" value="payment_methods_text">
                        <small style="color: #666;">Текст будет отображаться на странице оформления заказа под выбором способа оплаты</small>
                        @php $index++; @endphp
                    </div>
                    
                    <hr style="margin: 30px 0; border: none; border-top: 2px solid #e9ecef;">
                    
                    <h3 class="section-title" style="margin-top: 30px;">🚚 Настройки доставки</h3>
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
                            @elseif($setting->key == 'yandex_metrika_id') Код Яндекс.Метрики
                            @elseif($setting->key == 'google_tag_manager_id') Google Tag Manager ID
                            @else {{ ucfirst(str_replace('_', ' ', $setting->key)) }}
                            @endif
                        </label>
                        @if($setting->key == 'yandex_metrika_id')
                            <textarea id="{{ $setting->key }}" name="settings[{{ $index }}][value]" rows="6" placeholder="Вставьте код счетчика Яндекс.Метрики">{{ $setting->value }}</textarea>
                            <div class="help-text">Скопируйте код счетчика из личного кабинета Яндекс.Метрики и вставьте сюда полностью.</div>
                        @else
                            <input type="{{ $setting->type ?? 'text' }}" id="{{ $setting->key }}" name="settings[{{ $index }}][value]" value="{{ $setting->value }}" placeholder="UA-XXXXXXXXX-X">
                        @endif
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

                    <h3 class="section-title" style="margin-top: 40px;">🔒 Cloudflare Turnstile</h3>
                    <div class="form-group">
                        <label for="cloudflare_turnstile_site_key">
                            Публичный ключ (Site Key)
                        </label>
                        <input type="text" id="cloudflare_turnstile_site_key" name="settings[{{ $index }}][value]" value="{{ \App\Models\Setting::get('cloudflare_turnstile_site_key', '') }}" placeholder="Введите публичный ключ Turnstile">
                        <input type="hidden" name="settings[{{ $index }}][key]" value="cloudflare_turnstile_site_key">
                        <div class="help-text">Публичный ключ из панели Cloudflare. Используется для отображения капчи на сайте.</div>
                        @php $index++; @endphp
                    </div>

                    <div class="form-group">
                        <label for="cloudflare_turnstile_secret_key">
                            Секретный ключ (Secret Key)
                        </label>
                        <input type="text" id="cloudflare_turnstile_secret_key" name="settings[{{ $index }}][value]" value="{{ \App\Models\Setting::get('cloudflare_turnstile_secret_key', '') }}" placeholder="Введите секретный ключ Turnstile">
                        <input type="hidden" name="settings[{{ $index }}][key]" value="cloudflare_turnstile_secret_key">
                        <div class="help-text">Секретный ключ из панели Cloudflare. Используется для проверки капчи на сервере. Никому не передавайте этот ключ!</div>
                        @php $index++; @endphp
                    </div>

                    <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; border-left: 4px solid #2196F3; margin-top: 20px;">
                        <h4 style="margin: 0 0 10px 0; color: #1976D2;">📖 Как получить ключи Cloudflare Turnstile?</h4>
                        <ol style="margin: 0; padding-left: 20px; color: #333;">
                            <li>Зайдите в <a href="https://dash.cloudflare.com/" target="_blank" style="color: #2196F3;">панель Cloudflare</a></li>
                            <li>Перейдите в раздел "Turnstile" (или создайте новый сайт)</li>
                            <li>Создайте виджет Turnstile</li>
                            <li>Скопируйте <strong>Site Key</strong> и <strong>Secret Key</strong></li>
                            <li>Вставьте их в поля выше</li>
                        </ol>
                        <p style="margin: 10px 0 0 0; color: #666; font-size: 13px;">
                            <strong>Важно:</strong> Cloudflare Turnstile полностью бесплатен. Если ключи не заполнены, форма контактов будет работать без проверки капчи.
                        </p>
                    </div>
                </div>

                <!-- Tab: Юридическое -->
                <div class="tab-content" id="tab-legal">
                    <h3 class="section-title">⚖️ Юридическая информация</h3>
                    @forelse($settings['legal'] ?? [] as $setting)
                        @continue(in_array($setting->key, ['privacy_policy_content', 'terms_of_service_content']))
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
                            <textarea id="{{ $setting->key }}" name="settings[{{ $index }}][value]" class="no-tinymce">{{ $setting->value }}</textarea>
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
                        @continue(in_array($setting->key, ['privacy_policy_content', 'terms_of_service_content']))
                    <div class="form-group">
                        <label for="{{ $setting->key }}">
                            @if($setting->key == 'privacy_policy_url') Политика конфиденциальности (URL)
                            @elseif($setting->key == 'terms_of_service_url') Пользовательское соглашение (URL)
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

                    <div class="form-group" style="margin-top: 30px;">
                        <label for="privacy_policy_content">
                            📋 Политика конфиденциальности (контент)
                        </label>
                        <textarea id="privacy_policy_content" name="settings[{{ $index }}][value]">{{ \App\Models\Setting::get('privacy_policy_content', '') }}</textarea>
                        <input type="hidden" name="settings[{{ $index }}][key]" value="privacy_policy_content">
                        <div class="help-text">
                            Контент страницы "Политика конфиденциальности". Если не заполнено, будет использован текст по умолчанию.
                            <br>
                            <a href="{{ route('privacy') }}" target="_blank" style="color: #667eea;">Посмотреть страницу →</a>
                        </div>
                        @php $index++; @endphp
                    </div>

                    <div class="form-group" style="margin-top: 30px;">
                        <label for="terms_of_service_content">
                            📋 Пользовательское соглашение (контент)
                        </label>
                        <textarea id="terms_of_service_content" name="settings[{{ $index }}][value]">{{ \App\Models\Setting::get('terms_of_service_content', '') }}</textarea>
                        <input type="hidden" name="settings[{{ $index }}][key]" value="terms_of_service_content">
                        <div class="help-text">
                            Контент страницы "Пользовательское соглашение". Если не заполнено, будет использован текст по умолчанию.
                            <br>
                            <a href="{{ route('terms') }}" target="_blank" style="color: #667eea;">Посмотреть страницу →</a>
                        </div>
                        @php $index++; @endphp
                    </div>
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

        // Управление способами оплаты
        function updatePaymentMethodsJson() {
            const items = document.querySelectorAll('.payment-method-item');
            const methods = [];
            items.forEach(item => {
                const value = item.querySelector('.payment-method-value').value.trim();
                const label = item.querySelector('.payment-method-label').value.trim();
                if (value && label) {
                    methods.push({ value: value, label: label });
                }
            });
            document.getElementById('payment_methods_json_value').value = JSON.stringify(methods);
        }

        // Инициализация TinyMCE для полей политики и соглашения
        document.addEventListener('DOMContentLoaded', function() {
            // Добавление способа оплаты
            const addPaymentMethodBtn = document.getElementById('add-payment-method');
            if (addPaymentMethodBtn) {
                addPaymentMethodBtn.addEventListener('click', function() {
                    const list = document.getElementById('payment-methods-list');
                    const index = list.children.length;
                    const newItem = document.createElement('div');
                    newItem.className = 'payment-method-item';
                    newItem.setAttribute('data-index', index);
                    newItem.style.cssText = 'display: flex; gap: 10px; margin-bottom: 10px; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 8px;';
                    newItem.innerHTML = `
                        <div style="flex: 1;">
                            <input type="text" class="payment-method-value" placeholder="Значение (например: bank_transfer)" style="width: 100%; margin-bottom: 8px; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                            <input type="text" class="payment-method-label" placeholder="Название (например: Банковский перевод)" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                        <button type="button" class="remove-payment-method" style="padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">Удалить</button>
                    `;
                    
                    // Добавляем обработчики событий
                    newItem.querySelector('.payment-method-value').addEventListener('input', updatePaymentMethodsJson);
                    newItem.querySelector('.payment-method-label').addEventListener('input', updatePaymentMethodsJson);
                    newItem.querySelector('.remove-payment-method').addEventListener('click', function() {
                        newItem.remove();
                        updatePaymentMethodsJson();
                    });
                    
                    list.appendChild(newItem);
                    updatePaymentMethodsJson();
                });
            }

            // Удаление способа оплаты
            document.querySelectorAll('.remove-payment-method').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.payment-method-item').remove();
                    updatePaymentMethodsJson();
                });
            });

            // Обновление JSON при изменении существующих полей
            document.querySelectorAll('.payment-method-value, .payment-method-label').forEach(input => {
                input.addEventListener('input', updatePaymentMethodsJson);
            });

            // Инициализация JSON при загрузке страницы
            updatePaymentMethodsJson();
            // Функция для инициализации TinyMCE редактора
            function initTinyMCE(selector) {
                // Проверяем, что элемент существует и еще не инициализирован
                const element = document.querySelector(selector);
                if (!element) {
                    console.log('Element not found: ' + selector);
                    return;
                }
                
                // Проверяем, не инициализирован ли уже редактор для этого элемента
                const editorId = element.id;
                if (tinymce.get(editorId)) {
                    console.log('TinyMCE already initialized for: ' + selector);
                    return;
                }
                
                tinymce.init({
                    selector: selector,
                    height: 400,
                    menubar: 'file edit view insert format tools table help',
                    readonly: false,
                    promotion: false,
                    branding: false,
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'visualchars', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'emoticons', 'codesample', 'help', 'wordcount',
                        'pagebreak', 'nonbreaking', 'directionality', 'quickbars'
                    ],
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                             'forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify | ' +
                             'bullist numlist outdent indent | link image media table | ' +
                             'code visualblocks visualchars codesample | emoticons charmap | ' +
                             'searchreplace fullscreen preview | pagebreak nonbreaking anchor | ' +
                             'insertdatetime | help',
                    toolbar_mode: 'sliding',
                    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px }',
                    setup: function(editor) {
                        editor.on('init', function() {
                            console.log('TinyMCE initialized successfully for: ' + selector);
                        });
                    }
                });
            }

            // Инициализация редакторов только для нужных полей
            // Используем точные ID, чтобы избежать конфликтов
            setTimeout(function() {
                initTinyMCE('#privacy_policy_content');
                initTinyMCE('#terms_of_service_content');
            }, 100);

            // Инициализация редакторов при переключении на вкладку "Юридическое"
            const legalTabButton = document.querySelector('[data-tab="legal"]');
            if (legalTabButton) {
                legalTabButton.addEventListener('click', function() {
                    setTimeout(function() {
                        // Инициализируем только если они еще не инициализированы
                        initTinyMCE('#privacy_policy_content');
                        initTinyMCE('#terms_of_service_content');
                    }, 150);
                });
            }
        });
    </script>
</body>
</html>
