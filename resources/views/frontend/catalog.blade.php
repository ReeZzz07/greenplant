@extends('frontend.layout')

@section('title', 'Каталог - GreenPlant')

@section('content')
    <!-- Page Header -->
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden;">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ $catalogSettings && $catalogSettings->background_image ? asset('storage/' . $catalogSettings->background_image) : asset('assets/images/bg_6.jpg') }}'); background-size: {{ $catalogSettings && $catalogSettings->background_size ? $catalogSettings->background_size : 'cover' }}; background-position: {{ $catalogSettings && $catalogSettings->background_position ? $catalogSettings->background_position : 'center center' }}; background-repeat: no-repeat; z-index: 0;"></div>
        @if($catalogSettings && $catalogSettings->overlay_type !== 'none')
            <div class="overlay-layer" style="background: @if($catalogSettings->overlay_type === 'darken') rgba(0, 0, 0, {{ $catalogSettings->overlay_opacity / 100 }}) @elseif($catalogSettings->overlay_type === 'lighten') rgba(255, 255, 255, {{ $catalogSettings->overlay_opacity / 100 }}) @endif; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        @endif
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ $catalogSettings && $catalogSettings->title ? $catalogSettings->title : 'Каталог товаров' }}</h1>
                    @if($catalogSettings && $catalogSettings->subtitle)
                        <p class="mt-3" style="color: rgba(255, 255, 255, 0.9); font-size: 18px;">{{ $catalogSettings->subtitle }}</p>
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
                        <span>Каталог</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="sidebar-box bg-white p-4 rounded" style="box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <h2 class="heading mb-4" style="font-size: 20px; border-bottom: 2px solid #82ae46; padding-bottom: 10px;">Категории</h2>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 10px;">
                                <a href="{{ route('catalog') }}" style="color: {{ !request('category') ? '#82ae46' : '#333' }}; font-weight: {{ !request('category') ? '600' : 'normal' }};">
                                    Все товары
                                </a>
                            </li>
                            @foreach($categories as $category)
                            <li style="margin-bottom: 10px;">
                                <a href="{{ route('catalog', ['category' => $category->slug]) }}" style="color: {{ request('category') == $category->slug ? '#82ae46' : '#333' }}; font-weight: {{ request('category') == $category->slug ? '600' : 'normal' }};">
                                    {{ $category->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-md-9">
                    <div class="row">
                        @forelse($products as $product)
                            <x-product-card :product="$product" />
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                Товары не найдены
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <div class="row mt-5">
                        <div class="col text-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

