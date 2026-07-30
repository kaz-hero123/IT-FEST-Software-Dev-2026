<footer class="bg-[#F9FAFB] border-t border-gray-100 mt-auto py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row justify-between gap-12 lg:gap-24">
            
            <!-- Left: Brand & Description -->
            <div class="max-w-xs">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-[36px] h-[28px] flex-shrink-0">
                        <img src="{{ asset('images/jelajah_madura_logo.png') }}" alt="Logo Jelajah Madura" class="w-full h-full object-contain">
                    </div>
                    <h2 class="text-xl font-bold text-[#0a2622] tracking-tight">Jelajah <span class="text-[#ff8a65]">Madura</span></h2>
                </div>
                <p class="text-[15px] text-gray-500 leading-relaxed font-medium">
                    Platform pariwisata cerdas yang mempermudah kamu untuk mengeksplorasi keindahan Madura.
                </p>
            </div>

            <!-- Right: Links -->
            <div class="flex-1 lg:ml-12 grid grid-cols-2 md:grid-cols-3 gap-10">
                <!-- Utama -->
                <div>
                    <h3 class="text-[15px] font-bold text-[#1A1A1A] mb-5">Utama</h3>
                    <ul class="space-y-4">
                        <li><a href="/" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Beranda</a></li>
                        <li><a href="/explore" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Explore</a></li>
                        <li><a href="/about" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <!-- Destinasi -->
                <div>
                    <h3 class="text-[15px] font-bold text-[#1A1A1A] mb-5">Destinasi</h3>
                    <ul class="space-y-4">
                        <li><a href="/explore/bangkalan" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Bangkalan</a></li>
                        <li><a href="/explore/sampang" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Sampang</a></li>
                        <li><a href="/explore/pamekasan" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Pamekasan</a></li>
                        <li><a href="/explore/sumenep" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Sumenep</a></li>
                    </ul>
                </div>

                <!-- Bantuan -->
                <div>
                    <h3 class="text-[15px] font-bold text-[#1A1A1A] mb-5">Bantuan</h3>
                    <ul class="space-y-4">
                        <li><a href="/question" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Tanya Jawab (FAQ)</a></li>
                        <li><a href="/register" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Jadi Kontributor</a></li>
                        <li><a href="/login" class="text-[14px] text-gray-500 hover:text-[#0a2622] font-medium transition-colors">Masuk Dashboard</a></li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</footer>
