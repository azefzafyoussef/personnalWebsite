<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'categoriesCount' => Category::count(),
            'postsCount' => Post::count(),
            'publishedPostsCount' => Post::where('is_published', true)->count(),
            'totalViews' => Post::sum('views'),
            'totalDownloads' => Post::sum('downloads'),
            'usersCount' => User::count(),
        ];

        $recentPosts = Post::with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $popularCategories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        $popularPosts = Post::with(['category', 'user'])
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'popularCategories',
            'popularPosts'
        ));
    }
}