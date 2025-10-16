@extends('frontend.layout')

@section('title', 'О компании - GreenPlant')

@section('content')
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden;">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ $aboutSettings && $aboutSettings->background_image ? asset('storage/' . $aboutSettings->background_image) : asset('assets/images/bg_6.jpg') }}'); background-size: {{ $aboutSettings && $aboutSettings->background_size ? $aboutSettings->background_size : 'cover' }}; background-position: {{ $aboutSettings && $aboutSettings->background_position ? $aboutSettings->background_position : 'center center' }}; background-repeat: no-repeat; z-index: 0;"></div>
        @if($aboutSettings && $aboutSettings->overlay_type !== 'none')
            <div class="overlay-layer" style="background: @if($aboutSettings->overlay_type === 'darken') rgba(0, 0, 0, {{ $aboutSettings->overlay_opacity / 100 }}) @elseif($aboutSettings->overlay_type === 'lighten') rgba(255, 255, 255, {{ $aboutSettings->overlay_opacity / 100 }}) @endif; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        @endif
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ $aboutSettings && $aboutSettings->title ? $aboutSettings->title : 'О компании GreenPlant' }}</h1>
                    @if($aboutSettings && $aboutSettings->subtitle)
                        <p class="mt-3" style="color: rgba(255, 255, 255, 0.9); font-size: 18px;">{{ $aboutSettings->subtitle }}</p>
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
                        <span>О компании</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{ $aboutSettings && $aboutSettings->about_image ? asset('storage/' . $aboutSettings->about_image) : asset('assets/images/about.jpg') }});">
                </div>
                <div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section-bold mb-4 mt-md-5">
                        <div class="ml-md-0">
                            <h2 class="mb-4">{{ $aboutSettings && $aboutSettings->welcome_title ? $aboutSettings->welcome_title : 'Добро пожаловать в GreenPlant' }}</h2>
                        </div>
                    </div>
                    <div class="pb-md-5">
                        <p>{{ $aboutSettings && $aboutSettings->welcome_text ? $aboutSettings->welcome_text : 'GreenPlant - это питомник растений, который специализируется на выращивании и продаже различных сортов туи премиум-качества. Мы работаем на рынке уже более 10 лет и знаем все о выращивании здоровых, крепких растений.' }}</p>
                        
                        @if($aboutSettings && $aboutSettings->main_content)
                            <div class="main-content">
                                {!! $aboutSettings->main_content !!}
                            </div>
                        @else
                            <p>Наши преимущества:</p>
                            <ul>
                                <li>Собственный питомник с соблюдением всех агротехнических норм</li>
                                <li>Широкий ассортимент сортов туи для любых целей</li>
                                <li>Гарантия приживаемости при соблюдении рекомендаций</li>
                                <li>Профессиональные консультации по выбору и уходу</li>
                                <li>Доставка по всей России с сохранением корневой системы</li>
                                <li>Индивидуальный подход к каждому клиенту</li>
                            </ul>

                            <p>Мы поможем вам создать живую изгородь, украсить ландшафт или просто добавить зелени на ваш участок. Наши специалисты всегда готовы проконсультировать по выбору сорта, посадке и уходу за растениями.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

