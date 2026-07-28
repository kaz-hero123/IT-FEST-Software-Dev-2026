@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
@php
    $regencyBySlug = $regencies->keyBy('slug');
    $mapRegions = [
        'bangkalan' => [
            'label' => 'Bangkalan',
            'tagline' => 'Gerbang Madura',
            'fill' => '#0a2622',
            'fillHover' => '#0d332d',
            'accent' => '#f5c6a9',
            'attributes' => [
                ['icon' => '🏔️', 'label' => 'IKON', 'value' => 'Bukit Jaddih'],
                ['icon' => '🌉', 'label' => 'AKSES', 'value' => 'Jembatan Suramadu'],
                ['icon' => '🧭', 'label' => 'POSISI', 'value' => 'Barat Madura'],
            ],
            // SVG zone (organic, follows island outline on west side)
            'zone' => 'M78,281 C89,248 128,225 174,218 C214,211 247,195 290,202 C335,207 361,230 380,225 L380,560 L50,560 C60,400 70,310 78,281 Z',
            'popupX' => 120,
            'popupY' => 50,
        ],
        'sampang' => [
            'label' => 'Sampang',
            'tagline' => 'Alam Tersembunyi',
            'fill' => '#1b5148',
            'fillHover' => '#22665b',
            'accent' => '#d8ebe3',
            'attributes' => [
                ['icon' => '💧', 'label' => 'IKON', 'value' => 'Air Terjun Toroan'],
                ['icon' => '🏖️', 'label' => 'PANTAI', 'value' => 'Camplong Beach'],
                ['icon' => '🧭', 'label' => 'POSISI', 'value' => 'Tengah Barat'],
            ],
            'zone' => 'M380,225 C407,223 447,215 474,195 C490,200 510,205 540,210 L540,560 L380,560 Z',
            'popupX' => 350,
            'popupY' => 35,
        ],
        'pamekasan' => [
            'label' => 'Pamekasan',
            'tagline' => 'Batik & Budaya',
            'fill' => '#af4926',
            'fillHover' => '#c85530',
            'accent' => '#fff0e5',
            'attributes' => [
                ['icon' => '🔥', 'label' => 'IKON', 'value' => 'Api Tak Kunjung Padam'],
                ['icon' => '🎨', 'label' => 'BUDAYA', 'value' => 'Batik Klampar'],
                ['icon' => '🧭', 'label' => 'POSISI', 'value' => 'Tengah Timur'],
            ],
            'zone' => 'M540,210 C558,207 589,228 628,221 C669,214 704,197 730,200 L730,560 L540,560 Z',
            'popupX' => 560,
            'popupY' => 50,
        ],
        'sumenep' => [
            'label' => 'Sumenep',
            'tagline' => 'Mutiara Timur',
            'fill' => '#ed8a53',
            'fillHover' => '#f59d6e',
            'accent' => '#7c311a',
            'attributes' => [
                ['icon' => '🏝️', 'label' => 'IKON', 'value' => 'Gili Labak'],
                ['icon' => '🫁', 'label' => 'SPESIAL', 'value' => 'Pulau Oksigen'],
                ['icon' => '🧭', 'label' => 'POSISI', 'value' => 'Ujung Timur'],
            ],
            'zone' => 'M730,200 C746,203 793,211 824,232 C868,223 907,214 944,200 C989,208 1023,214 1054,232 C1068,257 1083,283 1042,328 C1003,353 957,361 908,356 C864,352 830,339 786,345 C760,348 740,350 730,355 L730,560 Z',
            'popupX' => 780,
            'popupY' => 35,
        ],
    ];
@endphp

