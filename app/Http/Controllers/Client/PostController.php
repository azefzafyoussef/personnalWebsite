<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('is_published', true)
            ->with(['category', 'user']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'downloads':
                $query->orderBy('downloads', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
        }

        $posts = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('client.posts.index', compact('posts', 'categories', 'sort'));
    }

    public function show(Post $post)
    {
        // Check if post is published
        if (!$post->is_published) {
            abort(404);
        }

        // Increment views
        $post->increment('views');

        $post->load(['category', 'user']);
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->with('user')
            ->latest()
            ->take(4)
            ->get();

        return view('client.posts.show', compact('post', 'relatedPosts'));
    }

    // public function download(Post $post)
    // {
    //     // Check if post is published
    //     if (!$post->is_published) {
    //         abort(404);
    //     }

    //     if (!$post->file_path) {
    //         return redirect()->back()->with('error', 'No file available for download.');
    //     }

    //     // Increment download count
    //     $post->increment('downloads');

    //     return Storage::disk('public')->download($post->file_path);
    // }

        public function download(Post $post)
{
    if (!$post->file_path || !Storage::disk('public')->exists($post->file_path)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    return Storage::disk('public')->download($post->file_path);
}


    public function bookmark(Request $request, Post $post)
    {
        // Simple bookmark functionality (you can extend this with a bookmarks table)
        $bookmarks = $request->session()->get('bookmarks', []);

        if (in_array($post->id, $bookmarks)) {
            // Remove bookmark
            $bookmarks = array_diff($bookmarks, [$post->id]);
            $message = 'Post removed from bookmarks.';
        } else {
            // Add bookmark
            $bookmarks[] = $post->id;
            $message = 'Post added to bookmarks.';
        }

        $request->session()->put('bookmarks', array_unique($bookmarks));

        return redirect()->back()->with('success', $message);
    }

    public function bookmarks(Request $request)
    {
        $bookmarkIds = $request->session()->get('bookmarks', []);
        $posts = Post::whereIn('id', $bookmarkIds)
            ->where('is_published', true)
            ->with(['category', 'user'])
            ->get();

        return view('client.posts.bookmarks', compact('posts'));
    }


}
