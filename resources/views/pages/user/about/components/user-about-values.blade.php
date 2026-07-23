<section class="py-16 md:py-24 bg-white overflow-hidden">
    <div class="max-w-[70rem] mx-auto px-6">
        
        <!-- Header -->
        <div class="text-center mb-10 md:mb-14">
            <h2 class="text-[28px] md:text-[32px] font-bold text-[#0f172a]">
                Nilai Inti Kami
            </h2>
        </div>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 md:gap-6">
            
            <!-- LEFT CARD (Culture-focused) -->
            <div class="col-span-1 lg:col-span-7 relative rounded-[24px] overflow-hidden min-h-[380px] lg:min-h-[440px] flex flex-col justify-end p-8 group shadow-sm bg-gray-100">
                <!-- Background Image (fallback to pantai.png if failed) -->
                <img src="{{ asset('images/culture/culture01.jpg') }}" alt="Culture" onerror="this.src='{{ asset('images/pantai.png') }}'" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 z-0">
                
                <!-- Gradient Overlay -->
                <!-- Making the gradient slightly dark at bottom mapped with the image -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent z-10 transition-opacity duration-300"></div>
                
                <!-- Content -->
                <div class="relative z-20">
                    <div class="w-11 h-11 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white mb-4 border border-white/20">
                        <x-lucide-users class="w-5 h-5" />
                    </div>
                    <h3 class="text-[22px] md:text-[24px] font-bold text-white mb-2">Culture-focused</h3>
                    <p class="text-gray-200 text-[14px] md:text-[15px] leading-relaxed max-w-md font-medium">
                        Menjaga kelestarian dan mempromosikan kekayaan warisan budaya Madura sebagai identitas utama pariwisata.
                    </p>
                </div>
            </div>

            <!-- RIGHT COLUMN (Two Stacked Cards) -->
            <div class="col-span-1 lg:col-span-5 flex flex-col gap-5 md:gap-6">
                
                <!-- Top Right Card (Community-driven) -->
                <div class="bg-[#f4f5f5] rounded-[24px] p-8 flex-1 flex flex-col justify-center border border-gray-50/50 shadow-sm relative group overflow-hidden">
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-[#334155] mb-4 shrink-0 transition-transform duration-300 group-hover:scale-110">
                        <x-lucide-handshake class="w-5 h-5" />
                    </div>
                    <h3 class="text-[20px] md:text-[22px] font-bold text-[#0f172a] mb-2">Community-driven</h3>
                    <p class="text-gray-500 text-[14px] md:text-[15px] leading-relaxed font-medium">
                        Dibangun dari, oleh, dan untuk masyarakat. Memberdayakan ekonomi lokal melalui partisipasi aktif.
                    </p>
                </div>

                <!-- Bottom Right Card (Quality-assured) -->
                <div class="bg-[#041613] rounded-[24px] p-8 flex-1 flex flex-col justify-center relative overflow-hidden shadow-lg group">
                    <div class="w-10 h-10 rounded-full bg-[#11302a] flex items-center justify-center text-emerald-400 mb-4 shrink-0 z-10 transition-transform duration-300 group-hover:scale-110">
                        <x-lucide-shield-check class="w-5 h-5" />
                    </div>
                    <h3 class="text-[20px] md:text-[22px] font-bold text-white mb-2 z-10">Quality-assured</h3>
                    <p class="text-gray-300 text-[14px] md:text-[15px] leading-relaxed font-medium z-10">
                        Standar informasi yang dikurasi ketat untuk memberikan rasa aman dan nyaman bagi setiap pengunjung.
                    </p>
                    
                    <!-- Faded decorative icon at the bottom right -->
                    <x-lucide-shield-check class="absolute -bottom-6 -right-6 w-40 h-40 text-white/[0.04] z-0 transform -rotate-12 transition-transform duration-500 group-hover:rotate-0 group-hover:scale-110" />
                </div>

            </div>
            
        </div>
        
    </div>
</section>
