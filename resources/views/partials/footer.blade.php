<!-- Footer -->
<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <i class="fas fa-book text-2xl text-blue-400"></i>
                    <span class="text-xl font-bold">NotesHub</span>
                </div>
                <p class="text-gray-400">
                    Share knowledge, learn together. A platform for students and educators to share study materials.
                </p>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('categories.index') }}" class="hover:text-white transition-colors">Categories</a></li>
                    <li><a href="{{ route('posts.index') }}" class="hover:text-white transition-colors">All Notes</a></li>
                    @auth
                        <li><a href="{{ route('posts.bookmarks') }}" class="hover:text-white transition-colors">My Bookmarks</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Categories</h3>
                <ul class="space-y-2 text-gray-400">
                    @foreach(\App\Models\Category::where('is_active', true)->take(5)->get() as $category)
                    <li>
                        <a href="{{ route('categories.show', $category) }}" class="hover:text-white transition-colors flex items-center space-x-2">
                            <i class="{{ $category->icon }} text-sm" style="color: {{ $category->color }};"></i>
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-4">Connect</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
                <div class="mt-4 text-gray-400">
                    <p class="text-sm">Have questions?</p>
                    <a href="mailto:support@noteshub.com" class="text-blue-400 hover:text-blue-300 transition-colors">
                        support@noteshub.com
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} NotesHub. All rights reserved.</p>
        </div>
    </div>
</footer>