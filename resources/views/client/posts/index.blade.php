@extends('layouts.app')

@section('title', 'All Notes - NotesHub')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
     
    <div class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <nav class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('posts.index') }}" class="hover:text-blue-600">All notes</a>
            </nav>
                
                <!-- Search and Filters -->
                <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" placeholder="Search notes..." id="global-search"
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64"
                               value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    
                    <!-- Sort -->
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="downloads" {{ $sort == 'downloads' ? 'selected' : '' }}>Most Downloads</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                    <h3 class="font-semibold text-gray-800 mb-4">Categories</h3>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                        <a href="{{ route('posts.index') }}?category={{ $category->slug }}" 
                           class="flex items-center justify-between p-2 rounded hover:bg-gray-50 {{ request('category') == $category->slug ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">
                            <span class="flex items-center space-x-2">
                                <i class="{{ $category->icon }} text-sm" style="color: {{ $category->color }};"></i>
                                <span>{{ $category->name }}</span>
                            </span>
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">{{ $category->posts_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="lg:col-span-3">
                @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                    <div class="note-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
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
                                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600 text-xs"></i>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $post->user->name }}</span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
                @else
                <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                    <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No notes found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                        Clear filters
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.querySelector('input[type="text"]');
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    window.location.href = `{{ route('posts.index') }}?search=${encodeURIComponent(query)}`;
                }
            }
        });

        // Sort functionality
        const sortSelect = document.querySelector('select');
        sortSelect.addEventListener('change', function() {
            const sort = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sort);
            window.location.href = url.toString();
        });
    });
</script>
@endsection
@endsection