<!-- Header (Dark Mode) -->
<header class="bg-gray-900 shadow-sm sticky top-0 z-50 border-b-2 border-blue-500">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">

            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="/logo4.png" alt="Logo" class="h-8 w-auto object-contain"
                        style="">


                    <style>
                        .hacker-text {
                            font-family: "JetBrains Mono", "Fira Code", monospace;
                            font-weight: 400;
                            letter-spacing: 0.5px;
                            /* less spacing = more terminal-like */
                            font-size: 1.15rem;
                        }
                    </style>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class="text-gray-300 hover:text-blue-400 font-medium ml-4
                   {{ request()->routeIs('home') ? 'text-blue-400 border-b-2 border-blue-400 ml-4 pb-1' : '' }}">
                {{__("index.home")}}

                </a>


                <a href="{{ route('posts.index') }}"
                    class="text-gray-300 hover:text-blue-400 font-medium
                   {{ request()->routeIs('posts.index') ? 'text-blue-400 border-b-2 border-blue-400 pb-1' : '' }}">
                {{__("index.all_notes")}}

                </a>
                <a href="{{ route('about') }}"
                    class="text-gray-300 hover:text-blue-400 font-medium
                   {{ request()->routeIs('about') ? 'text-blue-400 border-b-2 border-blue-400 pb-1' : '' }}">
                {{__("index.about-me")}}

                </a>
            </nav>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">

                <!-- Language Selector -->
<!-- Language Selector -->
<div class="flex items-center space-x-1 mr-2" x-data="{ open: false }" @click.outside="open = false">
    <button @click="open = !open"
            class="flex items-center space-x-1 px-2 py-1 rounded-md hover:bg-gray-800 transition">
        <i class="fas p-2 fa-globe text-gray-400"></i>
        <span class="text-gray-300 text-sm font-medium">
            @switch(app()->getLocale())
                @case('en')
                    EN
                    @break
                @case('fr')
                    FR
                    @break
                @case('ar')
                    العربية
                    @break
                @default
                    EN
            @endswitch
        </span>
        <i class="fas p-2 fa-chevron-down text-gray-400 text-xs"></i>
    </button>

    <!-- Language Dropdown -->
    <div x-show="open"
         x-transition
         class="absolute left-4 mt-12 w-28 bg-gray-800 border border-gray-700 rounded-lg shadow-lg py-1 z-50">

        <!-- English -->
        <form method="POST" action="{{ route('locale.setting') }}" class="block">
            @csrf
            <input type="hidden" name="locale" value="en">
            <button type="submit"
                    class="w-full text-left px-3 py-2 text-sm hover:bg-gray-700 hover:text-blue-400
                           {{ app()->getLocale() == 'en' ? 'bg-gray-700 text-blue-400' : 'text-gray-300' }}">
                English
            </button>
        </form>

        <!-- French -->
        <form method="POST" action="{{ route('locale.setting') }}" class="block">
            @csrf
            <input type="hidden" name="locale" value="fr">
            <button type="submit"
                    class="w-full text-left px-3 py-2 text-sm hover:bg-gray-700 hover:text-blue-400
                           {{ app()->getLocale() == 'fr' ? 'bg-gray-700 text-blue-400' : 'text-gray-300' }}">
                Français
            </button>
        </form>

        <!-- Arabic -->
        <form method="POST" action="{{ route('locale.setting') }}" class="block">
            @csrf
            <input type="hidden" name="locale" value="ar">
            <button type="submit"
                    class="w-full text-left px-3 py-2 text-sm hover:bg-gray-700 hover:text-blue-400
                           {{ app()->getLocale() == 'ar' ? 'bg-gray-700 text-blue-400' : 'text-gray-300' }}"
                    dir="rtl">
                العربية
            </button>
        </form>
    </div>
