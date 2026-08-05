@extends('layouts.layout')
@section('title', 'Jelajahi Madura — Empat Kabupaten, Ribuan Cerita')

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
        gap: 12px;
        height: 70vh;
        min-height: 500px;
        max-height: 650px;
    }
    .accordion-panel {
        position: relative;
        flex: 1;
        overflow: hidden;
        cursor: pointer;
        border-radius: 24px;
        transition: flex 0.6s cubic-bezier(0.25, 1, 0.5, 1);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.3);
    }
    .accordion-container:hover .accordion-panel,
    .accordion-container:focus-within .accordion-panel { flex: 0.8; }
    .accordion-container .accordion-panel:hover,
    .accordion-container .accordion-panel:focus-within { flex: 4; }

    .accordion-panel .panel-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1), filter 0.6s ease;
    }
    .accordion-panel:hover .panel-bg,
    .accordion-panel:focus-within .panel-bg { 
        transform: scale(1.05); 
        filter: brightness(0.9) saturate(1.1); 
    }
    .accordion-panel:not(:hover):not(:focus-within) .panel-bg { 
        filter: brightness(0.7) saturate(0.9); 
    }

    .accordion-panel .panel-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(10,38,34,0.85) 0%, rgba(10,38,34,0.1) 40%, transparent 100%);
        transition: opacity 0.5s ease, background 0.5s ease;
    }
    .accordion-panel:hover .panel-overlay,
    .accordion-panel:focus-within .panel-overlay {
        background: linear-gradient(to top, rgba(10,38,34,0.95) 0%, rgba(10,38,34,0.5) 45%, rgba(10,38,34,0.1) 100%);
    }

    .panel-collapsed-label {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        padding: 12px 24px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 100px;
        text-align: center;
        opacity: 1;
        transition: all 0.4s ease;
        z-index: 10;
        white-space: nowrap;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .accordion-panel:hover .panel-collapsed-label,
    .accordion-panel:focus-within .panel-collapsed-label { 
        opacity: 0; 
        transform: translate(-50%, 20px); 
    }
    
    .panel-collapsed-label p {
        color: white;
        font-weight: 700;
        font-size: 16px;
        letter-spacing: 0.05em;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .panel-number {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 10;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: rgba(255,255,255,0.4);
        transition: color 0.4s ease;
    }
    .accordion-panel:hover .panel-number,
    .accordion-panel:focus-within .panel-number { color: rgba(255,255,255,0.8); }

    .panel-expanded-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 40px 32px;
        z-index: 10;
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.4s ease, transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .accordion-panel:hover .panel-expanded-content,
    .accordion-panel:focus-within .panel-expanded-content { opacity: 1; transform: translateY(0); transition-delay: 0.15s; }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 12px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        white-space: nowrap;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    @media (max-width: 767px) {
        .accordion-container { flex-direction: column; height: auto; min-height: unset; max-height: unset; gap: 16px; }
        .accordion-panel { flex: none !important; height: 240px; border-radius: 20px; }
        .accordion-panel:not(:hover) .panel-bg { filter: brightness(0.8) saturate(0.9); }
        .panel-collapsed-label { opacity: 1 !important; bottom: 20px; }
        .accordion-panel:hover .panel-collapsed-label { opacity: 0 !important; }
        .panel-expanded-content { padding: 24px 20px; }
        .accordion-panel:hover { height: 380px; }
    }
</style>

<!-- Hero Banner -->
<section class="relative h-[85vh] flex items-center justify-center overflow-hidden ">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="{{ asset('images/culture/culture05.jpg') }}"
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
                  data-typing='["Jelajahi Empat Kabupaten"]'
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
                    <p>{{ $name }}</p>
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

<!-- Smart Predictor Section -->
@include('pages.user.explore.components.user-explore-predictor')
@endsection
