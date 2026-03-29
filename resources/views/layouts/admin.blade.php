<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Youssef.sec')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white">
            <div class="p-4">
                <div class="flex items-center space-x-3 mb-8">
                    <i class="fas p-2 fa-book text-2xl"></i>
                    <span class="text-xl font-bold">Youssef.sec Admin</span>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                        <i class="fas p-2 fa-chart-bar"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                        <i class="fas p-2 fa-folder"></i>
                        <span>Categories</span>
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.posts.*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                        <i class="fas p-2 fa-file-alt"></i>
                        <span>Posts</span>
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <i class="fas p-2 fa-home"></i>
                        <span>View Site</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 w-full text-start">
                            <i class="fas p-2 fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex justify-between items-center p-4">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('header')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, {{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
