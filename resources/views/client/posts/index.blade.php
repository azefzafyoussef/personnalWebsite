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
    }

    .posts-root {
        background: var(--bg);
        font-family: 'Syne', sans-serif;
        min-height: 100vh;
        color: var(--text);
    }

    /* ===== TOP BAR ===== */
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

    /* Breadcrumb */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        color: var(--muted);
    }

    .breadcrumb a {
        color: var(--muted);
        text-decoration: none;
        transition: color 0.2s;
    }

    .breadcrumb a:hover { color: var(--accent); }

    .breadcrumb-sep {
        font-size: 10px;
        opacity: 0.4;
    }

    .breadcrumb-current { color: var(--text); }

    /* Search */
    .search-wrap {
        position: relative;
    }

    .search-wrap svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        color: var(--muted);
        pointer-events: none;
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

    .search-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(0,194,255,0.08);
    }

    /* ===== LAYOUT ===== */
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

    .sidebar-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

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
    }

    .cat-link:hover {
        background: rgba(0,194,255,0.05);
        border-color: rgba(0,194,255,0.2);
        color: var(--accent);
    }

    .cat-link.active {
        background: rgba(0,194,255,0.08);
        border-color: rgba(0,194,255,0.3);
        color: var(--accent);
    }

    .cat-link-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cat-link-left i { font-size: 12px; }

    .cat-count {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--muted);
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 3px;
        padding: 1px 7px;
    }

    /* ===== POSTS GRID ===== */
    .posts-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .posts-count {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        color: var(--muted);
    }

    .posts-count span { color: var(--accent); }

    .posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    /* ===== POST CARD ===== */
    .post-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .post-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--accent), var(--accent2));
        opacity: 0;
        transition: opacity 0.25s;
    }

    .post-card:hover {
        border-color: rgba(0,194,255,0.3);
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.4);
    }

    .post-card:hover::before { opacity: 1; }

    .post-card-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }

    .post-card-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .post-cat-badge {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 10px;
        padding: 3px 10px;
        border-radius: 3px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 500;
    }

    .post-stats {
        display: flex;
        gap: 10px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--muted);
    }

    .post-stats span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .post-stats svg { width: 11px; height: 11px; }

    .post-title {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 10px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .post-excerpt {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
        margin-bottom: 16px;
    }

    .post-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        border-top: 1px solid var(--border);
    }

    .post-author {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: var(--muted);
    }

    .post-author-avatar {
        width: 24px;
        height: 24px;
        background: rgba(0,194,255,0.1);
        border: 1px solid rgba(0,194,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .post-author-avatar svg { width: 11px; height: 11px; color: var(--accent); }

    .post-read-more {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--accent);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: gap 0.2s;
    }

    .post-read-more:hover { gap: 9px; }
    .post-read-more svg { width: 12px; height: 12px; }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 80px 32px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        grid-column: 1 / -1;
    }

    .empty-icon {
        width: 56px;
        height: 56px;
        background: rgba(0,194,255,0.06);
        border: 1px solid rgba(0,194,255,0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }

    .empty-icon svg { width: 24px; height: 24px; color: var(--accent); opacity: 0.6; }

    .empty-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
    }

    .empty-sub {
        font-size: 13px;
        color: var(--muted);
        margin-bottom: 20px;
    }

    .empty-link {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        color: var(--accent);
        text-decoration: none;
        border: 1px solid rgba(0,194,255,0.3);
        padding: 8px 18px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .empty-link:hover { background: rgba(0,194,255,0.07); }

    /* ===== PAGINATION ===== */
    .pagination-wrap {
        margin-top: 36px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrap nav { font-family: 'IBM Plex Mono', monospace; font-size: 12px; }

    /* Override Laravel pagination */
    .pagination-wrap .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination-wrap .page-item .page-link {
        display: inline-flex;
        align-items: center;
        padding: 7px 13px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 4px;
        color: var(--text);
        text-decoration: none;
        transition: all 0.2s;
    }

    .pagination-wrap .page-item.active .page-link,
    .pagination-wrap .page-item .page-link:hover {
        background: rgba(0,194,255,0.1);
        border-color: var(--accent);
        color: var(--accent);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .posts-body {
            grid-template-columns: 1fr;
            padding: 24px 16px 60px;
        }
        .sidebar { position: static; }
        .search-input { width: 200px; }
        .posts-topbar-inner { padding: 0 16px; }
    }
</style>

<div class="posts-root">

    {{-- ===== TOP BAR ===== --}}
    <div class="posts-topbar">
        <div class="posts-topbar-inner">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('index.home') }}</a>
                <span class="breadcrumb-sep">›</span>
                <span class="breadcrumb-current">{{ __('index.all_notes') }}</span>
            </nav>

            {{-- <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input
                    type="text"
                    id="global-search"
                    class="search-input"
                    placeholder="{{ __('index.search_placeholder') }}"
                    value="{{ request('search') }}"
                >
            </div> --}}
        </div>
    </div>

    {{-- ===== BODY ===== --}}
    <div class="posts-body">

        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <div class="sidebar-title">{{ __('index.categories') }}</div>

            <a href="{{ route('posts.index') }}?category=my-0-days"
               class="cat-link {{ request('category') == 'my-0-days' ? 'active' : '' }}">
                <span class="cat-link-left">
                    <i class="fas fa-folder" style="color:#4361ee;"></i>
                    My 0-Days
                </span>
                <span class="cat-count"></span>
            </a>

            {{-- @foreach($categories as $category)
            <a href="{{ route('posts.index') }}?category={{ $category->slug }}"
               class="cat-link {{ request('category') == $category->slug ? 'active' : '' }}">
                <span class="cat-link-left">
                    <i class="{{ $category->icon }} text-sm" style="color: {{ $category->color }};"></i>
                    <span>{{ $category->name }}</span>
                </span>
                <span class="cat-count">{{ $category->posts_count }}</span>
            </a>
            @endforeach --}}
        </aside>

        {{-- MAIN CONTENT --}}
        <div>
            <div class="posts-header">
                <div class="posts-count">
                    <span>{{ $posts->total() }}</span> {{ __('index.all_notes') }}
                </div>
            </div>

            @if(0 !=  0)
                <div class="posts-grid">
                    {{-- @foreach($posts as $post) --}}
                    <div class="post-card">
                        <div class="post-card-body">
                            <div class="post-card-meta">
                                <span class="post-cat-badge"
                                    style="background:  #4361ee 18; color:  #4361ee ;">
                                    'My 0-Days'
                                </span>
                                <div class="post-stats">
                                    <span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        {{ $post->views ?? 0 }}
                                    </span>
                                    <span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        {{ $post->downloads_count ?? 0 }}
                                    </span>
                                </div>
                            </div>

                            <h3 class="post-title">CVE</h3>
                            <p class="post-excerpt">CVE</p>

                            <div class="post-card-footer">
                                <div class="post-author">
                                    <div class="post-author-avatar">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                     admin
                                </div>
                                <a href="{{ route('posts.show') }}" class="post-read-more">
                                    Read
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- @endforeach --}}
                </div>

                <div class="pagination-wrap">
                    {{ $posts->links() }}
                </div>

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

    searchInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            const query = this.value.trim();
            if (query) {
                window.location.href = `{{ route('posts.index') }}?search=${encodeURIComponent(query)}`;
            }
        }
    });
});
</script>
@endsection
