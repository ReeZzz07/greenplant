@php
    $initialFaq = [];
    $oldQuestions = old('faq_questions');
    $oldAnswers = old('faq_answers');
    if (is_array($oldQuestions)) {
        foreach ($oldQuestions as $index => $question) {
            $question = $question ?? '';
            $answer = $oldAnswers[$index] ?? '';
            if (trim($question) !== '' || trim($answer) !== '') {
                $initialFaq[] = ['question' => $question, 'answer' => $answer];
            }
        }
    } else {
        $initialFaq = $content['info_faq_json'] ?? [];
    }
@endphp

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки страницы "Информация" - GreenPlant</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .header h1 span {
            font-size: 32px;
        }

        .header a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }

        .header a:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px 60px;
        }

        .card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 18px 45px rgba(82, 111, 173, 0.15);
            padding: 45px;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(130, 174, 70, 0.12), rgba(102, 126, 234, 0.12));
            opacity: 0.6;
            pointer-events: none;
        }

        .card-inner {
            position: relative;
            z-index: 1;
        }

        .card h2 {
            font-size: 28px;
            margin-bottom: 12px;
            color: #2f3367;
        }

        .card p.lead {
            color: #5a5c78;
            margin-bottom: 24px;
            max-width: 720px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s ease;
            background: #fff;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="number"]:focus,
        .form-group input[type="file"]:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        }

        .form-group small {
            display: block;
            margin-top: 6px;
            color: #6c757d;
            font-size: 13px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .tab-nav {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .tab-button {
            flex: 1 0 180px;
            min-width: 150px;
            background: #fff;
            border: 1px solid rgba(130, 174, 70, 0.3);
            border-radius: 14px;
            padding: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            box-shadow: 0 10px 24px rgba(113, 128, 185, 0.15);
        }

        .tab-button .icon {
            font-size: 26px;
        }

        .tab-button strong {
            font-size: 17px;
            color: #2f3367;
        }

        .tab-button span {
            font-size: 13px;
            color: #6b6d8f;
            line-height: 1.4;
        }

        .tab-button.active {
            background: linear-gradient(135deg, #82ae46 0%, #6b9238 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 14px 32px rgba(107, 146, 56, 0.35);
        }

        .tab-button.active strong,
        .tab-button.active span {
            color: white;
        }

        .tab-pane {
            display: none;
            animation: fadeIn 0.2s ease;
        }

        .tab-pane.active {
            display: block;
        }

        .editor-area textarea {
            width: 100%;
            min-height: 260px;
            padding: 18px;
            border: 1px solid rgba(130, 174, 70, 0.4);
            border-radius: 14px;
            font-size: 15px;
            font-family: inherit;
            line-height: 1.6;
            background: rgba(255, 255, 255, 0.92);
            transition: all 0.2s ease;
        }

        .editor-area textarea:focus {
            outline: none;
            border-color: #6f9e3f;
            box-shadow: 0 0 0 4px rgba(130, 174, 70, 0.15);
            background: #fff;
        }

        .editor-area small {
            display: block;
            margin-top: 8px;
            color: #7a7c9a;
        }

        .faq-builder {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 16px;
            padding: 28px;
            border: 1px solid rgba(130, 174, 70, 0.25);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.7);
        }

        .faq-builder-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .faq-items {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .faq-item {
            background: #fff;
            border: 1px solid rgba(130, 174, 70, 0.2);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(82, 111, 173, 0.12);
        }

        .faq-item-header {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 12px;
        }

        .faq-item-header input[type="text"] {
            flex: 1;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid rgba(130, 174, 70, 0.35);
            font-size: 15px;
        }

        .faq-item-header button {
            background: transparent;
            border: none;
            color: #dc3545;
            font-weight: 600;
            cursor: pointer;
            padding: 10px 12px;
            border-radius: 10px;
            transition: background 0.2s ease;
        }

        .faq-item-header button:hover {
            background: rgba(220, 53, 69, 0.12);
        }

        .btn-row {
            display: flex;
            justify-content: flex-end;
            margin-top: 45px;
            gap: 16px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            cursor: pointer;
            font-size: 15px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-secondary {
            background: #e9ecf5;
            color: #394165;
        }

        .btn-secondary:hover {
            background: #dae1f3;
        }

        .btn-primary {
            background: linear-gradient(135deg, #82ae46 0%, #6b9238 100%);
            color: white;
            box-shadow: 0 12px 24px rgba(107, 146, 56, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(107, 146, 56, 0.28);
        }

        .info-image-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 16px;
        }

        .info-image-preview img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
        }

        .info-preview-box {
            width: 100%;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            margin: 20px 0;
            overflow: hidden;
            position: relative;
            background: #f8f9fa;
        }

        .info-preview-box #info-preview-bg {
            position: absolute;
            inset: 0;
            background-size:
                {{ $content['info_page_background_size'] }}
            ;
            background-position:
                {{ $content['info_page_background_position'] }}
            ;
            background-repeat: no-repeat;
            @if(!empty($content['info_page_background']))
                background-image: url('{{ asset('storage/' . $content['info_page_background']) }}');
            @else background-image: url('{{ asset('assets/images/bg_6.jpg') }}');
            @endif
        }

        .info-preview-box #info-preview-overlay {
            position: absolute;
            inset: 0;
            background:
                {{ $content['info_page_overlay'] === 'darken' ? 'rgba(0,0,0,' . ($content['info_page_overlay_opacity'] / 100) . ')' : ($content['info_page_overlay'] === 'lighten' ? 'rgba(255,255,255,' . ($content['info_page_overlay_opacity'] / 100) . ')' : 'transparent') }}
            ;
        }

        .info-preview-box #info-preview-title {
            margin: 0;
            font-size: 32px;
        }

        .info-preview-box #info-preview-subtitle {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .card {
                padding: 24px;
            }

            .tab-button {
                flex: 1 0 100%;
            }

            .btn-row {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-content">
            <h1><span>📘</span>Настройки страницы "Информация"</h1>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('info') }}" target="_blank">👀 Посмотреть на сайте</a>
                <a href="{{ route('admin.dashboard') }}">← Назад в панель</a>
            </div>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-inner">
                <form action="{{ route('admin.info-page-settings.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div
                        style="background: rgba(255,255,255,0.95); border-radius: 18px; padding: 28px; margin-bottom: 32px; border: 1px solid rgba(130, 174, 70, 0.24); box-shadow: 0 10px 32px rgba(113,128,185,0.15);">
                        <h2 style="margin-bottom: 18px; color: #2f3367; display: flex; align-items: center; gap: 10px;">
                            <span>🎨</span>Фон Hero-секции
                        </h2>
                        <p style="color:#6b6d8f; max-width: 720px; margin-bottom: 22px;">Выберите фоновое изображение и
                            параметры наложения для верхнего блока страницы «Информация».</p>

                        <div class="form-group">
                            <label for="info_page_background">Фоновое изображение</label>
                            <input type="file" id="info_page_background" name="info_page_background" accept="image/*"
                                onchange="previewInfoBackground(this)">
                            <small>Рекомендуемый размер: 1920×600px. Форматы: JPG, PNG. До 4 МБ.</small>
                            <div id="info-bg-preview" style="margin-top: 16px;">
                                @if(!empty($content['info_page_background']))
                                    <img src="{{ asset('storage/' . $content['info_page_background']) }}" alt="Текущий фон"
                                        id="info-bg-current"
                                        style="max-width: 100%; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1);">
                                    <label
                                        style="display:inline-flex; align-items:center; gap:6px; margin-top: 10px; font-size: 14px; color: #bf1650;">
                                        <input type="checkbox" name="remove_background" value="1"> Удалить текущее
                                        изображение
                                    </label>
                                @endif
                                <div id="info-bg-new" style="display:none; margin-top: 10px;">
                                    <strong>Новый фон:</strong>
                                    <img src="" alt="Предпросмотр"
                                        style="max-width:100%; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1);">
                                </div>
                            </div>
                        </div>

                        <div class="form-row"
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
                            <div class="form-group">
                                <label for="info_page_background_size">Размер фона</label>
                                <select id="info_page_background_size" name="info_page_background_size">
                                    <option value="cover" {{ (old('info_page_background_size', $content['info_page_background_size']) === 'cover') ? 'selected' : '' }}>Cover
                                    </option>
                                    <option value="contain" {{ (old('info_page_background_size', $content['info_page_background_size']) === 'contain') ? 'selected' : '' }}>Contain
                                    </option>
                                    <option value="auto" {{ (old('info_page_background_size', $content['info_page_background_size']) === 'auto') ? 'selected' : '' }}>Auto
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="info_page_background_position">Позиция фона</label>
                                <input type="text" id="info_page_background_position"
                                    name="info_page_background_position"
                                    value="{{ old('info_page_background_position', $content['info_page_background_position']) }}"
                                    placeholder="например: center center">
                            </div>
                            <div class="form-group">
                                <label for="info_page_overlay">Наложение</label>
                                <select id="info_page_overlay" name="info_page_overlay">
                                    <option value="none" {{ (old('info_page_overlay', $content['info_page_overlay']) === 'none') ? 'selected' : '' }}>Без наложения
                                    </option>
                                    <option value="darken" {{ (old('info_page_overlay', $content['info_page_overlay']) === 'darken') ? 'selected' : '' }}>Затемнение
                                    </option>
                                    <option value="lighten" {{ (old('info_page_overlay', $content['info_page_overlay']) === 'lighten') ? 'selected' : '' }}>Осветление
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="info_page_overlay_opacity">Прозрачность наложения (%)</label>
                                <input type="number" id="info_page_overlay_opacity" name="info_page_overlay_opacity"
                                    min="0" max="100"
                                    value="{{ old('info_page_overlay_opacity', $content['info_page_overlay_opacity']) }}">
                            </div>
                        </div>

                        <div class="info-preview-box"
                            style="width: 100%; border: 2px solid #e9ecef; border-radius: 12px; margin: 20px 0 0; overflow: hidden; position: relative; background: #f8f9fa;">
                            <div id="info-preview-bg"
                                style="position: absolute; inset: 0; background-size: {{ $content['info_page_background_size'] }}; background-position: {{ $content['info_page_background_position'] }}; background-repeat: no-repeat; @if(!empty($content['info_page_background'])) background-image: url('{{ asset('storage/' . $content['info_page_background']) }}'); @else background-image: url('{{ asset('assets/images/bg_6.jpg') }}'); @endif">
                            </div>
                            <div id="info-preview-overlay"
                                style="position: absolute; inset: 0; background: {{ $content['info_page_overlay'] === 'darken' ? 'rgba(0,0,0,' . ($content['info_page_overlay_opacity'] / 100) . ')' : ($content['info_page_overlay'] === 'lighten' ? 'rgba(255,255,255,' . ($content['info_page_overlay_opacity'] / 100) . ')' : 'transparent') }};">
                            </div>
                            <div
                                style="position: relative; z-index: 1; text-align: center; padding: 60px 20px; color: #fff; text-shadow: 0 2px 5px rgba(0,0,0,0.35);">
                                <h3 id="info-preview-title" style="margin: 0; font-size: 32px;">
                                    {{ $content['info_page_title'] }}</h3>
                                <p id="info-preview-subtitle" style="margin: 10px 0 0; font-size: 16px; opacity: 0.9;">
                                    {{ $content['info_page_subtitle'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        style="background: rgba(255,255,255,0.95); border-radius: 18px; padding: 28px; margin-bottom: 32px; border: 1px solid rgba(130, 174, 70, 0.24); box-shadow: 0 10px 32px rgba(113,128,185,0.15);">
                        <h2 style="margin-bottom: 18px; color: #2f3367; display: flex; align-items: center; gap: 10px;">
                            <span>📝</span>Заголовок и подзаголовок
                        </h2>
                        <div class="form-row"
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
                            <div class="form-group">
                                <label for="info_page_title">Заголовок *</label>
                                <input type="text" id="info_page_title" name="info_page_title"
                                    value="{{ old('info_page_title', $content['info_page_title']) }}" required
                                    oninput="updateInfoPreviewTitle(this.value)">
                            </div>
                            <div class="form-group">
                                <label for="info_page_subtitle">Подзаголовок</label>
                                <input type="text" id="info_page_subtitle" name="info_page_subtitle"
                                    value="{{ old('info_page_subtitle', $content['info_page_subtitle']) }}"
                                    placeholder="Оплата, доставка, гарантия..."
                                    oninput="updateInfoPreviewSubtitle(this.value)">
                            </div>
                        </div>
                    </div>

                    <div
                        style="background: rgba(255,255,255,0.95); border-radius: 18px; padding: 28px; margin-bottom: 32px; border: 1px solid rgba(130, 174, 70, 0.24); box-shadow: 0 10px 32px rgba(113,128,185,0.15);">
                        <h2>Редактор разделов</h2>
                        <p class="lead">Используйте блок ниже, чтобы изменить заголовок и подзаголовок контентного сектора, а затем заполните вкладки с текстом для клиентов.</p>

                        <div class="form-row"
                            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
                            <div class="form-group">
                                <label for="info_content_title">Заголовок секции</label>
                                <input type="text" id="info_content_title" name="info_content_title"
                                    value="{{ old('info_content_title', $content['info_content_title'] ?? 'Всё, что нужно знать перед покупкой') }}"
                                    oninput="updateInfoContentTitle(this.value)">
                                <label for="info_content_subtitle">Подзаголовок секции</label>
                                <textarea id="info_content_subtitle" name="info_content_subtitle" rows="3"
                                    placeholder="Например: мы собрали ответы на ключевые вопросы клиентов"
                                    oninput="updateInfoContentSubtitle(this.value)">{{ old('info_content_subtitle', $content['info_content_subtitle'] ?? 'Мы собрали ключевую информацию об оплате, доставке, гарантиях и заботе о растениях') }}</textarea>
                            </div>
                        </div>

                        <p class="lead">Используйте вкладки ниже, чтобы обновить содержимое на странице «Информация» —
                            способы оплаты, доставка, гарантии и ответы на частые вопросы. Поддерживается HTML-разметка.
                        </p>

                        <div class="tab-nav" id="infoTabs">
                            <button type="button" class="tab-button active" data-tab="payment">
                                <div class="icon">💳</div>
                                <strong>Оплата</strong>
                                <span>Способы оплаты, реквизиты, условия предоплаты</span>
                            </button>
                            <button type="button" class="tab-button" data-tab="delivery">
                                <div class="icon">🚚</div>
                                <strong>Доставка</strong>
                                <span>Сроки, тарифы, самовывоз, регионы</span>
                            </button>
                            <button type="button" class="tab-button" data-tab="warranty">
                                <div class="icon">🛡️</div>
                                <strong>Гарантии</strong>
                                <span>Гарантия приживаемости и условия возврата</span>
                            </button>
                            <button type="button" class="tab-button" data-tab="faq">
                                <div class="icon">❓</div>
                                <strong>Частые вопросы</strong>
                                <span>FAQ и рекомендации для клиентов</span>
                            </button>
                        </div>

                        <div class="tab-pane active" id="pane-payment">
                            <div class="editor-area">
                                <textarea name="info_payment_content" id="info_payment_content"
                                    class="tinymce-editor">{{ old('info_payment_content', $content['info_payment_content']) }}</textarea>
                                <small>Поддерживаются HTML теги: параграфы, заголовки, списки.</small>
                                @error('info_payment_content')<small style="color:#c00;">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <div class="tab-pane" id="pane-delivery">
                            <div class="editor-area">
                                <textarea name="info_delivery_content" id="info_delivery_content"
                                    class="tinymce-editor">{{ old('info_delivery_content', $content['info_delivery_content']) }}</textarea>
                                <small>Например: условия доставки по регионам, бесплатная доставка, сроки.</small>
                                @error('info_delivery_content')<small
                                style="color:#c00;">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <div class="tab-pane" id="pane-warranty">
                            <div class="editor-area">
                                <textarea name="info_warranty_content" id="info_warranty_content"
                                    class="tinymce-editor">{{ old('info_warranty_content', $content['info_warranty_content']) }}</textarea>
                                <small>Опишите гарантию на растения и сервисное сопровождение.</small>
                                @error('info_warranty_content')<small
                                style="color:#c00;">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <div class="tab-pane" id="pane-faq">
                            <div class="faq-builder">
                                <div class="faq-builder-header">
                                    <div>
                                        <h3 style="margin-bottom: 6px;">Список вопросов</h3>
                                        <p style="color:#6b6d8f; font-size:14px;">Добавляйте вопросы и подробные ответы.
                                            Они будут показаны на вкладке FAQ.</p>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="add-faq">＋ Добавить
                                        вопрос</button>
                                </div>
                                <div id="faq-items" class="faq-items"></div>
                            </div>
                            <input type="hidden" id="faq-data" value='@json($initialFaq)'>
                        </div>

                        <div class="btn-row">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary">💾 Сохранить изменения</button>
                        </div>
                </form>
            </div>
        </div>

    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tabs = document.querySelectorAll('.tab-button');
            var panes = {
                payment: document.getElementById('pane-payment'),
                delivery: document.getElementById('pane-delivery'),
                warranty: document.getElementById('pane-warranty'),
                faq: document.getElementById('pane-faq'),
            };

            var previewBg = document.getElementById('info-preview-bg');
            var previewOverlay = document.getElementById('info-preview-overlay');
            var previewTitle = document.getElementById('info-preview-title');
            var previewSubtitle = document.getElementById('info-preview-subtitle');
            var backgroundSizeInput = document.getElementById('info_page_background_size');
            var backgroundPositionInput = document.getElementById('info_page_background_position');
            var overlaySelect = document.getElementById('info_page_overlay');
            var overlayOpacityInput = document.getElementById('info_page_overlay_opacity');
            var contentTitleInput = document.getElementById('info_content_title');
            var contentSubtitleInput = document.getElementById('info_content_subtitle');
            var contentTitlePreview = document.getElementById('info-content-preview-title');
            var contentSubtitlePreview = document.getElementById('info-content-preview-subtitle');

            function activateTab(key) {
                tabs.forEach(function (tab) {
                    tab.classList.toggle('active', tab.getAttribute('data-tab') === key);
                });
                Object.keys(panes).forEach(function (k) {
                    panes[k].classList.toggle('active', k === key);
                });
            }

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    activateTab(tab.getAttribute('data-tab'));
                });
            });

            var faqContainer = document.getElementById('faq-items');
            var addFaqButton = document.getElementById('add-faq');
            var tinymceLoaded = false;
            var faqCounter = 0;

            if (addFaqButton) {
                addFaqButton.disabled = true;
            }

            function initContentEditors() {
                tinymce.init({
                    selector: '.tinymce-editor',
                    height: 400,
                    menubar: false,
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'visualchars', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'emoticons', 'codesample', 'help', 'wordcount',
                        'pagebreak', 'nonbreaking', 'directionality', 'quickbars'
                    ],
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                        'forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify | ' +
                        'bullist numlist outdent indent | link image media table | ' +
                        'code visualblocks visualchars codesample | emoticons charmap | ' +
                        'searchreplace fullscreen preview | pagebreak nonbreaking anchor | ' +
                        'insertdatetime | help',
                    toolbar_mode: 'sliding',
                    branding: false,
                    convert_urls: false
                });
            }

            function initFaqEditor(textarea) {
                if (!textarea.id) {
                    textarea.id = 'faq-answer-' + (++faqCounter);
                }
                tinymce.init({
                    selector: '#' + textarea.id,
                    height: 400,
                    menubar: false,
                    plugins: [
                        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                        'anchor', 'searchreplace', 'visualblocks', 'visualchars', 'code', 'fullscreen',
                        'insertdatetime', 'media', 'table', 'emoticons', 'codesample', 'help', 'wordcount',
                        'pagebreak', 'nonbreaking', 'directionality', 'quickbars'
                    ],
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | ' +
                        'forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify | ' +
                        'bullist numlist outdent indent | link image media table | ' +
                        'code visualblocks visualchars codesample | emoticons charmap | ' +
                        'searchreplace fullscreen preview | pagebreak nonbreaking anchor | ' +
                        'insertdatetime | help',
                    toolbar_mode: 'sliding',
                    branding: false,
                    convert_urls: false
                });
            }

            function createFaqItem(question, answer) {
                var wrapper = document.createElement('div');
                wrapper.className = 'faq-item';
                wrapper.innerHTML = `
                    <div class="faq-item-header">
                        <input type="text" name="faq_questions[]" value="${question || ''}" placeholder="Вопрос" required>
                        <button type="button" class="remove-faq">Удалить</button>
                    </div>
                    <textarea name="faq_answers[]" class="faq-answer-editor">${answer || ''}</textarea>
                `;
                faqContainer.appendChild(wrapper);

                var removeBtn = wrapper.querySelector('.remove-faq');
                removeBtn.addEventListener('click', function () {
                    if (tinymceLoaded) {
                        var textarea = wrapper.querySelector('.faq-answer-editor');
                        if (textarea && textarea.id && tinymce.get(textarea.id)) {
                            tinymce.get(textarea.id).remove();
                        }
                    }
                    wrapper.remove();
                });

                if (tinymceLoaded) {
                    var textarea = wrapper.querySelector('.faq-answer-editor');
                    if (textarea) {
                        initFaqEditor(textarea);
                    }
                }
            }

            if (addFaqButton) {
                addFaqButton.addEventListener('click', function () {
                    createFaqItem('', '');
                });
            }

            var existingFaq = JSON.parse(document.getElementById('faq-data').value || '[]');
            var form = document.querySelector('form');

            function initializeTinyMCE() {
                initContentEditors();
                tinymceLoaded = true;

                if (addFaqButton) {
                    addFaqButton.disabled = false;
                }

                if (existingFaq.length) {
                    existingFaq.forEach(function (item) {
                        createFaqItem(item.question, item.answer);
                    });
                }

                if (form) {
                    form.addEventListener('submit', function () {
                        tinymce.triggerSave();
                    });
                }
            }

            function loadTinyMCE(callback) {
                if (window.tinymce) {
                    callback();
                    return;
                }
                var script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js';
                script.onload = callback;
                script.onerror = function () {
                    console.error('Не удалось загрузить TinyMCE с CDN jsDelivr.');
                    if (addFaqButton) {
                        addFaqButton.disabled = false;
                    }
                };
                document.head.appendChild(script);
            }

            loadTinyMCE(initializeTinyMCE);

            function applyPreviewStyles() {
                if (backgroundSizeInput && previewBg) {
                    previewBg.style.backgroundSize = backgroundSizeInput.value || 'cover';
                }
                if (backgroundPositionInput && previewBg) {
                    previewBg.style.backgroundPosition = backgroundPositionInput.value || 'center center';
                }
                if (overlaySelect && overlayOpacityInput && previewOverlay) {
                    var value = overlaySelect.value;
                    var opacity = Math.min(Math.max(parseInt(overlayOpacityInput.value || '0', 10), 0), 100) / 100;
                    if (value === 'darken') {
                        previewOverlay.style.background = 'rgba(0,0,0,' + opacity + ')';
                    } else if (value === 'lighten') {
                        previewOverlay.style.background = 'rgba(255,255,255,' + opacity + ')';
                    } else {
                        previewOverlay.style.background = 'transparent';
                    }
                }
            }

            window.previewInfoBackground = function (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var url = e.target.result;
                        var newPreview = document.querySelector('#info-bg-new img');
                        if (newPreview) {
                            newPreview.src = url;
                            newPreview.parentElement.style.display = 'block';
                        }
                        if (previewBg) {
                            previewBg.style.backgroundImage = 'url(' + url + ')';
                        }
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };

            window.updateInfoPreviewTitle = function (value) {
                if (previewTitle) {
                    previewTitle.textContent = value || 'Полезная информация';
                }
            };

            window.updateInfoPreviewSubtitle = function (value) {
                if (previewSubtitle) {
                    previewSubtitle.textContent = value || 'Оплата, доставка, гарантии и ответы на частые вопросы';
                    previewSubtitle.style.display = value ? 'block' : 'none';
                }
            };

            window.updateInfoContentTitle = function (value) {
                if (contentTitlePreview) {
                    contentTitlePreview.textContent = value || 'Всё, что нужно знать перед покупкой';
                }
            };

            window.updateInfoContentSubtitle = function (value) {
                if (contentSubtitlePreview) {
                    contentSubtitlePreview.textContent = value || 'Мы собрали ключевую информацию об оплате, доставке, гарантиях и заботе о растениях';
                    contentSubtitlePreview.style.display = value ? 'block' : 'none';
                }
            };

            if (backgroundSizeInput) backgroundSizeInput.addEventListener('input', applyPreviewStyles);
            if (backgroundPositionInput) backgroundPositionInput.addEventListener('input', applyPreviewStyles);
            if (overlaySelect) overlaySelect.addEventListener('change', applyPreviewStyles);
            if (overlayOpacityInput) overlayOpacityInput.addEventListener('input', applyPreviewStyles);

            applyPreviewStyles();
            updateInfoContentTitle(contentTitleInput ? contentTitleInput.value : '');
            updateInfoContentSubtitle(contentSubtitleInput ? contentSubtitleInput.value : '');
        });
    </script>
</body>

</html>