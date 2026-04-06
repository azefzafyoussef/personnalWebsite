@extends('layouts.app')

@section('title', 'All Notes - Youssef.sec')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap');

    :root {
        --bg: #0a0e17;
        --surface: #0f1522;
        --border: #1e2d45;
        --accent: #00c2ff;
        --accent2: #7b61ff;
        --text: #c9d8ef;
        --muted: #566a85;
        --green: #00e5a0;
        --orange: #ff9f43;
    }

    .posts-root {
        background: var(--bg);
        font-family: 'Syne', sans-serif;
        min-height: 100vh;
        color: var(--text);
    }

    .posts-topbar {
        border-bottom: 1px solid var(--border);
        background: var(--surface);
        padding: 12px 0;
        position: sticky;
        top: 0;
        z-index: 50;
        backdrop-filter: blur(8px);
    }

    .posts-topbar-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        color: var(--muted);
    }

    .breadcrumb a { color: var(--muted); text-decoration: none; transition: color 0.2s; }
    .breadcrumb a:hover { color: var(--accent); }
    .breadcrumb-sep { font-size: 10px; opacity: 0.4; }
    .breadcrumb-current { color: var(--text); }

    .search-wrap { position: relative; }

    .search-wrap svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        width: 14px; height: 14px; color: var(--muted); pointer-events: none;
    }

    .search-input {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 8px 16px 8px 36px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 13px;
        color: var(--text);
        width: 280px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input::placeholder { color: var(--muted); }
    .search-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(0,194,255,0.08); }

    .posts-body {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 32px 80px;
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 32px;
        align-items: start;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        position: sticky;
        top: 72px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 24px;
    }

    .sidebar-title {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 10px;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 0.15em;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sidebar-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    .cat-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 12px;
        border-radius: 6px;
        text-decoration: none;
        color: var(--text);
        font-size: 13px;
        transition: all 0.2s;
        border: 1px solid transparent;
        margin-bottom: 4px;
        cursor: pointer;
    }

    .cat-link:hover { background: rgba(0,194,255,0.05); border-color: rgba(0,194,255,0.2); color: var(--accent); }
    .cat-link.active { background: rgba(0,194,255,0.08); border-color: rgba(0,194,255,0.3); color: var(--accent); }

    .cat-link-left { display: flex; align-items: center; gap: 10px; }
    .cat-link-left svg { width: 13px; height: 13px; flex-shrink: 0; }

    .cat-count {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--muted);
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 3px;
        padding: 1px 7px;
    }

    /* ===== POSTS HEADER ===== */
    .posts-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .posts-count { font-family: 'IBM Plex Mono', monospace; font-size: 12px; color: var(--muted); }
    .posts-count span { color: var(--accent); }

    .active-filter {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--muted);
    }

    .filter-tag {
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(0,194,255,0.08);
        border: 1px solid rgba(0,194,255,0.25);
        border-radius: 4px;
        padding: 3px 10px;
        color: var(--accent);
        cursor: pointer;
        transition: background 0.2s;
    }

    .filter-tag:hover { background: rgba(0,194,255,0.14); }
    .filter-tag svg { width: 10px; height: 10px; }

    /* ===== POSTS GRID ===== */
    .posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .post-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
        display: flex;
        flex-direction: column;
        position: relative;
        text-decoration: none;
    }

    .post-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--accent), var(--accent2));
        opacity: 0;
        transition: opacity 0.25s;
    }

    .post-card.php-card::before { background: linear-gradient(90deg, var(--orange), #ff6b6b); }

    .post-card:hover { border-color: rgba(0,194,255,0.3); transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.4); }
    .post-card.php-card:hover { border-color: rgba(255,159,67,0.3); }
    .post-card:hover::before { opacity: 1; }

    .post-card-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }

    .post-card-meta { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }

    .post-cat-badge {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 10px;
        padding: 3px 10px;
        border-radius: 3px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 500;
    }

    .badge-0day { background: rgba(67,97,238,0.12); color: #4361ee; border: 1px solid rgba(67,97,238,0.25); }
    .badge-php  { background: rgba(255,159,67,0.1);  color: var(--orange); border: 1px solid rgba(255,159,67,0.25); }

    .post-stats { display: flex; gap: 10px; font-family: 'IBM Plex Mono', monospace; font-size: 11px; color: var(--muted); }
    .post-stats span { display: flex; align-items: center; gap: 4px; }
    .post-stats svg { width: 11px; height: 11px; }

    .post-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 10px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    .post-excerpt { font-size: 13px; color: var(--muted); line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex: 1; margin-bottom: 16px; }

    .post-card-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 14px; border-top: 1px solid var(--border); }

    .post-author { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--muted); }

    .post-author-avatar {
        width: 24px; height: 24px;
        background: rgba(0,194,255,0.1);
        border: 1px solid rgba(0,194,255,0.2);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }

    .post-author-avatar svg { width: 11px; height: 11px; color: var(--accent); }

    .post-read-more {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px; color: var(--accent);
        text-decoration: none;
        display: flex; align-items: center; gap: 5px;
        transition: gap 0.2s;
    }

    .post-read-more:hover { gap: 9px; }
    .post-read-more svg { width: 12px; height: 12px; }

    /* Section divider */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 32px 0 20px;
    }

    .section-divider-label {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 10px;
        color: var(--orange);
        text-transform: uppercase;
        letter-spacing: 0.15em;
        white-space: nowrap;
    }

    .section-divider-line { flex: 1; height: 1px; background: var(--border); }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center; padding: 80px 32px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
    }

    .empty-icon {
        width: 56px; height: 56px;
        background: rgba(0,194,255,0.06);
        border: 1px solid rgba(0,194,255,0.15);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }

    .empty-icon svg { width: 24px; height: 24px; color: var(--accent); opacity: 0.6; }
    .empty-title { font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 8px; }
    .empty-sub { font-size: 13px; color: var(--muted); margin-bottom: 20px; }

    .empty-link {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px; color: var(--accent);
        text-decoration: none;
        border: 1px solid rgba(0,194,255,0.3);
        padding: 8px 18px; border-radius: 4px;
        transition: background 0.2s;
    }

    .empty-link:hover { background: rgba(0,194,255,0.07); }

    /* ===== PAGINATION ===== */
    .pagination-wrap { margin-top: 36px; display: flex; justify-content: center; }
    .pagination-wrap nav { font-family: 'IBM Plex Mono', monospace; font-size: 12px; }
    .pagination-wrap .pagination { display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; }
    .pagination-wrap .page-item .page-link { display: inline-flex; align-items: center; padding: 7px 13px; background: var(--surface); border: 1px solid var(--border); border-radius: 4px; color: var(--text); text-decoration: none; transition: all 0.2s; }
    .pagination-wrap .page-item.active .page-link,
    .pagination-wrap .page-item .page-link:hover { background: rgba(0,194,255,0.1); border-color: var(--accent); color: var(--accent); }

    @media (max-width: 900px) {
        .posts-body { grid-template-columns: 1fr; padding: 24px 16px 60px; }
        .sidebar { position: static; }
        .search-input { width: 200px; }
        .posts-topbar-inner { padding: 0 16px; }
    }
