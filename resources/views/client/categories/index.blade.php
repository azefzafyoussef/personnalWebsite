@extends('layouts.app')

@section('title', 'Categories - NotesHub')

@section('content')
<div class="bg-gray-150">
    <!-- Header -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex items-center space-x-2 text-sm text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('categories.index') }}" class="hover:text-blue-600">Categories</a>
            </nav>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}"
               class="category-card bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: {{ $category->color }}20;">
                        <i class="{{ $category->icon }} text-lg" style="color: {{ $category->color }};"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-800 text-lg">{{ $category->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ $category->description }}</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-sm text-gray-500">{{ $category->posts_count }} notes</span>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        @if($categories->isEmpty())
        <div class="text-center py-12">
            <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No categories found</h3>
            <p class="text-gray-500">Categories will appear here once they are created.</p>
        </div>
        @endif
    </div>
</div>
@endsection
