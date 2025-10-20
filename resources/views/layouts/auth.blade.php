<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NotesHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>
    <div class="auth-container">
        <div class="auth-card fade-in">
            <!-- Logo -->
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-book"></i>
                    <span>NotesHub</span>
                </div>
                <h1 class="auth-title">@yield('page-title')</h1>
                <p class="auth-subtitle">@yield('page-subtitle')</p>
            </div>

            <!-- Alerts -->
            @if($errors->any())
                <div class="alert alert-error">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Content -->
            @yield('auth-content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>