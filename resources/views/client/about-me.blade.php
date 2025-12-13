@extends('layouts.app')

@section('title', 'NotesHub - Share Your Knowledge')

@section('content')
    <!-- Header -->
    @php
        $currentLocale = app()->getLocale();
        $locales = [
            'en' => ['name' => 'English', 'flag' => 'gb'],
            'fr' => ['name' => 'Français', 'flag' => 'fr'],
            'ar' => ['name' => 'العربية', 'flag' => 'sa', 'dir' => 'rtl'],
        ];
    @endphp

<section class="bg-gray-900 text-gray-100 min-h-screen py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-4xl font-bold mb-6 text-blue-500">{{__('index.about-me')}}</h1>

        <p class="mb-6 text-lg">
            Hello! I'm <strong>AZEFZAF YOUSSEF</strong>, a Junior Pentester and Cybersecurity Engineer based in France.
            I specialize in penetration testing, vulnerability research, and offensive automation. I’m passionate about securing applications, systems, and networks while constantly learning the latest attack techniques.
        </p>

        <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-400">Professional Skills</h2>
        <ul class="list-disc list-inside space-y-2">
            <li>Web, API, Mobile, Windows, Active Directory & Linux penetration testing</li>
            <li>Privilege escalation, lateral movement, persistence, pivoting</li>
            <li>Vulnerability research, fuzzing, PoC exploit development</li>
            <li>Tools: Burp Suite, Metasploit, BloodHound, Mimikatz, sqlmap, nmap</li>
            <li>Programming & Scripting: Python, Bash</li>
            <li>Technologies: Docker, Splunk, MySQL, Oracle</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-400">Experience & Projects</h2>
        <p class="mb-4">
            I have hands-on experience in both professional and lab environments:
        </p>
        <ul class="list-disc list-inside space-y-2">
            <li>Internship — Researching 0-day vulnerabilities and penetration testing at Fenrisk (Paris)</li>
            <li>Fullstack Developer (PHP/Laravel) — E-sol, Casablanca</li>
            <li>CTF challenges: Root-Me, Hack The Box, TryHackMe</li>
            <li>Server & web audits, security tool development, automated attack chains</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-400">Languages & Interests</h2>
        <p class="mb-4">
            Fluent in French and English, native Arabic speaker. My passions include cybersecurity, CTF competitions, tool development, and sports.
        </p>

        <h2 class="text-2xl font-semibold mt-8 mb-4 text-blue-400">Contact Me</h2>
        <p class="mb-4">
            📧 <a href="mailto:azefzafyossef@gmail.com" class="text-blue-500 underline">azefzafyossef@gmail.com</a> <br>
            🔗 <a href="#" class="text-blue-500 underline">GitHub / LinkedIn / CTF Profiles</a>
        </p>
    </div>
</section>






    {{-- <!-- Recent Notes Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-8">
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
    </section> --}}



    <!-- Stats Section -->
    {{-- <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
        <div class="container mx-auto px-8">
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
    </section> --}}

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
