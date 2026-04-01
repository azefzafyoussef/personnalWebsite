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
        $categories = [];

        $recentPosts = [];

        $popularPosts = [];

        // Stats for the homepage
        $totalPosts = 0;
        $totalCategories = 0;
        $totalUsers = 0;
        $totalDownloads = 0;

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

            /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutMe()
    {
        return view('client.about-me');
    }
}
