@extends('frontend.layout')

@section('title', 'GreenPlant - Продажа саженцев и деревьев туи')

@section('content')
    @if(session('success'))
        <div class="floating-notification" id="floatingNotification" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 320px; max-width: 400px; background: #d4edda; color: #155724; padding: 20px 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); border-left: 4px solid #28a745; animation: slideInRight 0.5s ease-out;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle" style="font-size: 24px; color: #28a745;"></i>
                    <span style="font-weight: 500;">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('floatingNotification').style.display='none'" 
                        style="background: none; border: none; font-size: 20px; color: #155724; cursor: pointer; padding: 0; margin-left: 15px; line-height: 1;">
                    &times;
                </button>
            </div>
        </div>
        
        <style>
            @keyframes slideInRight {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes fadeOut {
                from {
                    opacity: 1;
                }
                to {
                    opacity: 0;
                }
            }
        </style>
        
        <script>
            // Автоматическое скрытие через 5 секунд
            setTimeout(function() {
                var notification = document.getElementById('floatingNotification');
                if (notification) {
                    notification.style.animation = 'fadeOut 0.5s ease-out';
                    setTimeout(function() {
                        notification.style.display = 'none';
                    }, 500);
                }
            }, 5000);
        </script>
    @endif

    <!-- Hero Section -->
    <section id="home-section" class="hero" style="position: relative; overflow: hidden; @if($heroSettings && $heroSettings->background_image) background-image: url('{{ asset('storage/' . $heroSettings->background_image) }}'); background-size: {{ $heroSettings->background_size ?? 'cover' }}; background-position: {{ $heroSettings->background_position ?? 'center center' }}; background-attachment: fixed; background-repeat: no-repeat; @else background-color: {{ $heroSettings->background_color ?? '#82ae46' }}; @endif">
        @if($heroSettings && $heroSettings->background_image && $heroSettings->overlay_type !== 'none')
            <div class="overlay" style="background: @if($heroSettings->overlay_type === 'darken') rgba(0, 0, 0, {{ $heroSettings->overlay_opacity / 100 }}) @elseif($heroSettings->overlay_type === 'lighten') rgba(255, 255, 255, {{ $heroSettings->overlay_opacity / 100 }}) @endif; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        @else
            <div class="overlay"></div>
        @endif
        <div class="home-slider owl-carousel" style="position: relative; z-index: 1;">
            @forelse($sliders as $slider)
                <div class="slider-item js-fullheight">
                    <div class="container-fluid p-0">
                        <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                            @if($slider->image)
                                <img
                                    class="one-third order-md-last img-fluid"
                                    src="{{ asset('storage/' . $slider->image) }}"
                                    alt="{{ $slider->title }}"
                                    style="
                                        @if($slider->image_width)width: {{ $slider->image_width }}px;@endif
                                        @if($slider->image_height)height: {{ $slider->image_height }}px;@endif
                                        object-fit: cover;
                                        object-position: {{ $slider->image_position_x ?? 50 }}% {{ $slider->image_position_y ?? 50 }}%;
                                    "
                                >
                            @endif
                            <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                                <div class="text">
                                    @if($slider->subtitle)
                                        <span class="subheading">{{ $slider->subtitle }}</span>
                                    @endif
                                    <div class="horizontal">
                                        <h1 class="mb-4 mt-3">{{ $slider->title }}</h1>
                                        @if($slider->description)
                                            <p class="mb-4">{{ $slider->description }}</p>
                                        @endif
                                        @if($slider->button_text && $slider->button_link)
                                            <p><a href="{{ $slider->button_link }}" class="btn-custom">{{ $slider->button_text }}</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Fallback to default slider if no sliders in database --}}
                <div class="slider-item js-fullheight">
                    <div class="container-fluid p-0">
                        <div class="row d-md-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
                            <img class="one-third order-md-last img-fluid" src="{{ asset('assets/images/bg_1.png') }}" alt="">
                            <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
                                <div class="text">
                                    <span class="subheading">#Новинки сезона</span>
                                    <div class="horizontal">
                                        <h1 class="mb-4 mt-3">Саженцы и деревья туи премиум-качества</h1>
                                        <p class="mb-4">Мы специализируемся на выращивании и продаже различных сортов туи. Высокое качество, гарантия приживаемости, профессиональные консультации.</p>
                                        <p><a href="{{ route('catalog') }}" class="btn-custom">Смотреть каталог</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <!-- Кнопка прокрутки вниз -->
        <a href="javascript:void(0)" class="scroll-down-btn" aria-label="Прокрутить вниз" onclick="event.preventDefault(); const nextSection = document.querySelector('#home-section').nextElementSibling; if(nextSection) nextSection.scrollIntoView({behavior: 'smooth'});">
            <i class="fas fa-chevron-down"></i>
        </a>
    </section>

    <script>
        // Исправление проблемы с увеличением фона hero-секции на iOS
        (function() {
            // Определяем iOS устройство
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            // Определяем мобильное устройство
            const isMobile = window.innerWidth <= 991;
            
            if (isIOS || isMobile) {
                const heroSection = document.getElementById('home-section');
                if (heroSection) {
                    // Убираем background-attachment: fixed на iOS и мобильных устройствах
                    heroSection.style.backgroundAttachment = 'scroll';
                    // Гарантируем правильный размер фона
                    heroSection.style.webkitBackgroundSize = 'cover';
                    heroSection.style.backgroundSize = 'cover';
                    heroSection.style.backgroundPosition = 'center center';
                }
            }
        })();
    </script>

    <!-- Services Section -->
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row no-gutters ftco-services">
                @forelse($features as $feature)
                    <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services p-4 py-md-5">
                            <div class="icon d-flex justify-content-center align-items-center mb-4">
                                @if($feature->icon_type === 'image' && $feature->icon_image)
                                    <img src="{{ asset('storage/' . $feature->icon_image) }}" alt="{{ $feature->title }}" style="max-width: {{ $feature->icon_size ?? '80px' }}; height: auto; {{ $feature->icon_color ? 'filter: drop-shadow(0 0 8px ' . $feature->icon_color . ');' : '' }}">
                                @elseif($feature->icon_type === 'custom')
                                    <span style="font-size: {{ $feature->icon_size ?? '48px' }}; {{ $feature->icon_color ? 'color: ' . $feature->icon_color . ';' : '' }}">
                                        {!! $feature->icon !!}
                                    </span>
                                @else
                                    <span class="{{ $feature->icon }}" style="font-size: {{ $feature->icon_size ?? '48px' }}; {{ $feature->icon_color ? 'color: ' . $feature->icon_color . ';' : '' }}"></span>
                                @endif
                            </div>
                            <div class="media-body">
                                <h3 class="heading">{{ $feature->title }}</h3>
                                <p>{{ $feature->description }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Fallback to default features if no features in database --}}
                    <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services p-4 py-md-5">
                            <div class="icon d-flex justify-content-center align-items-center mb-4">
                                <span class="flaticon-bag"></span>
                            </div>
                            <div class="media-body">
                                <h3 class="heading">Бесплатная доставка</h3>
                                <p>Бесплатная доставка по Москве и области при заказе от {{ number_format(\App\Models\Setting::get('free_delivery_from', 10000), 0, ',', ' ') }} рублей. Аккуратная транспортировка с сохранением корневой системы.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services p-4 py-md-5">
                            <div class="icon d-flex justify-content-center align-items-center mb-4">
                                <span class="flaticon-customer-service"></span>
                            </div>
                            <div class="media-body">
                                <h3 class="heading">Профессиональная поддержка</h3>
                                <p>Наши специалисты помогут подобрать сорт туи, проконсультируют по посадке и уходу. Всегда на связи для ваших вопросов.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services p-4 py-md-5">
                            <div class="icon d-flex justify-content-center align-items-center mb-4">
                                <span class="flaticon-payment-security"></span>
                            </div>
                            <div class="media-body">
                                <h3 class="heading">Гарантия приживаемости</h3>
                                <p>Все наши растения выращены в питомнике с соблюдением агротехники. Даем гарантию приживаемости при соблюдении рекомендаций.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    @php
                        $productsTitle = \App\Models\HomePageSectionTitle::getByKey('products');
                    @endphp
                    @if($productsTitle && $productsTitle->title)
                        <h2 class="mb-4">{{ $productsTitle->title }}</h2>
                    @else
                        <h2 class="mb-4">Популярные сорта туи</h2>
                    @endif
                    @if($productsTitle && $productsTitle->subtitle)
                        <p>{{ $productsTitle->subtitle }}</p>
                    @else
                        <p>Широкий ассортимент саженцев и взрослых деревьев туи различных сортов для вашего сада</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="ftco-section testimony-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-section ftco-animate mb-5 text-center">
                        @php
                            $testimonialsTitle = \App\Models\HomePageSectionTitle::getByKey('testimonials');
                        @endphp
                        @if($testimonialsTitle && $testimonialsTitle->title)
                            <h2 class="mb-4">{{ $testimonialsTitle->title }}</h2>
                        @else
                            <h2 class="mb-4">Отзывы наших клиентов</h2>
                        @endif
                        @if($testimonialsTitle && $testimonialsTitle->subtitle)
                            <p>{{ $testimonialsTitle->subtitle }}</p>
                        @else
                            <p>Мы гордимся отзывами наших покупателей. Качество наших растений и сервис — наш главный приоритет.</p>
                        @endif
                    </div>
                    <div class="carousel-testimony owl-carousel">
                        @foreach($testimonials as $testimonial)
                        <div class="item">
                            <div class="testimony-wrap">
                                <div class="user-img mb-4" style="background-image: url({{ $testimonial->image ? asset('storage/' . $testimonial->image) : asset('assets/images/person_1.jpg') }})">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="icon-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-4 pl-4 line">{{ $testimonial->content }}</p>
                                    <p class="name">{{ $testimonial->name }}</p>
                                    <span class="position">{{ $testimonial->position }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Section -->
    <section class="ftco-gallery">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 heading-section text-center mb-4 ftco-animate">
                    @php
                        $galleryTitle = \App\Models\HomePageSectionTitle::getByKey('gallery');
                    @endphp
                    @if($galleryTitle && $galleryTitle->title)
                        <h2 class="mb-4">{{ $galleryTitle->title }}</h2>
                    @else
                        <h2 class="mb-4">Следите за нами в Instagram</h2>
                    @endif
                    @if($galleryTitle && $galleryTitle->subtitle)
                        <p>{{ $galleryTitle->subtitle }}</p>
                    @else
                        <p>Смотрите фото наших растений, примеры работ наших клиентов и полезные советы по уходу за туями в нашем Instagram</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="container-fluid px-0">
            <div class="row no-gutters">
                @forelse($galleryImages as $galleryImage)
                    <div class="col-md-4 col-lg-2 ftco-animate">
                        <a href="{{ $galleryImage->link ?? asset('storage/' . $galleryImage->image) }}" class="gallery image-popup img d-flex align-items-center" style="background-image: url({{ asset('storage/' . $galleryImage->image) }});">
                            <div class="icon mb-4 d-flex align-items-center justify-content-center">
                                <span class="icon-instagram"></span>
                            </div>
                        </a>
                    </div>
                @empty
                    {{-- Fallback to default gallery if no gallery images in database --}}
                    @for($i = 1; $i <= 6; $i++)
                    <div class="col-md-4 col-lg-2 ftco-animate">
                        <a href="{{ asset('assets/images/gallery-' . $i . '.jpg') }}" class="gallery image-popup img d-flex align-items-center" style="background-image: url({{ asset('assets/images/gallery-' . $i . '.jpg') }});">
                            <div class="icon mb-4 d-flex align-items-center justify-content-center">
                                <span class="icon-instagram"></span>
                            </div>
                        </a>
                    </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>
@endsection

