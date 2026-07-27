{{-- Jelajahi Madura — Interactive Region Explorer --}}
@php
    $regencies = \App\Models\Regency::withCount('approvedContents')->get();
    
    $regencyMeta = [
        'bangkalan' => [
            'tagline' => 'Gerbang Madura',
            'highlight' => 'Bukit Jaddih • Mercusuar Sembilangan',
            'icon' => 'mountain',
            'gradient' => 'from-[#0a2622] to-[#1a4a3e]',
        ],
        'sampang' => [
            'tagline' => 'Pesona Alam Tersembunyi',
            'highlight' => 'Air Terjun Toroan • Pantai Camplong',
            'icon' => 'waves',
            'gradient' => 'from-[#1e3a5f] to-[#2d5a8e]',
        ],
        'pamekasan' => [
            'tagline' => 'Kota Batik & Budaya',
            'highlight' => 'Api Abadi • Kampung Batik Klampar',
            'icon' => 'flame',
            'gradient' => 'from-[#7c2d12] to-[#b45309]',
        ],
        'sumenep' => [
            'tagline' => 'Mutiara Timur Madura',
            'highlight' => 'Gili Labak • Gili Iyang • Keraton',
            'icon' => 'crown',
            'gradient' => 'from-[#4a1d6e] to-[#7c3aed]',
        ],
    ];
@endphp

<section class="py-16 md:py-24 bg-[#fafafa] overflow-hidden">
    <div class="max-w-6xl mx-auto px-6">

        {{-- Section Header --}}
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-[#e0f2f1] text-[#0a2622] text-[10px] font-bold rounded-full mb-6">
                Jelajahi Pulau Madura
            </span>
            <h2 class="text-[32px] md:text-[38px] lg:text-[44px] font-bold text-[#0a2622] leading-tight md:leading-[1.15] mb-4">
                Empat Kabupaten,<br class="hidden md:block"> Ribuan <span class="text-[#ff8a65]">Cerita</span>
            </h2>
            <p class="text-gray-500 leading-relaxed text-[14px] max-w-xl mx-auto">
                Setiap sudut Madura menyimpan keunikan tersendiri. Pilih kabupaten untuk mulai menjelajah.
            </p>
        </div>

        {{-- Region Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($regencies as $regency)
                @php
                    $meta = $regencyMeta[$regency->slug] ?? [
                        'tagline' => 'Kabupaten Madura',
                        'highlight' => '',
                        'icon' => 'map-pin',
                        'gradient' => 'from-[#0a2622] to-[#1a4a3e]',
                    ];
                    $coverImg = asset($regency->img);
                @endphp

                <a href="/explore/{{ $regency->slug }}"
                   class="group relative bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.04)] hover:shadow-xl hover:shadow-black/[0.06] hover:-translate-y-1 transition-all duration-500">
                    
                    {{-- Image --}}
                    <div class="relative h-44 overflow-hidden">
                        <img src="{{ $coverImg }}" alt="{{ $regency->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             onerror="this.src='{{ asset('images/pantai.png') }}'">
                        
                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        
                        {{-- Floating Badge --}}
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm rounded-full px-2.5 py-1 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#10b981] animate-pulse"></span>
                            <span class="text-[10px] font-bold text-[#0f172a]">{{ $regency->approved_contents_count }} destinasi</span>
                        </div>

                        {{-- Region Name on Image --}}
                        <div class="absolute bottom-3 left-4">
                            <h3 class="text-white text-lg font-bold drop-shadow-lg">{{ $regency->name }}</h3>
                            <p class="text-white/80 text-[11px] font-medium">{{ $meta['tagline'] }}</p>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        {{-- Highlights --}}
                        <p class="text-gray-500 text-[12px] leading-relaxed line-clamp-2 mb-3">
                            {{ $meta['highlight'] }}
                        </p>

                        {{-- CTA --}}
                        <div class="flex items-center gap-1.5 text-[#0a2622] text-[12px] font-bold group-hover:gap-3 transition-all duration-300">
                            <span>Jelajahi</span>
                            <x-lucide-arrow-right class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" />
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Island Stat Bar --}}
        <div class="mt-10 bg-white rounded-2xl border border-gray-100 p-4 md:p-5 flex flex-wrap items-center justify-center gap-6 md:gap-10">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#f0fdfa] flex items-center justify-center">
                    <x-lucide-map-pin class="w-4.5 h-4.5 text-[#0d9488]" />
                </div>
                <div>
                    <p class="text-[18px] font-bold text-[#0f172a]">{{ $regencies->sum('approved_contents_count') }}</p>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Destinasi</p>
                </div>
            </div>
            <div class="w-px h-8 bg-gray-100 hidden md:block"></div>
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#fef3c7] flex items-center justify-center">
                    <x-lucide-layout-grid class="w-4.5 h-4.5 text-[#d97706]" />
                </div>
                <div>
                    <p class="text-[18px] font-bold text-[#0f172a]">{{ \App\Models\Category::count() }}</p>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Kategori</p>
                </div>
            </div>
            <div class="w-px h-8 bg-gray-100 hidden md:block"></div>
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#ede9fe] flex items-center justify-center">
                    <x-lucide-users class="w-4.5 h-4.5 text-[#7c3aed]" />
                </div>
                <div>
                    <p class="text-[18px] font-bold text-[#0f172a]">{{ \App\Models\User::where('role', 'contributor')->count() }}</p>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Kontributor</p>
                </div>
            </div>
            <div class="w-px h-8 bg-gray-100 hidden md:block"></div>
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#fce7f3] flex items-center justify-center">
                    <x-lucide-globe class="w-4.5 h-4.5 text-[#db2777]" />
                </div>
                <div>
                    <p class="text-[18px] font-bold text-[#0f172a]">4</p>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Kabupaten</p>
                </div>
            </div>
        </div>
    </div>
</section>
