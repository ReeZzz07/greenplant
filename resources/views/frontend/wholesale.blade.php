@extends('frontend.layout')

@section('title', 'Оптовым покупателям - GreenPlant')

@section('content')
    <div class="hero-wrap hero-bread" style="position: relative; overflow: hidden;">
        <div class="hero-background" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('{{ $wholesaleSettings && $wholesaleSettings->background_image ? asset('storage/' . $wholesaleSettings->background_image) : asset('assets/images/bg_6.jpg') }}'); background-size: {{ $wholesaleSettings && $wholesaleSettings->background_size ? $wholesaleSettings->background_size : 'cover' }}; background-position: {{ $wholesaleSettings && $wholesaleSettings->background_position ? $wholesaleSettings->background_position : 'center center' }}; background-repeat: no-repeat; z-index: 0; @if(!$wholesaleSettings || !$wholesaleSettings->background_image) background-color: {{ $wholesaleSettings && $wholesaleSettings->background_color ? $wholesaleSettings->background_color : '#82ae46' }}; @endif"></div>
        @if($wholesaleSettings && $wholesaleSettings->overlay_type !== 'none')
            <div class="overlay-layer" style="background: @if($wholesaleSettings->overlay_type === 'darken') rgba(0, 0, 0, {{ $wholesaleSettings->overlay_opacity / 100 }}) @elseif($wholesaleSettings->overlay_type === 'lighten') rgba(255, 255, 255, {{ $wholesaleSettings->overlay_opacity / 100 }}) @endif; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0;"></div>
        @endif
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 300px;">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">{{ $wholesaleSettings && $wholesaleSettings->title ? $wholesaleSettings->title : 'Оптовым покупателям' }}</h1>
                    @if($wholesaleSettings && $wholesaleSettings->subtitle)
                        <p class="mt-3" style="color: rgba(255, 255, 255, 0.9); font-size: 18px;">{{ $wholesaleSettings->subtitle }}</p>
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
                        <span>Оптовым покупателям</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-5 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section-bold mb-4 mt-md-5">
                        <div class="ml-md-0">
                            <h2 class="mb-4">Почему мы — лучший оптовый партнёр?</h2>
                        </div>
                    </div>
                    <div class="pb-md-5">
                        <div class="row wholesale-advantages">
                            @php
                                $advantages = $wholesaleSettings && $wholesaleSettings->advantages ? $wholesaleSettings->advantages : [
                                    ['icon' => '🌱', 'title' => 'Выращены в открытом грунте', 'description' => 'Без стресса от пересадки, крона густая, цвет насыщенный'],
                                    ['icon' => '📦', 'title' => 'Доставка с комом земли', 'description' => 'Мешковина/корзина, корни целы, приживаемость до 98%'],
                                    ['icon' => '⚡', 'title' => 'Готовы к отправке за 1–3 дня', 'description' => 'Не ждите, пока саженцы «подрастут»'],
                                    ['icon' => '💰', 'title' => 'Цены на 15–25% ниже рынка', 'description' => 'Минимум посредников, максимум вашей прибыли'],
                                    ['icon' => '🤝', 'title' => 'Гибкие условия', 'description' => 'От 50 шт., доставка по РФ, индивидуальные сроки и упаковка'],
                                ];
                            @endphp
                            @foreach($advantages as $advantage)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body text-center">
                                            <div class="mb-3" style="font-size: 48px;">{{ $advantage['icon'] ?? '✨' }}</div>
                                            <h5 class="card-title mb-3">{{ $advantage['title'] ?? '' }}</h5>
                                            <p class="card-text">{{ $advantage['description'] ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Calculator Section -->
    <section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-5 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section-bold mb-4 mt-md-5">
                        <div class="ml-md-0">
                            <h2 class="mb-4">Рассчитайте свою прибыль</h2>
                            <p>Введите размеры участка и узнайте, сколько саженцев можно посадить и какую прибыль вы получите</p>
                        </div>
                    </div>
                    <div class="pb-md-5">
                        <div class="bg-white p-5 rounded calculator-wrapper">
                            <form id="profit-calculator" class="calculator-form">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Длина участка (метры)</label>
                                        <input type="number" id="plot-length" class="form-control" min="0" step="1" value="0" required>
                                        <small class="text-muted">Введите длину вашего участка в метрах</small>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Ширина участка (метры)</label>
                                        <input type="number" id="plot-width" class="form-control" min="0" step="1" value="0" required>
                                        <small class="text-muted">Введите ширину вашего участка в метрах</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Цена закупки саженца (₽)</label>
                                        <input type="number" id="seedling-price" class="form-control" min="0" step="10" value="{{ $wholesaleSettings->seedling_price ?? $wholesaleSettings->purchase_price ?? 300 }}" required>
                                        <small class="text-muted">Стоимость одного саженца</small>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Цена продажи взрослого дерева (₽)</label>
                                        <input type="number" id="mature-tree-price" class="form-control" min="0" step="10" value="{{ $wholesaleSettings->mature_tree_price ?? 3800 }}" required>
                                        <small class="text-muted">Цена продажи взрослого дерева через {{ $wholesaleSettings->maturity_years ?? 3 }} года</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="alert alert-info">
                                            <strong>Параметры посадки:</strong><br>
                                            • Рекомендуется отступ от края: 0.5 м с каждой стороны<br>
                                            • Расстояние между саженцами: 0.8 м (в ряду и между рядами)
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <button type="button" id="calculate-btn" class="btn btn-primary w-100 py-3">
                                            <i class="fas fa-calculator mr-2"></i> Рассчитать
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Results -->
                            <div id="calculator-results" class="mt-5" style="display: none;">
                                <div class="row calculator-results">
                                    <div class="col-md-6 mb-3">
                                        <div class="bg-light p-4 rounded calculator-result-card">
                                            <h5 class="text-muted mb-2">Количество саженцев</h5>
                                            <p class="h3 mb-0" id="seedling-count">0 шт.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="bg-light p-4 rounded calculator-result-card">
                                            <h5 class="text-muted mb-2">Общие затраты</h5>
                                            <p class="h3 mb-0" id="total-costs">0 ₽</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="bg-light p-4 rounded calculator-result-card">
                                            <h5 class="text-muted mb-2">Прибыль через {{ $wholesaleSettings->maturity_years ?? 3 }} года</h5>
                                            <p class="h2 mb-0" id="net-profit">0 ₽</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="bg-light p-4 rounded calculator-result-card">
                                            <h5 class="text-muted mb-2">Маржинальность</h5>
                                            <p class="h2 mb-0" id="profitability">0%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="warning mt-3 col-md-12">
                                <div class="alert alert-info">
                                    <strong>ВНИМАНИЕ!!!</strong>
                                    <br>
                                    Данные рассчеты являются примерными и мы не гарантируем, что результат будет точно таким же.
                                    <br>
                                    Реальная прибыль может быть ниже или гораздо выше?.
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-5 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section-bold mb-4 mt-md-5">
                        <div class="ml-md-0">
                            <h2 class="mb-4">Как это работает?</h2>
                            <p>Вы — продавец. Мы — поставщик. Вот как это просто:</p>
                        </div>
                    </div>
                    <div class="pb-md-5">
                        <div class="row">
                            @php
                                $steps = $wholesaleSettings && $wholesaleSettings->how_it_works ? $wholesaleSettings->how_it_works : [
                                    ['number' => '1', 'title' => 'Заказываете', 'description' => 'Нужное количество саженцев через форму на сайте или по телефону'],
                                    ['number' => '2', 'title' => 'Получаете', 'description' => 'Саженцы с комом земли, в мешковине, с паспортом качества — готовые к продаже'],
                                    ['number' => '3', 'title' => 'Продаёте', 'description' => 'Клиентам по вашей цене — без риска гибели растений'],
                                    ['number' => '4', 'title' => 'Получаете прибыль', 'description' => 'И возвращаетесь к нам за новой партией'],
                                ];
                            @endphp
                            @foreach($steps as $step)
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="mr-3" style="width: 50px; height: 50px; background: #82ae46; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; flex-shrink: 0;">{{ $step['number'] ?? '' }}</div>
                                        <div>
                                            <h5 class="mb-2">{{ $step['title'] ?? '' }}</h5>
                                            <p>{{ $step['description'] ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($wholesaleSettings && $wholesaleSettings->how_it_works_text)
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <p style="font-style: italic; color: #82ae46; font-weight: 600; font-size: 18px; white-space: pre-line;">
                                    {{ $wholesaleSettings->how_it_works_text }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="ftco-section ftco-no-pb ftco-no-pt bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-5 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section-bold mb-4 mt-md-5">
                        <div class="ml-md-0 text-center">
                            <h2 class="mb-4">Готовы начать сотрудничество?</h2>
                            <p class="mb-4">Свяжитесь с нами прямо сейчас и получите индивидуальное предложение для вашего бизнеса</p>
                            <div class="d-flex justify-content-center gap-4 flex-wrap">
                                <a href="{{ route('contact') }}" class="btn btn-primary px-5 py-3 mx-2 wholesale-cta-contact-btn" style="background: #82ae46; border: none; font-weight: 600; color: #fff;">
                                    <i class="fas fa-envelope mr-2"></i> Написать нам
                                </a>
                                <a href="tel:{{ \App\Models\Setting::get('phone', '+7 (988) 938-56-00') }}" class="btn btn-outline-primary px-5 py-3 mx-2 wholesale-cta-call-btn" style="border: 2px solid #82ae46; color: #82ae46; font-weight: 600;">
                                    <i class="fas fa-phone mr-2"></i> Позвонить
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    //const edgeOffset = 0.5; // Отступ от края (метры)
    const plantingDistance = 0.8; // Расстояние между саженцами (метры)
    
    // Calculate button
    document.getElementById('calculate-btn').addEventListener('click', calculateProfit);
    
    function calculateProfit() {
        const plotLength = parseFloat(document.getElementById('plot-length').value) || 0;
        const plotWidth = parseFloat(document.getElementById('plot-width').value) || 0;
        const seedlingPrice = parseFloat(document.getElementById('seedling-price').value) || 0;
        const matureTreePrice = parseFloat(document.getElementById('mature-tree-price').value) || 0;
        
        // Валидация
        if (plotLength <= 0 || plotWidth <= 0 || isNaN(plotLength) || isNaN(plotWidth)) {
            alert('Пожалуйста, введите корректные размеры участка (больше 0)');
            return;
        }
        
        if (seedlingPrice <= 0 || matureTreePrice <= 0) {
            alert('Пожалуйста, введите корректные цены');
            return;
        }
        
        // Шаг 1: Учёт отступов
        // Отступ 0.5 м с каждой стороны, значит с двух сторон = 1 м
        //const innerLength = plotLength - (2 * edgeOffset); // L - 1
        //const innerWidth = plotWidth - (2 * edgeOffset); // W - 1
        
        if (plotLength <= 0 || plotWidth <= 0) {
            alert('Участок слишком мал. Минимальный размер участка должен быть больше 1 метра (с учетом отступов).');
            return;
        }
        
        // Шаг 2: Расстановка саженцев в сетке
        // N = ⌊D/0.8⌋ + 1, где D - длина или ширина внутренней зоны
        const countByLength = plotLength / plantingDistance;
        const countByWidth = plotWidth / plantingDistance;
        console.log(countByLength);
        console.log(countByWidth);
        // Общее количество саженцев
        const seedlingCount = Math.ceil(countByLength * countByWidth);
        
        if (seedlingCount === 0) {
            alert('На участке такого размера нельзя посадить саженцы с учетом отступов и расстояния между ними.');
            return;
        }
        
        // Рассчитываем затраты
        const totalCosts = seedlingCount * seedlingPrice;
        
        // Рассчитываем выручку
        const totalRevenue = seedlingCount * matureTreePrice;
        
        // Рассчитываем прибыль
        const netProfit = totalRevenue - totalCosts;
        
        // Рассчитываем маржинальность (прибыль / выручка * 100%)
        const profitability = totalRevenue > 0 ? ((netProfit / totalRevenue) * 100).toFixed(1) : 0;
        console.log(totalCosts);
        
        // Update results
        document.getElementById('seedling-count').textContent = formatNumber(seedlingCount) + ' шт.';
        document.getElementById('total-costs').textContent = formatMoney(totalCosts);
        document.getElementById('net-profit').textContent = formatMoney(netProfit);
        document.getElementById('profitability').textContent = profitability + '%';
        
        // Show results
        document.getElementById('calculator-results').style.display = 'block';
        
        // Scroll to results
        document.getElementById('calculator-results').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    function formatMoney(amount) {
        return new Intl.NumberFormat('ru-RU', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount) + ' ₽';
    }
    
    function formatNumber(number) {
        return new Intl.NumberFormat('ru-RU', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }
});
</script>
@endsection

