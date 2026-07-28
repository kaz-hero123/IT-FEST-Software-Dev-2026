@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
@php
    $regencyBySlug = $regencies->keyBy('slug');
    $regionData = [
        'bangkalan' => [
            'tagline' => 'Gerbang Madura',
            'desc' => 'Kota pertama yang menyambut dari Jawa. Nikmati megahnya Jembatan Suramadu dan keindahan Bukit Jaddih yang memukau.',
            'number' => '01',
            'stats' => [
                ['icon' => 'map-pin', 'label' => 'Destinasi'],
                ['icon' => 'landmark', 'value' => 'Suramadu'],
                ['icon' => 'compass', 'value' => 'Barat'],
            ],
        ],
        'sampang' => [
            'tagline' => 'Alam Tersembunyi',
            'desc' => 'Surga tersembunyi dengan air terjun Toroan yang memukau dan tradisi Karapan Sapi yang legendaris.',
            'number' => '02',
            'stats' => [
                ['icon' => 'map-pin', 'label' => 'Destinasi'],
                ['icon' => 'landmark', 'value' => 'Toroan'],
                ['icon' => 'compass', 'value' => 'Tengah'],
            ],
        ],
        'pamekasan' => [
            'tagline' => 'Kota Batik',
            'desc' => 'Pusat kebudayaan Madura dengan Batik Pamekasan yang mendunia dan pesona Api Tak Kunjung Padam.',
            'number' => '03',
            'stats' => [
                ['icon' => 'map-pin', 'label' => 'Destinasi'],
                ['icon' => 'landmark', 'value' => 'Batik Klampar'],
                ['icon' => 'compass', 'value' => 'Timur'],
            ],
        ],
        'sumenep' => [
            'tagline' => 'Mutiara Timur',
            'desc' => 'Ujung timur Madura dengan kepulauan eksotis, Keraton Sumenep bersejarah, dan pantai-pantai tersembunyi.',
            'number' => '04',
            'stats' => [
                ['icon' => 'map-pin', 'label' => 'Destinasi'],
                ['icon' => 'landmark', 'value' => 'Gili Labak'],
                ['icon' => 'compass', 'value' => 'Ujung Timur'],
            ],
        ],
    ];
@endphp

