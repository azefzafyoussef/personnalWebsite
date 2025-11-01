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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'nullable|string',
            'category_id' => 'required|integer',
            'is_published' => 'required|integer'
        ]);
        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->is_published,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::latest()->get();

        return view('admin.posts.edit', compact('post','categories'));
    }

    public function toggle(Post $post)
    {
        return view('admin.posts.toggle', compact('post'));
    }

    public function update(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'nullable|string',
            'category_id' => 'required|integer',
            'is_published' => 'required|integer'
        ]);
        $post = Post::Find($request->id);
        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->is_published,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }

}
