<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <!-- Category Icons Grid -->
        <div x-data="{ active: null }" class="grid grid-cols-4 gap-4 mb-16 w-full">
            <!-- Kuliner -->
            <div @click="active = 'kuliner'" class="text-center group cursor-pointer">
                <div :class="active === 'kuliner' ? 'bg-[#0a2622] text-white shadow-lg shadow-[#0a2622]/20' : 'bg-gray-50 border border-gray-100 text-gray-600'" 
                     class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <i data-lucide="utensils-crosses" class="w-7 h-7"></i>
                </div>
                <span :class="active === 'kuliner' ? 'font-bold text-[#0a2622]' : 'font-semibold text-gray-500'" class="text-xs transition-colors">Kuliner</span>
            </div>
            <!-- Spot Foto -->
            <div @click="active = 'foto'" class="text-center group cursor-pointer">
                <div :class="active === 'foto' ? 'bg-[#0a2622] text-white shadow-lg shadow-[#0a2622]/20' : 'bg-gray-50 border border-gray-100 text-gray-600'" 
                     class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <i data-lucide="camera" class="w-7 h-7"></i>
                </div>
                <span :class="active === 'foto' ? 'font-bold text-[#0a2622]' : 'font-semibold text-gray-500'" class="text-xs transition-colors">Spot Foto</span>
            </div>
            <!-- UMKM -->
            <div @click="active = 'umkm'" class="text-center group cursor-pointer">
                <div :class="active === 'umkm' ? 'bg-[#0a2622] text-white shadow-lg shadow-[#0a2622]/20' : 'bg-gray-50 border border-gray-100 text-gray-600'" 
                     class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <i data-lucide="store" class="w-7 h-7"></i>
                </div>
                <span :class="active === 'umkm' ? 'font-bold text-[#0a2622]' : 'font-semibold text-gray-500'" class="text-xs transition-colors">UMKM</span>
            </div>
            <!-- Wisata -->
            <div @click="active = 'wisata'" class="text-center group cursor-pointer">
                <div :class="active === 'wisata' ? 'bg-[#0a2622] text-white shadow-lg shadow-[#0a2622]/20' : 'bg-gray-50 border border-gray-100 text-gray-600'" 
                     class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <i data-lucide="send" class="w-7 h-7"></i>
                </div>
                <span :class="active === 'wisata' ? 'font-bold text-[#0a2622]' : 'font-semibold text-gray-500'" class="text-xs transition-colors">Wisata</span>
            </div>
        </div>

        <!-- Featured Image (Full Width of container) -->
        <div class="mb-8">
            <img src="{{ asset('images/pantai.png') }}" 
                 alt="Madura Vision" 
                 class="rounded-[2.5rem] w-full object-cover">
        </div>

        <!-- Vision Content (Left Aligned with Image) -->
        <div class="max-w-2xl">
            <span class="inline-block px-4 py-1.5 bg-[#e0f2f1] text-[#0a2622] text-[10px] font-bold rounded-full mb-6">
                Visi Madura
            </span>
            
            <h2 class="text-[32px] md:text-[40px] font-bold text-[#0a2622] leading-tight mb-4">
                Mewujudkan Madura Sebagai <br>
                <span class="text-[#ff8a65]">Smart Island</span>
            </h2>

            <p class="text-gray-500 leading-relaxed mb-10 text-[14px]">
                Lebih dari sekadar destinasi wisata, Madura sedang bertransformasi mengintegrasikan warisan budaya yang kaya dengan inovasi digital. Menghubungkan potensi lokal ke panggung global melalui ekosistem pariwisata yang cerdas dan berkelanjutan.
            </p>

            <!-- Features Checklist -->
            <ul class="space-y-4 mb-10">
                <li class="flex items-center space-x-3 text-[#0a2622] font-semibold text-sm">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-[#ff8a65]"></i>
                    <span>Pemberdayaan UMKM Digital</span>
                </li>
                <li class="flex items-center space-x-3 text-[#0a2622] font-semibold text-sm">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-[#ff8a65]"></i>
                    <span>Pelestarian Budaya & Alam</span>
                </li>
                <li class="flex items-center space-x-3 text-[#0a2622] font-semibold text-sm">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-[#ff8a65]"></i>
                    <span>Pariwisata Terintegrasi</span>
                </li>
            </ul>

            <a href="#" class="inline-flex items-center font-bold text-[#0a2622] hover:text-[#ff8a65] transition-colors group">
                Pelajari Lebih Lanjut
                <i data-lucide="move-right" class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
