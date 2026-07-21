@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<style>
    html { scroll-behavior: smooth; }
</style>
<section class="bg-[#fcfcfc] min-h-screen pb-20">
    <!-- Hero Section -->
    <section class="relative w-full h-[85vh] flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="{{ asset('images/culture/culture02.jpg') }}" 
                 alt="FAQ Banner" 
                 data-parallax
                 data-parallax-speed="0.25"
                 data-parallax-scale="1.35"
                 class="w-full h-full object-cover origin-center will-change-transform"
                 onerror="this.src='{{ asset('images/dashboard.png') }}'">
            <!-- Overlay and Gradient -->
            <div class="absolute inset-0 bg-[#0a2622]/40 mix-blend-overlay"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#0a2622]/80 via-[#0a2622]/50 to-[#fcfcfc]"></div>
        </div>
    
        <!-- Hero Content -->
        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-12 w-full">
            <span class="inline-flex items-center py-1.5 px-4 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[13px] font-semibold mb-5 tracking-wide shadow-sm">
                <x-lucide-message-circle-question class="w-4 h-4 mr-2" />
                Pusat Edukasi & Bantuan
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-5 drop-shadow-[0_4px_4px_rgba(0,0,0,0.4)] tracking-tight">
                Bagaimana Kami Membantu?
            </h1>
            <p class="text-base md:text-lg text-gray-200 max-w-2xl mx-auto drop-shadow-md leading-relaxed">
                Temukan seluruh jawaban atas pertanyaan Anda seputar fitur Jelajah Madura, panduan rekomendasi tempat wisata favorit, hingga persyaratan menjadi kontributor penulis.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div x-data="scrollSpy()" class="max-w-6xl mx-auto px-4 mt-16 relative">
        <div class="flex items-center justify-center mt-40 mb-6">
            <h2 class="text-[32px] md:text-[36px] lg:text-[40px] font-bold text-[#0f172a] leading-tight md:leading-[1.2] mb-6 text-center">
                Pusat Bantuan & FAQ
            </h2>
        </div>
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- Sidebar -->
            <div class="w-full lg:w-1/4 relative hidden lg:block">
                <div class="sticky top-28 bg-white border border-gray-100 rounded-2xl p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.04)]">
                    <h3 class="text-[11px] font-bold tracking-[0.15em] text-gray-400 mb-5 uppercase">Kategori Bantuan</h3>
                    <ul class="space-y-1.5 relative">
                        <li>
                            <a @click.prevent="scrollTo('umum')" :class="activeSection === 'umum' ? 'bg-[#f8ede8] text-[#d35a39] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2622] font-medium'" href="#umum" class="block w-full text-left px-4 py-3 rounded-xl transition-all duration-300 text-sm">
                                Umum
                            </a>
                        </li>
                        <li>
                            <a @click.prevent="scrollTo('akun')" :class="activeSection === 'akun' ? 'bg-[#f8ede8] text-[#d35a39] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2622] font-medium'" href="#akun" class="block w-full text-left px-4 py-3 rounded-xl transition-all duration-300 text-sm">
                                Akun & Keamanan
                            </a>
                        </li>
                        <li>
                            <a @click.prevent="scrollTo('eksplorasi')" :class="activeSection === 'eksplorasi' ? 'bg-[#f8ede8] text-[#d35a39] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2622] font-medium'" href="#eksplorasi" class="block w-full text-left px-4 py-3 rounded-xl transition-all duration-300 text-sm">
                                Destinasi & Eksplorasi
                            </a>
                        </li>
                        <li>
                            <a @click.prevent="scrollTo('kontributor')" :class="activeSection === 'kontributor' ? 'bg-[#f8ede8] text-[#d35a39] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2622] font-medium'" href="#kontributor" class="block w-full text-left px-4 py-3 rounded-xl transition-all duration-300 text-sm">
                                Kontributor
                            </a>
                        </li>
                        <li>
                            <a @click.prevent="scrollTo('privasi')" :class="activeSection === 'privasi' ? 'bg-[#f8ede8] text-[#d35a39] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2622] font-medium'" href="#privasi" class="block w-full text-left px-4 py-3 rounded-xl transition-all duration-300 text-sm">
                                Kebijakan & Privasi
                            </a>
                        </li>
                        <li>
                            <a @click.prevent="scrollTo('teknis')" :class="activeSection === 'teknis' ? 'bg-[#f8ede8] text-[#d35a39] font-bold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0a2622] font-medium'" href="#teknis" class="block w-full text-left px-4 py-3 rounded-xl transition-all duration-300 text-sm">
                                Bantuan Teknis
                            </a>
                        </li>
                    </ul>
                    
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <p class="text-xs text-gray-500 mb-3">Tidak menemukan jawaban?</p>
                        <a href="mailto:support@jelajahmadura.com" class="inline-flex items-center justify-center w-full py-2.5 rounded-xl bg-gray-50 text-[#0a2622] font-semibold text-sm hover:bg-[#d35a39] hover:text-white transition-colors duration-300 border border-gray-100 hover:border-transparent">
                            <x-lucide-mail class="w-4 h-4 mr-2" />
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ Sections -->
            <div class="w-full lg:w-3/4 space-y-16 pb-12">
                
                <!-- Section: Umum -->
                <div id="umum" class="scroll-mt-36 faq-section">
                    <h2 class="text-2xl font-bold flex items-center mb-6 text-[#d35a39]">
                        <x-lucide-globe class="w-7 h-7 mr-3 shrink-0" />
                        Umum
                    </h2>
                    
                    <div class="space-y-4">
                        <x-faq-accordion question="Apa itu Jelajah Madura?">
                            Jelajah Madura adalah platform digital resmi yang bertujuan untuk mempromosikan pariwisata, budaya, dan kuliner di Pulau Madura. Kami menyediakan informasi terkurasi untuk memudahkan wisatawan merencanakan perjalanan mereka agar lebih tertata dan menyenangkan.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Apakah layanan platform ini berbayar?">
                            Tidak, fitur utama platform kami 100% gratis untuk diakses oleh seluruh wisatawan. Anda dapat mencari tempat wisata, membaca artikel, maupun mengeksplorasi budaya tanpa dipungut biaya sedikitpun.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Kabupaten apa saja yang tercakup di website ini?">
                            Platform kami saat ini melingkupi empat kabupaten penuh yang ada di Pulau Madura, yakni mulai dari gerbang Madura yaitu Kabupaten Bangkalan, berlanjut ke Kabupaten Sampang, Kabupaten Pamekasan, hingga kabupaten paling ujung timur yang kaya akan gugusan pulauan yakni Kabupaten Sumenep.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Siapa saja yang berada di balik Jelajah Madura?">
                            Jelajah Madura dikembangkan oleh komunitas pegiat wisata lokal, mahasiswa, dan ahli IT yang memiliki kepedulian terhadap kelestarian alam dan budaya Madura, bekerja sama dengan pemerintah daerah dan masyarakat setempat.
                        </x-faq-accordion>
                    </div>
                </div>

                <!-- Section: Akun & Keamanan -->
                <div id="akun" class="scroll-mt-36 faq-section">
                    <h2 class="text-2xl font-bold flex items-center mb-6 text-[#d35a39]">
                        <x-lucide-user-check class="w-7 h-7 mr-3 shrink-0" />
                        Akun & Keamanan
                    </h2>
                    
                    <div class="space-y-4">
                        <x-faq-accordion question="Bagaimana cara membuat akun baru?">
                            Klik tombol <b>"Pendaftaran"</b> atau ikon profil di sudut kanan atas. Masukkan alamat email aktif Anda, buat kata sandi yang aman, lalu isi profil singkat. Verifikasi email Anda melalui tautan yang kami kirimkan ke kotak masuk.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Bagaimana jika saya lupa kata sandi?">
                            Di halaman Login, klik tombol <b>"Lupa Kata Sandi?"</b>. Masukkan alamat email yang terdaftar, dan sistem akan secara otomatis mengirimkan tautan serta instruksi untuk mereset kata sandi Anda dengan aman.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Apakah saya bisa menghapus akun secara permanen?">
                            Ya, Anda memiliki hak penuh atas akun Anda. Silakan masuk ke "Pengaturan Akun" dan pilih opsi "Hapus Akun Permanen". Perlu diingat, setelah dihapus, semua draf, bookmark, dan konten yang menyertai profil Anda ikut dihapus dan tidak bisa dipulihkan.
                        </x-faq-accordion>
                    </div>
                </div>

                <!-- Section: Destinasi & Eksplorasi -->
                <div id="eksplorasi" class="scroll-mt-36 faq-section">
                    <h2 class="text-2xl font-bold flex items-center mb-6 text-[#d35a39]">
                        <x-lucide-map class="w-7 h-7 mr-3 shrink-0" />
                        Destinasi & Eksplorasi
                    </h2>
                    
                    <div class="space-y-4">
                        <x-faq-accordion question="Apakah informasi alamat dan jam buka dijamin akurat?">
                            Meskipun kami dan para kontributor selalu berusaha melakukan verifikasi berkala secara ketat, kami amat menyarankan agar Anda mengonfirmasi langsung ke pihak wisata tujuan sebelum berangkat, terutama pada hari libur nasional atau cuaca ekstrem.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Bagaimana cara mencari destinasi berdasarkan kabupaten?">
                            Buka menu <b>"Explore"</b> di navigasi atas. Dari sana Anda akan dimintakan untuk memilih salah satu dari 4 kabupaten (Bangkalan, Sampang, dll). Setelah terpilih, Anda bisa lanjut memfilter tempat wisata berdasarkan kategori yang ada (misal: Pantai, Kuliner, atau Religi).
                        </x-faq-accordion>

                        <x-faq-accordion question="Adakah rekomendasi rute perjalanan (Itinerary)?">
                            Fitur artikel di platform kami sering mengulas rekomendasi rute perjalanan harian bagi para wisatawan. Anda dapat membaca artikel populer kami yang khusus membahas cara mengelilingi Madura dalam 3 Hari 2 Malam!
                        </x-faq-accordion>
                    </div>
                </div>

                <!-- Section: Kontributor -->
                <div id="kontributor" class="scroll-mt-36 faq-section">
                    <h2 class="text-2xl font-bold flex items-center mb-6 text-[#d35a39]">
                        <x-lucide-feather class="w-7 h-7 mr-3 shrink-0" />
                        Kontributor & Publikasi
                    </h2>
                    
                    <div class="space-y-4">
                        <x-faq-accordion question="Syarat utama menjadi seorang Kontributor Konten?">
                            Tim kami mencari individu yang berdomisili atau memiliki pengetahuan luas tentang rupa-rupa destinasi di Madura. Anda harus bisa menyajikan gambar berkualitas baik, serta menyertai tulisan orisinil tak hasil salinan.
                        </x-faq-accordion>

                        <x-faq-accordion question="Berapa lama waktu tunggu moderasi konten?">
                            Setiap draft yang anda serahkan kepada admin akan melalui proses Quality Control. Biasanya moderasi memakan waktu sekitar maksimal 2x24 Jam Hari Kerja. Jika konten disetujui, ia akan langsung tampil (Publish).
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Mengapa konten yang saya unggah ditolak?">
                            Konten ditolak biasanya karena beberapa hal: gambar kurang jelas, resolusi sangat pecah, tulisan terdeteksi plagiat, tidak memiliki letak alamat yang konkret, maupun menduplikasi (tempat sama sudah pernah direview). Anda dapat memperbaikinya dan mengajukannya ulang.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Apakah kontributor akan dibayar?">
                            Untuk rilis saat ini, peran kontributor berbasis sukarela bagi pegiat wisata dan fotografer yang merangkap ingin mempromosikan tempat. Tidak menutup kemungkinan akan ada program *reward* khusus bagi penulis teladan pada pembaruan sistem yang akan datang.
                        </x-faq-accordion>
                    </div>
                </div>

                <!-- Section: Kebijakan & Privasi -->
                <div id="privasi" class="scroll-mt-36 faq-section">
                    <h2 class="text-2xl font-bold flex items-center mb-6 text-[#d35a39]">
                        <x-lucide-shield-check class="w-7 h-7 mr-3 shrink-0" />
                        Kebijakan & Privasi
                    </h2>
                    
                    <div class="space-y-4">
                        <x-faq-accordion question="Bagaimana data saya dikelola oleh website?">
                            Kami menerapkan enkripsi end-to-end khusus untuk data kredensial Anda, seperti password. Untuk data interaksi platform kami mengelolanya secara anonim sebatas keperuntukan perbaikan pengalaman User.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Apakah data email saya diberikan pada pihak ketiga?">
                            Tidak, kami menjamin penuh keamanan dan privasi data personal dalam server tersendiri (Private Server) dan tidak pernah mentransaksinya pada pihak eksternal, termasuk pengiklan.
                        </x-faq-accordion>

                        <x-faq-accordion question="Bagaimana klaim hak cipta foto yang diunggah?">
                            Segala macam materi publikasi berupa gambar akan tetap menjadi hak properti asli pemilik karya. Jelajah Madura hanya memegang lisensi pemakaian (hak tayang) dalam ekosistem perwebsite-an. Pengguna lain sangat dilarang untuk menyalin ulang foto kontributor ke luar platform tanpa persetujuan penulis langsung.
                        </x-faq-accordion>
                    </div>
                </div>

                <!-- Section: Teknis -->
                <div id="teknis" class="scroll-mt-36 faq-section">
                    <h2 class="text-2xl font-bold flex items-center mb-6 text-[#d35a39]">
                        <x-lucide-wrench class="w-7 h-7 mr-3 shrink-0" />
                        Bantuan Teknis
                    </h2>
                    
                    <div class="space-y-4">
                        <x-faq-accordion question="Browser apa saja yang disarankan?">
                            Untuk performa dan tingkat interaksi pemakaian (smooth scrolling & animasi) terbaik, kami menyarankan Anda menggunakan versi mutakhir pada peramban Chrome, Edge, Safari, Firefox maupun Opera.
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Saya tidak bisa mengunggah foto, mengapa?">
                            Batas ukuran <i>file upload</i> yang ditoleransi server yakni sebesar maksimal 5 MB dengan format PNG, JPEG, JPG, maupun WEBP. Harap kompres ukuran rasio gambar Anda terlebih dahulu apabila melebih batas (Error 413 Payload Too Large).
                        </x-faq-accordion>
                        
                        <x-faq-accordion question="Bagaimana cara melaporkan Bug atau Error yang saya temui?">
                            Apabila Anda menjumpai galat saat mengakses, layar blank, atau tombol tak merespon; bisa langsung infokan kami dengan menekan tombol **Hubungi Kami (Email)** pada bagian kanan bawah halaman ini. Lampirkan pula spesifikasi singkat berupa tangkapan layar jika dimungkinkan.
                        </x-faq-accordion>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