<style>
    /* =============================================
       CINEMATIC PHOTO ACCORDION — Explore Page
       ============================================= */

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

    /* Expanded state */
    .accordion-container:hover .accordion-panel,
    .accordion-container:focus-within .accordion-panel {
        flex: 0.7;
    }
    .accordion-container .accordion-panel:hover,
    .accordion-container .accordion-panel:focus-within {
        flex: 4;
    }

    /* Background image */
    .accordion-panel .panel-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.15, 1),
                    filter 0.5s ease;
    }
    .accordion-panel:hover .panel-bg,
    .accordion-panel:focus-within .panel-bg {
        transform: scale(1.08);
        filter: brightness(0.85);
    }
    .accordion-panel:not(:hover):not(:focus-within) .panel-bg {
        filter: brightness(0.45) saturate(0.6);
    }

    /* Gradient overlay */
    .accordion-panel .panel-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(10, 38, 34, 0.95) 0%,
            rgba(10, 38, 34, 0.6) 30%,
            rgba(10, 38, 34, 0.15) 55%,
            transparent 100%
        );
        transition: opacity 0.4s ease;
    }
    .accordion-panel:hover .panel-overlay,
    .accordion-panel:focus-within .panel-overlay {
        background: linear-gradient(
            to top,
            rgba(10, 38, 34, 0.92) 0%,
            rgba(10, 38, 34, 0.45) 35%,
            rgba(10, 38, 34, 0.05) 60%,
            transparent 100%
        );
    }

    /* Collapsed label (visible when not hovered) */
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
    .accordion-panel:focus-within .panel-collapsed-label {
        opacity: 0;
        transition: opacity 0.15s ease;
    }

    /* Region number (top-left) */
    .panel-number {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 10;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.35);
        transition: color 0.4s ease;
    }
    .accordion-panel:hover .panel-number,
    .accordion-panel:focus-within .panel-number {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Expanded content (visible on hover) */
    .panel-expanded-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 32px 28px;
        z-index: 10;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.35s ease,
                    transform 0.45s cubic-bezier(0.4, 0, 0.15, 1);
    }
    .accordion-panel:hover .panel-expanded-content,
    .accordion-panel:focus-within .panel-expanded-content {
        opacity: 1;
        transform: translateY(0);
        transition-delay: 0.15s;
    }

    /* Stats row */
    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        font-size: 12px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        white-space: nowrap;
    }

    /* CTA button */
    .explore-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 14px;
        background: #af4926;
        color: white;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.25s ease, transform 0.25s ease, gap 0.3s ease;
        border: none;
        cursor: pointer;
    }
    .explore-cta:hover {
        background: #c85530;
        transform: translateY(-1px);
        gap: 12px;
    }

    /* Scan line animation */
    @keyframes scanline {
        0% { transform: translateY(-100%); }
        100% { transform: translateY(100vh); }
    }
    .accordion-panel::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(237, 138, 83, 0.5), transparent);
        opacity: 0;
        z-index: 15;
        transition: opacity 0.3s ease;
    }
    .accordion-panel:hover::after,
    .accordion-panel:focus-within::after {
        opacity: 1;
        animation: scanline 2.5s linear infinite;
    }

    /* Corner brackets (game UI element) */
    .corner-bracket {
        position: absolute;
        width: 20px;
        height: 20px;
        z-index: 12;
        opacity: 0;
        transition: opacity 0.3s ease 0.2s;
    }
    .accordion-panel:hover .corner-bracket,
    .accordion-panel:focus-within .corner-bracket {
        opacity: 0.5;
    }
    .corner-bracket.tl { top: 14px; left: 14px; border-top: 2px solid #ed8a53; border-left: 2px solid #ed8a53; }
    .corner-bracket.tr { top: 14px; right: 14px; border-top: 2px solid #ed8a53; border-right: 2px solid #ed8a53; }
    .corner-bracket.bl { bottom: 14px; left: 14px; border-bottom: 2px solid #ed8a53; border-left: 2px solid #ed8a53; }
    .corner-bracket.br { bottom: 14px; right: 14px; border-bottom: 2px solid #ed8a53; border-right: 2px solid #ed8a53; }

    /* Mobile: vertical stack */
    @media (max-width: 767px) {
        .accordion-container {
            flex-direction: column;
            height: auto;
            min-height: unset;
            max-height: unset;
            gap: 12px;
        }
        .accordion-panel {
            flex: none !important;
            height: 220px;
            border-radius: 18px;
        }
        .accordion-panel:not(:hover) .panel-bg {
            filter: brightness(0.6) saturate(0.8);
        }
        .panel-collapsed-label {
            opacity: 1 !important;
        }
        .accordion-panel:hover .panel-collapsed-label {
            opacity: 0 !important;
        }
        .panel-expanded-content {
            padding: 20px 18px;
        }
        .accordion-panel:hover {
            height: 360px;
        }
        .accordion-panel::after {
            display: none;
        }
        .corner-bracket {
            display: none;
        }
    }
</style>

{{-- ========================================
     SECTION 1: HERO BANNER
     ======================================== --}}
<section class="relative w-full h-[50vh] min-h-[340px] max-h-[480px] flex items-center justify-center overflow-hidden">
    {{-- Background --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/culture/culture03.jpg') }}"
             alt="Pulau Madura"
             class="w-full h-full object-cover"
             style="object-position: center 40%;">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a2622]/70 via-[#0a2622]/50 to-[#0a2622]"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-4 max-w-3xl mx-auto">
        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.15em] text-white/90 mb-5">
            <x-lucide-compass class="w-3.5 h-3.5" />
            Jelajahi Madura
        </span>
        <h1 class="text-[30px] md:text-[44px] lg:text-[52px] font-extrabold text-white leading-[1.15] mb-4 tracking-tight">
            Empat Kabupaten,<br>
            <span class="text-[#ed8a53]">Satu Petualangan</span>
        </h1>
        <p class="text-[14px] md:text-[16px] text-white/65 leading-relaxed max-w-lg mx-auto">
            Pilih destinasi impianmu. Hover untuk mengintip, klik untuk memulai eksplorasi.
        </p>

        {{-- Scroll indicator --}}
        <div class="mt-8 flex flex-col items-center gap-2 animate-bounce">
            <x-lucide-chevron-down class="w-5 h-5 text-white/40" />
        </div>
    </div>
</section>

{{-- ========================================
     SECTION 2: PHOTO ACCORDION
     ======================================== --}}
<section class="bg-[#0a2622] px-3 md:px-6 pb-6 md:pb-10">
    {{-- Accordion --}}
    <div class="accordion-container max-w-7xl mx-auto -mt-6 md:-mt-10">
        @foreach($regionData as $slug => $data)
            @php
                $regency = $regencyBySlug->get($slug);
                $name = $regency->name ?? ucfirst($slug);
                $count = $regency->approved_contents_count ?? 0;
                $imgPath = $regency->img ?? 'images/pantai.png';
            @endphp

            <a href="{{ url('/explore/' . $slug) }}"
               class="accordion-panel group"
               aria-label="Jelajahi {{ $name }} — {{ $count }} destinasi">

                {{-- Corner brackets (game UI) --}}
                <div class="corner-bracket tl"></div>
                <div class="corner-bracket tr"></div>
                <div class="corner-bracket bl"></div>
                <div class="corner-bracket br"></div>

                {{-- Region number --}}
                <span class="panel-number">{{ $data['number'] }}</span>

                {{-- Background photo --}}
                <img src="{{ asset($imgPath) }}"
                     alt="{{ $name }}"
                     class="panel-bg"
                     loading="lazy"
                     onerror="this.src='{{ asset('images/pantai.png') }}'">

                {{-- Gradient overlay --}}
                <div class="panel-overlay"></div>

                {{-- COLLAPSED STATE: vertical label --}}
                <div class="panel-collapsed-label">
                    <p class="text-white font-extrabold text-[16px] md:text-[18px] tracking-wide mb-1">{{ $name }}</p>
                    <p class="text-white/50 text-[11px] font-semibold uppercase tracking-widest">{{ $data['tagline'] }}</p>
                </div>

                {{-- EXPANDED STATE: full details --}}
                <div class="panel-expanded-content">
                    {{-- Tagline badge --}}
                    <span class="inline-block rounded-full bg-[#ed8a53]/20 border border-[#ed8a53]/30 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-[#ed8a53] mb-3">
                        {{ $data['tagline'] }}
                    </span>

                    {{-- Region name --}}
                    <h2 class="text-[28px] md:text-[34px] font-extrabold text-white leading-tight mb-2 tracking-tight">
                        {{ $name }}
                    </h2>

                    {{-- Description --}}
                    <p class="text-white/60 text-[13px] leading-relaxed mb-5 max-w-md">
                        {{ $data['desc'] }}
                    </p>

                    {{-- Stats row --}}
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

                    {{-- CTA --}}
                    <span class="explore-cta">
                        Mulai Jelajah
                        <x-lucide-arrow-right class="w-4 h-4" />
                    </span>
                </div>
            </a>
        @endforeach
    </div>

    {{-- Bottom stat bar --}}
    <div class="max-w-7xl mx-auto mt-5 md:mt-7 flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-2">
        <div class="flex items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-[#ed8a53]">
                <x-lucide-gamepad-2 class="h-4 w-4" />
            </span>
            <span class="text-[13px] text-white/50">
                <strong class="font-bold text-white/80">4 zona perjalanan</strong> siap dijelajahi
            </span>
        </div>
        <p class="text-[11px] font-medium text-white/30">
            Hover untuk mengintip · Klik untuk masuk · Tab untuk navigasi keyboard
        </p>
    </div>
</section>
@endsection
