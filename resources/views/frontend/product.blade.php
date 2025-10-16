@extends('frontend.layout')

@section('title', $product->name . ' - GreenPlant')
@section('description', $product->short_description ?? Str::limit($product->description, 160))
@section('keywords', $product->name . ', ' . $product->category->name . ', купить тую, саженцы туи, GreenPlant')

@section('og_title', $product->name . ' - ' . number_format($product->price, 0, ',', ' ') . ' ₽')
@section('og_description', $product->short_description ?? Str::limit($product->description, 200))
@section('og_image', $product->image ? asset('storage/' . $product->image) : asset('assets/images/product-1.png'))

@section('content')
    <!-- Page Header -->
    <div class="hero-wrap hero-bread" style="background-image: url('{{ asset('assets/images/bg_6.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container">
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
                <div class="col-lg-6 mb-5 ftco-animate">
                    <a href="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/product-1.png') }}" class="image-popup prod-img-bg">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/product-1.png') }}" class="img-fluid" alt="{{ $product->name }}">
                    </a>
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
                            <img class="img-fluid" src="{{ $related->image ? asset('storage/' . $related->image) : asset('assets/images/product-1.png') }}" alt="{{ $related->name }}">
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

