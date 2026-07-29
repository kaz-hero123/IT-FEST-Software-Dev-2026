@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
@php
    $regencyBySlug = $regencies->keyBy('slug');
    $regionData = [
        'bangkalan' => [
            'desc' => 'Kota pertama yang menyambut dari Jawa. Nikmati megahnya Jembatan Suramadu dan keindahan Bukit Jaddih yang memukau.',
            'stats' => [
                ['icon' => 'map-pin', 'label' => 'Destinasi'],
                ['icon' => 'landmark', 'value' => 'Suramadu'],
                ['icon' => 'compass', 'value' => 'Barat'],
            ],
        ],
        'sampang' => [
            'desc' => 'Surga tersembunyi dengan air terjun Toroan yang memukau dan tradisi Karapan Sapi yang legendaris.',
            'stats' => [
                ['icon' => 'map-pin', 'label' => 'Destinasi'],
                ['icon' => 'landmark', 'value' => 'Toroan'],
                ['icon' => 'compass', 'value' => 'Tengah'],
            ],
        ],
        'pamekasan' => [
            'desc' => 'Pusat kebudayaan Madura dengan Batik Pamekasan yang mendunia dan pesona Api Tak Kunjung Padam.',
            'stats' => [
                ['icon' => 'map-pin', 'label' => 'Destinasi'],
                ['icon' => 'landmark', 'value' => 'Batik Klampar'],
                ['icon' => 'compass', 'value' => 'Timur'],
            ],
        ],
        'sumenep' => [
            'desc' => 'Ujung timur Madura dengan kepulauan eksotis, Keraton Sumenep bersejarah, dan pantai-pantai tersembunyi.',
            'stats' => [
                ['icon' => 'map-pin', 'label' => 'Destinasi'],
                ['icon' => 'landmark', 'value' => 'Gili Labak'],
                ['icon' => 'compass', 'value' => 'Ujung Timur'],
            ],
        ],
    ];
@endphp

<style>
    .accordion-container {
        display: flex;
        gap: 6px;
        height: 75vh;
        min-height: 520px;
        max-height: 700px;
    }
    .accordion-panel {
        position: relative;
        flex: 1;
        overflow: hidden;
        cursor: pointer;
        border-radius: 20px;
        transition: flex 0.55s cubic-bezier(0.4, 0, 0.15, 1);
    }
    .accordion-container:hover .accordion-panel,
    .accordion-container:focus-within .accordion-panel { flex: 0.7; }
    .accordion-container .accordion-panel:hover,
    .accordion-container .accordion-panel:focus-within { flex: 4; }

    .accordion-panel .panel-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.15, 1), filter 0.5s ease;
    }
    .accordion-panel:hover .panel-bg,
    .accordion-panel:focus-within .panel-bg { transform: scale(1.08); filter: brightness(0.85); }
    .accordion-panel:not(:hover):not(:focus-within) .panel-bg { filter: brightness(0.45) saturate(0.6); }

    .accordion-panel .panel-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10,38,34,0.95) 0%, rgba(10,38,34,0.6) 30%, rgba(10,38,34,0.15) 55%, transparent 100%);
        transition: opacity 0.4s ease;
    }
    .accordion-panel:hover .panel-overlay,
    .accordion-panel:focus-within .panel-overlay {
        background: linear-gradient(to top, rgba(10,38,34,0.92) 0%, rgba(10,38,34,0.45) 35%, rgba(10,38,34,0.05) 60%, transparent 100%);
    }

    .panel-collapsed-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 24px 16px;
        text-align: center;
        opacity: 1;
        transition: opacity 0.3s ease 0.1s;
        z-index: 10;
    }
    .accordion-panel:hover .panel-collapsed-label,
    .accordion-panel:focus-within .panel-collapsed-label { opacity: 0; transition: opacity 0.15s ease; }

    .panel-number {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 10;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: rgba(255,255,255,0.35);
        transition: color 0.4s ease;
    }
    .accordion-panel:hover .panel-number,
    .accordion-panel:focus-within .panel-number { color: rgba(255,255,255,0.7); }

    .panel-expanded-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 32px 28px;
        z-index: 10;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.35s ease, transform 0.45s cubic-bezier(0.4, 0, 0.15, 1);
    }
    .accordion-panel:hover .panel-expanded-content,
    .accordion-panel:focus-within .panel-expanded-content { opacity: 1; transform: translateY(0); transition-delay: 0.15s; }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 10px;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.12);
        font-size: 12px;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
        white-space: nowrap;
    }

    @media (max-width: 767px) {
        .accordion-container { flex-direction: column; height: auto; min-height: unset; max-height: unset; gap: 12px; }
        .accordion-panel { flex: none !important; height: 220px; border-radius: 18px; }
        .accordion-panel:not(:hover) .panel-bg { filter: brightness(0.6) saturate(0.8); }
        .panel-collapsed-label { opacity: 1 !important; }
        .accordion-panel:hover .panel-collapsed-label { opacity: 0 !important; }
        .panel-expanded-content { padding: 20px 18px; }
        .accordion-panel:hover { height: 360px; }
    }
