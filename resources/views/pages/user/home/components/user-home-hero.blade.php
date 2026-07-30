<section class="relative h-[85vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="{{ asset('images/culture/culture08.jpg') }}" 
             alt="Madura Beach" 
             data-parallax
             data-parallax-speed="0.25"
             data-parallax-scale="1.35"
             class="w-full h-full object-cover origin-center will-change-transform">
        <div class="absolute inset-0 bg-[#0a2622]/30 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a2622]/60 via-[#0a2622]/20 to-gray-50"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 w-full max-w-4xl px-4 text-center mx-auto">
        
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white drop-shadow-[0_4px_4px_rgba(0,0,0,0.4)] leading-tight tracking-wide">
            Jelajahi 
            <span class="text-white">Madura</span>
        </h1>
        <div class="text-2xl md:text-4xl lg:text-5xl font-bold text-[#ed8a53] mb-8 drop-shadow-[0_4px_4px_rgba(0,0,0,0.4)] leading-tight tracking-wide min-h-[1.3em] mt-2">
            <span class="inline-block"
                  data-typing='["Permata Tersembunyi", "Wisata Bahari & Alam", "Kuliner Otentik Khas", "Warisan Budaya"]'
                  data-typing-speed="90"
                  data-typing-pause="2200"
                  data-typing-delete-speed="40"
                  data-loop="true">
                <span class="typing-target"></span><span class="inline-block w-[3px] md:w-[4px] h-[0.85em] bg-amber-400 ml-1 translate-y-[2px] animate-typing-cursor align-middle"></span>
            </span> 
        </div>


        <form action="/search" method="GET" class="relative max-w-3xl mx-auto bg-white/95 backdrop-blur-md border border-white/60 rounded-full p-1.5 flex items-center shadow-2xl group transition-transform hover:scale-[1.01]">
            
            <div class="pl-4 pr-2 flex items-center pointer-events-none text-gray-400">
                <x-lucide-search class="w-5 h-5 stroke-[2.5]" />
            </div>
            
            <input type="text" 
                   name="q"
                   placeholder="Cari Kuliner, Wisata, atau UMKM..." 
                   autocomplete="off"
                   class="block w-full h-11 bg-transparent border-none text-[#0f172a] placeholder-gray-400 focus:outline-none text-sm md:text-base text-left pl-2 pr-24">
            
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 h-10 px-8 bg-[#af4926] hover:bg-[#8e381b] text-white text-sm font-semibold rounded-full transition-all duration-200 shadow-md">
                Cari
            </button>
            
        </form>
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent"></div>
</section>