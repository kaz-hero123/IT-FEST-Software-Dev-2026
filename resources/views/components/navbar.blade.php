<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Container -->
            <div class="flex items-center space-x-2">
                <!-- SVG Icon (Simplified version of the logo in image) -->
                <div class="w-[39px] h-[29px] flex-shrink-0">
                    <img src="{{ asset('images/jelajah_madura_logo.png') }}" alt="Logo" class="w-full h-full object-contain">

                </div>
                <!-- Text -->
                <a href="/" class="flex items-center text-[16px] font-bold tracking-tight">
                    <span class="text-[#0a2622]">Jelajah</span>
                    <span class="text-[#ff8a65] ml-1">Madura</span>
                </a>
            </div>

            <!-- Header Right: Toggle and Desktop Menu -->
            <div class="flex items-center">
                <!-- Hamburger Button (Visible on Mobile) -->
                <button @click="open = !open" class="text-[#0a2622] p-2 focus:outline-none md:hidden">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                    <a href="/" class="text-[#0a2622] hover:text-[#ff8a65] transition-colors">Beranda</a>
                    <a href="/explore" class="text-gray-500 hover:text-[#ff8a65] transition-colors">Jelajahi</a>
                    <a href="/contact" class="text-gray-500 hover:text-[#ff8a65] transition-colors">Kontak</a>
                    <a href="/login" class="bg-[#0a2622] text-white px-5 py-2 rounded-full hover:bg-opacity-90 transition-all">Login</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Alpine.js) -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-white border-t border-gray-50 px-4 py-4 space-y-3" style="display: none;">
        <a href="/" class="block text-sm font-semibold text-[#0a2622] py-2">Beranda</a>
        <a href="/explore" class="block text-sm font-medium text-gray-600 py-2">Jelajahi</a>
        <a href="/contact" class="block text-sm font-medium text-gray-600 py-2">Kontak</a>
        <div class="pt-2 border-t border-gray-100">
            <a href="/login" class="block w-full text-center bg-[#0a2622] text-white py-3 rounded-xl font-semibold">Login</a>
        </div>
    </div>
</nav>
