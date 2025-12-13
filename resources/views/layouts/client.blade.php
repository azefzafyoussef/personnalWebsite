@extends('layouts.app')

@section('content')
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
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
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 font-medium {{ request()->routeIs('home') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">Accueil</a>
                    <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-blue-600 font-medium {{ request()->routeIs('categories.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">Catégories</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-blue-600 font-medium {{ request()->routeIs('posts.index') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : '' }}">Toutes les notes</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-600">Bienvenue, <strong>{{ auth()->user()->name }}</strong></span>
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse" title="En ligne"></div>

                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 font-medium flex items-center space-x-2">
                                    <i class="fas fa-cog"></i>
                                    <span>Admin</span>
                                </a>
                            @endif

                            <a href="{{ route('posts.bookmarks') }}" class="text-gray-600 hover:text-blue-600 font-medium flex items-center space-x-1">
                                <i class="far fa-bookmark"></i>
                                <span>Favoris</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-red-600 font-medium flex items-center space-x-1">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Connexion</a>
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">S'inscrire</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('main-content')
    </main>

    <!-- Rest of the footer remains the same -->
    <footer class="bg-gray-800 text-white py-12 mt-12">
        <!-- ... footer content ... -->
    </footer>

    @yield('scripts')
@endsection
