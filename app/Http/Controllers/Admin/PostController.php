<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.posts.create',compact('categories'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'slug' => 'required|string|max:255',
    //         'content' => 'nullable|string',
    //         'category_id' => 'required|integer',
    //         'is_published' => 'required|integer',
    //     ]);
    //     Post::create([
    //         'title' => $request->title,
    //         'slug' => Str::slug($request->slug),
    //         'content' => $request->content,
    //         'category_id' => $request->category_id,
    //         'is_published' => $request->is_published,
    //         'file_path' => $request->file_path,
    //         'user_id' => Auth::user()->id,
    //     ]);

    //     return redirect()->route('admin.posts.index')
    //         ->with('success', 'Post created successfully.');
    // }


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug',
        'content_ar' => 'nullable|string',
        'content_en' => 'nullable|string',
        'content_fr' => 'nullable|string',
        'category_id' => 'required|integer|exists:categories,id',
        'is_published' => 'required|integer',
        'file_path' => 'nullable|file|mimes:zip|max:10240', // 10MB max
    ]);

    $filePath = null;
    if ($request->hasFile('file_path')) {
        $file = $request->file('file_path');
        $fileName = 'post_' . time() . '_' . Str::random(10) . '.zip';
        $filePath = $file->storeAs('post_zips', $fileName, 'public');
    }

    Post::create([
        'title' => $request->title,
        'slug' => Str::slug($request->slug),
        'content_ar' => $request->content_ar,
        'content_fr' => $request->content_fr,
        'content' => $request->content_en,
        'category_id' => $request->category_id,
        'is_published' => $request->is_published,
        'file_path' => $filePath,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('admin.posts.index')
        ->with('success', 'Post created successfully.');
}

public function update(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:posts,slug,' . $request->id,
        'content_ar' => 'nullable|string',
        'content_en' => 'nullable|string',
        'content_fr' => 'nullable|string',
        'category_id' => 'required|integer|exists:categories,id',
        'is_published' => 'required|integer',
        'file_path' => 'nullable|file|mimes:zip|max:10240', // 10MB max
    ]);

    $post = Post::findOrFail($request->id);

    $filePath = $post->file_path;
    if ($request->hasFile('file_path')) {
        // Delete old file if exists
        if ($post->file_path && Storage::disk('public')->exists($post->file_path)) {
            Storage::disk('public')->delete($post->file_path);
        }

        // Store new file
        $file = $request->file('file_path');
        $fileName = 'post_' . time() . '_' . Str::random(10) . '.zip';
        $filePath = $file->storeAs('post_zips', $fileName, 'public');
    }

    $post->update([
        'title' => $request->title,
        'slug' => Str::slug($request->slug),
        'content_ar' => $request->content_ar,
        'content_fr' => $request->content_fr,
        'content' => $request->content_en,
        'category_id' => $request->category_id,
        'is_published' => $request->is_published,
        'file_path' => $filePath,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('admin.posts.index')
        ->with('success', 'Post updated successfully.');
}

    public function edit(Post $post)
    {
        $categories = Category::latest()->get();

        return view('admin.posts.edit', compact('post','categories'));
    }

    public function download(Post $post)
{
    if (!$post->file_path || !Storage::disk('public')->exists($post->file_path)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    return Storage::disk('public')->download($post->file_path);
}

    public function toggle(Post $post)
    {
        return view('admin.posts.toggle', compact('post'));
    }

    // public function update(Request $request)
    // {
    //     // dd($request);
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'slug' => 'required|string|max:255',
    //         'content' => 'nullable|str    // public function update(Request $request)
    // {
    //     // dd($request);
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'slug' => 'required|string|max:255',
    //         'content' => 'nullable|string',
    //         'category_id' => 'required|integer',
    //         'is_published' => 'required|integer'
    //     ]);
    //     $post = Post::Find($request->id);
    //     $post->update([
    //         'title' => $request->title,
    //         'slug' => Str::slug($request->slug),
    //         'content' => $request->content,
    //         'category_id' => $request->category_id,
    //         'is_published' => $request->is_published,
    //         'user_id' => Auth::user()->id,
    //     ]);

    //     return redirect()->route('admin.posts.index')
    //         ->with('success', 'Post updated successfully.');
    // }ing',
    //         'category_id' => 'required|integer',
    //         'is_published' => 'required|integer'
    //     ]);
    //     $post = Post::Find($request->id);
    //     $post->update([
    //         'title' => $request->title,
    //         'slug' => Str::slug($request->slug),
    //         'content' => $request->content,
    //         'category_id' => $request->category_id,
    //         'is_published' => $request->is_published,
    //         'user_id' => Auth::user()->id,
    //     ]);

    //     return redirect()->route('admin.posts.index')
    //         ->with('success', 'Post updated successfully.');
    // }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }

}
