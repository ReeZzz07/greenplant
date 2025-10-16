@php
    $settings = \App\Models\AccountPageSetting::getSettings();
    $heroImageUrl = $settings->hero_background_image 
        ? asset('storage/' . $settings->hero_background_image) 
        : asset('assets/images/bg_6.jpg');
    
    // Определяем стили для overlay
    $overlayStyle = '';
    if ($settings->overlay_type === 'darken') {
        $overlayOpacity = $settings->overlay_opacity / 100;
        $overlayStyle = "background: rgba(0, 0, 0, {$overlayOpacity});";
    } elseif ($settings->overlay_type === 'lighten') {
        $overlayOpacity = $settings->overlay_opacity / 100;
        $overlayStyle = "background: rgba(255, 255, 255, {$overlayOpacity});";
    }
@endphp

<div class="hero-wrap hero-bread" style="background-image: url('{{ $heroImageUrl }}'); background-size: {{ $settings->background_size }}; background-position: {{ $settings->background_position }}; position: relative;">
    @if($overlayStyle)
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; {{ $overlayStyle }}"></div>
    @endif
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">{{ $title ?? 'Личный кабинет' }}</h1>
                @if(isset($subtitle))
                    <p class="mt-3" style="font-size: 18px; color: #ffffff;">
                        <span>{{ $subtitle }}</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

