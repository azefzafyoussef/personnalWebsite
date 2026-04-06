<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'isFake - Share Knowledge')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
    <style>
        /* ---- FIX: prevent horizontal overflow on mobile ---- */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e3c72 0%, #000000 100%);
        }

        #particle-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
            pointer-events: none;
            z-index: -1;
        }

        .hero-container {
            position: relative;
            isolation: isolate;
            overflow: hidden; /* ---- FIX: clamp children to container ---- */
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        a {
            transition: all 0.2s ease;
        }
    </style>
</head>

<body class="hero-container gradient-bg">
    <canvas id="particle-canvas"></canvas>

    @if (app()->getLocale() === 'ar')
        @include('partials.header_ar')
    @else
        @include('partials.header')
    @endif

    @yield('content')

    {{-- @include('partials.footer') --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('input[type="text"]');
            if (searchInput) {
                searchInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        const query = this.value.trim();
                        if (query) {
                            window.location.href =
                                `{{ route('posts.index') }}?search=${encodeURIComponent(query)}`;
                        }
                    }
                });
            }
        });

        (function () {
            const canvas = document.getElementById('particle-canvas');
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];
            let mouseX = -1000, mouseY = -1000;
            let animationFrame;

            const PARTICLE_COUNT = 620;
            const MAX_RADIUS     = 1.2;
            const MIN_RADIUS     = 0.5;
            const GLOW_SIZE      = 62;
            const BASE_OPACITY   = 1;

            const colorPalette = [
                { r: 255, g: 255, b: 255 },
                { r: 255, g: 230, b: 200 },
                { r: 255, g: 200, b: 150 },
                { r: 200, g: 220, b: 255 },
                { r: 255, g: 250, b: 180 },
                { r: 230, g: 180, b: 255 },
                { r: 180, g: 220, b: 255 },
                { r: 255, g: 180, b: 180 },
            ];

            class Particle {
                constructor(x, y) {
                    this.x          = x;
                    this.y          = y;
                    this.colorIndex = Math.floor(Math.random() * colorPalette.length);
                    this.baseRadius = MIN_RADIUS + Math.random() * (MAX_RADIUS - MIN_RADIUS);
                    this.driftX     = (Math.random() - 0.5) * 0.5;
                    this.driftY     = (Math.random() - 0.5) * 0.5;
                }
                update(w, h) {
                    this.x += this.driftX;
                    this.y += this.driftY;
                    if (this.x < 0)  this.x = w;
                    if (this.x > w)  this.x = 0;
                    if (this.y < 0)  this.y = h;
                    if (this.y > h)  this.y = 0;
                }
            }

            function initParticles(w, h) {
                particles = [];
                for (let i = 0; i < PARTICLE_COUNT; i++) {
                    particles.push(new Particle(Math.random() * w, Math.random() * h));
                }
            }

            function resizeCanvas() {
                const section = document.querySelector('.gradient-bg');
                if (section) {
                    width  = section.offsetWidth;
                    height = section.offsetHeight;
                } else {
                    width  = window.innerWidth;
                    height = window.innerHeight;
                }
                canvas.width  = width;
                canvas.height = height;
            }

            function handleMouseMove(e) {
                const rect = canvas.getBoundingClientRect();
                mouseX = e.clientX - rect.left;
                mouseY = e.clientY - rect.top;
                if (mouseX < 0 || mouseX > width || mouseY < 0 || mouseY > height) {
                    mouseX = -1000;
                    mouseY = -1000;
                }
            }

            function handleMouseLeave() {
                mouseX = -1000;
                mouseY = -1000;
            }

            function drawParticles() {
                if (!ctx || width === 0 || height === 0) return;
                ctx.clearRect(0, 0, width, height);

                for (let p of particles) {
                    let dist      = Math.hypot(p.x - mouseX, p.y - mouseY);
                    let influence = 0;
                    if (dist < GLOW_SIZE) {
                        influence = Math.pow(1 - dist / GLOW_SIZE, 0.8);
                    } else if (dist < GLOW_SIZE * 2) {
                        influence = Math.max(0, 1 - (dist - GLOW_SIZE) / GLOW_SIZE) * 0.2;
                    }

                    const col = colorPalette[p.colorIndex];
                    let r, g, b;

                    if (influence > 0.01) {
                        r = Math.min(255, col.r + 60 * influence);
                        g = Math.min(255, col.g + 50 * influence);
                        b = Math.min(255, col.b + 30 * influence);
                    } else {
                        const gray = 130;
                        r = col.r * 0.25 + gray * 0.75;
                        g = col.g * 0.25 + gray * 0.75;
                        b = col.b * 0.25 + gray * 0.75;
                    }

                    let radius = p.baseRadius + (influence > 0 ? influence * 2.2 : 0);
                    let alpha  = Math.min(0.95, BASE_OPACITY + influence * 0.5);

                    ctx.beginPath();
                    ctx.arc(p.x, p.y, radius, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(${Math.round(r)}, ${Math.round(g)}, ${Math.round(b)}, ${alpha})`;
                    ctx.fill();
                    ctx.shadowBlur = 0;
                }
            }

            function animate() {
                if (!width || !height) resizeCanvas();
                for (let p of particles) p.update(width, height);
                drawParticles();
                animationFrame = requestAnimationFrame(animate);
            }

            window.addEventListener('resize', () => {
                resizeCanvas();
                initParticles(width, height);
            });

            const section = document.querySelector('.gradient-bg');
            section.addEventListener('mousemove',  handleMouseMove);
            section.addEventListener('mouseleave', handleMouseLeave);

            resizeCanvas();
            initParticles(width, height);
            animate();

            // ---- FIX: passive: true so native scroll is never blocked ----
            section.addEventListener('touchmove', (e) => {
                const touch = e.touches[0];
                const rect  = canvas.getBoundingClientRect();
                mouseX = touch.clientX - rect.left;
                mouseY = touch.clientY - rect.top;
                if (mouseX < 0 || mouseX > width || mouseY < 0 || mouseY > height) {
                    mouseX = -1000;
                    mouseY = -1000;
                }
            }, { passive: true }); // no preventDefault — lets scroll work normally

            section.addEventListener('touchend', () => {
                mouseX = -1000;
                mouseY = -1000;
            });
        })();
    </script>
    @yield('scripts')

</body>

</html>
