<!-- ===== NAVBAR ===== -->
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
        --red: #ff4d6d;
    }

    .nav-root {
        position: sticky;
        top: 0;
        z-index: 100;
        background: rgba(10, 14, 23, 0.92);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--border);
        font-family: 'Syne', sans-serif;
    }

    .nav-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 64px;
        gap: 24px;
    }

    /* ===== LOGO ===== */
    .nav-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        flex-shrink: 0;
    }

    .nav-logo-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, rgba(0,194,255,0.15), rgba(123,97,255,0.15));
        border: 1px solid rgba(0,194,255,0.3);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-logo-icon svg { width: 16px; height: 16px; color: var(--accent); }

    .nav-logo-text {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 14px;
        font-weight: 500;
        color: #fff;
        letter-spacing: 0.02em;
    }

    .nav-logo-text span { color: var(--accent); }

    /* ===== NAV LINKS ===== */
    .nav-links {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .nav-link {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        font-weight: 500;
        color: var(--muted);
        text-decoration: none;
        padding: 6px 14px;
        border-radius: 5px;
        border: 1px solid transparent;
        letter-spacing: 0.04em;
        transition: all 0.2s;
        position: relative;
    }

    .nav-link:hover {
        color: var(--accent);
        background: rgba(0,194,255,0.05);
        border-color: rgba(0,194,255,0.15);
    }

    .nav-link.active {
        color: var(--accent);
        background: rgba(0,194,255,0.08);
        border-color: rgba(0,194,255,0.25);
    }

    /* ===== RIGHT SECTION ===== */
    .nav-right {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    /* Mobile search icon */
    .nav-mobile-search-btn {
        display: none;
        background: none;
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 7px 10px;
        color: var(--muted);
        cursor: pointer;
        transition: all 0.2s;
    }

    .nav-mobile-search-btn:hover { color: var(--accent); border-color: rgba(0,194,255,0.3); }
    .nav-mobile-search-btn svg { width: 14px; height: 14px; display: block; }

    /* ===== USER BUTTON ===== */
    .user-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 6px 12px 6px 6px;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .user-btn:hover {
        border-color: rgba(0,194,255,0.3);
        background: rgba(0,194,255,0.04);
    }

    .user-avatar {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        font-weight: 700;
        color: #0a0e17;
        flex-shrink: 0;
    }

    .user-name {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        color: var(--text);
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .user-chevron {
        width: 12px;
        height: 12px;
        color: var(--muted);
        transition: transform 0.2s;
        flex-shrink: 0;
    }

    .user-chevron.rotated { transform: rotate(180deg); }

    /* ===== DROPDOWN ===== */
    .user-dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 10px);
        width: 240px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        overflow: hidden;
        display: none;
        z-index: 200;
    }

    .user-dropdown.open { display: block; }

    .dropdown-header {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border);
        background: rgba(0,194,255,0.03);
    }

    .dropdown-header-name {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 13px;
        font-weight: 500;
        color: #fff;
        margin-bottom: 2px;
    }

    .dropdown-header-email {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 11px;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .dropdown-status {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--green);
        animation: blink 2s ease-in-out infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    .status-label {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 10px;
        color: var(--green);
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .dropdown-section { padding: 6px 0; }
    .dropdown-section + .dropdown-section { border-top: 1px solid var(--border); }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
        color: var(--text);
        text-decoration: none;
        transition: all 0.15s;
        cursor: pointer;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
    }

    .dropdown-item svg {
        width: 13px;
        height: 13px;
        color: var(--muted);
        flex-shrink: 0;
        transition: color 0.15s;
    }

    .dropdown-item:hover {
        background: rgba(0,194,255,0.05);
        color: var(--accent);
    }

    .dropdown-item:hover svg { color: var(--accent); }

    .dropdown-item.danger:hover {
        background: rgba(255,77,109,0.06);
        color: var(--red);
    }

    .dropdown-item.danger:hover svg { color: var(--red); }

    /* ===== MOBILE SEARCH BAR ===== */
    .nav-mobile-search {
        display: none;
        background: var(--surface);
        border-top: 1px solid var(--border);
        padding: 12px 24px;
    }

    .nav-mobile-search.open { display: block; }

    .mobile-search-wrap {
        position: relative;
    }

    .mobile-search-wrap svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 13px;
        height: 13px;
        color: var(--muted);
        pointer-events: none;
    }

    .mobile-search-input {
        width: 100%;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 9px 16px 9px 36px;
        font-family: 'IBM Plex Mono', monospace;
        font-size: 13px;
        color: var(--text);
        outline: none;
        transition: border-color 0.2s;
    }

    .mobile-search-input::placeholder { color: var(--muted); }
    .mobile-search-input:focus { border-color: var(--accent); }

    /* ===== HAMBURGER (mobile nav) ===== */
    .nav-hamburger {
        display: none;
        background: none;
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 7px 9px;
        cursor: pointer;
        flex-direction: column;
        gap: 4px;
        transition: border-color 0.2s;
    }

    .nav-hamburger:hover { border-color: rgba(0,194,255,0.3); }

    .hamburger-line {
        width: 18px;
        height: 1.5px;
        background: var(--muted);
        border-radius: 2px;
        transition: all 0.25s;
    }

    .nav-hamburger.open .hamburger-line:nth-child(1) { transform: translateY(5.5px) rotate(45deg); }
    .nav-hamburger.open .hamburger-line:nth-child(2) { opacity: 0; }
    .nav-hamburger.open .hamburger-line:nth-child(3) { transform: translateY(-5.5px) rotate(-45deg); }

    /* Mobile nav drawer */
    .nav-mobile-drawer {
        display: none;
        background: var(--surface);
        border-top: 1px solid var(--border);
        padding: 12px 24px 16px;
        flex-direction: column;
        gap: 4px;
    }

    .nav-mobile-drawer.open { display: flex; }

    .nav-mobile-link {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 13px;
        color: var(--muted);
        text-decoration: none;
        padding: 10px 12px;
        border-radius: 6px;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .nav-mobile-link:hover,
    .nav-mobile-link.active {
        color: var(--accent);
        background: rgba(0,194,255,0.05);
        border-color: rgba(0,194,255,0.2);
    }

    /* ===== RESPONSIVE BREAKPOINTS ===== */
    @media (max-width: 768px) {
        .nav-links { display: none; }
        .nav-mobile-search-btn { display: flex; }
        .nav-hamburger { display: flex; }
        .user-name { display: none; }
        .nav-inner { padding: 0 16px; }
    }
</style>

<header class="nav-root">
    <div class="nav-inner">

        {{-- ===== LOGO ===== --}}
        <a href="{{ route('home') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <span class="nav-logo-text">youssef<span>.sec</span></span>
        </a>

        {{-- ===== DESKTOP NAV ===== --}}
        <nav class="nav-links">
            <a href="{{ route('home') }}"
               class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                ~/home
            </a>
            <a href="{{ route('posts.index') }}"
               class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}">
                ~/notes
            </a>
            <a href="{{ route('about') }}"
               class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                ~/about
            </a>
        </nav>

        {{-- ===== RIGHT SECTION ===== --}}
        <div class="nav-right">

            {{-- Mobile search icon --}}
            <button class="nav-mobile-search-btn" id="mobile-search-toggle" aria-label="Search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
            </button>

            @auth
                {{-- User dropdown --}}
                <div style="position:relative;">
                    <button class="user-btn" id="user-menu-button" aria-expanded="false">
                        <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <svg class="user-chevron" id="user-menu-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>

                    <div class="user-dropdown" id="user-dropdown-menu">
                        {{-- Header --}}
                        <div class="dropdown-header">
                            <div class="dropdown-header-name">{{ auth()->user()->name }}</div>
                            <div class="dropdown-header-email">{{ auth()->user()->email }}</div>
                            <div class="dropdown-status">
                                <div class="status-dot"></div>
                                <span class="status-label">Online</span>
                            </div>
                        </div>

                        {{-- Links --}}
                        <div class="dropdown-section">
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                                    Admin Dashboard
                                </a>
                            @endif
                            <a href="{{ route('posts.bookmarks') }}" class="dropdown-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m19 21-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                                My Bookmarks
                            </a>
                            <a href="#" class="dropdown-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Profile
                            </a>
                            <a href="#" class="dropdown-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                                Settings
                            </a>
                        </div>

                        {{-- Logout --}}
                        <div class="dropdown-section">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item danger">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            {{-- Hamburger --}}
            <button class="nav-hamburger" id="nav-hamburger" aria-label="Menu">
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
            </button>

        </div>
    </div>

    {{-- ===== MOBILE SEARCH ===== --}}
    <div class="nav-mobile-search" id="mobile-search-container">
        <div class="mobile-search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text"
                   id="mobile-search"
                   class="mobile-search-input"
                   placeholder="Search notes...">
        </div>
    </div>

    {{-- ===== MOBILE NAV DRAWER ===== --}}
    <nav class="nav-mobile-drawer" id="nav-mobile-drawer">
        <a href="{{ route('home') }}"
           class="nav-mobile-link {{ request()->routeIs('home') ? 'active' : '' }}">
            ~/home
        </a>
        <a href="{{ route('posts.index') }}"
           class="nav-mobile-link {{ request()->routeIs('posts.index') ? 'active' : '' }}">
            ~/notes
        </a>
        <a href="{{ route('about') }}"
           class="nav-mobile-link {{ request()->routeIs('about') ? 'active' : '' }}">
            ~/about
        </a>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== USER DROPDOWN =====
    const userBtn     = document.getElementById('user-menu-button');
    const userMenu    = document.getElementById('user-dropdown-menu');
    const userChevron = document.getElementById('user-menu-chevron');

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = userMenu.classList.toggle('open');
            userBtn.setAttribute('aria-expanded', isOpen);
            if (userChevron) userChevron.classList.toggle('rotated', isOpen);
        });

        document.addEventListener('click', function (e) {
            if (!userBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.remove('open');
                userBtn.setAttribute('aria-expanded', false);
                if (userChevron) userChevron.classList.remove('rotated');
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                userMenu.classList.remove('open');
                if (userChevron) userChevron.classList.remove('rotated');
            }
        });
    }

    // ===== MOBILE SEARCH =====
    const mobileSearchToggle    = document.getElementById('mobile-search-toggle');
    const mobileSearchContainer = document.getElementById('mobile-search-container');

    if (mobileSearchToggle && mobileSearchContainer) {
        mobileSearchToggle.addEventListener('click', function () {
            mobileSearchContainer.classList.toggle('open');
            if (mobileSearchContainer.classList.contains('open')) {
                document.getElementById('mobile-search')?.focus();
            }
        });
    }

    // ===== HAMBURGER / MOBILE DRAWER =====
    const hamburger   = document.getElementById('nav-hamburger');
    const mobileDrawer = document.getElementById('nav-mobile-drawer');

    if (hamburger && mobileDrawer) {
        hamburger.addEventListener('click', function () {
            hamburger.classList.toggle('open');
            mobileDrawer.classList.toggle('open');
        });
    }

    // ===== SEARCH =====
    function setupSearch(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const q = this.value.trim();
                if (q) window.location.href = `{{ route('posts.index') }}?search=${encodeURIComponent(q)}`;
            }
        });
    }

    setupSearch('global-search');
    setupSearch('mobile-search');
});
</script>
