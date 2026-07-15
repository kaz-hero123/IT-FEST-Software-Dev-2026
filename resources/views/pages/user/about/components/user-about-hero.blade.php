<section class="relative h-[60vh] md:h-[75vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/culture/culture03.jpg') }}" 
             alt="culture" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#0a2622]/40 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a2622]/60 via-[#0a2622]/30 to-gray-50/20"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 w-full max-w-4xl px-4 text-center mx-auto mt-4">
        <!-- Badge Atas -->
        <span class="inline-block px-4 py-1.5 mb-5 text-xs font-semibold tracking-wider uppercase border border-white/40 rounded-full bg-white/10 backdrop-blur-sm text-white">
            Platform Digital Terintegrasi
        </span>

        <!-- Heading Utama -->
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-6 drop-shadow-[0_4px_4px_rgba(0,0,0,0.4)] leading-tight tracking-wide">
            Tentang Jelajah Madura
        </h1>

        <!-- Sub-deskripsi -->
        <p class="text-sm md:text-lg text-white/90 max-w-3xl mx-auto font-medium leading-relaxed drop-shadow-sm">
            Menghubungkan keindahan budaya, pesona alam, dan potensi lokal Madura melalui ekosistem pariwisata digital yang cerdas dan terkurasi.
        </p>
    </div>

    <!-- Gradient Overlay bawah untuk smooth transition -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent"></div>
</section>