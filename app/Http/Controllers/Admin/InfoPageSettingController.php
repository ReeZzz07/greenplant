<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class InfoPageSettingController extends Controller
{
    /**
     * Show edit form for information page content.
     */
    public function edit()
    {
        $defaults = [
            'info_payment_content' => '<p>Мы принимаем оплату наличными, банковскими картами и безналичным переводом. После подтверждения заказа менеджер уточнит удобный для вас способ и оформит счёт.</p><ul class="list-unstyled info-list"><li>Оплата при получении или предоплата 100%.</li><li>Поддерживаем СБП и электронные кошельки.</li><li>Для юридических лиц предоставляем полный пакет закрывающих документов.</li></ul>',
            'info_delivery_content' => '<p>Доставляем растения по Москве, области и в другие регионы России. Бережно упаковываем растения и контролируем температурный режим.</p><ul class="list-unstyled info-list"><li>Курьерская доставка по Москве и МО — от 1 до 3 дней.</li><li>Доставка ТК по России — от 3 до 7 дней в стандартном режиме.</li><li>Возможен самовывоз из питомника по предварительной договорённости.</li></ul>',
            'info_warranty_content' => '<p>Мы выращиваем растения в собственном питомнике и отбираем только здоровые экземпляры. На каждую покупку действует гарантия приживаемости при соблюдении рекомендаций.</p><ul class="list-unstyled info-list"><li>Перед отправкой проводим двойной осмотр растений.</li><li>Предоставляем памятку по посадке и уходу.</li><li>Помогаем с заменой в случае выявленных дефектов при получении.</li></ul>',
            'info_page_title' => 'Полезная информация',
            'info_page_subtitle' => 'Оплата, доставка, гарантии и ответы на частые вопросы',
            'info_content_title' => 'Всё, что нужно знать перед покупкой',
            'info_content_subtitle' => 'Мы собрали ключевую информацию об оплате, доставке, гарантиях и заботе о растениях',
            'info_page_background' => null,
            'info_page_background_size' => 'cover',
            'info_page_background_position' => 'center center',
            'info_page_overlay' => 'none',
            'info_page_overlay_opacity' => '40',
        ];

        $content = [];
        foreach ($defaults as $key => $default) {
            $content[$key] = Setting::get($key, $default);
        }

        $faqJson = Setting::get('info_faq_json', '[]');
        try {
            $decodedFaq = json_decode($faqJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            $decodedFaq = [];
        }
        $content['info_faq_json'] = $decodedFaq;

        $tinymceApiKey = Setting::get('tinymce_api_key', 'no-api-key');

        return view('admin.info-page-settings.edit', [
            'content' => $content,
            'tinymceApiKey' => $tinymceApiKey,
        ]);
    }

    /**
     * Update information page content.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'info_payment_content' => 'required|string',
            'info_delivery_content' => 'required|string',
            'info_warranty_content' => 'required|string',
            'info_page_title' => 'required|string|max:255',
            'info_page_subtitle' => 'nullable|string|max:255',
            'info_content_title' => 'nullable|string|max:255',
            'info_content_subtitle' => 'nullable|string|max:255',
            'info_page_background' => 'nullable|image|max:4096',
            'info_page_background_size' => 'nullable|string|max:50',
            'info_page_background_position' => 'nullable|string|max:50',
            'info_page_overlay' => 'nullable|in:none,darken,lighten',
            'info_page_overlay_opacity' => 'nullable|integer|min:0|max:100',
            'faq_questions' => 'nullable|array',
            'faq_questions.*' => 'nullable|string',
            'faq_answers' => 'nullable|array',
            'faq_answers.*' => 'nullable|string',
        ]);

        $group = 'info_page';

        if ($request->hasFile('info_page_background')) {
            $path = $request->file('info_page_background')->store('info_page', 'public');
            Setting::set('info_page_background', $path, 'text', $group);
        } elseif ($request->boolean('remove_background')) {
            Setting::set('info_page_background', null, 'text', $group);
        }

        $faqItems = [];
        $questions = $data['faq_questions'] ?? [];
        $answers = $data['faq_answers'] ?? [];
        foreach ($questions as $index => $question) {
            $question = trim($question ?? '');
            $answer = $answers[$index] ?? '';
            if ($question !== '' || trim($answer) !== '') {
                $faqItems[] = [
                    'question' => $question,
                    'answer' => $answer,
                ];
            }
        }

        $content = [
            'info_payment_content' => $data['info_payment_content'],
            'info_delivery_content' => $data['info_delivery_content'],
            'info_warranty_content' => $data['info_warranty_content'],
            'info_faq_json' => json_encode($faqItems, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'info_page_title' => $data['info_page_title'],
            'info_page_subtitle' => $data['info_page_subtitle'] ?? '',
            'info_content_title' => $data['info_content_title'] ?? 'Всё, что нужно знать перед покупкой',
            'info_content_subtitle' => $data['info_content_subtitle'] ?? 'Мы собрали ключевую информацию об оплате, доставке, гарантиях и заботе о растениях',
            'info_page_background_size' => $data['info_page_background_size'] ?? 'cover',
            'info_page_background_position' => $data['info_page_background_position'] ?? 'center center',
            'info_page_overlay' => $data['info_page_overlay'] ?? 'none',
            'info_page_overlay_opacity' => $data['info_page_overlay_opacity'] ?? '40',
        ];

        foreach ($content as $key => $value) {
            Setting::set($key, $value, 'html', $group);
        }

        return redirect()->route('admin.info-page-settings.edit')
            ->with('success', 'Контент страницы "Информация" успешно обновлён.');
    }
}
