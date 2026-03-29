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
        /* gradient background from your original section */
        .gradient-bg {
                background: linear-gradient(135deg, #1e3c72 0%, #000000 100%);
            }
        /* canvas positioned exactly behind the content */
        #particle-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: block;
            pointer-events: none;
            /* lets mouse events pass through to the section */
            z-index: -1;
        }

        /* make sure container stacks content above canvas */
        .hero-container {
            position: relative;
            isolation: isolate;
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        /* tiny extra: subtle transition on link */
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
        // Simple search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[type="text"]');

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        window.location.href =
                            `{{ route('posts.index') }}?search=${encodeURIComponent(query)}`;
                    }
                }
            });

            // Category card click (already handled by anchor tags now)
        });

        (function() {
            // ---------- canvas setup ----------
            const canvas = document.getElementById('particle-canvas');
            const ctx = canvas.getContext('2d');
            let width, height;
            let particles = [];
            let mouseX = -1000,
                mouseY = -1000; // start off canvas
            let animationFrame;

            // ---------- particle parameters (bee‑house style) ----------
            const PARTICLE_COUNT = 620;
            const MAX_RADIUS = 1.2;
            const MIN_RADIUS = 0.5;
            const GLOW_SIZE = 62; // distance from mouse that gets fully colored
            const BASE_OPACITY = 1; // subtle background particles
            const COLOR_INTENSITY = 1; // saturation when near mouse

            // palette – warm / honey / flower like a bee meadow
            // const colorPalette = [
            //     {r:255, g:215, b:0},   // honey gold
            //     {r:255, g:165, b:0},   // orange
            //     {r:255, g:230, b:100}, // light yellow
            //     {r:220, g:180, b:40},  // dark gold
            //     {r:200, g:230, b:255}, // ice (rare, for variety)
            //     {r:180, g:220, b:90},  // fresh green
            // ];

            // palette – star colors like celestial bodies
            const colorPalette = [{
                    r: 255,
                    g: 255,
                    b: 255
                }, // pure white (main sequence)
                {
                    r: 255,
                    g: 230,
                    b: 200
                }, // warm white (procyon)
                {
                    r: 255,
                    g: 200,
                    b: 150
                }, // orange star (betelgeuse)
                {
                    r: 200,
                    g: 220,
                    b: 255
                }, // blue-white (rigel)
                {
                    r: 255,
                    g: 250,
                    b: 180
                }, // yellow star (sun)
                {
                    r: 230,
                    g: 180,
                    b: 255
                }, // purple star (unusual)
                {
                    r: 180,
                    g: 220,
                    b: 255
                }, // blue star (spica)
                {
                    r: 255,
                    g: 180,
                    b: 180
                }, // red dwarf
            ];

            // pre‑assign a random color index & base radius to each particle
            class Particle {
                constructor(x, y) {
                    this.x = x;
                    this.y = y;
                    this.colorIndex = Math.floor(Math.random() * colorPalette.length);
                    this.baseRadius = MIN_RADIUS + Math.random() * (MAX_RADIUS - MIN_RADIUS);
                    // random jitter offsets for "alive" movement – very subtle drift
                    this.driftX = (Math.random() - 0.5) * 0.5;
                    this.driftY = (Math.random() - 0.5) * 0.5;
                }
                // update position very slowly (like floating bees)
                update(width, height) {
                    this.x += this.driftX;
                    this.y += this.driftY;
                    // wrap around edges softly (so they never leave)
                    if (this.x < 0) this.x = width;
                    if (this.x > width) this.x = 0;
                    if (this.y < 0) this.y = height;
                    if (this.y > height) this.y = 0;
                }
            }

            // initialize particles randomly
            function initParticles(w, h) {
                particles = [];
                for (let i = 0; i < PARTICLE_COUNT; i++) {
                    let x = Math.random() * w;
                    let y = Math.random() * h;
                    particles.push(new Particle(x, y));
                }
            }

            // resize handler
            function resizeCanvas() {
                width = window.innerWidth;
                height = document.querySelector('.hero-container').offsetHeight;
                // but we need full section height; container uses py-xx so it's fine
                // fallback: use window innerHeight? but section has fixed padding. better get section height
                const section = document.querySelector('.gradient-bg');
                if (section) {
                    height = section.offsetHeight;
                    width = section.offsetWidth;
                } else {
                    width = window.innerWidth;
                    height = window.innerHeight * 0.8; // fallback
                }
                canvas.width = width;
                canvas.height = height;

                // reinitialize particles if needed (keep roughly same count)
                if (particles.length === 0) {
                    initParticles(width, height);
                } else {
                    // adjust particles that might be out of bounds after extreme resize?
                    // just relocate some if count is weird? we keep them, they will wrap.
                }
            }

            // mouse move listener – update mouse coords relative to section
            function handleMouseMove(e) {
                const rect = canvas.getBoundingClientRect();
                // calculate mouse position inside canvas
                mouseX = e.clientX - rect.left;
                mouseY = e.clientY - rect.top;
                // clamp to canvas region (avoid colored flashes outside)
                if (mouseX < 0 || mouseX > width || mouseY < 0 || mouseY > height) {
                    mouseX = -1000; // off canvas -> no coloring
                    mouseY = -1000;
                }
            }

            // mouse leave – reset color activation
            function handleMouseLeave() {
                mouseX = -1000;
                mouseY = -1000;
            }

            // draw each particle with dynamic color based on distance to mouse
            function drawParticles() {
                if (!ctx || width === 0 || height === 0) return;

                ctx.clearRect(0, 0, width, height);

                // loop through particles
                for (let p of particles) {
                    // calculate distance to mouse
                    let dist = Math.hypot(p.x - mouseX, p.y - mouseY);
                    // influence factor: 1 if distance < GLOW_SIZE, then fades to 0 after
                    let influence = 0;
                    if (dist < GLOW_SIZE) {
                        influence = 1 - (dist / GLOW_SIZE); // 1 at center, 0 at edge
                        // smooth curve
                        influence = Math.pow(influence, 0.8); // a bit more gradual
                    } else if (dist < GLOW_SIZE * 2) {
                        // small feather outside main radius
                        influence = Math.max(0, 1 - (dist - GLOW_SIZE) / GLOW_SIZE) * 0.2;
                    } else {
                        influence = 0;
                    }

                    // base color from palette
                    const col = colorPalette[p.colorIndex];
                    // mix with white/increased luminosity based on influence
                    let r = col.r;
                    let g = col.g;
                    let b = col.b;

                    // if influenced, brighten and saturate (bee glow)
                    if (influence > 0.01) {
                        // toward vibrant: boost saturation and brightness
                        r = Math.min(255, col.r + 60 * influence);
                        g = Math.min(255, col.g + 50 * influence);
                        b = Math.min(255, col.b + 30 * influence);
                    } else {
                        // desaturated background (semi‑transparent grayish)
                        // keep hint of original hue, but very soft
                        const gray = 130;
                        r = col.r * 0.25 + gray * 0.75;
                        g = col.g * 0.25 + gray * 0.75;
                        b = col.b * 0.25 + gray * 0.75;
                    }

                    // radius also increases near mouse? optional: tiny effect
                    let radius = p.baseRadius;
                    if (influence > 0) {
                        radius += influence * 2.2; // subtle swelling
                    }

                    // opacity: base + extra glow
                    let alpha = BASE_OPACITY + influence * 0.5;
                    alpha = Math.min(0.95, alpha);

                    ctx.beginPath();
                    ctx.arc(p.x, p.y, radius, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(${Math.round(r)}, ${Math.round(g)}, ${Math.round(b)}, ${alpha})`;
                    ctx.fill();

                    // tiny extra glow for highly influenced particles
                    if (influence > 0.7) {
                        ctx.shadowColor = `rgba(255, 120, 140, 0.6)`;
                        ctx.shadowBlur = 12;
                        ctx.fill(); // overdraw with same style? but careful: we already filled, so we can re-fill? no
                        // better to draw an extra ring or reset shadow. quick fix: draw a second larger blur on top
                        ctx.shadowBlur = 0; // avoid stacking
                    }
                    ctx.shadowBlur = 0; // reset
                }

                // // optional: extra floating "bee glitter" near mouse – few tiny stars
                // if (mouseX > 0 && mouseY > 0 && mouseX < width && mouseY < height) {
                //     for (let i = 0; i < 3; i++) {
                //         let offX = mouseX + (Math.random() - 0.5) * 30;
                //         let offY = mouseY + (Math.random() - 0.5) * 30;
                //         ctx.beginPath();
                //         ctx.arc(offX, offY, 1.2 + Math.random()*2, 0, 2 * Math.PI);
                //         ctx.fillStyle = `rgba(255, 255, 220, 0.7)`;
                //         ctx.fill();
                //     }
                // }
            }

            // animation loop – update particles and draw
            function animate() {
                if (!width || !height) {
                    // retry resize if dimensions missing
                    resizeCanvas();
                }
                // slowly drift particles
                for (let p of particles) {
                    p.update(width, height);
                }
                drawParticles();
                animationFrame = requestAnimationFrame(animate);
            }

            // attach events
            window.addEventListener('resize', () => {
                resizeCanvas();
                // reinitialize particles on resize to keep density nice (optional but smoother)
                // keep existing particles? we prefer to regenerate for better distribution
                initParticles(width, height);
            });

            const section = document.querySelector('.gradient-bg');
            section.addEventListener('mousemove', handleMouseMove);
            section.addEventListener('mouseleave', handleMouseLeave);

            // initial call
            resizeCanvas();
            initParticles(width, height);
            // start animation
            animate();

            // (optional) touch devices: use touchmove
            section.addEventListener('touchmove', (e) => {
                e.preventDefault();
                const touch = e.touches[0];
                const rect = canvas.getBoundingClientRect();
                mouseX = touch.clientX - rect.left;
                mouseY = touch.clientY - rect.top;
                if (mouseX < 0 || mouseX > width || mouseY < 0 || mouseY > height) {
                    mouseX = -1000;
                    mouseY = -1000;
                }
            }, {
                passive: false
            });
            section.addEventListener('touchend', () => {
                mouseX = -1000;
                mouseY = -1000;
            });
        })();
    </script>
    @yield('scripts')

</body>

</html>
