@extends('frontend.layout')

@section('title', $product->name . ' - GreenPlant')
@section('description', $product->short_description ?? Str::limit($product->description, 160))
@section('keywords', $product->name . ', ' . $product->category->name . ', купить тую, саженцы туи, GreenPlant')

@section('og_title', $product->name . ' - ' . number_format($product->price, 0, ',', ' ') . ' ₽')
@section('og_description', $product->short_description ?? Str::limit($product->description, 200))
@section('og_image', $product->first_image_url)

@section('content')
    @php
        $heroBackgroundImage = $product->hero_background_image
            ? asset('storage/' . $product->hero_background_image)
            : asset('assets/images/bg_6.jpg');

        $heroBackgroundColor = $product->hero_background_color
            ? '#' . ltrim($product->hero_background_color, '#')
            : '#82ae46';

        $heroBackgroundSize = $product->hero_background_size ?: 'cover';
        $heroBackgroundPosition = $product->hero_background_position ?: 'center center';
        $heroOverlayType = $product->hero_overlay_type ?: 'darken';
        $heroOverlayOpacity = max(0, min(100, (int) ($product->hero_overlay_opacity ?? 40)));
    @endphp

    <!-- Page Header -->
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden; background-color: {{ $heroBackgroundColor }};">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ $heroBackgroundImage }}'); background-size: {{ $heroBackgroundSize }}; background-position: {{ $heroBackgroundPosition }}; background-repeat: no-repeat; z-index: 0;"></div>
        @if($heroOverlayType !== 'none')
            <div class="overlay-layer" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0; background: {{ $heroOverlayType === 'lighten' ? 'rgba(255, 255, 255, ' . ($heroOverlayOpacity / 100) . ')' : 'rgba(0, 0, 0, ' . ($heroOverlayOpacity / 100) . ')' }};"></div>
        @endif
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ $product->name }}</h1>
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
                        <span class="mr-2"><a href="{{ route('catalog') }}">Каталог</a></span>
                        <span>{{ $product->name }}</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                @php
                    $galleryImages = collect($product->images ?? []);
                    $primaryImage = $product->first_image;
                    if ($primaryImage && !$galleryImages->contains($primaryImage)) {
                        $galleryImages = $galleryImages->prepend($primaryImage);
                    }
                @endphp
                <div class="col-lg-6 mb-5 ftco-animate">
                    <div
                        class="product-gallery"
                        data-product-name="{{ $product->name }}">
                        <a href="{{ $product->first_image_url }}" class="image-popup prod-img-bg" data-role="primary-image-link" data-index="0">
                            <img src="{{ $product->first_image_url }}" class="img-fluid" alt="{{ $product->name }}" data-role="primary-image">
                        </a>

                        @if($galleryImages->count() > 1)
                            <div class="product-thumbnails mt-3">
                                @foreach($galleryImages as $imgPath)
                                    <button type="button"
                                            class="thumbnail-item {{ $loop->first ? 'is-active' : '' }}"
                                            data-image="{{ asset('storage/' . $imgPath) }}"
                                            data-full="{{ asset('storage/' . $imgPath) }}"
                                            data-index="{{ $loop->index }}"
                                            aria-label="Просмотреть изображение {{ $loop->iteration }}"
                                            data-alt="{{ $product->name }} — фото {{ $loop->iteration }}">
                                        <img src="{{ asset('storage/' . $imgPath) }}" alt="{{ $product->name }} — фото {{ $loop->iteration }}" loading="lazy">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                    <h3>{{ $product->name }}</h3>
                    <div class="rating d-flex">
                        <p class="text-left mr-4">
                            @for($i = 0; $i < 5; $i++)
                                <a href="#"><span class="ion-ios-star{{ $i < 4 ? '' : '-outline' }}"></span></a>
                            @endfor
                        </p>
                        <p class="text-left mr-4">
                            <a href="#" class="mr-2" style="color: #000;">5.0 <span style="color: #bbb;">Рейтинг</span></a>
                        </p>
                    </div>
                    <p class="price">
                        @if($product->old_price)
                            <span class="mr-2" style="text-decoration: line-through; color: #999;">{{ number_format($product->old_price, 0, ',', ' ') }} ₽</span>
                            <span style="font-size: 32px; font-weight: 600;">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        @else
                            <span style="font-size: 32px; font-weight: 600;">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        @endif
                    </p>

                    @if($product->short_description)
                    <p>{{ $product->short_description }}</p>
                    @endif

                    @if($product->description)
                    <div style="margin-top: 20px;">
                        <h4>Описание</h4>
                        <p>{{ $product->description }}</p>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <p style="color: #000;">
                                <strong>Категория:</strong> {{ $product->category->name }}<br>
                                <strong>Артикул:</strong> {{ $product->sku ?? '-' }}<br>
                                <strong>Наличие:</strong> 
                                @if($product->stock > 0)
                                    <span class="in-stock">В наличии ({{ $product->stock }} шт.)</span>
                                @else
                                    <span class="out-of-stock">Под заказ</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label for="quantity" style="margin: 0; font-weight: 500;">Количество:</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="100" style="width: 80px; text-align: center; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                                    <button type="submit" class="btn btn-primary py-3 px-5 mr-2 add-to-cart-btn" style="border: none; cursor: pointer;">В корзину +</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3 class="mb-4">Похожие товары</h3>
                </div>
                @foreach($relatedProducts as $related)
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="product">
                        <a href="{{ route('product', $related->slug) }}" class="img-prod">
                            <img class="img-fluid" src="{{ $related->first_image_url }}" alt="{{ $related->name }}">
                            <div class="overlay"></div>
                        </a>
                        <div class="text py-3 pb-4 px-3 text-center">
                            <h3><a href="{{ route('product', $related->slug) }}">{{ $related->name }}</a></h3>
                            <div class="pricing">
                                <p class="price"><span>{{ number_format($related->price, 0, ',', ' ') }} ₽</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gallery = document.querySelector('.product-gallery');
            if (!gallery) {
                return;
            }

            const primaryImage = gallery.querySelector('[data-role="primary-image"]');
            const primaryLink = gallery.querySelector('[data-role="primary-image-link"]');
            const thumbnails = Array.from(gallery.querySelectorAll('.thumbnail-item'));
            const galleryItems = thumbnails.map((thumbnail) => ({
                src: thumbnail.dataset.full,
                title: thumbnail.dataset.alt || gallery.dataset.productName || '',
            })).filter((item) => !!item.src);

            if (!primaryImage || !primaryLink || galleryItems.length === 0) {
                return;
            }

            const setActiveThumbnail = (thumbnail) => {
                thumbnails.forEach((btn) => btn.classList.toggle('is-active', btn === thumbnail));
            };

            thumbnails.forEach((thumbnail) => {
                thumbnail.addEventListener('click', () => {
                    const fullUrl = thumbnail.dataset.full;
                    const imgUrl = thumbnail.dataset.image || fullUrl;
                    const altText = thumbnail.dataset.alt;
                    const index = parseInt(thumbnail.dataset.index ?? '0', 10);

                    if (!fullUrl) {
                        return;
                    }

                    primaryImage.src = imgUrl;
                    if (altText) {
                        primaryImage.alt = altText;
                    } else {
                        primaryImage.alt = gallery.dataset.productName || primaryImage.alt;
                    }
                    primaryLink.href = fullUrl;
                    primaryLink.dataset.index = Number.isNaN(index) ? '0' : String(index);
                    setActiveThumbnail(thumbnail);
                });

                thumbnail.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        thumbnail.click();
                    }
                });
            });

            const $ = window.jQuery;
            if ($ && $.fn.magnificPopup && primaryLink) {
                const $primaryLink = $(primaryLink);
                $primaryLink.magnificPopup({
                    type: 'image',
                    items: galleryItems,
                    gallery: {
                        enabled: true,
                        tPrev: 'Назад',
                        tNext: 'Вперёд',
                        tCounter: '%curr% из %total%'
                    },
                    callbacks: {
                        open: function () {
                            const index = parseInt(primaryLink.dataset.index ?? '0', 10);
                            if (!Number.isNaN(index) && index >= 0 && index < this.items.length) {
                                this.goTo(index);
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
