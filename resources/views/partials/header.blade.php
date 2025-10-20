<!-- Header -->
<header class="bg-white shadow-sm sticky top-0 z-50 border-b-2 border-blue-600">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <i class="fas fa-book text-2xl text-blue-600"></i>
                    <span class="text-xl font-bold text-gray-800">NotesHub</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium {{ request()->routeIs('home') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                    Home
                </a>
                <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-blue-600 font-medium {{ request()->routeIs('categories.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                    Categories
                </a>
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-blue-600 font-medium {{ request()->routeIs('posts.index') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">
                    All Notes
                </a>
            </nav>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- Search Bar (Desktop) -->
                <!-- <div class="hidden lg:block">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search notes..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64"
                               id="global-search">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div> -->

                <!-- Mobile Search Toggle -->
                <button class="lg:hidden text-gray-600 hover:text-blue-600" id="mobile-search-toggle">
                    <i class="fas fa-search"></i>
                </button>

                @auth
                    <!-- User Menu -->
                    <div class="relative">
                        <!-- User Avatar/Button -->
                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                                id="user-menu-button">
                            <!-- User Avatar -->
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <!-- User Name (Desktop) -->
                            <span class="hidden md:block text-gray-700 font-medium">
                                {{ auth()->user()->name }}
                            </span>
                            <!-- Chevron Icon -->
                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200" id="user-menu-chevron"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 top-full mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 py-2 hidden z-50"
                             id="user-dropdown-menu">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ auth()->user()->email }}</p>
                                <div class="flex items-center mt-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
                                    <span class="text-xs text-green-600">Online</span>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="py-2">
                                @if(auth()->user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                        <i class="fas fa-cog text-gray-400 w-5"></i>
                                        <span>Admin Dashboard</span>
                                    </a>
                                @endif
                                
                                <a href="{{ route('posts.bookmarks') }}" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                    <i class="far fa-bookmark text-gray-400 w-5"></i>
                                    <span>My Bookmarks</span>
                                </a>

                                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                    <i class="far fa-user text-gray-400 w-5"></i>
                                    <span>Profile</span>
                                </a>

                                <a href="#" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                    <i class="fas fa-cog text-gray-400 w-5"></i>
                                    <span>Settings</span>
                                </a>
                            </div>

                            <!-- Logout -->
                            <div class="border-t border-gray-100 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 w-full text-left transition-colors duration-150">
                                        <i class="fas fa-sign-out-alt text-gray-400 w-5"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Auth Buttons for Guests -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium hidden sm:block">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">Sign Up</a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div class="lg:hidden mt-4 hidden" id="mobile-search-container">
            <div class="relative">
                <input type="text" 
                       placeholder="Search notes..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full"
                       id="mobile-search">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>
</header>

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
                        window.location.href = `{{ route('posts.index') }}?search=${encodeURIComponent(query)}`;
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
`;
document.head.appendChild(style);
</script>