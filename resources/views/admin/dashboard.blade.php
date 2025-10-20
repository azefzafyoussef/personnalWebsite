@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Categories -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-folder text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Categories</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['categoriesCount'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Posts -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Posts</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['postsCount'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Views -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-eye text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Views</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['totalViews'] }}</p>
            </div>
        </div>
    </div>

    <!-- Total Downloads -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                <i class="fas fa-download text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Downloads</h3>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['totalDownloads'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Posts -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Recent Posts</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recentPosts as $post)
                <div class="flex items-center justify-between p-3 border rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">{{ $post->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $post->category->name }} • {{ $post->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">{{ $post->views }} views</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $post->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Popular Categories -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-medium text-gray-900">Popular Categories</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($popularCategories as $category)
                <div class="flex items-center justify-between p-3 border rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded flex items-center justify-center" style="background-color: {{ $category->color }}20;">
                            <i class="{{ $category->icon }} text-sm" style="color: {{ $category->color }};"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $category->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $category->posts_count }} posts</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection