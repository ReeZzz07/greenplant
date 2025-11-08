@extends('frontend.layout')

@section('title', 'Информация для покупателей - GreenPlant')
@section('description', 'Оплата, доставка, гарантии и ответы на частые вопросы питомника GreenPlant.')
@section('keywords', 'доставка туй, оплата растений, гарантия приживаемости, вопросы GreenPlant')

@section('content')
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden;">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ $heroBackground }}'); background-size: {{ $heroBackgroundSize }}; background-position: {{ $heroBackgroundPosition }}; background-repeat: no-repeat; z-index: 0;"></div>
        @if($heroOverlayType !== 'none')
            <div class="overlay-layer" style="background: @if($heroOverlayType === 'darken') rgba(0, 0, 0, {{ $heroOverlayOpacity / 100 }}) @elseif($heroOverlayType === 'lighten') rgba(255, 255, 255, {{ $heroOverlayOpacity / 100 }}) @endif; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        @endif
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-8 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ $heroTitle }}</h1>
                    @if($heroSubtitle)
                        <p class="mt-3" style="color: rgba(255, 255, 255, 0.9); font-size: 18px;">{{ $heroSubtitle }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <section class="breadcrumbs-section bg-white py-3" style="border-bottom: 1px solid #e9ecef;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="breadcrumbs mb-0">
                        <span class="mr-2"><a href="{{ route('home') }}">Главная</a></span>
                        <span>Информация</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-10 col-lg-8 text-center ftco-animate">
                    <h2 class="mb-3 info-section-header">{{ $contentTitle }}</h2>
                    @if(!empty($contentSubtitle))
                        <p>{{ $contentSubtitle }}</p>
                    @endif
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <ul class="nav info-tabs justify-content-center mb-4" id="infoTab" role="tablist">
                        @foreach($tabs as $key => $tab)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link {{ $activeTab === $key ? 'active' : '' }}" id="tab-{{ $key }}-link" data-toggle="pill" href="#tab-{{ $key }}" role="tab" aria-controls="tab-{{ $key }}" aria-selected="{{ $activeTab === $key ? 'true' : 'false' }}" data-tab="{{ $key }}">
                                    <span class="info-tab-icon">{{ \Illuminate\Support\Str::substr($tab['title'], 0, 1) }}</span>
                                    <span class="info-tab-title">{{ $tab['title'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content bg-white p-4 p-md-5 shadow-sm rounded" id="infoTabContent">
                        @foreach($tabs as $key => $tab)
                            <div class="tab-pane fade {{ $activeTab === $key ? 'show active' : '' }}" id="tab-{{ $key }}" role="tabpanel" aria-labelledby="tab-{{ $key }}-link">
                                @if(isset($tab['faq_items']))
                                    <div class="info-faq">
                                        @foreach($tab['faq_items'] as $item)
                                            @php
                                                $question = $item['question'] ?? '';
                                                $answer = $item['answer'] ?? '';
                                            @endphp
                                            @if($question !== '')
                                                <h5>{{ $question }}</h5>
                                            @endif
                                            @if($answer !== '')
                                                {!! $answer !!}
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    {!! $tab['content'] !!}
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var infoLinks = document.querySelectorAll('#infoTab .nav-link[data-tab]');
            if (!infoLinks.length) {
                return;
            }

            infoLinks.forEach(function (link) {
                link.addEventListener('shown.bs.tab', function (event) {
                    var targetTab = event.target.getAttribute('data-tab');
                    if (!targetTab) {
                        return;
                    }
                    if (history.replaceState) {
                        var url = new URL(window.location.href);
                        url.searchParams.set('tab', targetTab);
                        history.replaceState(null, '', url.toString());
                    }
                });
            });
        });
    </script>
@endsection
