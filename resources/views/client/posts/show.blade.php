@extends('layouts.app')

@section('title', $post->title . ' - NotesHub')

@section('content')
<!-- Header -->


<!-- Breadcrumb -->
<div class="bg-white border-b">
    <div class="container mx-auto px-4 py-4">
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('categories.index') }}" class="hover:text-blue-600">Categories</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('categories.show', $post->category) }}" class="hover:text-blue-600">{{
                $post->category->name }}</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-400">{{ Str::limit($post->title, 50) }}</span>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-lg shadow-sm p-8">
                <!-- Category Badge -->
                <div class="mb-6">
                    <span class="px-4 py-2 rounded-full text-sm font-medium"
                        style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }};">
                        <i class="{{ $post->category->icon }} mr-2"></i>
                        {{ $post->category->name }}
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-6">
                    <span class="flex items-center space-x-1">
                        <i class="fas fa-user"></i>
                        <span>{{ $post->user->name }}</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <i class="far fa-calendar"></i>
                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <i class="fas fa-eye"></i>
                        <span>{{ $post->views }} views</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <i class="fas fa-download"></i>
                        <span>{{ $post->downloads }} downloads</span>
                    </span>
                </div>

                <!-- Excerpt -->
                @if($post->excerpt)
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <p class="text-blue-800">{{ $post->excerpt }}</p>
                </div>
                @endif

                <!-- Content -->
                <button id="read-btn" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    🔊 Read Aloud
                </button>
                <div class="prose max-w-none mb-8" id="article-content">
                    {!! $post->content !!}
                </div>

                <!-- File Info -->
                @if($post->file_path)
                <div class="mt-8 p-6 bg-gray-50 rounded-lg border">
                    <h3 class="font-semibold text-gray-800 mb-4 text-lg">Attached File</h3>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-file-pdf text-red-500 text-3xl"></i>
                            <div>
                                <p class="font-medium text-gray-800">Downloadable Notes</p>
                                <p class="text-sm text-gray-500">PDF Document • {{ $post->downloads }} downloads</p>
                            </div>
                        </div>
                        <a href="{{ route('posts.download', $post) }}"
                            class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 flex items-center space-x-2 font-medium">
                            <i class="fas fa-download"></i>
                            <span>Download PDF</span>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4 mt-8 pt-6 border-t">
                    @if($post->file_path)
                    <a href="{{ route('posts.download', $post) }}"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </a>
                    @endif

                    @auth
                    <form action="{{ route('posts.bookmark', $post) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                            <i class="far fa-bookmark"></i>
                            <span>Bookmark</span>
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}"
                        class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                        <i class="far fa-bookmark"></i>
                        <span>Login to Bookmark</span>
                    </a>
                    @endauth

                    <button onclick="window.print()"
                        class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 flex items-center space-x-2">
                        <i class="fas fa-print"></i>
                        <span>Print</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4 text-lg">Related Notes</h3>
                <div class="space-y-4">
                    @foreach($relatedPosts as $related)
                    <a href="{{ route('posts.show', $related) }}" class="block group">
                        <div
                            class="p-4 border border-gray-100 rounded-lg hover:border-blue-200 hover:bg-blue-50 transition-colors duration-200">
                            <h4 class="font-medium text-gray-800 group-hover:text-blue-600 line-clamp-2 mb-2">{{
                                $related->title }}</h4>
                            <div class="flex items-center justify-between text-sm">
                                <span class="px-2 py-1 rounded-full text-xs"
                                    style="background-color: {{ $related->category->color }}20; color: {{ $related->category->color }};">
                                    {{ $related->category->name }}
                                </span>
                                <span class="text-gray-500">{{ $related->views }} views</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex space-x-6">
                <div class="bg-white rounded-lg shadow-sm p-6 flex-1">
                    <!-- Author content here -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="font-semibold text-gray-800 mb-4 text-lg">About Author</h3>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $post->user->name }}</h4>
                                <p class="text-sm text-gray-500">Author</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p class="flex items-center space-x-2 mb-2">
                                <i class="fas fa-file-alt text-gray-400"></i>
                                <span>{{ $post->user->posts->count() }} notes published</span>
                            </p>
                            <p class="flex items-center space-x-2">
                                <i class="fas fa-calendar text-gray-400"></i>
                                <span>Joined {{ $post->user->created_at->format('M Y') }}</span>
                            </p>
                        </div>
                    </div>

                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 flex-1">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="font-semibold text-gray-800 mb-4 text-lg">Category</h3>
                        <a href="{{ route('categories.show', $post->category) }}" class="block group">
                            <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                    style="background-color: {{ $post->category->color }}20;">
                                    <i class="{{ $post->category->icon }} text-lg"
                                        style="color: {{ $post->category->color }};"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-800 group-hover:text-blue-600">{{
                                        $post->category->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $post->category->posts_count }} notes</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600"></i>
                            </div>
                        </a><!-- Category content here -->
                        <p class="text-sm text-gray-600 mt-3">{{ $post->category->description }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    // Add some interactive features
    document.addEventListener('DOMContentLoaded', function () {
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add copy code functionality
        document.querySelectorAll('pre').forEach(pre => {
            const button = document.createElement('button');
            button.className = 'copy-code absolute top-2 right-2 bg-gray-200 hover:bg-gray-300 text-gray-700 px-2 py-1 rounded text-xs';
            button.textContent = 'Copy';
            button.style.position = 'absolute';
            pre.style.position = 'relative';
            pre.appendChild(button);

            button.addEventListener('click', function () {
                const codeElement = pre.querySelector('code');
                const code = codeElement ? codeElement.textContent : pre.textContent;

                navigator.clipboard.writeText(code).then(() => {
                    const originalText = button.textContent;
                    button.textContent = 'Copied!';
                    button.classList.add('bg-green-200', 'text-green-800');

                    setTimeout(() => {
                        button.textContent = originalText;
                        button.classList.remove('bg-green-200', 'text-green-800');
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy text: ', err);
                    button.textContent = 'Error';
                    setTimeout(() => {
                        button.textContent = 'Copy';
                    }, 2000);
                });
            });
        });

        // Add search functionality
        const searchInput = document.querySelector('input[type="text"][placeholder*="Search"]');
        if (searchInput) {
            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        window.location.href = `{{ route('posts.index') }}?search=${encodeURIComponent(query)}`;
                    }
                }
            });
        }
        });
    document.addEventListener('DOMContentLoaded', function () {

        const readBtn = document.getElementById('read-btn');
        const content = document.getElementById('article-content');
                console.log("click")

        if (readBtn && content) {
            let isReading = false;
            let utterance = null;

            readBtn.addEventListener('click', function () {
                console.log("click")
                if (!isReading) {
                    const text = content.innerText;
                    utterance = new SpeechSynthesisUtterance(text);
                    utterance.lang = 'en-US'; // or 'fr-FR', 'ar-SA', etc.
                    utterance.rate = 1;       // speed
                    utterance.pitch = 1;      // voice tone

                    speechSynthesis.speak(utterance);
                    isReading = true;
                    readBtn.textContent = '⏹ Stop Reading';

                    utterance.onend = function () {
                        isReading = false;
                        readBtn.textContent = '🔊 Read Aloud';
                    };
                } else {
                    speechSynthesis.cancel();
                    isReading = false;
                    readBtn.textContent = '🔊 Read Aloud';
                }
            });
        }
    });

</script>
@endsection
