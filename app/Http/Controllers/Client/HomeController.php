<?php
// app/Http/Controllers/Client/HomeController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('posts')
            ->latest()
            ->take(8)
            ->get();

        $recentPosts = Post::where('is_published', true)
            ->with('category', 'user')
            ->latest()
            ->take(6)
            ->get();

        $popularPosts = Post::where('is_published', true)
            ->with('category', 'user')
            ->orderBy('views', 'desc')
            ->take(6)
            ->get();

        // Stats for the homepage
        $totalPosts = Post::where('is_published', true)->count();
        $totalCategories = Category::where('is_active', true)->count();
        $totalUsers = User::count();
        $totalDownloads = Post::sum('downloads');

        return view('client.home', compact(
            'categories',
            'recentPosts',
            'popularPosts',
            'totalPosts',
            'totalCategories',
            'totalUsers',
            'totalDownloads'
        ));
    }
}