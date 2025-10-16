@extends('frontend.layout')

@section('title', $post->title . ' - GreenPlant')
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))
@section('keywords', 'блог, ' . $post->title . ', уход за туей, туя, GreenPlant')

@section('og_title', $post->title)
@section('og_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 200))
@section('og_image', $post->image ? asset('storage/' . $post->image) : asset('assets/images/image_1.jpg'))

@section('content')
    <div class="hero-wrap hero-bread" style="background-image: url('{{ asset('assets/images/bg_6.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ $post->title }}</h1>
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
                        <span class="mr-2"><a href="{{ route('blog') }}">Блог</a></span>
                        <span>{{ Str::limit($post->title, 50) }}</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 ftco-animate">
                    @if($post->image)
                    <p>
                        <a href="{{ asset('storage/' . $post->image) }}" class="image-popup">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid">
                        </a>
                    </p>
                    @endif

                    <h2 class="mb-3">{{ $post->title }}</h2>
                    
                    <p style="color: #999; margin-bottom: 20px;">
                        <span>{{ $post->published_at->format('d.m.Y') }}</span> • 
                        <span>Автор: {{ $post->author->name }}</span>
                    </p>

                    <div class="blog-post-content" style="line-height: 1.8;">
                        {!! $post->content !!}
                    </div>

                    <div class="tag-widget post-tag-container mb-5 mt-5">
                        <div class="tagcloud">
                            <a href="{{ route('blog') }}" class="tag-cloud-link">Блог</a>
                            <a href="{{ route('catalog') }}" class="tag-cloud-link">Туя</a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 sidebar ftco-animate">
                    <div class="sidebar-box ftco-animate">
                        <h3 class="heading-sidebar">Последние статьи</h3>
                        @forelse($recentPosts as $recent)
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url({{ $recent->image ? asset('storage/' . $recent->image) : asset('assets/images/image_1.jpg') }});"></a>
                            <div class="text">
                                <h3 class="heading"><a href="{{ route('blog.post', $recent->slug) }}">{{ $recent->title }}</a></h3>
                                <div class="meta">
                                    <div><span class="icon-calendar"></span> {{ $recent->published_at->format('d.m.Y') }}</div>
                                    <div><span class="icon-person"></span> {{ $recent->author->name }}</div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color: #999;">Пока нет других статей в блоге</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Оборачиваем все изображения в контенте статьи в ссылки для увеличения
    $('.blog-post-content img').each(function() {
        const img = $(this);
        // Проверяем, не находится ли изображение уже внутри ссылки
        if (!img.parent().is('a')) {
            img.wrap('<a href="' + img.attr('src') + '" class="image-popup"></a>');
        }
    });
    
    // Инициализация Magnific Popup для увеличения изображений
    $('.image-popup').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: true,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom',
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300
        },
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1]
        }
    });
    
    // Инициализация слайдеров изображений в блоге
    const carousels = document.querySelectorAll('.blog-post-content .image-carousel');
    
    carousels.forEach(function(carousel, index) {
        // Проверяем, не был ли уже инициализирован
        if (carousel.classList.contains('owl-initialized')) {
            return;
        }
        
        // Оборачиваем изображения в owl-carousel div
        const images = carousel.querySelectorAll('img');
        if (images.length > 0) {
            const owlDiv = document.createElement('div');
            owlDiv.className = 'owl-carousel owl-theme blog-image-slider-' + index;
            
            images.forEach(function(img) {
                const item = document.createElement('div');
                item.className = 'item';
                
                // Клонируем изображение
                const clonedImg = img.cloneNode(true);
                item.appendChild(clonedImg);
                
                owlDiv.appendChild(item);
            });
            
            carousel.innerHTML = '';
            carousel.appendChild(owlDiv);
            carousel.classList.add('owl-initialized');
            
            // Инициализация Owl Carousel
            $('.blog-image-slider-' + index).owlCarousel({
                items: 1,
                loop: images.length > 1,
                margin: 0,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                smartSpeed: 800,
                navText: ['<span class="ion-ios-arrow-back"></span>', '<span class="ion-ios-arrow-forward"></span>'],
                responsive: {
                    0: { items: 1, nav: false },
                    600: { items: 1, nav: true },
                    1000: { items: 1, nav: true }
                }
            });
        }
    });
    
    // Повторная инициализация Magnific Popup для изображений в слайдерах
    $('.blog-post-content .image-popup').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: true,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom',
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300
        },
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1]
        }
    });
});
</script>
@endsection

