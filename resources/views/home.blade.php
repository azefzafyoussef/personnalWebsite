@extends('layouts.client')

@section('title', 'NotesHub - Partagez Vos Connaissances')

@section('main-content')
    <!-- Hero Section -->
    <section class="gradient-bg text-white py-20">
        <div class="container mx-auto px-4 text-center">
            @auth
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 mb-8 inline-block">
                    <h2 class="text-2xl font-bold mb-2">👋 Bonjour, {{ auth()->user()->name }} !</h2>
                    <p class="text-blue-100">Content de vous revoir. Continuez à apprendre et partager !</p>
                </div>
            @endauth
            
            <h1 class="text-5xl font-bold mb-6">Partagez Vos Connaissances</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Découvrez des milliers de notes sur divers sujets, ou contribuez en partageant vos propres supports d'étude.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('posts.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Explorer les Notes
                </a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.posts.create') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                            📝 Ajouter une Note
                        </a>
                    @else
                        <a href="{{ route('posts.index') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                            📚 Mes Favoris
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                        Commencer
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Rest of the home page content remains the same -->
    <section class="py-16 bg-white">
        <!-- ... categories section ... -->
    </section>

    <section class="py-16 bg-gray-50">
        <!-- ... recent notes section ... -->
    </section>

    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
        <!-- ... stats section ... -->
    </section>
@endsection