<style>
    /* ========================================
       INTERACTIVE MAP — Game-Inspired Styles
       ======================================== */

    /* Region zone base */
    .map-region-zone {
        cursor: pointer;
        transition: filter 350ms cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 350ms ease;
    }

    /* Region group hover — zone glow */
    .map-region-group:hover .map-region-zone,
    .map-region-group:focus-within .map-region-zone {
        filter: brightness(1.25) saturate(1.15) drop-shadow(0 0 18px rgba(237, 138, 83, 0.35));
    }

    /* Tooltip — hidden by default */
    .map-tooltip-group {
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 280ms cubic-bezier(0.4, 0, 0.2, 1),
                    transform 280ms cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
    }

    /* Tooltip — visible on hover */
    .map-region-group:hover .map-tooltip-group,
    .map-region-group:focus-within .map-tooltip-group {
        opacity: 1;
        transform: translateY(0);
    }

    /* Dashed connector line */
    .map-connector {
        opacity: 0;
        transition: opacity 300ms ease 80ms;
    }
    .map-region-group:hover .map-connector,
    .map-region-group:focus-within .map-connector {
        opacity: 0.7;
    }

    /* Region label text */
    .map-region-label {
        transition: opacity 250ms ease;
    }
    .map-region-group:hover .map-region-label {
        opacity: 0.5;
    }

    /* Focus styling for keyboard nav */
    .map-region-group:focus { outline: none; }
    .map-region-group:focus-within .map-region-zone {
        filter: brightness(1.3) saturate(1.2) drop-shadow(0 0 22px rgba(237, 138, 83, 0.5));
    }

    /* Pulse animation for scan indicator */
    @keyframes pulse-ring {
        0% { r: 4; opacity: 0.7; }
        100% { r: 14; opacity: 0; }
    }
    .scan-pulse {
        animation: pulse-ring 2s ease-out infinite;
    }

    /* Float animation for tooltip */
    @keyframes float-gentle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }
    .map-region-group:hover .map-tooltip-group {
        animation: float-gentle 3s ease-in-out infinite;
        animation-delay: 0.3s;
    }
</style>

