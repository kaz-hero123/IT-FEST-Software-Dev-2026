<section class="relative h-[85vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/dashboard.png') }}" 
             alt="Madura Beach" 
             class="w-full h-full object-cover">
        <!-- Green Gradient Overlay -->
        <div class="absolute inset-0 bg-[#0a2622]/30 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a2622]/60 via-[#0a2622]/20 to-gray-50"></div>


    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-3xl px-4 text-center">
        <h1 class="text-[32px] md:text-[40px] font-bold text-white mb-8 drop-shadow-lg leading-tight">
            Jelajahi Permata <br> Tersembunyi Madura
        </h1>

        <!-- Search Bar with Glassmorphism -->
        <div class="relative group max-w-2xl mx-auto">
            <input type="text" 
                   placeholder="Cari Kuliner, Wisata, atau UMKM..." 
                   class="block w-full h-[46px] px-14 bg-white/20 backdrop-blur-md border border-white rounded-full text-white placeholder-white/80 placeholder:text-[12px] focus:outline-none focus:ring-4 focus:ring-white/30 focus:bg-white/40 transition-all text-sm shadow-2xl">
            
            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none z-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-white drop-shadow-md"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>

        </div>


    </div>

    <!-- Bottom Vignette Fade to White -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent"></div>
</section>
