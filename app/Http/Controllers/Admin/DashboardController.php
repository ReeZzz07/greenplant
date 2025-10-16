<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\ContactMessage;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Главная страница админки
     */
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'blog_posts' => BlogPost::count(),
            'testimonials' => Testimonial::count(),
            'users' => User::count(),
            'messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
        ];

        $recentProducts = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentPosts = BlogPost::with('author')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentPosts'));
    }
}

