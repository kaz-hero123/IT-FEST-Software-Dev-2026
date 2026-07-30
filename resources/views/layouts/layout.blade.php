<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jelajah Madura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/chat-support.js') }}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/js/app.js'])


    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@700,500,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Satoshi', sans-serif; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Satoshi', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    @vite(['resources/js/app.js'])
</head>
<body class="bg-gray-50 text-[#0a2622] min-h-screen flex flex-col">
    {{-- Main Navbar --}}
    @yield('navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-footer />
    <x-admin-chat />
    
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof window.initParallaxScroll === 'function') {
                window.initParallaxScroll();
            } else {
                const parallaxElements = document.querySelectorAll('[data-parallax]');
                if (!parallaxElements.length) return;
                let ticking = false;

                function updateParallax() {
                    const windowHeight = window.innerHeight;
                    parallaxElements.forEach((el) => {
                        const speed = parseFloat(el.dataset.parallaxSpeed) || 0.25;
                        const scale = parseFloat(el.dataset.parallaxScale) || 1.35;
                        const parent = el.closest('section') || el.closest('.group') || el.parentElement;
                        if (!parent) return;

                        const rect = parent.getBoundingClientRect();
                        if (rect.bottom >= -100 && rect.top <= windowHeight + 100) {
                            const centerY = rect.top + rect.height / 2 - windowHeight / 2;
                            const maxTranslate = Math.max(0, (rect.height * (scale - 1)) / 2 - 10);
                            const rawTranslate = centerY * speed;
                            const translateY = Math.max(-maxTranslate, Math.min(maxTranslate, rawTranslate));

                            el.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0) scale(${scale})`;
                        }
                    });
                    ticking = false;
                }

                function onScroll() {
                    if (!ticking) {
                        requestAnimationFrame(updateParallax);
                        ticking = true;
                    }
                }

                window.addEventListener('scroll', onScroll, { passive: true });
                window.addEventListener('resize', onScroll, { passive: true });
                updateParallax();
            }
        });
    </script>
</body>




</html>
