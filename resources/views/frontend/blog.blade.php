@extends('frontend.layout')

@section('title', 'Советы и уход - GreenPlant')

@section('content')
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden;">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ $blogSettings && $blogSettings->background_image ? asset('storage/' . $blogSettings->background_image) : asset('assets/images/bg_6.jpg') }}'); background-size: {{ $blogSettings && $blogSettings->background_size ? $blogSettings->background_size : 'cover' }}; background-position: {{ $blogSettings && $blogSettings->background_position ? $blogSettings->background_position : 'center center' }}; background-repeat: no-repeat; z-index: 0;"></div>
        @if($blogSettings && $blogSettings->overlay_type !== 'none')
            <div class="overlay-layer" style="background: @if($blogSettings->overlay_type === 'darken') rgba(0, 0, 0, {{ $blogSettings->overlay_opacity / 100 }}) @elseif($blogSettings->overlay_type === 'lighten') rgba(255, 255, 255, {{ $blogSettings->overlay_opacity / 100 }}) @endif; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        @endif
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ $blogSettings && $blogSettings->title ? $blogSettings->title : 'Советы и уход' }}</h1>
                    @if($blogSettings && $blogSettings->subtitle)
                        <p class="mt-3" style="color: rgba(255, 255, 255, 0.9); font-size: 18px;">{{ $blogSettings->subtitle }}</p>
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
                        <span>Советы и уход</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-degree-bg">
        <div class="container">
            <div class="row">
                @forelse($posts as $post)
                <div class="col-md-4 ftco-animate">
                    <div class="blog-entry">
                        <a href="{{ route('blog.post', $post->slug) }}" class="block-20 d-flex align-items-end" style="background-image: url('{{ $post->image ? asset('storage/' . $post->image) : asset('assets/images/image_1.jpg') }}');">
                            <div class="meta-date text-center p-2">
                                <span class="day">{{ $post->published_at->format('d') }}</span>
                                <span class="mos">{{ $post->published_at->formatLocalized('%B') }}</span>
                                <span class="yr">{{ $post->published_at->format('Y') }}</span>
                            </div>
                        </a>
                        <div class="text bg-white p-4">
                            <h3 class="heading"><a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a></h3>
                            <p>{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                            <div class="d-flex align-items-center mt-4">
                                <p class="mb-0"><a href="{{ route('blog.post', $post->slug) }}" class="btn btn-black py-2 px-3">Читать далее <span class="ion-ios-arrow-round-forward"></span></a></p>
                                <p class="ml-auto mb-0">
                                    <a href="#" class="mr-2">{{ $post->author->name }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Статей пока нет
                    </div>
                </div>
                @endforelse
            </div>

            <div class="row mt-5">
                <div class="col text-center">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

