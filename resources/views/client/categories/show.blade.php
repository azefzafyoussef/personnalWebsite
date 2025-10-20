@extends('layouts.app')

@section('title','Categories - NotesHub')

@section('content')
<div class="bg-gray-50">

    <!-- Header -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('categories.index') }}" class="hover:text-blue-600">Categories</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('categories.show', $category) }}" class="hover:text-blue-600">{{ $category->name }}</a>
            </nav>
        </div>
    </div>


    <!-- Notes Grid -->
    <div class="container mx-auto px-4 py-8">
        @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium" style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                            {{ $category->name }}
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
                        <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Read More
                        </a>
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
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No notes found in this category</h3>
            <p class="text-gray-500 mb-4">Be the first to share notes in {{ $category->name }}!</p>
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                Browse all notes
            </a>
        </div>
        @endif
    </div>
    </div>
@endsection
