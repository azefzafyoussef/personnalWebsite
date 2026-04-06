@extends('layouts.app')
@section('title', 'Youssef Azefzaf - Cybersecurity Consultant')
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

        .hero-root {
            background: var(--bg);
            font-family: 'Syne', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* === GRID BACKGROUND === */
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(30, 45, 69, 0.45) 1px, transparent 1px),
                linear-gradient(90deg, rgba(30, 45, 69, 0.45) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
            pointer-events: none;
        }

        /* === GLOW ORBS === */
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }

        .hero-orb-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 194, 255, 0.12) 0%, transparent 70%);
            top: -100px;
            left: -100px;
        }

        .hero-orb-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(123, 97, 255, 0.1) 0%, transparent 70%);
            bottom: -80px;
            right: 20%;
        }

        /* === SCAN LINE ANIMATION === */
        .hero-scanline {
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(0deg,
                    transparent,
                    transparent 2px,
                    rgba(0, 194, 255, 0.015) 2px,
                    rgba(0, 194, 255, 0.015) 4px);
            pointer-events: none;
            animation: scanMove 8s linear infinite;
        }

        @keyframes scanMove {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 0 100px;
            }
        }

        /* === CANVAS FOR PARTICLES === */
        #particle-canvas {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 1;
        }

        /* === LAYOUT === */
        .hero-inner {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            min-height: 100vh;
        }

        /* === LEFT CONTENT === */
        .hero-left {
            flex: 1;
            max-width: 560px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 194, 255, 0.08);
            border: 1px solid rgba(0, 194, 255, 0.25);
            border-radius: 4px;
            padding: 5px 14px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            color: var(--accent);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .hero-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
            animation: blink 1.8s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.2;
            }
        }

        .hero-headline {
            font-size: clamp(36px, 5vw, 62px);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -0.02em;
            color: #fff;
            margin-bottom: 20px;
        }

        .hero-headline .accent {
            color: var(--accent);
        }

        .hero-headline .accent2 {
            color: var(--accent2);
        }

        .hero-sub {
            font-size: 16px;
            line-height: 1.7;
            color: var(--text);
            margin-bottom: 40px;
            max-width: 480px;
        }

        /* === CTA BUTTONS === */
        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 52px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--accent);
            color: #0a0e17;
            padding: 13px 28px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
            letter-spacing: 0.01em;
        }

        .btn-primary:hover {
            background: #33ccff;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 194, 255, 0.3);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            color: var(--text);
            padding: 13px 28px;
            border-radius: 6px;
            border: 1px solid var(--border);
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-2px);
        }

        /* === STATS ROW === */
        .hero-stats {
            display: flex;
            gap: 36px;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .stat-value span {
            color: var(--accent);
        }

        .stat-label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .stat-divider {
            width: 1px;
            background: var(--border);
            align-self: stretch;
        }

        /* === RIGHT IMAGE === */
        .hero-right {
            flex-shrink: 0;
            position: relative;
        }

        .hero-img-wrap {
            position: relative;

            width: 515px;
            height: 683px;
            bottom: 3vh !important;
            /* left: 10vh; */
        }

        /* Corner brackets */
        .hero-img-wrap::before,
        .hero-img-wrap::after {
            content: '';
            position: absolute;
            width: 28px;
            height: 28px;
            z-index: 2;
            pointer-events: none;
        }

        .hero-img-wrap::before {
            top: -8px;
            left: -8px;
            border-top: 2px solid var(--accent);
            border-left: 2px solid var(--accent);
        }

        .hero-img-wrap::after {
            bottom: -8px;
            right: -8px;
            border-bottom: 2px solid var(--accent);
            border-right: 2px solid var(--accent);
        }

        .hero-img-corner-tr,
        .hero-img-corner-bl {
            position: absolute;
            width: 28px;
            height: 28px;
            z-index: 2;
        }

        .hero-img-corner-tr {
            top: -8px;
            right: -8px;
            border-top: 2px solid var(--accent2);
            border-right: 2px solid var(--accent2);
        }

        .hero-img-corner-bl {
            bottom: -8px;
            left: -8px;
            border-bottom: 2px solid var(--accent2);
            border-left: 2px solid var(--accent2);
        }

        .hero-img-bg {
            position: absolute;
            inset: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(0, 194, 255, 0.08), rgba(123, 97, 255, 0.06));
            border: 1px solid var(--border);
        }

        .hero-img-scan {
            position: absolute;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0.6;
            animation: scanY 3s ease-in-out infinite;
            z-index: 3;
            pointer-events: none;
        }

        @keyframes scanY {
            0% {
                top: 0%;
                opacity: 0;
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                top: 100%;
                opacity: 0;
            }
        }

        .hero-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            border-radius: 12px;
            position: relative;
            z-index: 1;
            display: block;
            transition: transform 0.4s ease;
        }

        .hero-img-wrap:hover .hero-photo {
            transform: scale(1.02);
        }

        /* Label tag on image */
        .hero-img-tag {
            position: absolute;
            bottom: -18px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 6px 16px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            color: var(--accent);
            white-space: nowrap;
            z-index: 4;
            letter-spacing: 0.08em;
        }

        /* === SCROLL INDICATOR === */
        .hero-scroll {
            position: absolute;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            z-index: 10;
        }

        .hero-scroll-line {
            width: 1px;
            height: 36px;
            background: linear-gradient(to bottom, var(--accent), transparent);
            animation: scrollPulse 2s ease-in-out infinite;
        }

        @keyframes scrollPulse {

            0%,
            100% {
                opacity: 0.3;
                transform: scaleY(1);
            }

            50% {
                opacity: 1;
                transform: scaleY(1.1);
            }
        }

        /* === RESPONSIVE === */
        @media (max-width: 900px) {
            .hero-root {
                overflow: hidden;
            }

            .hero-inner {
                flex-direction: column-reverse;
                padding: 60px 24px 100px;
                text-align: center;
                min-height: 100vh;
                overflow: hidden;
            }

            .hero-left {
                max-width: 100%;
            }

            .hero-cta,
            .hero-stats {
                justify-content: center;
            }

            /* THIS is the key fix — stop using fixed px dimensions */
            .hero-img-wrap {
                width: 280px;
                height: auto;
                aspect-ratio: 3 / 4;
                bottom: 0 !important;
            }

            .hero-photo {
                height: 100%;
            }

            .stat-divider {
                display: none;
            }
        }
    </style>

    <div class="hero-root">
        <div class="hero-grid"></div>
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-scanline"></div>
        <canvas id="particle-canvas"></canvas>

        <div class="hero-inner">

            {{-- LEFT: TEXT --}}
            <div class="hero-left">
                <div class="hero-badge">Cybersecurity Consultant</div>

                <h1 class="hero-headline">
                    {{ __('index.home-main-headline') }}
                </h1>

                <p class="hero-sub">
                    {{ __('index.home-subtext') }}
                </p>

                <div class="hero-cta">
                    <a href="{{ route('posts.index') }}" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        Start Exploring
                    </a>
                    <a href="{{ route('about') ?? '#' }}" class="btn-secondary">
                        About Me
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-value">0<span>-Day</span></div>
                        <div class="stat-label">RCE Found</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-value">150<span>+</span></div>
                        <div class="stat-label">CTF Machines</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-value">4K<span>+</span></div>
                        <div class="stat-label">RootMe Points</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-value">Top<span> 3%</span></div>
                        <div class="stat-label">TryHackMe</div>
                    </div>
                </div>
            </div>

            {{-- RIGHT: IMAGE --}}
            <div class="hero-right">
                <div class="hero-img-wrap">
                    <div class="hero-img-bg"></div>
                    <div class="hero-img-scan"></div>
                    <div class="hero-img-corner-tr"></div>
                    <div class="hero-img-corner-bl"></div>
                    <img src="YOUSSEF.png" alt="Youssef Azefzaf" class="hero-photo">
                    <div class="hero-img-tag">// youssef.azefzaf</div>
                </div>
            </div>

        </div>

        <div class="hero-scroll">
            <div class="hero-scroll-line"></div>
            scroll
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('particle-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            let W, H, particles = [],
                mouse = {
                    x: -999,
                    y: -999
                };

            function resize() {
                W = canvas.width = canvas.offsetWidth;
                H = canvas.height = canvas.offsetHeight;
            }
            resize();
            window.addEventListener('resize', resize);

            document.addEventListener('mousemove', e => {
                const r = canvas.getBoundingClientRect();
                mouse.x = e.clientX - r.left;
                mouse.y = e.clientY - r.top;
            });

            const COUNT = 55;

            for (let i = 0; i < COUNT; i++) {
                particles.push({
                    x: Math.random() * 1200,
                    y: Math.random() * 800,
                    vx: (Math.random() - 0.5) * 0.4,
                    vy: (Math.random() - 0.5) * 0.4,
                    r: Math.random() * 1.5 + 0.5,
                    alpha: Math.random() * 0.5 + 0.2
                });
            }

            function dist(a, b) {
                return Math.hypot(a.x - b.x, a.y - b.y);
            }

            function draw() {
                ctx.clearRect(0, 0, W, H);

                particles.forEach(p => {
                    p.x += p.vx;
                    p.y += p.vy;
                    if (p.x < 0 || p.x > W) p.vx *= -1;
                    if (p.y < 0 || p.y > H) p.vy *= -1;

                    // Mouse repulsion
                    const dm = dist(p, mouse);
                    if (dm < 100) {
                        const angle = Math.atan2(p.y - mouse.y, p.x - mouse.x);
                        p.vx += Math.cos(angle) * 0.04;
                        p.vy += Math.sin(angle) * 0.04;
                    }

                    // Dampen speed
                    p.vx *= 0.995;
                    p.vy *= 0.995;

                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(0, 194, 255, ${p.alpha})`;
                    ctx.fill();
                });

                // Draw lines between close particles
                for (let i = 0; i < particles.length; i++) {
                    for (let j = i + 1; j < particles.length; j++) {
                        const d = dist(particles[i], particles[j]);
                        if (d < 130) {
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            ctx.strokeStyle = `rgba(0, 194, 255, ${(1 - d / 130) * 0.15})`;
                            ctx.lineWidth = 0.5;
                            ctx.stroke();
                        }
                    }
                }

                requestAnimationFrame(draw);
            }

            draw();
        });
    </script>
@endsection