</div>

                <!-- Mobile Search Button -->
                <button class="lg:hidden text-gray-300 hover:text-blue-400" id="mobile-search-toggle">
                    <i class="fas p-2 fa-search"></i>
                </button>

                @auth
                    <div class="relative">

                        <!-- User Button -->
                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-800 transition"
                            id="user-menu-button">

                            <div
                                class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>

                            <span class="hidden md:block text-gray-200 font-medium">
                                {{ auth()->user()->name }}
                            </span>

                            <i class="fas p-2 fa-chevron-down text-gray-400 text-xs transition-transform duration-200"
                                id="user-menu-chevron"></i>
                        </button>

                        <!-- Dropdown -->
                        <div class="absolute right-0 top-full mt-2 w-64 bg-gray-800 rounded-lg shadow-xl border border-gray-700 py-2 hidden"
                            id="user-dropdown-menu">

                            <div class="px-4 py-3 border-b border-gray-700">
                                <p class="text-sm font-semibold text-gray-100">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ auth()->user()->email }}</p>

                                <div class="flex items-center mt-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
                                    <span class="text-xs text-green-400">Online</span>
                                </div>
                            </div>

                            <div class="py-2">
                                @if (auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-blue-400">
                                        <i class="fas p-2 fa-cog text-gray-400 w-5"></i>
                                        <span>Admin Dashboard</span>
                                    </a>
                                @endif

                                <a href="{{ route('posts.bookmarks') }}"
                                    class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-blue-400">
                                    <i class="far fa-bookmark text-gray-400 w-5"></i>
                                    <span>My Bookmarks</span>
                                </a>

                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-blue-400">
                                    <i class="far fa-user text-gray-400 w-5"></i>
                                    <span>Profile</span>
                                </a>

                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-blue-400">
                                    <i class="fas p-2 fa-cog text-gray-400 w-5"></i>
                                    <span>Settings</span>
                                </a>
                            </div>

                            <div class="border-t border-gray-700 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center space-x-3 px-4 py-2 text-gray-300 hover:bg-red-900 hover:text-red-400 w-full text-left">
                                        <i class="fas p-2 fa-sign-out-alt text-gray-400 w-5"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Login / Register -->
                    <div class="flex items-center space-x-3">
                        {{-- <a href="{{ route('login') }}" class="text-gray-300 hover:text-blue-400 font-medium hidden sm:block">Login</a> --}}
                        {{-- <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">Sign Up</a> --}}
                    </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Search (Dark) -->
        <div class="lg:hidden mt-4 hidden" id="mobile-search-container">
            <div class="relative">
                <input type="text" placeholder="Search notes..."
                    class="pl-10 pr-4 py-2 border border-gray-700 bg-gray-800 text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                    id="mobile-search">
                <i class="fas p-2 fa-search absolute left-3 top-3 text-gray-500"></i>
            </div>
        </div>
    </div>
</header>
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - testing user menu');

        // User menu functionality - SIMPLE VERSION
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdownMenu = document.getElementById('user-dropdown-menu');
        const userMenuChevron = document.getElementById('user-menu-chevron');

        if (userMenuButton && userDropdownMenu) {
            console.log('✅ User menu elements found');

            // Simple toggle - no complex animations
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                console.log('🎯 User menu clicked');

                // Toggle hidden class
                if (userDropdownMenu.classList.contains('hidden')) {
                    console.log('📂 Opening menu');
                    userDropdownMenu.classList.remove('hidden');
                    if (userMenuChevron) {
                        userMenuChevron.classList.add('rotate-180');
                    }
                } else {
                    console.log('📁 Closing menu');
                    userDropdownMenu.classList.add('hidden');
                    if (userMenuChevron) {
                        userMenuChevron.classList.remove('rotate-180');
                    }
                }
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!userMenuButton.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    if (!userDropdownMenu.classList.contains('hidden')) {
                        console.log('🚪 Closing menu (outside click)');
                        userDropdownMenu.classList.add('hidden');
                        if (userMenuChevron) {
                            userMenuChevron.classList.remove('rotate-180');
                        }
                    }
                }
            });

            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !userDropdownMenu.classList.contains('hidden')) {
                    console.log('⌨️ Closing menu (escape key)');
                    userDropdownMenu.classList.add('hidden');
                    if (userMenuChevron) {
                        userMenuChevron.classList.remove('rotate-180');
                    }
                }
            });

        } else {
            console.log('❌ User menu elements not found:', {
                button: !!userMenuButton,
                menu: !!userDropdownMenu,
                chevron: !!userMenuChevron
            });
        }

        // Mobile search functionality
        const mobileSearchToggle = document.getElementById('mobile-search-toggle');
        const mobileSearchContainer = document.getElementById('mobile-search-container');

        if (mobileSearchToggle && mobileSearchContainer) {
            mobileSearchToggle.addEventListener('click', function() {
                mobileSearchContainer.classList.toggle('hidden');
            });
        }

        // Global search functionality
        function setupSearch(inputId) {
            const searchInput = document.getElementById(inputId);
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const query = this.value.trim();
                        if (query) {
                            window.location.href =
                                `{{ route('posts.index') }}?search=${encodeURIComponent(query)}`;
                        }
                    }
                });
            }
        }

        setupSearch('global-search');
        setupSearch('mobile-search');
    });

    // Simple CSS for chevron rotation
    const style = document.createElement('style');
    style.textContent = `
    #user-menu-chevron.rotate-180 {
        transform: rotate(180deg);
    }

    /* Ensure dropdown is above everything */
    #user-dropdown-menu {
        z-index: 1000 !important;
    }

    /* Language dropdown styling */
    [x-cloak] { display: none !important; }
`;
    document.head.appendChild(style);
</script>
