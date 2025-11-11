<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\HomePageFeature;
use App\Models\HomePageGallery;
use App\Models\HeroSetting;
use App\Models\CatalogPageSetting;
use App\Models\AboutPageSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Главная страница
     */
    public function index()
    {
        $sliders = Slider::where('is_active', true)
            ->orderBy('order')
            ->get();

        $features = HomePageFeature::where('is_active', true)
            ->orderBy('order')
            ->get();

        $featuredProducts = Product::active()
            ->featured()
            ->with('category')
            ->take(8)
            ->get();

        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        $galleryImages = HomePageGallery::where('is_active', true)
            ->orderBy('order')
            ->take(6)
            ->get();

        $heroSettings = HeroSetting::where('is_active', true)->first();

        return view('frontend.home', compact('sliders', 'features', 'featuredProducts', 'testimonials', 'galleryImages', 'heroSettings'));
    }

    /**
     * Каталог товаров
     */
    public function catalog(Request $request)
    {
        $query = Product::active()->with('category');

        // Фильтр по категории
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
$q->where('slug', $request->category);
            });
        }

        // Сортировка
        $sortBy = $request->get('sort', 'name');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        // Получаем количество товаров на странице из настроек
        $perPage = Setting::get('products_per_page', 12);
        $products = $query->paginate($perPage);
        $categories = Category::active()->roots()->get();

        // Получаем настройки страницы каталога
        $catalogSettings = CatalogPageSetting::getActive();

        return view('frontend.catalog', compact('products', 'categories', 'catalogSettings'));
    }

    /**
     * Страница товара
     */
    public function product($slug)
    {
        $product = Product::active()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $productHeroSetting = \App\Models\ProductHeroSetting::getSettings();

        return view('frontend.product', compact('product', 'relatedProducts', 'productHeroSetting'));
    }

    /**
     * Блог
     */
    public function blog()
    {
        $posts = BlogPost::published()
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $blogSettings = \App\Models\BlogPageSetting::getActive();

        return view('frontend.blog', compact('posts', 'blogSettings'));
    }

    /**
     * Статья блога
     */
    public function blogPost($slug)
    {
        $post = BlogPost::published()
            ->with('author')
            ->where('slug', $slug)
            ->firstOrFail();

        $recentPosts = BlogPost::published()
            ->with('author')
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.blog-post', compact('post', 'recentPosts'));
    }

    /**
     * О компании
     */
    public function about()
    {
        $aboutSettings = AboutPageSetting::getActive();
        return view('frontend.about', compact('aboutSettings'));
    }

    /**
     * Контакты
     */
    public function contact()
    {
        $phone = Setting::get('phone');
        $email = Setting::get('email');
        $address = Setting::get('address');

        $contactSettings = \App\Models\ContactPageSetting::getActive();

        return view('frontend.contact', compact('phone', 'email', 'address', 'contactSettings'));
    }

    /**
     * Страница информации (оплата, доставка, гарантии, FAQ)
     */
    public function info(Request $request)
    {
        $defaults = [
            'payment' => '<p>Мы принимаем оплату наличными, банковскими картами и безналичным переводом. После подтверждения заказа менеджер уточнит удобный для вас способ и оформит счёт.</p><ul class="list-unstyled info-list"><li>Оплата при получении или предоплата 100%.</li><li>Поддерживаем СБП и электронные кошельки.</li><li>Для юридических лиц предоставляем полный пакет закрывающих документов.</li></ul>',
            'delivery' => '<p>Доставляем растения по Москве, области и в другие регионы России. Бережно упаковываем растения и контролируем температурный режим.</p><ul class="list-unstyled info-list"><li>Курьерская доставка по Москве и МО — от 1 до 3 дней.</li><li>Доставка ТК по России — от 3 до 7 дней в стандартном режиме.</li><li>Возможен самовывоз из питомника по предварительной договорённости.</li></ul>',
            'warranty' => '<p>Мы выращиваем растения в собственном питомнике и отбираем только здоровые экземпляры. На каждую покупку действует гарантия приживаемости при соблюдении рекомендаций.</p><ul class="list-unstyled info-list"><li>Перед отправкой проводим двойной осмотр растений.</li><li>Предоставляем памятку по посадке и уходу.</li><li>Помогаем с заменой в случае выявленных дефектов при получении.</li></ul>',
        ];

        $faqDefault = [
            ['question' => 'Как выбрать сорт туи?', 'answer' => '<p>Выбор зависит от желаемой высоты и формы посадки. Наши менеджеры помогут подобрать идеальный сорт под ваш участок.</p>'],
            ['question' => 'Когда высаживать растения?', 'answer' => '<p>Лучшее время для посадки — весна и начало осени, когда нет сильных температурных перепадов.</p>'],
            ['question' => 'Как ухаживать после посадки?', 'answer' => '<p>Регулярно поливайте, мульчируйте почву и используйте удобрения для хвойных культур.</p>'],
        ];

        $faqJson = Setting::get('info_faq_json', json_encode($faqDefault, JSON_UNESCAPED_UNICODE));
        try {
            $faqItems = json_decode($faqJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            $faqItems = $faqDefault;
        }

        if (!is_array($faqItems) || empty($faqItems)) {
            $faqItems = $faqDefault;
        }

        $tabs = [
            'payment' => [
                'title' => 'Оплата',
                'content' => Setting::get('info_payment_content', $defaults['payment'])
            ],
            'delivery' => [
                'title' => 'Доставка',
                'content' => Setting::get('info_delivery_content', $defaults['delivery'])
            ],
            'warranty' => [
                'title' => 'Гарантии',
                'content' => Setting::get('info_warranty_content', $defaults['warranty'])
            ],
            'faq' => [
                'title' => 'Частые вопросы',
                'faq_items' => $faqItems,
            ],
        ];

        $activeTab = $request->get('tab', 'delivery');
        if (!array_key_exists($activeTab, $tabs)) {
            $activeTab = 'delivery';
        }

        $heroTitle = Setting::get('info_page_title', 'Полезная информация');
        $heroSubtitle = Setting::get('info_page_subtitle', 'Оплата, доставка, гарантии и ответы на частые вопросы');
        $backgroundPath = Setting::get('info_page_background');
        $backgroundSize = Setting::get('info_page_background_size', 'cover');
        $backgroundPosition = Setting::get('info_page_background_position', 'center center');
        $overlayType = Setting::get('info_page_overlay', 'none');
        $overlayOpacity = Setting::get('info_page_overlay_opacity', '40');
        $contentTitle = Setting::get('info_content_title', 'Всё, что нужно знать перед покупкой');
        $contentSubtitle = Setting::get('info_content_subtitle', 'Мы собрали ключевую информацию об оплате, доставке, гарантиях и заботе о растениях');

        $heroBackground = $backgroundPath
            ? asset('storage/' . $backgroundPath)
            : asset('assets/images/bg_6.jpg');

        return view('frontend.info', [
            'tabs' => $tabs,
            'activeTab' => $activeTab,
            'heroTitle' => $heroTitle,
            'heroSubtitle' => $heroSubtitle,
            'heroBackground' => $heroBackground,
            'heroBackgroundSize' => $backgroundSize,
            'heroBackgroundPosition' => $backgroundPosition,
            'heroOverlayType' => $overlayType,
            'heroOverlayOpacity' => $overlayOpacity,
            'contentTitle' => $contentTitle,
            'contentSubtitle' => $contentSubtitle,
        ]);
    }
}

