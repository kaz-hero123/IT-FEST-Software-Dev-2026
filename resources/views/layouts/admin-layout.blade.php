<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal - Madura Smart Island')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@700,500,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Satoshi', sans-serif; }
        #sidebar { transition: transform 0.25s ease; }
        #sidebar-overlay { transition: opacity 0.25s ease; }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-[#f5f5f3]">

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/40 z-20 hidden opacity-0"
         onclick="closeSidebar()">
    </div>

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Mobile Top Bar --}}
        <header class="flex md:hidden items-center justify-between px-4 py-3 bg-white border-b border-gray-200 shrink-0">
            <button onclick="openSidebar()" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-[14px] font-bold text-[#0f172a]">Admin Portal</span>
            <div class="w-8 h-8 rounded-full overflow-hidden">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=100&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto bg-white flex flex-col">
            @yield('content')
        </main>
    </div>

    <script>
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden', 'opacity-0');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
        }
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            setTimeout(() => overlay.classList.add('hidden'), 250);
        }
    </script>
</body>
</html>
