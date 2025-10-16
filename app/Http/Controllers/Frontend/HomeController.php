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

        return view('frontend.product', compact('product', 'relatedProducts'));
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
}

