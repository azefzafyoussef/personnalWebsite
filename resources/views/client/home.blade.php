@extends('layouts.app')

@section('title', 'NotesHub - Share Your Knowledge')

@section('content')
    <!-- Header -->


    <!-- Hero Section -->
    <section class="gradient-bg text-white py-20">
        <div class="container mx-auto px-4 text-center">
            @auth
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 mb-8 inline-block">
                    <h2 class="text-2xl font-bold mb-2">👋 Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-blue-100">Ready to continue learning and sharing knowledge!</p>
                </div>
            @endauth
            
            <h1 class="text-5xl font-bold mb-6">Share Your Knowledge with the World</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Discover thousands of notes on various topics, or contribute by uploading your own study materials. Learning made easy and accessible.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('posts.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Explore Notes
                </a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.posts.create') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                            📝 Add Note
                        </a>
                    @else
                        <a href="{{ route('posts.bookmarks') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                            📚 My Bookmarks
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Browse by Category</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Find notes organized by subject and topic for easy navigation</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="category-card block bg-white rounded-xl shadow-md border border-gray-100 p-6 cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: {{ $category->color }}20;">
                            <i class="{{ $category->icon }} text-lg" style="color: {{ $category->color }};"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->posts_count }} notes</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    View All Categories <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Recent Notes Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Recent Notes</h2>
                    <p class="text-gray-600">Newly uploaded study materials</p>
                </div>
                <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                    View All <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentPosts as $post)
                <div class="note-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium" style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                                {{ $post->category->name }}
                            </span>
                            <span class="text-gray-400 text-sm">
                                <i class="fas fa-eye mr-1"></i>{{ $post->views }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $post->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-500">{{ $post->user->name }}</span>
                            </div>
                            <div class="flex space-x-2">
                                @auth
                                    <form action="{{ route('posts.bookmark', $post) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-blue-600">
                                            <i class="far fa-bookmark"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-blue-600">
                                        <i class="far fa-bookmark"></i>
                                    </a>
                                @endauth
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Popular Notes Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Popular Notes</h2>
                    <p class="text-gray-600">Most viewed and downloaded materials</p>
                </div>
                <a href="{{ route('posts.index') }}?sort=popular" class="text-blue-600 hover:text-blue-700 font-semibold">
                    View All <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularPosts as $post)
                <div class="note-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium" style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                                {{ $post->category->name }}
                            </span>
                            <div class="flex space-x-2 text-sm text-gray-400">
                                <span><i class="fas fa-eye mr-1"></i>{{ $post->views }}</span>
                                <span><i class="fas fa-download mr-1"></i>{{ $post->downloads }}</span>
                            </div>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $post->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600 text-xs"></i>
                                </div>
                                <span class="text-sm text-gray-500">{{ $post->user->name }}</span>
                            </div>
                            <div class="flex space-x-3">
                                @auth
                                    <form action="{{ route('posts.bookmark', $post) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-yellow-500" title="Add to favorites">
                                            <i class="far fa-star"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-yellow-500" title="Login to bookmark">
                                        <i class="far fa-star"></i>
                                    </a>
                                @endauth
                                <a href="{{ route('posts.show', $post) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold mb-2">{{ $totalPosts }}</div>
                    <div class="text-blue-100">Total Notes</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">{{ $totalCategories }}</div>
                    <div class="text-blue-100">Categories</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">{{ $totalUsers }}</div>
                    <div class="text-blue-100">Active Users</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-2">{{ $totalDownloads }}</div>
                    <div class="text-blue-100">Total Downloads</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->

@endsection

@section('scripts')
<script>
    // Simple search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[type="text"]');
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    window.location.href = `{{ route('posts.index') }}?search=${encodeURIComponent(query)}`;
                }
            }
        });

        // Category card click (already handled by anchor tags now)
    });
</script>
@endsection