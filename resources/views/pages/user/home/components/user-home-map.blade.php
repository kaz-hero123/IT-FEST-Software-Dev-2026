{{-- Peta Interaktif Madura — Smart Island Navigation --}}
@php
    $regencies = \App\Models\Regency::withCount('approvedContents')->get();
    $regencyData = [];
    foreach ($regencies as $r) {
        $regencyData[$r->slug] = [
            'name' => $r->name,
            'count' => $r->approved_contents_count,
            'url' => '/explore/' . $r->slug,
        ];
    }
@endphp

<section class="py-16 md:py-24 bg-[#fafafa] overflow-hidden">
    <div class="max-w-6xl mx-auto px-6">

        {{-- Section Header --}}
        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#f0fdfa] text-[#0d9488] text-[11px] font-semibold rounded-full mb-5">
                <x-lucide-map class="w-3.5 h-3.5" />
                Peta Interaktif
            </span>
            <h2 class="text-[32px] md:text-[36px] lg:text-[40px] font-bold text-[#0f172a] leading-tight md:leading-[1.2] mb-4">
                Jelajahi <span class="text-[#af4926]">Pulau Madura</span>
            </h2>
            <p class="text-gray-500 leading-relaxed text-[14px] md:text-[15px] max-w-2xl mx-auto">
                Klik kabupaten untuk menjelajahi destinasi wisata, kuliner, UMKM, dan spot foto di setiap wilayah.
            </p>
        </div>

        {{-- Map Container --}}
        <div class="relative max-w-4xl mx-auto">
            <svg viewBox="0 0 900 350" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg" id="madura-map">
                {{-- Water Background --}}
                <rect width="900" height="350" fill="none" />

                {{-- Bangkalan --}}
                <a href="{{ $regencyData['bangkalan']['url'] ?? '/explore/bangkalan' }}" class="map-region" data-regency="bangkalan">
                    <path d="M50,180 Q60,120 120,100 Q180,80 220,90 Q250,95 270,110 Q280,130 275,160 Q270,190 250,200 Q220,215 180,210 Q140,208 100,200 Q70,195 50,180 Z"
                          fill="#e8d5cf" stroke="#af4926" stroke-width="2"
                          class="transition-all duration-300 hover:fill-[#af4926]/20 cursor-pointer" />
                    <text x="165" y="148" text-anchor="middle" class="text-[15px] font-bold fill-[#0f172a] pointer-events-none">Bangkalan</text>
                    <text x="165" y="168" text-anchor="middle" class="text-[11px] font-semibold fill-[#af4926] pointer-events-none">{{ $regencyData['bangkalan']['count'] ?? 0 }} destinasi</text>
                </a>

                {{-- Sampang --}}
                <a href="{{ $regencyData['sampang']['url'] ?? '/explore/sampang' }}" class="map-region" data-regency="sampang">
                    <path d="M270,110 Q310,90 360,85 Q410,80 450,90 Q470,100 475,120 Q478,145 470,165 Q455,185 430,195 Q400,205 360,200 Q320,198 290,190 Q275,180 275,160 Q275,135 270,110 Z"
                          fill="#e0d8cf" stroke="#af4926" stroke-width="2"
                          class="transition-all duration-300 hover:fill-[#af4926]/20 cursor-pointer" />
                    <text x="375" y="138" text-anchor="middle" class="text-[15px] font-bold fill-[#0f172a] pointer-events-none">Sampang</text>
                    <text x="375" y="158" text-anchor="middle" class="text-[11px] font-semibold fill-[#af4926] pointer-events-none">{{ $regencyData['sampang']['count'] ?? 0 }} destinasi</text>
                </a>

                {{-- Pamekasan --}}
                <a href="{{ $regencyData['pamekasan']['url'] ?? '/explore/pamekasan' }}" class="map-region" data-regency="pamekasan">
                    <path d="M475,120 Q480,95 510,85 Q550,75 590,80 Q630,85 660,100 Q675,115 670,140 Q665,165 650,180 Q630,195 600,200 Q560,205 520,195 Q490,185 480,170 Q475,150 475,120 Z"
                          fill="#d8ddd0" stroke="#af4926" stroke-width="2"
                          class="transition-all duration-300 hover:fill-[#af4926]/20 cursor-pointer" />
                    <text x="575" y="135" text-anchor="middle" class="text-[15px] font-bold fill-[#0f172a] pointer-events-none">Pamekasan</text>
                    <text x="575" y="155" text-anchor="middle" class="text-[11px] font-semibold fill-[#af4926] pointer-events-none">{{ $regencyData['pamekasan']['count'] ?? 0 }} destinasi</text>
                </a>

                {{-- Sumenep (largest, easternmost) --}}
                <a href="{{ $regencyData['sumenep']['url'] ?? '/explore/sumenep' }}" class="map-region" data-regency="sumenep">
                    <path d="M660,100 Q700,80 750,75 Q800,72 840,85 Q870,100 875,130 Q878,160 860,185 Q840,205 800,215 Q760,222 720,215 Q690,210 670,195 Q655,180 655,160 Q658,135 660,100 Z"
                          fill="#cfd8e0" stroke="#af4926" stroke-width="2"
                          class="transition-all duration-300 hover:fill-[#af4926]/20 cursor-pointer" />
                    <text x="765" y="138" text-anchor="middle" class="text-[15px] font-bold fill-[#0f172a] pointer-events-none">Sumenep</text>
                    <text x="765" y="158" text-anchor="middle" class="text-[11px] font-semibold fill-[#af4926] pointer-events-none">{{ $regencyData['sumenep']['count'] ?? 0 }} destinasi</text>
                </a>

                {{-- Small islands (Sumenep) --}}
                <a href="{{ $regencyData['sumenep']['url'] ?? '/explore/sumenep' }}" class="map-region">
                    <ellipse cx="810" cy="250" rx="25" ry="15" fill="#cfd8e0" stroke="#af4926" stroke-width="1.5"
                             class="transition-all duration-300 hover:fill-[#af4926]/20 cursor-pointer" />
                    <text x="810" y="254" text-anchor="middle" class="text-[9px] font-semibold fill-gray-500 pointer-events-none">Gili</text>
                </a>
                <ellipse cx="855" cy="270" rx="15" ry="10" fill="#cfd8e0" stroke="#af4926" stroke-width="1" opacity="0.6" />
                <ellipse cx="780" cy="265" rx="12" ry="8" fill="#cfd8e0" stroke="#af4926" stroke-width="1" opacity="0.5" />

                {{-- Compass Rose --}}
                <g transform="translate(60, 280)">
                    <circle cx="0" cy="0" r="20" fill="white" stroke="#e5e7eb" stroke-width="1" />
                    <text x="0" y="-8" text-anchor="middle" class="text-[10px] font-bold fill-[#af4926]">N</text>
                    <line x1="0" y1="-5" x2="0" y2="5" stroke="#af4926" stroke-width="1.5" />
                    <line x1="-5" y1="0" x2="5" y2="0" stroke="#d1d5db" stroke-width="1" />
                    <text x="0" y="14" text-anchor="middle" class="text-[7px] fill-gray-400">S</text>
                </g>

                {{-- Selat Madura label --}}
                <text x="200" y="260" class="text-[11px] fill-gray-300 italic pointer-events-none" font-style="italic">Selat Madura</text>
                <text x="500" y="280" class="text-[11px] fill-gray-300 italic pointer-events-none" font-style="italic">Laut Jawa</text>
            </svg>

            {{-- Mobile-friendly list fallback --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-8 md:mt-6">
                @foreach($regencies as $regency)
                <a href="/explore/{{ $regency->slug }}"
                   class="group flex items-center gap-3 bg-white rounded-xl p-3.5 border border-gray-100 hover:border-[#af4926]/30 hover:shadow-md transition-all duration-300">
                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 shrink-0">
                        <img src="{{ asset($regency->img) }}" alt="{{ $regency->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                             onerror="this.src='{{ asset('images/pantai.png') }}'">
                    </div>
                    <div class="min-w-0">
                        <p class="text-[13px] font-bold text-[#0f172a] group-hover:text-[#af4926] transition-colors truncate">{{ $regency->name }}</p>
                        <p class="text-[11px] text-gray-500 font-medium">{{ $regency->approved_contents_count }} destinasi</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