<section class="relative overflow-hidden bg-[#fafafa] py-10 md:py-16 min-h-screen">
    {{-- Subtle radial glow at top --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 h-56 bg-[radial-gradient(ellipse_at_top,_rgba(224,242,241,0.95),_transparent_72%)]"></div>

    <div class="relative mx-auto w-full max-w-6xl px-4 md:px-6">

        {{-- Header --}}
        <header class="mx-auto mb-8 max-w-2xl text-center md:mb-10">
            <span class="mb-5 inline-flex items-center gap-2 rounded-full bg-[#e0f2f1] px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.14em] text-[#0a2622]">
                <x-lucide-gamepad-2 class="h-3.5 w-3.5" aria-hidden="true" />
                Pilih zona perjalanan
            </span>
            <h1 class="mb-3 text-[28px] font-bold leading-tight text-[#0a2622] md:text-[38px]">
                Temukan <span class="text-[#ed8a53]">level berikutnya</span> di Madura
            </h1>
            <p class="text-[13px] leading-relaxed text-gray-500 md:text-[15px]">
                Arahkan cursor ke satu wilayah untuk melihat statistik perjalanannya, lalu klik untuk mulai menjelajah.
            </p>
        </header>

        {{-- Map Container --}}
        <div class="overflow-hidden rounded-[24px] border border-[#0a2622]/10 bg-white p-2.5 shadow-[0_20px_60px_-30px_rgba(10,38,34,0.35)] md:rounded-[32px] md:p-4">

            {{-- Info badge --}}
            <div class="relative overflow-hidden rounded-[18px] bg-[#e8f2ef] md:rounded-[24px]">
                <div class="absolute left-4 top-4 z-20 hidden rounded-xl border border-white/80 bg-white/80 px-3 py-2 shadow-sm backdrop-blur-sm md:block">
                    <p class="text-[9px] font-bold uppercase tracking-[0.12em] text-[#af4926]">Pulau Madura</p>
                    <p class="mt-0.5 text-[10px] font-medium text-[#0a2622]/70">Hover zona untuk membuka data</p>
                </div>

                {{-- ====== SVG MAP (Desktop) ====== --}}
                <svg viewBox="0 0 1120 560" class="hidden h-auto w-full md:block" role="img"
                     aria-label="Peta interaktif Pulau Madura dengan empat zona kabupaten"
                     xmlns="http://www.w3.org/2000/svg">

                    <defs>
                        {{-- Island outline --}}
                        <path id="madura-outline"
                              d="M78,281 C89,248 128,225 174,218 C214,211 247,195 290,202 C335,207 361,230 407,223 C447,215 474,195 515,201 C558,207 589,228 628,221 C669,214 704,197 746,203 C793,211 824,232 868,223 C907,214 944,200 989,208 C1023,214 1054,232 1068,257 C1083,283 1069,310 1042,328 C1003,353 957,361 908,356 C864,352 830,339 786,345 C739,352 702,369 658,366 C613,364 581,346 540,354 C500,361 460,371 420,362 C383,354 353,340 313,349 C270,358 235,367 193,356 C150,345 110,331 85,312 C72,302 70,292 78,281 Z" />
                        <clipPath id="island-clip">
                            <use href="#madura-outline" />
                        </clipPath>

                        {{-- Wave pattern for ocean --}}
                        <pattern id="ocean-wave" width="60" height="30" patternUnits="userSpaceOnUse">
                            <path d="M0,15 C10,7 20,7 30,15 S50,23 60,15" fill="none" stroke="#b8d8cf" stroke-width="1.2" opacity="0.6" />
                        </pattern>

                        {{-- Glow filter --}}
                        <filter id="glow-soft" x="-20%" y="-20%" width="140%" height="140%">
                            <feGaussianBlur stdDeviation="3" result="blur" />
                            <feMerge>
                                <feMergeNode in="blur" />
                                <feMergeNode in="SourceGraphic" />
                            </feMerge>
                        </filter>

                        {{-- Tooltip shadow filter --}}
                        <filter id="tooltip-shadow" x="-10%" y="-10%" width="130%" height="140%">
                            <feDropShadow dx="0" dy="6" stdDeviation="8" flood-color="#0a2622" flood-opacity="0.25" />
                        </filter>
                    </defs>

                    {{-- Ocean background --}}
                    <rect width="1120" height="560" fill="#e8f2ef" />
                    <rect width="1120" height="560" fill="url(#ocean-wave)" />

                    {{-- Decorative shipping lanes --}}
                    <path d="M60,180 C280,140 500,155 700,130 C850,110 980,140 1060,175" fill="none" stroke="#c6e1d9" stroke-width="1.5" stroke-dasharray="5 12" />
                    <path d="M80,420 C300,450 520,430 700,445 C850,458 970,440 1060,410" fill="none" stroke="#c6e1d9" stroke-width="1.5" stroke-dasharray="5 12" />

                    {{-- Island drop shadow --}}
                    <use href="#madura-outline" transform="translate(3,8)" fill="#0a2622" opacity="0.12" />

                    {{-- ====== INTERACTIVE REGIONS ====== --}}
                    @foreach($mapRegions as $slug => $region)
                        @php
                            $regency = $regencyBySlug->get($slug);
                            $name = $regency->name ?? $region['label'];
                            $count = $regency->approved_contents_count ?? 0;
                            $attrs = array_merge(
                                [['icon' => '📍', 'label' => 'DESTINASI', 'value' => $count . ' lokasi']],
                                $region['attributes']
                            );
                        @endphp

                        <a href="{{ url('/explore/' . $slug) }}"
                           class="map-region-group"
                           tabindex="0"
                           aria-label="Jelajahi {{ $name }} — {{ $count }} destinasi">

                            {{-- Colored zone inside island clip --}}
                            <g clip-path="url(#island-clip)">
                                <path d="{{ $region['zone'] }}"
                                      fill="{{ $region['fill'] }}"
                                      class="map-region-zone" />
                            </g>

                            {{-- Region label (always visible) --}}
                            <text x="{{ $region['popupX'] + 55 }}"
                                  y="{{ ($slug === 'sumenep') ? 290 : 310 }}"
                                  text-anchor="middle"
                                  fill="white"
                                  font-size="17"
                                  font-weight="700"
                                  class="map-region-label pointer-events-none"
                                  style="text-shadow: 0 2px 8px rgba(0,0,0,0.3);">{{ $name }}</text>
                            <text x="{{ $region['popupX'] + 55 }}"
                                  y="{{ ($slug === 'sumenep') ? 308 : 328 }}"
                                  text-anchor="middle"
                                  fill="white"
                                  font-size="10.5"
                                  font-weight="600"
                                  opacity="0.75"
                                  class="map-region-label pointer-events-none">{{ $region['tagline'] }} · {{ $count }} destinasi</text>

                            {{-- Scan pulse dot (always visible center of zone) --}}
                            <circle cx="{{ $region['popupX'] + 55 }}"
                                    cy="{{ ($slug === 'sumenep') ? 260 : 280 }}"
                                    r="4" fill="{{ $region['accent'] }}"
                                    class="pointer-events-none" />
                            <circle cx="{{ $region['popupX'] + 55 }}"
                                    cy="{{ ($slug === 'sumenep') ? 260 : 280 }}"
                                    r="4" fill="none" stroke="{{ $region['accent'] }}"
                                    stroke-width="1.5"
                                    class="scan-pulse pointer-events-none" />

                            {{-- Connector line (hover only) --}}
                            <line x1="{{ $region['popupX'] + 55 }}"
                                  y1="{{ ($slug === 'sumenep') ? 255 : 275 }}"
                                  x2="{{ $region['popupX'] + 100 }}"
                                  y2="{{ $region['popupY'] + 140 }}"
                                  stroke="{{ $region['accent'] }}"
                                  stroke-width="1.5"
                                  stroke-dasharray="4 6"
                                  class="map-connector pointer-events-none" />

                            {{-- ====== RPG TOOLTIP (hover only) ====== --}}
                            <g class="map-tooltip-group" filter="url(#tooltip-shadow)">
                                {{-- Tooltip body --}}
                                <rect x="{{ $region['popupX'] }}"
                                      y="{{ $region['popupY'] }}"
                                      width="210"
                                      height="136"
                                      rx="12"
                                      fill="#09201c"
                                      stroke="{{ $region['accent'] }}"
                                      stroke-width="1.5"
                                      opacity="0.97" />

                                {{-- Header bar --}}
                                <rect x="{{ $region['popupX'] }}"
                                      y="{{ $region['popupY'] }}"
                                      width="210"
                                      height="34"
                                      rx="12"
                                      fill="{{ $region['fill'] }}" />
                                {{-- Flatten bottom corners of header --}}
                                <rect x="{{ $region['popupX'] }}"
                                      y="{{ $region['popupY'] + 22 }}"
                                      width="210"
                                      height="12"
                                      fill="{{ $region['fill'] }}" />

                                {{-- "REGION UNLOCKED" badge --}}
                                <rect x="{{ $region['popupX'] + 9 }}"
                                      y="{{ $region['popupY'] + 8 }}"
                                      width="8" height="8" rx="2"
                                      fill="{{ $region['accent'] }}" />
                                <text x="{{ $region['popupX'] + 23 }}"
                                      y="{{ $region['popupY'] + 16 }}"
                                      fill="{{ $region['accent'] }}"
                                      font-size="8.5"
                                      font-weight="700"
                                      letter-spacing="1.1">REGION UNLOCKED</text>

                                {{-- Region number --}}
                                <text x="{{ $region['popupX'] + 197 }}"
                                      y="{{ $region['popupY'] + 16 }}"
                                      text-anchor="end"
                                      fill="{{ $region['accent'] }}"
                                      font-size="9"
                                      font-weight="700"
                                      opacity="0.6">{{ sprintf('%02d', $loop->iteration) }}</text>

                                {{-- Divider after header --}}
                                <line x1="{{ $region['popupX'] + 9 }}"
                                      y1="{{ $region['popupY'] + 34 }}"
                                      x2="{{ $region['popupX'] + 201 }}"
                                      y2="{{ $region['popupY'] + 34 }}"
                                      stroke="white" stroke-opacity="0.1" />

                                {{-- Region name large --}}
                                <text x="{{ $region['popupX'] + 12 }}"
                                      y="{{ $region['popupY'] + 53 }}"
                                      fill="white"
                                      font-size="15"
                                      font-weight="800">{{ strtoupper($name) }}</text>

                                {{-- Stat rows --}}
                                @foreach($attrs as $i => $attr)
                                    <text x="{{ $region['popupX'] + 12 }}"
                                          y="{{ $region['popupY'] + 74 + ($i * 16) }}"
                                          fill="{{ $region['accent'] }}"
                                          font-size="8"
                                          font-weight="700">{{ $attr['icon'] ?? '' }} {{ $attr['label'] }}</text>
                                    <text x="{{ $region['popupX'] + 88 }}"
                                          y="{{ $region['popupY'] + 74 + ($i * 16) }}"
                                          fill="white"
                                          font-size="9"
                                          font-weight="600">{{ $attr['value'] }}</text>
                                @endforeach

                                {{-- "KLIK UNTUK MASUK" footer --}}
                                <text x="{{ $region['popupX'] + 105 }}"
                                      y="{{ $region['popupY'] + 130 }}"
                                      text-anchor="middle"
                                      fill="{{ $region['accent'] }}"
                                      font-size="7.5"
                                      font-weight="700"
                                      letter-spacing="0.8"
                                      opacity="0.7">▶ KLIK UNTUK MASUK</text>
                            </g>
                        </a>
                    @endforeach

                    {{-- ====== ZONE DIVIDERS (on top of zones, inside clip) ====== --}}
                    <g clip-path="url(#island-clip)" fill="none" stroke="#fffaf4" stroke-linecap="round" opacity="0.55">
                        <line x1="380" y1="195" x2="380" y2="560" stroke-width="2" stroke-dasharray="6 8" />
                        <line x1="540" y1="195" x2="540" y2="560" stroke-width="2" stroke-dasharray="6 8" />
                        <line x1="730" y1="195" x2="730" y2="560" stroke-width="2" stroke-dasharray="6 8" />
                    </g>

                    {{-- Island outline stroke --}}
                    <use href="#madura-outline" fill="none" stroke="#fffaf4" stroke-width="3.5" stroke-linejoin="round" />

                    {{-- ====== KEPULAUAN SUMENEP (decorative small islands) ====== --}}
                    <g fill="#ed8a53" stroke="#7c311a" stroke-width="1.5">
                        <ellipse cx="900" cy="400" rx="16" ry="10" />
                        <ellipse cx="940" cy="418" rx="11" ry="7" />
                        <ellipse cx="975" cy="395" rx="8" ry="5" />
                        <ellipse cx="998" cy="414" rx="5" ry="3.5" />
                    </g>
                    <path d="M915,375 C930,385 938,395 940,408" fill="none" stroke="#af4926" stroke-width="1.3" stroke-dasharray="3 5" opacity="0.5" />
                    <text x="950" y="445" text-anchor="middle" fill="#6b9b8e" font-size="10" font-style="italic">Kepulauan Sumenep</text>

                    {{-- Ocean labels --}}
                    <text x="480" y="490" text-anchor="middle" fill="#9ec3b8" font-size="12" font-style="italic" opacity="0.8">Laut Jawa</text>
                    <text x="350" y="185" text-anchor="middle" fill="#9ec3b8" font-size="11" font-style="italic" opacity="0.6">Selat Madura</text>

                    {{-- Compass --}}
                    <g transform="translate(72,470)">
                        <circle r="20" fill="white" fill-opacity="0.85" stroke="#b8d8cf" stroke-width="1.2" />
                        <path d="M0,-14 L4,0 L0,14 L-4,0 Z" fill="#af4926" />
                        <line x1="-12" y1="0" x2="12" y2="0" stroke="#1b5148" stroke-width="1.2" />
                        <text x="0" y="-24" text-anchor="middle" fill="#1b5148" font-size="9" font-weight="700">N</text>
                    </g>
                </svg>

                {{-- ====== MOBILE FALLBACK ====== --}}
                <div class="grid grid-cols-2 gap-3 p-4 md:hidden" aria-label="Pilih kabupaten di Madura">
                    @foreach($mapRegions as $slug => $region)
                        @php
                            $regency = $regencyBySlug->get($slug);
                            $name = $regency->name ?? $region['label'];
                            $count = $regency->approved_contents_count ?? 0;
                        @endphp
                        <a href="{{ url('/explore/' . $slug) }}"
                           class="group rounded-2xl border border-white/80 bg-white/80 p-4 shadow-sm backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-[#af4926]/30 hover:bg-white hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#af4926]/50 focus:ring-offset-2">
                            <span class="mb-3 flex h-10 w-10 items-center justify-center rounded-xl text-white shadow-sm" style="background-color: {{ $region['fill'] }}">
                                <x-lucide-map-pin class="h-4.5 w-4.5" aria-hidden="true" />
                            </span>
                            <span class="block text-[14px] font-bold text-[#0a2622]">{{ $name }}</span>
                            <span class="mt-1 block text-[11px] font-medium text-gray-500">{{ $region['tagline'] }} · {{ $count }} destinasi</span>
                            <span class="mt-3 flex items-center gap-1 text-[11px] font-bold text-[#af4926] group-hover:gap-2 transition-all">
                                Mulai jelajah
                                <x-lucide-arrow-right class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" aria-hidden="true" />
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Footer bar --}}
            <div class="flex flex-col gap-2 px-2 pb-1 pt-4 md:flex-row md:items-center md:justify-between md:px-3">
                <div class="flex items-center gap-2 text-[12px] text-gray-500">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#e0f2f1] text-[#0a2622]">
                        <x-lucide-crosshair class="h-3.5 w-3.5" aria-hidden="true" />
                    </span>
                    <span><strong class="font-bold text-[#0a2622]">4 zona perjalanan</strong> siap dijelajahi</span>
                </div>
                <p class="text-[10px] font-medium text-gray-400">Hover atau gunakan Tab untuk membuka data wilayah · Klik untuk masuk</p>
            </div>
        </div>
    </div>
</section>
@endsection