</style>

{{-- Data: define all articles here --}}
@php
$allArticles = [

    // ===== 0-DAYS =====
    [
        'category'  => 'my-0-days',
        'badge'     => 'badge-0day',
        'label'     => 'My 0-Days',
        'title'     => 'CVE — Bypassing Velocity Sandbox to Achieve RCE',
        'excerpt'   => 'A Remote Code Execution vulnerability in Velocity macro and page title parameter. By navigating pre-instantiated objects in the Velocity context, the sandbox blacklist is entirely bypassed.',
        'route'     => 'posts.show',
        'route_param' => 'cve',
        'views'     => 59,
        'author'    => 'Youssef',
    ],

    // ===== PHP =====
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'Introduction to PHP Security',
        'excerpt'   => 'Overview of the PHP language from a security perspective: execution model, dangerous functions, unsafe defaults, and why PHP applications are historically a prime attack surface.',
        'route'     => 'posts.show',
        'route_param' => 'php-introduction',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'Exhaustive List of PHP Vulnerabilities',
        'excerpt'   => 'A comprehensive reference covering every major PHP vulnerability class: SQLi, XSS, RCE, LFI/RFI, SSRF, XXE, Deserialization, Type Juggling, open_basedir bypass, and more.',
        'route'     => 'posts.show',
        'route_param' => 'php-vulnerabilities-list',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'SQL Injection in PHP',
        'excerpt'   => 'How SQLi works in PHP applications, vulnerable patterns with mysql_query / PDO misuse, blind/time-based techniques, and exploitation with sqlmap.',
        'route'     => 'posts.show',
        'route_param' => 'php-sqli',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'Local & Remote File Inclusion (LFI / RFI)',
        'excerpt'   => 'Exploiting include(), require() and file path manipulation in PHP. Log poisoning, /proc/self/environ, php://filter wrappers, and RFI to RCE chains.',
        'route'     => 'posts.show',
        'route_param' => 'php-lfi-rfi',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'PHP Object Deserialization & POP Chains',
        'excerpt'   => 'Abusing unserialize() in PHP to trigger magic methods (__wakeup, __destruct). Building Property-Oriented Programming chains to achieve RCE, file write, and SSRF.',
        'route'     => 'posts.show',
        'route_param' => 'php-deserialization',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'PHP Type Juggling & Loose Comparisons',
        'excerpt'   => 'How PHP\'s == operator and type coercion lead to authentication bypasses. Magic hashes, 0e collisions, and the differences between == and === in security-critical code.',
        'route'     => 'posts.show',
        'route_param' => 'php-type-juggling',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'Remote Code Execution via PHP Functions',
        'excerpt'   => 'Exploiting eval(), system(), exec(), passthru(), preg_replace with /e modifier, and variable variables. Real-world RCE chains and bypass techniques for disable_functions.',
        'route'     => 'posts.show',
        'route_param' => 'php-rce',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'Cross-Site Scripting (XSS) in PHP Applications',
        'excerpt'   => 'Reflected, stored and DOM-based XSS in PHP. Bypassing htmlspecialchars, filter_var, and WAFs. Context-aware injection and CSP bypass techniques.',
        'route'     => 'posts.show',
        'route_param' => 'php-xss',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
    [
        'category'  => 'php',
        'badge'     => 'badge-php',
        'label'     => 'PHP Security',
        'title'     => 'Server-Side Request Forgery (SSRF) in PHP',
        'excerpt'   => 'Using file_get_contents(), curl, and stream wrappers to pivot to internal services, cloud metadata endpoints, and bypass IP/host-based filters.',
        'route'     => 'posts.show',
        'route_param' => 'php-ssrf',
        'views'     => 0,
        'author'    => 'Youssef',
    ],
];

