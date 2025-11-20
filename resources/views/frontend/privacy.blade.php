@extends('frontend.layout')

@section('title', 'Политика конфиденциальности - GreenPlant')

@section('content')
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden;">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ asset('assets/images/bg_6.jpg') }}'); background-size: cover; background-position: center center; background-repeat: no-repeat; z-index: 0;"></div>
        <div class="overlay-layer" style="background: rgba(0, 0, 0, 0.4); position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread" style="text-shadow: 0px 0px 20px black !important;">Политика конфиденциальности</h1>
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
                        <span>Политика конфиденциальности</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-5 wrap-about ftco-animate">
                    <div class="bg-white p-5">
                        <div class="privacy-content">
                            {!! $content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<style>
    .privacy-content {
        line-height: 1.8;
        color: #333;
    }
    .privacy-content h2 {
        color: #82ae46;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-size: 1.5rem;
        font-weight: 600;
    }
    .privacy-content h2:first-child {
        margin-top: 0;
    }
    .privacy-content p {
        margin-bottom: 1rem;
    }
    .privacy-content ul {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    .privacy-content li {
        margin-bottom: 0.5rem;
    }
</style>
@endsection

