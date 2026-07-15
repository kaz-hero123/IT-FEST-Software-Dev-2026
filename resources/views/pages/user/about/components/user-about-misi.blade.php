<!-- Section Misi Kami / Smart Small Island -->
<section class="py-16 md:py-24 bg-white overflow-hidden">
    <div class="max-w-[70rem] mx-auto px-6">
        
        <div class="flex flex-col md:flex-row items-center justify-between gap-12 lg:gap-16">
            
            <!-- KOLOM KIRI: TEKS & INFO -->
            <div class="w-full md:w-[45%]">
                <!-- Badge Misi Kami -->
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#f0fdfa] text-[#0d9488] text-[11px] font-semibold rounded-full mb-6">
                    <x-lucide-lightbulb class="w-3.5 h-3.5" />
                    Misi Kami
                </span>

                <!-- Heading Utama -->
                <h2 class="text-[32px] md:text-[36px] lg:text-[40px] font-bold text-[#0f172a] leading-tight md:leading-[1.2] mb-6">
                    Mewujudkan "Smart Small Island"
                </h2>

                <!-- Deskripsi Paragraf 1 -->
                <p class="text-gray-500 leading-relaxed mb-5 text-[14px] md:text-[15px] max-w-lg">
                    Jelajah Madura lahir dari inisiatif untuk mentransformasi potensi pulau Madura melalui digitalisasi. Kami tidak hanya sekadar direktori wisata, melainkan sebuah platform pemberdayaan.
                </p>

                <!-- Deskripsi Paragraf 2 -->
                <p class="text-gray-500 leading-relaxed mb-8 text-[14px] md:text-[15px] max-w-md">
                    Melalui konsep Smart Small Island, kami memfasilitasi komunitas lokal dan UMKM untuk go-digital, memastikan standar kualitas layanan bagi wisatawan, dan mempromosikan warisan budaya Madura secara terintegrasi dan berkelanjutan.
                </p>

                <!-- Komunitas & UMKM Avatars Grid -->
                <div class="flex items-center mt-2">
                    <!-- Avatar Stack -->
                    <div class="relative flex shrink-0 h-10 w-[100px]">
                        <img class="absolute left-0 w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm z-[1]" src="/images/avatar-1.jpg" alt="User 1" onerror="this.src='{{ asset('images/culture/culture02.jpg') }}'">
                        <img class="absolute left-6 w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm z-[2]" src="/images/avatar-2.jpg" alt="User 2" onerror="this.src='{{ asset('images/jelajah_madura_logo.png') }}'">
                        <div class="absolute left-12 w-10 h-10 rounded-full border-2 border-white bg-gray-200 flex items-center justify-center text-[11px] font-bold text-gray-500 shadow-sm z-[3]">
                            +5k
                        </div>
                    </div>
                    <!-- Label Komunitas -->
                    <div class="text-[12px] font-semibold text-gray-500 ml-1">
                        Komunitas & UMKM Bergabung
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: CITRA VISUAL & BADGE FLOATING -->
            <div class="w-full md:w-[55%] relative mt-12 md:mt-0 flex lg:justify-end justify-center">

                <!-- Gambar Utama Banner -->
                <div class="w-full lg:max-w-[540px] rounded-2xl overflow-hidden shadow-lg relative z-10">
                    <img class="w-full h-[380px] sm:h-[420px] md:h-[500px] block object-cover object-center" src="{{ asset('images/culture/culture02.jpg') }}" alt="Misi Kemitraan UMKM Madura" onerror="this.src='{{ asset('images/pantai.png') }}'">
                </div>

                <!-- Floating Card: Data Tervalidasi -->
                <div class="absolute -bottom-8 md:-bottom-6 left-0 lg:left-8 bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-gray-100 p-4 px-6 flex items-center gap-4 z-20">
                    <!-- Icon Centang -->
                    <div class="w-11 h-11 bg-[#ecfdf5] rounded-full flex items-center justify-center text-[#10b981] shrink-0 border border-[#d1fae5]">
                        <x-lucide-badge-check class="w-6 h-6" />
                    </div>
                    <!-- Teks Notifikasi -->
                    <div>
                        <h4 class="text-[14px] font-bold text-[#0f172a] leading-tight mb-1">Data Tervalidasi</h4>
                        <p class="text-[12px] font-medium text-gray-400">Oleh Admin Kabupaten</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>