// Filter by category if requested
$activeCategory = request('category', 'all');
$search = request('search', '');

$filtered = collect($allArticles)->filter(function($a) use ($activeCategory, $search) {
    $matchCat = $activeCategory === 'all' || $a['category'] === $activeCategory;
    $matchSearch = $search === '' ||
        str_contains(strtolower($a['title']), strtolower($search)) ||
        str_contains(strtolower($a['excerpt']), strtolower($search));
    return $matchCat && $matchSearch;
});

$categories = [
    'all'        => ['label' => 'All Articles', 'count' => count($allArticles), 'color' => '#00c2ff', 'icon' => 'grid'],
    'my-0-days'  => ['label' => 'My 0-Days',   'count' => collect($allArticles)->where('category','my-0-days')->count(), 'color' => '#4361ee', 'icon' => 'zap'],
    'php'        => ['label' => 'PHP Security', 'count' => collect($allArticles)->where('category','php')->count(),      'color' => '#ff9f43', 'icon' => 'code'],
];
@endphp

<div class="posts-root">

    {{-- TOP BAR --}}
    <div class="posts-topbar">
        <div class="posts-topbar-inner">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('index.home') }}</a>
                <span class="breadcrumb-sep">›</span>
                <span class="breadcrumb-current">{{ __('index.all_notes') }}</span>
                @if($activeCategory !== 'all')
                    <span class="breadcrumb-sep">›</span>
                    <span class="breadcrumb-current">{{ $categories[$activeCategory]['label'] ?? $activeCategory }}</span>
                @endif
            </nav>

            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" id="global-search" class="search-input"
                    placeholder="Search articles..."
                    value="{{ $search }}">
            </div>
        </div>
    </div>

    {{-- BODY --}}
    <div class="posts-body">

        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <div class="sidebar-title">Categories</div>

            @foreach($categories as $slug => $cat)
            <a href="{{ route('posts.index') }}?category={{ $slug }}"
               class="cat-link {{ $activeCategory === $slug ? 'active' : '' }}">
                <span class="cat-link-left">
                    @if($cat['icon'] === 'grid')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:{{ $cat['color'] }}"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                    @elseif($cat['icon'] === 'zap')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:{{ $cat['color'] }}"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    @elseif($cat['icon'] === 'code')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:{{ $cat['color'] }}"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    @endif
                    <span>{{ $cat['label'] }}</span>
                </span>
                <span class="cat-count">{{ $cat['count'] }}</span>
            </a>
            @endforeach
        </aside>

        {{-- MAIN --}}
        <div>
            <div class="posts-header">
                <div class="posts-count">
                    <span>{{ $filtered->count() }}</span> article{{ $filtered->count() > 1 ? 's' : '' }}
                    @if($search !== '')
                        pour "{{ $search }}"
                    @endif
                </div>
                @if($activeCategory !== 'all')
                <div class="active-filter">
                    <span>Filtre :</span>
                    <a href="{{ route('posts.index') }}" class="filter-tag">
                        {{ $categories[$activeCategory]['label'] ?? $activeCategory }}
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                </div>
                @endif
            </div>

            @if($filtered->count() > 0)

                {{-- Group by category for visual sections --}}
                @foreach(['my-0-days', 'php'] as $catSlug)
                    @php
                        $group = $filtered->where('category', $catSlug)->values();
                    @endphp

                    @if($group->count() > 0 && $activeCategory === 'all')
                        <div class="section-divider">
                            <span class="section-divider-label"
                                style="color: {{ $categories[$catSlug]['color'] }}">
                                // {{ $categories[$catSlug]['label'] }}
                            </span>
                            <div class="section-divider-line"></div>
                        </div>
                    @endif

                    @if($group->count() > 0)
                    <div class="posts-grid" style="margin-bottom: 8px;">
                        @foreach($group as $article)
                        <a href="{{ route($article['route'], $article['route_param']) }}"
                           class="post-card {{ $article['category'] === 'php' ? 'php-card' : '' }}">
                            <div class="post-card-body">
                                <div class="post-card-meta">
                                    <span class="post-cat-badge {{ $article['badge'] }}">
                                        {{ $article['label'] }}
                                    </span>
                                    <div class="post-stats">
                                        <span>
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            {{ $article['views'] }}
                                        </span>
                                    </div>
                                </div>

                                <h3 class="post-title">{{ $article['title'] }}</h3>
                                <p class="post-excerpt">{{ $article['excerpt'] }}</p>

                                <div class="post-card-footer">
                                    <div class="post-author">
                                        <div class="post-author-avatar">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        </div>
                                        {{ $article['author'] }}
                                    </div>
                                    <span class="post-read-more">
                                        Read
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif

                @endforeach

            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <div class="empty-title">{{ __('index.no_notes_found') }}</div>
                    <p class="empty-sub">{{ __('index.no_notes_message') }}</p>
                    <a href="{{ route('posts.index') }}" class="empty-link">{{ __('index.clear_filters') }}</a>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('global-search');
    if (!searchInput) return;

    // Live search redirect on Enter
    searchInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            const query = this.value.trim();
            const category = new URLSearchParams(window.location.search).get('category') || 'all';
            const params = new URLSearchParams();
            if (query) params.set('search', query);
            if (category !== 'all') params.set('category', category);
            window.location.href = `{{ route('posts.index') }}?${params.toString()}`;
        }
    });
});
</script>
@endsection