</style>

<!-- Hero Banner -->
<section class="relative h-[85vh] flex items-center justify-center overflow-hidden ">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="{{ asset('images/culture/culture03.jpg') }}"
             alt="Eksplorasi Madura"
             data-parallax
             data-parallax-speed="0.25"
             data-parallax-scale="1.35"
             class="w-full h-full object-cover origin-center will-change-transform">
        <div class="absolute inset-0 bg-[#0a2622]/40 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a2622]/60 via-[#0a2622]/30 to-[#0a2622]"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-4xl px-4 text-center mx-auto mt-4">
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-6 drop-shadow-[0_4px_4px_rgba(0,0,0,0.4)] leading-tight tracking-wide min-h-[1.3em]">
            <span class="inline-block text-white"
                  data-typing='["Empat Kabupaten, Satu Petualangan"]'
                  data-typing-speed="80"
                  data-loop="false">
                <span class="typing-target"></span><span class="inline-block w-[3px] md:w-[4px] h-[0.85em] bg-white ml-1 translate-y-[2px] animate-typing-cursor align-middle"></span>
            </span>
        </h1>
        <p class="text-sm md:text-lg text-white/80 max-w-xl mx-auto font-medium leading-relaxed drop-shadow-sm">
            Pilih destinasi impianmu dan mulai eksplorasi keindahan Madura.
        </p>
    </div>

    <!-- Fade ke hijau -->
    <div class="absolute bottom-0 left-0 right-0 h-48 bg-gradient-to-t from-[#0a2622] via-[#0a2622]/80 to-transparent"></div>
</section>

<!-- Photo Accordion -->
<section class="bg-[#0a2622] px-4 md:px-6 pb-10 pt-8">
    <!-- Section Header -->
    <div class="max-w-7xl mx-auto text-center mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
            Pilih Kabupaten Tujuanmu
        </h2>
        <p class="text-sm md:text-base text-white/60 max-w-xl mx-auto leading-relaxed">
            Madura terdiri dari empat kabupaten dengan keunikan dan daya tariknya masing-masing.
        </p>
    </div>
    <div class="accordion-container max-w-7xl mx-auto">
        @foreach($regionData as $slug => $data)
            @php
                $regency = $regencyBySlug->get($slug);
                $name = $regency->name ?? ucfirst($slug);
                $count = $regency->approved_contents_count ?? 0;
                $imgPath = $regency->img ?? 'images/pantai.png';
            @endphp

            <a href="{{ url('/explore/' . $slug) }}" class="accordion-panel group" aria-label="Jelajahi {{ $name }}">

                <img src="{{ asset($imgPath) }}" alt="{{ $name }}" class="panel-bg" loading="lazy" onerror="this.src='{{ asset('images/pantai.png') }}'">
                <div class="panel-overlay"></div>

                <!-- Collapsed -->
                <div class="panel-collapsed-label">
                    <p class="text-white font-bold text-base md:text-lg tracking-wide mb-1">{{ $name }}</p>
                </div>

                <!-- Expanded -->
                <div class="panel-expanded-content">

                    <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight mb-2 tracking-tight">{{ $name }}</h2>

                    <p class="text-white/60 text-sm leading-relaxed mb-5 max-w-md">{{ $data['desc'] }}</p>

                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach($data['stats'] as $stat)
                            <span class="stat-pill">
                                @if($stat['icon'] === 'map-pin')
                                    <x-lucide-map-pin class="w-3.5 h-3.5 text-[#ed8a53]" />
                                    <span>{{ $count }} {{ $stat['label'] }}</span>
                                @elseif($stat['icon'] === 'landmark')
                                    <x-lucide-landmark class="w-3.5 h-3.5 text-[#ed8a53]" />
                                    <span>{{ $stat['value'] }}</span>
                                @else
                                    <x-lucide-compass class="w-3.5 h-3.5 text-[#ed8a53]" />
                                    <span>{{ $stat['value'] }}</span>
                                @endif
                            </span>
                        @endforeach
                    </div>

                    <span class="inline-flex items-center gap-2 bg-[#EF8D55] hover:bg-[#D67C46] transition-colors duration-200 text-white text-sm font-bold py-3 px-6 rounded-xl shadow-lg">
                        Mulai Jelajah
                        <x-lucide-arrow-right class="w-4 h-4" />
                    </span>
                </div>
            </a>
        @endforeach
    </div>
    <p class="text-center mt-8 text-sm text-white/40 italic"> Arahkan kursor ke panel untuk melihat lebih lanjut.</p>
</section>
@endsection
