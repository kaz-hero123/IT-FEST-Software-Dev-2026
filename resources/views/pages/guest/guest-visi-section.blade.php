<section class="py-16 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-6">
        <!-- Category Icons Grid -->
        <div x-data="{ active: null }" class="grid grid-cols-4 gap-4 mb-16 w-full">
            <!-- Kuliner -->
            <div @click="active = 'kuliner'" class="text-center group cursor-pointer">
                <div :class="active === 'kuliner' ? 'bg-[#0a2622] text-white shadow-lg shadow-[#0a2622]/20' : 'bg-gray-50 border border-gray-100 text-gray-600'" 
                     class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <x-lucide-utensils class="w-7 h-7" />
                </div>
                <span :class="active === 'kuliner' ? 'font-bold text-[#0a2622]' : 'font-semibold text-gray-500'" class="text-xs transition-colors">Kuliner</span>
            </div>
            <!-- Spot Foto -->
            <div @click="active = 'foto'" class="text-center group cursor-pointer">
                <div :class="active === 'foto' ? 'bg-[#0a2622] text-white shadow-lg shadow-[#0a2622]/20' : 'bg-gray-50 border border-gray-100 text-gray-600'" 
                     class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <x-lucide-camera class="w-7 h-7" />
                </div>
                <span :class="active === 'foto' ? 'font-bold text-[#0a2622]' : 'font-semibold text-gray-500'" class="text-xs transition-colors">Spot Foto</span>
            </div>
            <!-- UMKM -->
            <div @click="active = 'umkm'" class="text-center group cursor-pointer">
                <div :class="active === 'umkm' ? 'bg-[#0a2622] text-white shadow-lg shadow-[#0a2622]/20' : 'bg-gray-50 border border-gray-100 text-gray-600'" 
                     class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <x-lucide-store class="w-7 h-7" />
                </div>
                <span :class="active === 'umkm' ? 'font-bold text-[#0a2622]' : 'font-semibold text-gray-500'" class="text-xs transition-colors">UMKM</span>
            </div>
            <!-- Wisata -->
            <div @click="active = 'wisata'" class="text-center group cursor-pointer">
                <div :class="active === 'wisata' ? 'bg-[#0a2622] text-white shadow-lg shadow-[#0a2622]/20' : 'bg-gray-50 border border-gray-100 text-gray-600'" 
                     class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center transition-all duration-300">
                    <x-lucide-send class="w-7 h-7" />
                </div>
                <span :class="active === 'wisata' ? 'font-bold text-[#0a2622]' : 'font-semibold text-gray-500'" class="text-xs transition-colors">Wisata</span>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-12 lg:gap-16">
            
            <!-- MODE HP: Gambar Single Tampil di Atas dengan Glow Lebih Terang & Kompak -->
            <div class="relative w-full mb-8 md:hidden flex items-center justify-center">
                <!-- Glow Blur Background Mobile (Ukuran Kompak, Warna Lebih Menyala) -->
                <div class="absolute top-2 left-0 w-40 h-40 bg-[#124d45]/70 rounded-full blur-[40px] pointer-events-none"></div>
                <div class="absolute bottom-6 right-0 w-48 h-48 bg-[#ff8a65]/80 rounded-full blur-[40px] pointer-events-none"></div>
                
                <img src="{{ asset('images/pantai.png') }}" alt="Madura Vision Mobile" class="relative z-10 rounded-[2.5rem] w-full object-cover shadow-xl">
            </div>

            <!-- SISI KIRI (Teks Konten Visi) -->
            <div class="w-full md:w-1/2">
                <span class="inline-block px-4 py-1.5 bg-[#e0f2f1] text-[#0a2622] text-[10px] font-bold rounded-full mb-6">
                    Visi Madura
                </span>
                
                <h2 class="text-[32px] md:text-[38px] lg:text-[44px] font-bold text-[#0a2622] leading-tight md:leading-[1.15] mb-4">
                    Mewujudkan Madura<br class="hidden md:block"> Sebagai <span class="text-[#ff8a65]">Smart Island</span>
                </h2>

                <p class="text-gray-500 leading-relaxed mb-8 text-[14px] max-w-xl">
                    Lebih dari sekadar destinasi wisata, Madura sedang bertransformasi mengintegrasikan warisan budaya yang kaya dengan inovasi digital. Menghubungkan potensi lokal ke panggung global melalui ekosistem pariwisata yang cerdas dan berkelanjutan.
                </p>

                <!-- Features Checklist -->
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center space-x-3 text-[#0a2622] font-semibold text-sm">
                        <x-lucide-check-circle-2 class="w-5 h-5 text-[#ff8a65] shrink-0" />
                        <span>Pemberdayaan UMKM Digital</span>
                    </li>
                    <li class="flex items-center space-x-3 text-[#0a2622] font-semibold text-sm">
                        <x-lucide-check-circle-2 class="w-5 h-5 text-[#ff8a65] shrink-0" />
                        <span>Pelestarian Budaya & Alam</span>
                    </li>
                    <li class="flex items-center space-x-3 text-[#0a2622] font-semibold text-sm">
                        <x-lucide-check-circle-2 class="w-5 h-5 text-[#ff8a65] shrink-0" />
                        <span>Pariwisata Terintegrasi</span>
                    </li>
                </ul>

                <a href="#" class="inline-flex items-center font-bold text-[#0a2622] hover:text-[#ff8a65] transition-colors group">
                    Pelajari Lebih Lanjut
                    <x-lucide-move-right class="ml-2 w-5 h-5 transition-transform duration-200 group-hover:translate-x-1" />
                </a>
            </div>

            <!-- SISI KANAN (Hanya Aktif di Desktop): Overlapping Images Grid Tanpa Border/Padding -->
            <div class="hidden md:flex w-full md:w-1/2 justify-center md:justify-end">
                <div class="relative w-full max-w-[480px] h-[420px] flex items-center justify-center">
                    
                    <!-- Glow Blur Background Desktop (Ukuran Pas, Intensitas Cahaya Maksimal) -->
                    <div class="absolute top-6 left-2 w-56 h-56 bg-[#124d45]/70 rounded-full blur-[45px] pointer-events-none"></div>
                    <div class="absolute bottom-12 right-6 w-56 h-56 bg-[#ff8a65]/80 rounded-full blur-[50px] pointer-events-none"></div>

                    <!-- KANAN ATAS: Gambar Utama Besar -->
                    <div class="absolute top-0 left-0 w-[70%] z-20 shadow-xl shadow-black/5 transition-transform duration-300 hover:scale-[1.02]">
                        <img src="{{ asset('images/pantai.png') }}" alt="Main Vision" class="rounded-[2rem] w-full object-cover aspect-[4/3]">
                    </div>

                    <!-- KANAN TENGAH-BELAKANG: Gambar Kedua Tanpa Border Putih -->
                    <div class="absolute top-1/4 right-0 w-[50%] z-10 opacity-90 shadow-lg transition-transform duration-300 hover:scale-[1.02]">
                        <img src="{{ asset('images/pantai.png') }}" alt="Secondary Vision" class="rounded-[1.5rem] w-full object-cover aspect-[4/3]">
                    </div>

                    <!-- KIRI BAWAH: Gambar Ketiga Tanpa Border Putih -->
                    <div class="absolute bottom-0 left-[20%] w-[55%] z-30 shadow-2xl shadow-black/10 transition-transform duration-300 hover:scale-[1.02]">
                        <img src="{{ asset('images/pantai.png') }}" alt="Tertiary Vision" class="rounded-[1.5rem] w-full object-cover aspect-[4/3]">
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>