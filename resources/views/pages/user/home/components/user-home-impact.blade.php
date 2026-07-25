{{-- Smart Island Impact Dashboard — Publik-facing statistik platform --}}
@php
    $regencyStats = \App\Models\Regency::withCount('approvedContents')->get();
    $totalContents = $regencyStats->sum('approved_contents_count');
    $totalContributors = \App\Models\User::where('role', 'contributor')->count();
    $totalCategories = \App\Models\Category::count();
    $totalRegencies = $regencyStats->count();
@endphp

<section class="py-16 md:py-24 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-6">
        
        {{-- Section Header --}}
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#ecfdf5] text-[#0d9488] text-[11px] font-bold rounded-full mb-5 uppercase tracking-wider">
                <x-lucide-bar-chart-3 class="w-3.5 h-3.5" />
                Platform Impact
            </span>
            <h2 class="text-[32px] md:text-[36px] lg:text-[40px] font-bold text-[#0f172a] leading-tight md:leading-[1.2] mb-4">
                Data & Dampak <span class="text-[#10b981]">Smart Island</span>
            </h2>
            <p class="text-gray-500 leading-relaxed text-[14px] md:text-[15px] max-w-2xl mx-auto">
                Statistik real-time dari kontribusi komunitas lokal dalam membangun ekosistem pariwisata digital berkelanjutan di Pulau Madura.
            </p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-12">
            {{-- Total Destinasi --}}
            <div class="bg-gradient-to-br from-[#f8fafc] to-white rounded-2xl border border-gray-100 p-6 text-center group hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <div class="w-12 h-12 bg-[#af4926]/10 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                    <x-lucide-map-pin class="w-6 h-6 text-[#af4926]" />
                </div>
                <h3 class="text-[28px] md:text-[32px] font-extrabold text-[#0f172a] leading-none mb-1">{{ $totalContents }}</h3>
                <p class="text-[12px] text-gray-500 font-semibold">Destinasi Terkurasi</p>
            </div>
            {{-- Kontributor Aktif --}}
            <div class="bg-gradient-to-br from-[#f8fafc] to-white rounded-2xl border border-gray-100 p-6 text-center group hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <div class="w-12 h-12 bg-[#0d9488]/10 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                    <x-lucide-users class="w-6 h-6 text-[#0d9488]" />
                </div>
                <h3 class="text-[28px] md:text-[32px] font-extrabold text-[#0f172a] leading-none mb-1">{{ $totalContributors }}</h3>
                <p class="text-[12px] text-gray-500 font-semibold">Kontributor Lokal</p>
            </div>
            {{-- Kategori --}}
            <div class="bg-gradient-to-br from-[#f8fafc] to-white rounded-2xl border border-gray-100 p-6 text-center group hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <div class="w-12 h-12 bg-[#6366f1]/10 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                    <x-lucide-layers class="w-6 h-6 text-[#6366f1]" />
                </div>
                <h3 class="text-[28px] md:text-[32px] font-extrabold text-[#0f172a] leading-none mb-1">{{ $totalCategories }}</h3>
                <p class="text-[12px] text-gray-500 font-semibold">Kategori Konten</p>
            </div>
            {{-- Kabupaten --}}
            <div class="bg-gradient-to-br from-[#f8fafc] to-white rounded-2xl border border-gray-100 p-6 text-center group hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <div class="w-12 h-12 bg-[#f59e0b]/10 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                    <x-lucide-building-2 class="w-6 h-6 text-[#f59e0b]" />
                </div>
                <h3 class="text-[28px] md:text-[32px] font-extrabold text-[#0f172a] leading-none mb-1">{{ $totalRegencies }}</h3>
                <p class="text-[12px] text-gray-500 font-semibold">Kabupaten Tercakup</p>
            </div>
        </div>

        {{-- Per-Regency Breakdown --}}
        <div class="bg-gradient-to-br from-[#f8fafc] to-white rounded-2xl border border-gray-100 p-6 md:p-8">
            <h3 class="text-[14px] font-bold text-[#0f172a] mb-6 flex items-center gap-2">
                <x-lucide-trending-up class="w-4 h-4 text-[#10b981]" />
                Distribusi Konten per Kabupaten
            </h3>
            <div class="space-y-4">
                @foreach($regencyStats as $regency)
                @php 
                    $percentage = $totalContents > 0 ? round(($regency->approved_contents_count / $totalContents) * 100) : 0;
                @endphp
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-[13px] font-bold text-[#0f172a]">{{ $regency->name }}</span>
                        <span class="text-[12px] font-semibold text-gray-500">{{ $regency->approved_contents_count }} destinasi</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-[#0d9488] to-[#10b981] transition-all duration-700"
                             style="width: {{ max($percentage, 3) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Sustainability Footer --}}
        <div class="mt-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#ecfdf5] rounded-full">
                <x-lucide-leaf class="w-4 h-4 text-[#10b981]" />
                <p class="text-[12px] text-[#065f46] font-semibold">
                    Mendukung pembangunan pariwisata berkelanjutan — Smart Small Island Initiative
                </p>
            </div>
        </div>
    </div>
</section>
