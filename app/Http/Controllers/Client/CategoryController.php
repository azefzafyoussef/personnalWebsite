<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('posts')
            ->latest()
            ->get();

        return view('client.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        // Check if category is active
        if (!$category->is_active) {
            abort(404);
        }

        $posts = Post::where('category_id', $category->id)
            ->where('is_published', true)
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('client.categories.show', compact('category', 'posts'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $categories = Category::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->withCount('posts')
            ->latest()
            ->paginate(12);

        return view('client.categories.search', compact('categories', 'query'));
    }
}