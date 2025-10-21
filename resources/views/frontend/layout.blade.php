<!DOCTYPE html>
<html lang="ru">
<head>
    <title>@yield('title', 'GreenPlant - Продажа саженцев и деревьев туи')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/prod-1.png') }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'GreenPlant - питомник растений. Продажа саженцев и взрослых деревьев туи различных сортов. Гарантия приживаемости, доставка по России.')">
    <meta name="keywords" content="@yield('keywords', 'туя, саженцы туи, купить тую, туя западная, живая изгородь, питомник растений, GreenPlant')">
    <meta name="author" content="GreenPlant">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'GreenPlant - Продажа саженцев и деревьев туи')">
    <meta property="og:description" content="@yield('og_description', 'Питомник растений GreenPlant. Продажа саженцев и взрослых деревьев туи различных сортов с гарантией приживаемости.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/bg_1.png'))">
    <meta property="og:site_name" content="GreenPlant">
    <meta property="og:locale" content="ru_RU">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('og_title', 'GreenPlant - Продажа саженцев и деревьев туи')">
    <meta property="twitter:description" content="@yield('og_description', 'Питомник растений GreenPlant')">
    <meta property="twitter:image" content="@yield('og_image', asset('assets/images/bg_1.png'))">
    
    <link rel="canonical" href="{{ url()->current() }}">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    
    <!-- Font Awesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="{{ asset('assets/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-fixes.css') }}">
</head>
<body class="goto-here">
    <!-- Top Bar -->
    <div class="py-1 bg-black top-bar-desktop">
        <div class="container">
            <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
                <div class="col-lg-12 d-block">
                    <div class="row d-flex">
                        <div class="col-md pr-4 d-flex topper align-items-center">
                            <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                            <a href="tel:+79889385600" style="color: inherit; text-decoration: none;"><span class="text">{{ \App\Models\Setting::get('phone', '+7 (495) 123-45-67') }}</span></a>
                        </div>
                        <div class="col-md pr-4 d-flex topper align-items-center">
                            <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                            <span class="text">{{ \App\Models\Setting::get('email', 'info@greenplant.ru') }}</span>
                        </div>
                        <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
                            <span class="text">{{ \App\Models\Setting::get('delivery_text', 'Доставка по России • Гарантия приживаемости') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">GreenPlant</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span>
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}" class="nav-link">Главная</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('catalog') ? 'active' : '' }}">
                        <a href="{{ route('catalog') }}" class="nav-link">Каталог</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                        <a href="{{ route('about') }}" class="nav-link">О компании</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('blog*') ? 'active' : '' }}">
                        <a href="{{ route('blog') }}" class="nav-link">Блог</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <a href="{{ route('contact') }}" class="nav-link">Контакты</a>
                    </li>
                    <li class="nav-item cta cta-colored {{ request()->routeIs('cart*') ? 'active' : '' }}">
                        <a href="{{ route('cart.index') }}" class="nav-link cart-link">
                            <span class="icon-shopping_cart cart-icon"></span>
                            <span class="cart-count-badge">{{ \App\Http\Controllers\Frontend\CartController::getCartCount() }}</span>
                        </a>
                    </li>
                    @if(!auth()->check())
                        {{-- Гости: показываем иконку входа --}}
                        <li class="nav-item cta cta-colored">
                            <a href="{{ route('customer.auth') }}" class="nav-link user-link" title="Вход / Регистрация">
                                <span class="icon-user"></span>
                            </a>
                        </li>
                    @elseif(auth()->user()->hasRole('customer'))
                        {{-- Покупатели: показываем иконку личного кабинета --}}
                        <li class="nav-item cta cta-colored">
                            <a href="{{ route('account.dashboard') }}" class="nav-link user-link" title="Личный кабинет">
                                <span class="icon-user"></span>
                            </a>
                        </li>
                    @endif
                    {{-- Админы и менеджеры: не показываем иконку, они используют прямой вход /login в админку --}}
                </ul>
                
                <!-- Контактная информация для мобильных устройств -->
                <div class="mobile-contact-info">
                    <div class="mobile-contact-item">
                        <div class="icon"><span class="icon-phone2"></span></div>
                        <a href="tel:+79889385600">{{ \App\Models\Setting::get('phone', '+7 (495) 123-45-67') }}</a>
                    </div>
                    <div class="mobile-contact-item">
                        <div class="icon"><span class="icon-paper-plane"></span></div>
                        <span>{{ \App\Models\Setting::get('email', 'info@greenplant.ru') }}</span>
                    </div>
                    <div class="mobile-contact-item">
                        <div class="icon"><span class="icon-truck"></span></div>
                        <span>{{ \App\Models\Setting::get('delivery_text', 'Доставка по России • Гарантия приживаемости') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="ftco-footer ftco-section">
        <div class="container">
            <div class="row">
                <div class="mouse">
                    <a href="#" class="mouse-icon">
                        <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
                    </a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">GreenPlant</h2>
                        <p>{{ \App\Models\Setting::get('site_description', 'Питомник растений. Специализируемся на выращивании и продаже различных сортов туи премиум-качества.') }}</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            @if(\App\Models\Setting::get('instagram_url'))
                            <li class="ftco-animate"><a href="{{ \App\Models\Setting::get('instagram_url') }}"><span class="icon-instagram"></span></a></li>
                            @endif
                            @if(\App\Models\Setting::get('whatsapp_url'))
                            <li class="ftco-animate"><a href="{{ \App\Models\Setting::get('whatsapp_url') }}"><span class="icon-whatsapp"></span></a></li>
                            @endif
                            @if(\App\Models\Setting::get('telegram_url'))
                            <li class="ftco-animate"><a href="{{ \App\Models\Setting::get('telegram_url') }}"><span class="icon-telegram"></span></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Меню</h2>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('catalog') }}" class="py-2 d-block">Каталог</a></li>
                            <li><a href="{{ route('about') }}" class="py-2 d-block">О компании</a></li>
                            <li><a href="{{ route('blog') }}" class="py-2 d-block">Блог</a></li>
                            <li><a href="{{ route('contact') }}" class="py-2 d-block">Контакты</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Помощь</h2>
                        <div class="d-flex">
                            <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
                                <li><a href="#" class="py-2 d-block">Доставка</a></li>
                                <li><a href="#" class="py-2 d-block">Оплата</a></li>
                                <li><a href="#" class="py-2 d-block">Гарантии</a></li>
                            </ul>
                            <ul class="list-unstyled">
                                <li><a href="#" class="py-2 d-block">Частые вопросы</a></li>
                                <li><a href="{{ route('contact') }}" class="py-2 d-block">Связаться с нами</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Остались вопросы?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">{{ \App\Models\Setting::get('address', 'Московская область') }}</span></li>
                                <li><a href="tel:+79889385600"><span class="icon icon-phone"></span><span class="text">{{ \App\Models\Setting::get('phone') }}</span></a></li>
                                <li><a href="mailto:{{ \App\Models\Setting::get('email') }}"><span class="icon icon-envelope"></span><span class="text">{{ \App\Models\Setting::get('email') }}</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> GreenPlant. Все права защищены.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/scrollax.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    
    @yield('scripts')
</body>
</html>

