<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Logo Container -->
            <div class="flex items-center space-x-3">
                <div class="w-[45px] h-[35px] flex-shrink-0">
                    <img src="{{ asset('images/jelajah_madura_logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <!-- Text Logo -->
                <a href="/" class="flex items-center text-[18px] font-bold tracking-tight">
                    <span class="text-[#0a2622]">Jelajah</span>
                    <span class="text-[#ed8a53] ml-1">Madura</span>
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
                <div class="hidden md:flex items-center space-x-8 text-[15px] font-medium">
                    <!-- Active State for Home -->
                    <a href="/" class="{{ request()->is('/') ? 'text-[#ed8a53] border-b-2 border-[#ed8a53] pb-1' : 'text-gray-900 hover:text-[#ed8a53]' }} transition-colors">Home</a>
                    <a href="/about" class="{{ request()->is('about') ? 'text-[#ed8a53] border-b-2 border-[#ed8a53] pb-1' : 'text-gray-900 hover:text-[#ed8a53]' }} transition-colors">About</a>
                    <a href="/explore" class="{{ request()->is('explore*') ? 'text-[#ed8a53] border-b-2 border-[#ed8a53] pb-1' : 'text-gray-900 hover:text-[#ed8a53]' }} transition-colors">Explore</a>
                    <a href="/contact" class="{{ request()->is('contact') ? 'text-[#ed8a53] border-b-2 border-[#ed8a53] pb-1' : 'text-gray-900 hover:text-[#ed8a53]' }} transition-colors">Contact</a>
                    
                    <!-- Gradient Button -->
                    <a href="/promosi" class="bg-gradient-to-r from-[#ed8a53] to-[#0a2622] text-white px-6 py-2.5 rounded-full hover:opacity-90 transition-all shadow-sm font-semibold text-sm">
                        Promosikan Tempatmu
                    </a>
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
        <a href="/" class="block text-sm {{ request()->is('/') ? 'font-semibold text-[#ed8a53]' : 'font-medium text-gray-600' }} py-2">Home</a>
        <a href="/about" class="block text-sm {{ request()->is('about') ? 'font-semibold text-[#ed8a53]' : 'font-medium text-gray-600' }} py-2">About</a>
        <a href="/explore" class="block text-sm {{ request()->is('explore*') ? 'font-semibold text-[#ed8a53]' : 'font-medium text-gray-600' }} py-2">Explore</a>
        <a href="/contact" class="block text-sm {{ request()->is('contact') ? 'font-semibold text-[#ed8a53]' : 'font-medium text-gray-600' }} py-2">Contact</a>
        <div class="pt-2 border-t border-gray-100">
            <a href="/promosi" class="block w-full text-center bg-gradient-to-r from-[#ed8a53] to-[#0a2622] text-white py-3 rounded-xl font-semibold">
                Promosikan Tempatmu
            </a>
        </div>
    </div>
</nav>