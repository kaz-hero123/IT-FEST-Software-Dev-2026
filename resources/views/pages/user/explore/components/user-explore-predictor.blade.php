<section id="predictor" class="bg-gray-50/50 py-16" x-data="smartPredictor()">
    <div class="max-w-4xl mx-auto px-4 md:px-6">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center p-3 bg-teal-50 rounded-2xl mb-4">
                <x-lucide-sparkles class="w-8 h-8 text-teal-600" />
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-[#0a2622] mb-3 tracking-tight">Smart Predictor</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Sistem cerdas penentu rekomendasi destinasi wisata terbaik menggunakan metode Simple Additive Weighting (SAW) berdasarkan preferensi Anda.</p>
        </div>

        <!-- Form Kuis -->
        <div class="bg-white rounded-3xl p-6 md:p-10 shadow-[0_2px_20px_-5px_rgba(0,0,0,0.05)] border border-gray-100 mb-8" x-show="!showResults" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            
            <form @submit.prevent="submitPrediction" class="space-y-8">
                
                <!-- Q1: Prioritas Utama -->
                <div class="space-y-4">
                    <label class="block text-lg font-bold text-gray-800">1. Apa prioritas utama liburan Anda?</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <label class="relative flex p-4 cursor-pointer rounded-2xl border-2 transition-all duration-200"
                               :class="form.priority === 'sepi' ? 'border-teal-500 bg-teal-50/50' : 'border-gray-100 hover:border-gray-200 hover:bg-gray-50'">
                            <input type="radio" x-model="form.priority" value="sepi" class="sr-only">
                            <div class="flex items-start gap-4">
                                <div class="p-2 rounded-xl" :class="form.priority === 'sepi' ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-400'">
                                    <x-lucide-users-round class="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">Paling Sepi / Anti-Mainstream</h4>
                                    <p class="text-xs text-gray-500">Mencari tempat yang jarang dikunjungi (View minimum).</p>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex p-4 cursor-pointer rounded-2xl border-2 transition-all duration-200"
                               :class="form.priority === 'eco' ? 'border-teal-500 bg-teal-50/50' : 'border-gray-100 hover:border-gray-200 hover:bg-gray-50'">
                            <input type="radio" x-model="form.priority" value="eco" class="sr-only">
                            <div class="flex items-start gap-4">
                                <div class="p-2 rounded-xl" :class="form.priority === 'eco' ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-400'">
                                    <x-lucide-leaf class="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">Paling Ramah Lingkungan</h4>
                                    <p class="text-xs text-gray-500">Memaksimalkan indeks Eco-Score berdasar kategori.</p>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex p-4 cursor-pointer rounded-2xl border-2 transition-all duration-200"
                               :class="form.priority === 'populer' ? 'border-teal-500 bg-teal-50/50' : 'border-gray-100 hover:border-gray-200 hover:bg-gray-50'">
                            <input type="radio" x-model="form.priority" value="populer" class="sr-only">
                            <div class="flex items-start gap-4">
                                <div class="p-2 rounded-xl" :class="form.priority === 'populer' ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-400'">
                                    <x-lucide-trending-up class="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">Paling Populer</h4>
                                    <p class="text-xs text-gray-500">Mencari destinasi hits dengan jumlah view terbanyak.</p>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex p-4 cursor-pointer rounded-2xl border-2 transition-all duration-200"
                               :class="form.priority === 'bebas' ? 'border-teal-500 bg-teal-50/50' : 'border-gray-100 hover:border-gray-200 hover:bg-gray-50'">
                            <input type="radio" x-model="form.priority" value="bebas" class="sr-only">
                            <div class="flex items-start gap-4">
                                <div class="p-2 rounded-xl" :class="form.priority === 'bebas' ? 'bg-teal-100 text-teal-600' : 'bg-gray-100 text-gray-400'">
                                    <x-lucide-shuffle class="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">Seimbang (Bebas)</h4>
                                    <p class="text-xs text-gray-500">Tidak ada prioritas khusus, bobot dibagi rata.</p>
                                </div>
                            </div>
                        </label>

                    </div>
                </div>

                <!-- Q2: Kategori Favorit -->
                <div class="space-y-4">
                    <label class="block text-lg font-bold text-gray-800">2. Apa kategori favorit Anda?</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border-2 transition-all text-sm font-semibold"
                               :class="form.category === 'semua' ? 'border-teal-500 bg-teal-50 text-teal-700' : 'border-gray-100 hover:border-gray-200 text-gray-600'">
                            <input type="radio" x-model="form.category" value="semua" class="sr-only">
                            Bebas / Semua
                        </label>
                        @foreach($categories as $cat)
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border-2 transition-all text-sm font-semibold"
                               :class="form.category === '{{ $cat->slug }}' ? 'border-teal-500 bg-teal-50 text-teal-700' : 'border-gray-100 hover:border-gray-200 text-gray-600'">
                            <input type="radio" x-model="form.category" value="{{ $cat->slug }}" class="sr-only">
                            {{ $cat->name }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Q3: Lokasi Tujuan -->
                <div class="space-y-4">
                    <label class="block text-lg font-bold text-gray-800">3. Kabupaten mana yang ingin dituju?</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border-2 transition-all text-sm font-semibold"
                               :class="form.regency === 'semua' ? 'border-teal-500 bg-teal-50 text-teal-700' : 'border-gray-100 hover:border-gray-200 text-gray-600'">
                            <input type="radio" x-model="form.regency" value="semua" class="sr-only">
                            Bebas / Semua
                        </label>
                        @foreach($regencies as $reg)
                        <label class="relative flex items-center justify-center p-3 cursor-pointer rounded-xl border-2 transition-all text-sm font-semibold"
                               :class="form.regency === '{{ $reg->slug }}' ? 'border-teal-500 bg-teal-50 text-teal-700' : 'border-gray-100 hover:border-gray-200 text-gray-600'">
                            <input type="radio" x-model="form.regency" value="{{ $reg->slug }}" class="sr-only">
                            {{ $reg->name }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100">
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3.5 bg-[#af4926] hover:bg-[#8e381b] text-white font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2"
                            :disabled="isLoading"
                            :class="isLoading ? 'opacity-75 cursor-not-allowed' : ''">
                        <span x-show="!isLoading">Mulai Prediksi (SAW)</span>
                        <span x-show="isLoading" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Mengkalkulasi...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Hasil Prediksi -->
        <div x-show="showResults" style="display: none;" class="space-y-8" x-transition:enter="transition ease-out duration-500 delay-100" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-[#0a2622]">Hasil Rekomendasi (Top 3)</h3>
                <button @click="resetForm" class="text-sm font-semibold text-gray-500 hover:text-teal-600 flex items-center gap-1.5 transition-colors">
                    <x-lucide-rotate-ccw class="w-4 h-4" /> Ulangi Prediksi
                </button>
            </div>

            <!-- Pesan Jujur (Disclaimer) -->
            <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl flex gap-3 text-blue-800 text-sm mb-6">
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
                            <!-- Rank Ribbon -->
                            <div class="absolute -right-12 top-6 w-40 text-center transform rotate-45 text-[10px] font-bold py-1 shadow-sm uppercase tracking-wider"
                                 :class="index === 0 ? 'bg-teal-500 text-white' : (index === 1 ? 'bg-[#ed8a53] text-white' : 'bg-amber-500 text-white')">
                                Top <span x-text="index + 1"></span>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-5">
                                <!-- Image -->
                                <div class="w-full sm:w-48 aspect-[4/3] rounded-2xl overflow-hidden shrink-0 bg-gray-100">
                                    <img :src="res.content.primary_photo ? res.content.primary_photo.resolved_url : '/images/culture/culture05.jpg'" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                         alt="Gambar">
                                </div>

                                <!-- Info -->
                                <div class="flex-1 flex flex-col justify-center">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-bold px-2 py-0.5 rounded-md uppercase tracking-wider bg-gray-100 text-gray-600" x-text="res.content.category.name"></span>
                                        <span class="text-xs text-gray-400" x-text="res.content.regency.name"></span>
                                    </div>
                                    <h4 class="text-xl font-extrabold text-[#0a2622] mb-1 group-hover:text-teal-700 transition-colors" x-text="res.content.title"></h4>
                                    
                                    <div class="mt-auto pt-3 flex flex-wrap items-center gap-4 text-xs font-semibold text-gray-500">
                                        <div class="flex items-center gap-1.5" title="Indeks Eco-Score Kategori">
                                            <x-lucide-leaf class="w-4 h-4 text-green-500" />
                                            <span>Base Eco: <span x-text="res.eco_index"></span></span>
                                        </div>
                                        <div class="flex items-center gap-1.5" title="Popularitas Web">
                                            <x-lucide-eye class="w-4 h-4 text-blue-500" />
                                            <span>Views: <span x-text="res.view_count"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Score Circular -->
                                <div class="shrink-0 sm:self-center flex flex-col items-center justify-center p-4">
                                    <div class="relative w-16 h-16 flex items-center justify-center rounded-full border-4"
                                         :class="res.match_percentage >= 80 ? 'border-green-400 text-green-600' : 'border-amber-400 text-amber-600'">
                                        <span class="text-xl font-bold" x-text="res.match_percentage + '%'"></span>
                                    </div>
                                    <span class="text-[10px] uppercase font-bold text-gray-400 mt-2 tracking-wider">Match</span>
                                </div>
                            </div>
                        </a>

                        <!-- Accordion for Transparency -->
                        <div class="border-t border-gray-50 bg-gray-50/50">
                            <button @click="showDetails = !showDetails" class="w-full px-5 py-3 flex items-center justify-center gap-2 text-xs font-bold text-gray-500 hover:text-teal-600 transition-colors">
                                <span x-text="showDetails ? 'Sembunyikan Rincian' : 'Lihat Rincian Perhitungan'"></span>
                                <x-lucide-chevron-down class="w-4 h-4 transition-transform duration-300" x-bind:class="showDetails ? 'rotate-180' : ''" />
                            </button>
                            <div x-show="showDetails" x-collapse class="px-5 pb-4">
                                <div class="bg-white rounded-xl p-4 border border-gray-100 text-xs text-gray-600 font-mono leading-relaxed shadow-sm">
                                    <div class="font-bold text-gray-800 mb-2 border-b border-gray-100 pb-2">Metrik Simple Additive Weighting (SAW)</div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Kriteria 1: Eco-Score (Benefit)</div>
                                            <div>Nilai Awal: <span class="font-bold text-gray-800" x-text="res.eco_index"></span></div>
                                            <!-- Normalisasi (Nilai / Max) -->
                                            <div class="text-gray-400 mt-1">Ternormalisasi (x) = <span x-text="(res.eco_index / Math.max(...results.map(r => r.eco_index))).toFixed(3)"></span></div>
                                        </div>
                                        <div>
                                            <div class="text-[10px] uppercase tracking-wider text-gray-400 font-bold mb-1">Kriteria 2: Popularitas (<span x-text="form.priority === 'sepi' ? 'Cost' : 'Benefit'"></span>)</div>
                                            <div>Nilai Awal: <span class="font-bold text-gray-800" x-text="res.view_count"></span> views</div>
                                            <!-- Normalisasi -->
                                            <div class="text-gray-400 mt-1">Ternormalisasi (x) = 
                                                <span x-text="form.priority === 'sepi' ? (res.view_count === 0 ? 1 : Math.min(...results.map(r => r.view_count))/res.view_count).toFixed(3) : (res.view_count / Math.max(...results.map(r => r.view_count))).toFixed(3)"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-gray-100 bg-gray-50/80 -mx-4 -mb-4 p-4 rounded-b-xl flex items-center justify-between">
                                        <span class="font-bold text-gray-700">Skor Akhir (Σ w * x)</span>
                                        <span class="font-bold text-teal-600 text-sm" x-text="res.final_score.toFixed(4)"></span>
                                    </div>
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
