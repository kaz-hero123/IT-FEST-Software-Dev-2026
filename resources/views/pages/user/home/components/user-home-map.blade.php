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
        <div class="text-center mb-12">
            <h2 class="text-[32px] md:text-[38px] lg:text-[44px] font-bold text-[#0a2622] leading-tight md:leading-[1.15] mb-3">
                Empat Kabupaten,<br class="hidden md:block"> Ribuan <span class="text-[#ff8a65]">Cerita</span>
            </h2>
            <p class="text-gray-500 leading-relaxed text-[14px] max-w-xl mx-auto">
                Setiap sudut Madura menyimpan keunikan tersendiri. Pilih kabupaten untuk mulai menjelajah.
            </p>
        </div>

        {{-- Region Cards (Full Image Clean Overlay) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($regencies as $regency)
                @php
                    $meta = $regencyMeta[$regency->slug] ?? [
                        'tagline' => 'Kabupaten Madura',
                        'highlight' => '',
                    ];
                    $coverImg = asset($regency->img);
                @endphp

                <a href="/explore/{{ $regency->slug }}"
                   class="group relative h-72 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500">
                    
                    {{-- Background Image --}}
                    <img src="{{ $coverImg }}" alt="{{ $regency->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         onerror="this.src='{{ asset('images/pantai.png') }}'">
                    
                    {{-- Dark Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent transition-opacity duration-300"></div>

                    {{-- Destinasi Badge --}}
                    <div class="absolute top-3.5 right-3.5 bg-black/40 backdrop-blur-md px-2.5 py-1 rounded-full border border-white/10 text-[10px] font-medium text-white/90">
                        {{ $regency->approved_contents_count }} Destinasi
                    </div>

                    {{-- Content at Bottom --}}
                    <div class="absolute bottom-0 inset-x-0 p-5 flex items-end justify-between gap-3">
                        <div>
                            <span class="text-[11px] font-semibold text-[#ff8a65] tracking-wide block mb-0.5">
                                {{ $meta['tagline'] }}
                            </span>
                            <h3 class="text-white text-xl font-bold leading-tight drop-shadow-sm mb-1">
                                {{ $regency->name }}
                            </h3>
                            @if(!empty($meta['highlight']))
                                <p class="text-white/70 text-[11px] line-clamp-1 font-light">
                                    {{ $meta['highlight'] }}
                                </p>
                            @endif
                        </div>

                        {{-- Action Arrow Button --}}
                        <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white shrink-0 group-hover:bg-[#ff8a65] transition-all duration-300 transform group-hover:scale-110">
                            <x-lucide-arrow-right class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Island Stat Bar (Tanpa BG & dengan Animasi Count Up) --}}
        <div class="mt-10 py-4 flex flex-wrap items-center justify-around gap-6 md:gap-8">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#f0fdfa] flex items-center justify-center shrink-0">
                    <x-lucide-map-pin class="w-4.5 h-4.5 text-[#0d9488]" />
                </div>
                <div x-data="{
                    count: 0,
                    target: {{ $regencies->sum('approved_contents_count') }},
                    animated: false,
                    init() {
                        const observer = new IntersectionObserver((entries) => {
                            if (entries[0].isIntersecting && !this.animated) {
                                this.animated = true;
                                this.start();
                            }
                        }, { threshold: 0.2 });
                        observer.observe(this.$el);
                    },
                    start() {
                        const duration = 1200;
                        const start = performance.now();
                        const step = (now) => {
                            const progress = Math.min((now - start) / duration, 1);
                            const ease = 1 - Math.pow(1 - progress, 3);
                            this.count = Math.floor(ease * this.target);
                            if (progress < 1) requestAnimationFrame(step);
                            else this.count = this.target;
                        };
                        requestAnimationFrame(step);
                    }
                }">
                    <p class="text-[18px] font-bold text-[#0f172a] leading-tight" x-text="count + '+'">0+</p>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Destinasi</p>
                </div>
            </div>

            <div class="w-px h-8 bg-gray-200/60 hidden sm:block"></div>

            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#fef3c7] flex items-center justify-center shrink-0">
                    <x-lucide-layout-grid class="w-4.5 h-4.5 text-[#d97706]" />
                </div>
                <div x-data="{
                    count: 0,
                    target: {{ \App\Models\Category::count() }},
                    animated: false,
                    init() {
                        const observer = new IntersectionObserver((entries) => {
                            if (entries[0].isIntersecting && !this.animated) {
                                this.animated = true;
                                this.start();
                            }
                        }, { threshold: 0.2 });
                        observer.observe(this.$el);
                    },
                    start() {
                        const duration = 1000;
                        const start = performance.now();
                        const step = (now) => {
                            const progress = Math.min((now - start) / duration, 1);
                            const ease = 1 - Math.pow(1 - progress, 3);
                            this.count = Math.floor(ease * this.target);
                            if (progress < 1) requestAnimationFrame(step);
                            else this.count = this.target;
                        };
                        requestAnimationFrame(step);
                    }
                }">
                    <p class="text-[18px] font-bold text-[#0f172a] leading-tight" x-text="count">0</p>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Kategori</p>
                </div>
            </div>

            <div class="w-px h-8 bg-gray-200/60 hidden sm:block"></div>

            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#ede9fe] flex items-center justify-center shrink-0">
                    <x-lucide-users class="w-4.5 h-4.5 text-[#7c3aed]" />
                </div>
                <div x-data="{
                    count: 0,
                    target: {{ \App\Models\User::where('role', 'contributor')->count() }},
                    animated: false,
                    init() {
                        const observer = new IntersectionObserver((entries) => {
                            if (entries[0].isIntersecting && !this.animated) {
                                this.animated = true;
                                this.start();
                            }
                        }, { threshold: 0.2 });
                        observer.observe(this.$el);
                    },
                    start() {
                        const duration = 1000;
                        const start = performance.now();
                        const step = (now) => {
                            const progress = Math.min((now - start) / duration, 1);
                            const ease = 1 - Math.pow(1 - progress, 3);
                            this.count = Math.floor(ease * this.target);
                            if (progress < 1) requestAnimationFrame(step);
                            else this.count = this.target;
                        };
                        requestAnimationFrame(step);
                    }
                }">
                    <p class="text-[18px] font-bold text-[#0f172a] leading-tight" x-text="count + '+'">0+</p>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Kontributor</p>
                </div>
            </div>

            <div class="w-px h-8 bg-gray-200/60 hidden sm:block"></div>

            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#fce7f3] flex items-center justify-center shrink-0">
                    <x-lucide-globe class="w-4.5 h-4.5 text-[#db2777]" />
                </div>
                <div x-data="{
                    count: 0,
                    target: 4,
                    animated: false,
                    init() {
                        const observer = new IntersectionObserver((entries) => {
                            if (entries[0].isIntersecting && !this.animated) {
                                this.animated = true;
                                this.start();
                            }
                        }, { threshold: 0.2 });
                        observer.observe(this.$el);
                    },
                    start() {
                        const duration = 1000;
                        const start = performance.now();
                        const step = (now) => {
                            const progress = Math.min((now - start) / duration, 1);
                            const ease = 1 - Math.pow(1 - progress, 3);
                            this.count = Math.floor(ease * this.target);
                            if (progress < 1) requestAnimationFrame(step);
                            else this.count = this.target;
                        };
                        requestAnimationFrame(step);
                    }
                }">
                    <p class="text-[18px] font-bold text-[#0f172a] leading-tight" x-text="count">0</p>
                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Kabupaten</p>
                </div>
            </div>
        </div>
    </div>
</section>
