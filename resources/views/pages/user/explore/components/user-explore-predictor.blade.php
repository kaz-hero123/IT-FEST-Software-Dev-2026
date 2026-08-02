<section id="predictor" class="bg-gray-50/50 py-16" x-data="smartPredictor()">
    <div class="max-w-6xl mx-auto px-4 md:px-6">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <h2 class="text-[28px] md:text-[36px] lg:text-[40px] font-bold text-[#0a2622] leading-tight mb-4">
                Smart <span class="text-[#EF8D55]">Predictor</span>
            </h2>
            <p class="text-gray-500 text-[14px] md:text-[15px] leading-relaxed max-w-xl mx-auto">Sistem cerdas penentu rekomendasi destinasi wisata terbaik menggunakan metode Simple Additive Weighting (SAW) berdasarkan preferensi Anda.</p>
        </div>

        <!-- ===== FORM VIEW ===== -->
        <div x-show="!showResults"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0">

            <!-- 2-KOLOM LUAR: Gambar (kiri) + Card (kanan) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

                <!-- KIRI LUAR: Gambar destinasi Madura -->
                <div class="lg:col-span-4 rounded-3xl overflow-hidden relative min-h-[300px] lg:min-h-full shadow-md">
                    <img src="{{ asset('images/culture/culture08.jpg') }}"
                         alt="Wisata Madura"
                         class="absolute inset-0 w-full h-full object-cover"
                         onerror="this.src='{{ asset('images/culture/culture01.jpg') }}'">
                    <!-- Gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a2622]/85 via-[#0a2622]/20 to-transparent"></div>
                    <!-- Teks di atas foto -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-xl font-extrabold leading-snug mb-2">Temukan Destinasi Impianmu di Madura</h3>
                        <p class="text-xs text-white/70 leading-relaxed">Pilih kriteria di sebelah kanan, sistem kami akan merekomendasikan destinasi terbaik menggunakan metode SAW.</p>
                    </div>
                </div>

                <!-- KANAN LUAR: Card putih berisi tips (kiri) + form (kanan) -->
                <div class="lg:col-span-8 bg-white rounded-3xl overflow-hidden shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] border border-gray-100">
                    
                    <form @submit.prevent="submitPrediction" class="grid grid-cols-1 md:grid-cols-12 h-full">

                        <!-- Sub-kiri: Tips kuning -->
                        <div class="md:col-span-4 bg-amber-50 border-r border-amber-100 p-6 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 text-amber-700 text-xs font-bold uppercase tracking-wider mb-3">
                                    <x-lucide-lightbulb class="w-4 h-4 text-amber-500" />
                                    <span>Tips Memilih</span>
                                </div>
                                <h3 class="text-base font-bold text-amber-950 mb-3">Preferensi Wisata</h3>
                                <p class="text-xs text-amber-900/80 leading-relaxed font-medium">
                                    Pilih kriteria liburan Anda untuk menemukan destinasi wisata terbaik di Madura secara instan berbasis metode Simple Additive Weighting (SAW).
                                </p>
                            </div>
                            <div class="mt-6 space-y-2.5 pt-4 border-t border-amber-200/60">
                                <div class="flex items-center gap-2 text-xs font-semibold text-amber-900/90">
                                    <x-lucide-check-circle-2 class="w-4 h-4 text-amber-600 shrink-0" />
                                    <span>Perhitungan otomatis &amp; akurat</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs font-semibold text-amber-900/90">
                                    <x-lucide-check-circle-2 class="w-4 h-4 text-amber-600 shrink-0" />
                                    <span>Kombinasi Eco-Score &amp; Popularitas</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs font-semibold text-amber-900/90">
                                    <x-lucide-check-circle-2 class="w-4 h-4 text-amber-600 shrink-0" />
                                    <span>Top 3 rekomendasi instan</span>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-kanan: Form input -->
                        <div class="md:col-span-8 p-6 space-y-5">

                            <!-- Q1: Prioritas Liburan -->
                            <div class="space-y-2.5">
                                <label class="block text-sm font-bold text-[#0a2622]">1. Prioritas Liburan</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="flex items-center justify-center p-2.5 cursor-pointer rounded-xl border transition-all text-xs font-bold text-center"
                                        :class="form.priority === 'sepi' ? 'bg-[#0a2622] border-[#0a2622] text-white' : 'border-gray-200 text-gray-700 hover:border-gray-300 bg-white'">
                                        <input type="radio" x-model="form.priority" value="sepi" class="sr-only">
                                        Sepi / Quiet
                                    </label>
                                    <label class="flex items-center justify-center p-2.5 cursor-pointer rounded-xl border transition-all text-xs font-bold text-center"
                                        :class="form.priority === 'eco' ? 'bg-[#0a2622] border-[#0a2622] text-white' : 'border-gray-200 text-gray-700 hover:border-gray-300 bg-white'">
                                        <input type="radio" x-model="form.priority" value="eco" class="sr-only">
                                        Ramah Lingkungan
                                    </label>
                                    <label class="flex items-center justify-center p-2.5 cursor-pointer rounded-xl border transition-all text-xs font-bold text-center"
                                        :class="form.priority === 'populer' ? 'bg-[#0a2622] border-[#0a2622] text-white' : 'border-gray-200 text-gray-700 hover:border-gray-300 bg-white'">
                                        <input type="radio" x-model="form.priority" value="populer" class="sr-only">
                                        Paling Populer
                                    </label>
                                    <label class="flex items-center justify-center p-2.5 cursor-pointer rounded-xl border transition-all text-xs font-bold text-center"
                                        :class="form.priority === 'bebas' ? 'bg-[#0a2622] border-[#0a2622] text-white' : 'border-gray-200 text-gray-700 hover:border-gray-300 bg-white'">
                                        <input type="radio" x-model="form.priority" value="bebas" class="sr-only">
                                        Seimbang (Bebas)
                                    </label>
                                </div>
                            </div>

                            <!-- Q2: Kategori Favorit -->
                            <div class="space-y-2.5">
                                <label class="block text-sm font-bold text-[#0a2622]">2. Kategori Favorit</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="flex items-center justify-center px-3.5 py-2 cursor-pointer rounded-xl border transition-all text-xs font-bold"
                                        :class="form.category === 'semua' ? 'bg-[#0a2622] border-[#0a2622] text-white' : 'border-gray-200 text-gray-700 hover:border-gray-300 bg-white'">
                                        <input type="radio" x-model="form.category" value="semua" class="sr-only">
                                        Semua Kategori
                                    </label>
                                    @foreach($categories as $cat)
                                    <label class="flex items-center justify-center px-3.5 py-2 cursor-pointer rounded-xl border transition-all text-xs font-bold"
                                        :class="form.category === '{{ $cat->slug }}' ? 'bg-[#0a2622] border-[#0a2622] text-white' : 'border-gray-200 text-gray-700 hover:border-gray-300 bg-white'">
                                        <input type="radio" x-model="form.category" value="{{ $cat->slug }}" class="sr-only">
                                        {{ $cat->name }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Q3: Lokasi Tujuan -->
                            <div class="space-y-2.5">
                                <label class="block text-sm font-bold text-[#0a2622]">3. Lokasi Tujuan</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="flex items-center justify-center px-3.5 py-2 cursor-pointer rounded-xl border transition-all text-xs font-bold"
                                        :class="form.regency === 'semua' ? 'bg-[#0a2622] border-[#0a2622] text-white' : 'border-gray-200 text-gray-700 hover:border-gray-300 bg-white'">
                                        <input type="radio" x-model="form.regency" value="semua" class="sr-only">
                                        Semua Kabupaten
                                    </label>
                                    @foreach($regencies as $reg)
                                    <label class="flex items-center justify-center px-3.5 py-2 cursor-pointer rounded-xl border transition-all text-xs font-bold"
                                        :class="form.regency === '{{ $reg->slug }}' ? 'bg-[#0a2622] border-[#0a2622] text-white' : 'border-gray-200 text-gray-700 hover:border-gray-300 bg-white'">
                                        <input type="radio" x-model="form.regency" value="{{ $reg->slug }}" class="sr-only">
                                        {{ $reg->name }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="pt-4 border-t border-gray-100 flex justify-end">
                                <button type="submit"
                                        style="background-color: #EF8D55;"
                                        class="w-full sm:w-auto px-7 py-3 text-white font-bold text-sm rounded-xl shadow-sm transition-all duration-200 flex items-center justify-center gap-2 group hover:opacity-90 active:scale-95 cursor-pointer"
                                        :disabled="isLoading"
                                        :class="isLoading ? 'opacity-75 cursor-not-allowed' : ''">
                                    <span x-show="!isLoading">Mulai Prediksi</span>
                                    <x-lucide-arrow-right x-show="!isLoading" class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
                                    <span x-show="isLoading" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Mengkalkulasi...
                                    </span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- ===== HASIL PREDIKSI ===== -->
        <div x-show="showResults" style="display: none;" class="space-y-8"
             x-transition:enter="transition ease-out duration-500 delay-100"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-[#0a2622]">Hasil Rekomendasi (Top 3)</h3>
                <button @click="resetForm" class="text-sm font-semibold text-gray-500 hover:text-[#EF8D55] flex items-center gap-1.5 transition-colors cursor-pointer">
                    <x-lucide-rotate-ccw class="w-4 h-4" /> Ulangi Prediksi
                </button>
            </div>

            <!-- Disclaimer -->
            <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl flex gap-3 text-blue-800 text-sm">
                <x-lucide-info class="w-5 h-5 shrink-0 text-blue-500 mt-0.5" />
                <p>
                    <strong>Transparansi Data:</strong> Persentase kecocokan di bawah ini adalah hasil kalkulasi matematis (SAW) murni dari sistem berdasarkan <strong>tren popularitas kunjungan web (view)</strong> dan <strong>estimasi indeks kategori (Eco-Score basis)</strong>, bukan merepresentasikan kondisi fisik/lingkungan di dunia nyata.
                </p>
            </div>

            <!-- List Results -->
            <div class="space-y-4">
                <template x-for="(res, index) in results" :key="index">
                    <div x-data="{ showDetails: false }" class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                        
                        <a :href="'/explore/' + res.content.regency.slug + '/' + res.content.slug" class="block p-4 sm:p-5">

                            <div class="flex flex-col sm:flex-row gap-5">
                                <!-- Image + Rank Badge -->
                                <div class="w-full sm:w-48 aspect-[4/3] rounded-2xl overflow-hidden shrink-0 bg-gray-100 relative">
                                    <img :src="res.content.primary_photo ? res.content.primary_photo.resolved_url : '/images/culture/culture05.jpg'" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                         alt="Gambar">
                                    <!-- Rank Badge -->
                                    <div class="absolute top-2.5 left-2.5 flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold shadow text-white"
                                         :class="index === 0 ? 'bg-[#EF8D55]' : (index === 1 ? 'bg-[#0a2622]' : 'bg-gray-700')">
                                        <x-lucide-trophy class="w-3 h-3" />
                                        <span>Top <span x-text="index + 1"></span></span>
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 flex flex-col justify-center">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-bold px-2 py-0.5 rounded-md uppercase tracking-wider bg-gray-100 text-gray-600" x-text="res.content.category.name"></span>
                                        <span class="text-xs text-gray-400" x-text="res.content.regency.name"></span>
                                    </div>
                                    <h4 class="text-lg font-bold text-[#0a2622] mb-1 group-hover:text-[#EF8D55] transition-colors" x-text="res.content.title"></h4>
                                    
                                    <div class="mt-auto pt-3 flex flex-wrap items-center gap-4 text-xs font-semibold text-gray-500">
                                        <div class="flex items-center gap-1.5">
                                            <x-lucide-leaf class="w-4 h-4 text-green-500" />
                                            <span>Base Eco: <span x-text="res.eco_index"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Score Circle -->
                                <div class="shrink-0 sm:self-center flex flex-col items-center justify-center p-4">
                                    <div class="relative w-16 h-16 flex items-center justify-center rounded-full border-4"
                                         :class="res.match_percentage >= 80 ? 'border-green-400 text-green-600' : 'border-amber-400 text-amber-600'">
                                        <span class="text-xl font-bold" x-text="res.match_percentage + '%'"></span>
                                    </div>
                                    <span class="text-[10px] uppercase font-bold text-gray-400 mt-2 tracking-wider">Match</span>
                                </div>
                            </div>
                        </a>

                        <!-- Accordion: Deskripsi Wisata -->
                        <div class="border-t border-gray-50 bg-gray-50/50">
                            <button @click="showDetails = !showDetails" class="w-full px-5 py-3 flex items-center justify-center gap-2 text-xs font-bold text-gray-500 hover:text-[#0a2622] transition-colors cursor-pointer">
                                <span x-text="showDetails ? 'Sembunyikan Deskripsi' : 'Lihat Deskripsi Wisata'"></span>
                                <x-lucide-chevron-down class="w-4 h-4 transition-transform duration-300" x-bind:class="showDetails ? 'rotate-180' : ''" />
                            </button>
                            <div x-show="showDetails" x-collapse class="px-5 pb-4">
                                <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                                    <p class="text-sm text-gray-600 leading-relaxed" x-text="res.content.description || 'Tidak ada deskripsi tersedia untuk destinasi ini.'"></p>
                                    <a :href="'/explore/' + res.content.regency.slug + '/' + res.content.slug"
                                       class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-[#EF8D55] hover:underline">
                                        Lihat selengkapnya
                                        <x-lucide-arrow-right class="w-3.5 h-3.5" />
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>
                
                <!-- Empty State -->
                <div x-show="results.length === 0" class="text-center py-12 bg-white rounded-3xl border border-gray-100 border-dashed">
                    <x-lucide-folder-search class="w-12 h-12 text-gray-300 mx-auto mb-3" />
                    <h3 class="text-gray-700 font-bold mb-1">Tidak Ada Data</h3>
                    <p class="text-sm text-gray-500">Tidak ada destinasi yang cocok dengan kriteria Anda.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- CSRF Token for Axios/Fetch -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('smartPredictor', () => ({
        form: {
            priority: 'bebas',
            category: 'semua',
            regency: 'semua'
        },
        isLoading: false,
        showResults: false,
        results: [],

        async submitPrediction() {
            this.isLoading = true;
            try {
                // Add artificial delay to show 'calculating' state
                await new Promise(r => setTimeout(r, 800));

                const response = await fetch('/predictor/predict', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(this.form)
                });
                
                const data = await response.json();
                if (data.success) {
                    this.results = data.data;
                    this.showResults = true;
                } else {
                    alert('Gagal memproses prediksi.');
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan jaringan.');
            } finally {
                this.isLoading = false;
            }
        },

        resetForm() {
            this.showResults = false;
            this.results = [];
            // biarkan form tetap agar user bisa modifikasi opsi terakhir
        }
    }))
})
</script>
