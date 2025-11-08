<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\CustomerAuthController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\HomePageFeatureController;
use App\Http\Controllers\Admin\HomePageGalleryController;
use App\Http\Controllers\Admin\HeroSettingController;
use App\Http\Controllers\Admin\HomePageSectionTitleController;
use App\Http\Controllers\Admin\CatalogPageSettingController;
use App\Http\Controllers\Admin\AboutPageSettingController;
use App\Http\Controllers\Admin\BlogPageSettingController;
use App\Http\Controllers\Admin\ContactPageSettingController;
use App\Http\Controllers\Admin\AccountPageSettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [HomeController::class, 'blogPost'])->name('blog.post');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/info', [HomeController::class, 'info'])->name('info');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1') // Защита от спама: 5 попыток в минуту
    ->name('contact.send');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])
    ->middleware('throttle:3,1') // Защита от спама: 3 заказа в минуту
    ->name('checkout.store');
Route::get('/order/success/{id}', [CheckoutController::class, 'success'])->name('order.success');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Вход/регистрация для покупателей (фронтенд)
Route::get('/customer-login', [CustomerAuthController::class, 'showAuthPage'])
    ->middleware('guest')
    ->name('customer.auth');
Route::post('/customer-login', [CustomerAuthController::class, 'login'])
    ->middleware(['guest', 'throttle:5,1'])
    ->name('customer.login.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes (для админов)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])
        ->middleware('throttle:5,1'); // Защита от brute-force: 5 попыток в минуту
    
    // Регистрация для покупателей
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])
        ->middleware('throttle:3,1'); // 3 регистрации в минуту
    
    // Восстановление пароля
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->middleware('throttle:3,1') // 3 попытки в минуту
        ->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])
        ->middleware('throttle:3,1') // 3 попытки в минуту
        ->name('password.update');
});

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Account Routes
|--------------------------------------------------------------------------
*/

Route::prefix('account')
    ->name('account.')
    ->middleware(['auth', 'role:customer'])
    ->group(function () {
        // Главная страница личного кабинета
        Route::get('/', [AccountController::class, 'dashboard'])->name('dashboard');
        
        // Профиль
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::post('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::post('/password', [AccountController::class, 'updatePassword'])->name('password.update');
        
        // Заказы
        Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [AccountController::class, 'orderShow'])->name('orders.show');
        
        // Адреса
        Route::get('/addresses', [AccountController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [AccountController::class, 'storeAddress'])->name('addresses.store');
        Route::put('/addresses/{id}', [AccountController::class, 'updateAddress'])->name('addresses.update');
        Route::delete('/addresses/{id}', [AccountController::class, 'destroyAddress'])->name('addresses.destroy');
        Route::post('/addresses/{id}/default', [AccountController::class, 'setDefaultAddress'])->name('addresses.set-default');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'check.admin'])
    ->group(function () {
        
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Products
        Route::resource('products', ProductController::class);
        Route::post('products/{product}/toggle-active', [ProductController::class, 'toggleActive'])
            ->name('products.toggle-active');
        
        // Categories
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])
            ->name('categories.toggle-active');
        
        // Blog Posts
        Route::resource('blog', BlogPostController::class);
        Route::post('blog/{blog}/toggle-published', [BlogPostController::class, 'togglePublished'])
            ->name('blog.toggle-published');
        Route::post('blog/upload-image', [BlogPostController::class, 'uploadImage'])
            ->name('blog.upload-image');
        
        // Testimonials
        Route::resource('testimonials', TestimonialController::class);
        Route::post('testimonials/{testimonial}/toggle-active', [TestimonialController::class, 'toggleActive'])
            ->name('testimonials.toggle-active');
        
        // Contact Messages
        Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
        Route::post('contact-messages/{contactMessage}/toggle-read', [ContactMessageController::class, 'toggleRead'])->name('contact-messages.toggle-read');
        
        // Info page settings
        Route::get('info-page-settings', [\App\Http\Controllers\Admin\InfoPageSettingController::class, 'edit'])->name('info-page-settings.edit');
        Route::post('info-page-settings', [\App\Http\Controllers\Admin\InfoPageSettingController::class, 'update'])->name('info-page-settings.update');

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        
        // Sliders
        Route::resource('sliders', SliderController::class);
        
        // Home Page Features
        Route::resource('home-page-features', HomePageFeatureController::class);
        
        // Home Page Gallery
        Route::resource('home-page-galleries', HomePageGalleryController::class);
        
        // Hero Settings
        Route::resource('hero-settings', HeroSettingController::class);
        
        // Home Page Section Titles
        Route::resource('home-page-section-titles', HomePageSectionTitleController::class);
        
        // Catalog Page Settings
        Route::resource('catalog-page-settings', CatalogPageSettingController::class);
        
        // About Page Settings
        Route::resource('about-page-settings', AboutPageSettingController::class);
        
        // Blog Page Settings
        Route::resource('blog-page-settings', BlogPageSettingController::class);
        
        // Contact Page Settings
        Route::resource('contact-page-settings', ContactPageSettingController::class);
        
        // Account Page Settings
        Route::get('account-page-settings', [AccountPageSettingController::class, 'index'])->name('account-page-settings.index');
        Route::post('account-page-settings', [AccountPageSettingController::class, 'update'])->name('account-page-settings.update');
        Route::delete('account-page-settings/delete-image', [AccountPageSettingController::class, 'deleteImage'])->name('account-page-settings.delete-image');
        
        // Settings и Users (только для админов)
        Route::middleware('role:admin')->group(function () {
            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
            
            // Управление пользователями
            Route::resource('users', UserController::class);
        });
    });

