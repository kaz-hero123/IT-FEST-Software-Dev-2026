{{-- Eco-Tourism Tips Section — Smart Small Island --}}
@php
    $ecoTips = [
        'wisata' => [
            'icon' => 'leaf',
            'title' => 'Tips Wisata Bertanggung Jawab',
            'tips' => [
                'Jangan tinggalkan sampah di lokasi wisata — bawa kantong sampah sendiri.',
                'Gunakan sunscreen ramah terumbu karang saat berkunjung ke pantai.',
                'Hormati budaya dan adat istiadat masyarakat lokal setempat.',
                'Gunakan transportasi umum lokal untuk mengurangi jejak karbon.',
            ],
        ],
        'kuliner' => [
            'icon' => 'utensils',
            'title' => 'Dukung Kuliner Lokal',
            'tips' => [
                'Prioritaskan membeli dari warung dan pedagang UMKM lokal.',
                'Bawa wadah sendiri untuk takeaway — kurangi penggunaan plastik sekali pakai.',
                'Cicipi kuliner autentik Madura yang diwariskan turun-temurun.',
                'Berikan ulasan positif untuk mendukung usaha kuliner lokal.',
            ],
        ],
        'umkm' => [
            'icon' => 'store',
            'title' => 'Dukung UMKM Madura',
            'tips' => [
                'Beli produk langsung dari pengrajin lokal untuk mendukung ekonomi desa.',
                'Bagikan pengalaman belanja ke media sosial untuk membantu promosi.',
                'Tanyakan cerita dan proses pembuatan produk — hargai karya lokal.',
                'Pilih produk dengan kemasan ramah lingkungan jika tersedia.',
            ],
        ],
        'spot-foto' => [
            'icon' => 'camera',
            'title' => 'Fotografi yang Bertanggung Jawab',
            'tips' => [
                'Jaga kelestarian spot foto — jangan merusak tanaman atau struktur alam.',
                'Minta izin sebelum memotret masyarakat lokal atau properti pribadi.',
                'Patuhi peraturan di area yang dilindungi atau bersejarah.',
                'Bagikan foto dengan tag lokasi untuk membantu promosi wisata lokal.',
            ],
        ],
    ];

    $categorySlug = strtolower($content->category->slug ?? 'wisata');
    $tips = $ecoTips[$categorySlug] ?? $ecoTips['wisata'];
@endphp

<div class="bg-gradient-to-br from-[#ecfdf5] to-[#f0fdfa] rounded-3xl p-6 md:p-8 border border-[#d1fae5] shadow-[0_2px_15px_-3px_rgba(0,0,0,0.02)]">
    <div class="flex items-center gap-3 mb-5">
        <div class="w-10 h-10 bg-[#10b981]/10 rounded-xl flex items-center justify-center shrink-0">
            <x-lucide-leaf class="w-5 h-5 text-[#10b981]" />
        </div>
        <div>
            <h3 class="text-[15px] font-bold text-[#064e3b]">{{ $tips['title'] }}</h3>
            <p class="text-[11px] text-[#6ee7b7] font-semibold tracking-wide uppercase">Smart Small Island Initiative</p>
        </div>
    </div>

    <ul class="space-y-3">
        @foreach($tips['tips'] as $tip)
        <li class="flex items-start gap-2.5 text-[13px] text-[#065f46] leading-relaxed">
            <div class="w-5 h-5 bg-[#10b981]/15 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                <x-lucide-check class="w-3 h-3 text-[#10b981]" />
            </div>
            {{ $tip }}
        </li>
        @endforeach
    </ul>

    <div class="mt-5 pt-4 border-t border-[#a7f3d0]/50 flex items-center gap-2">
        <x-lucide-globe class="w-3.5 h-3.5 text-[#10b981]" />
        <p class="text-[11px] text-[#6ee7b7] font-medium">
            Jelajah Madura mendukung pariwisata berkelanjutan untuk Pulau Madura
        </p>
    </div>
</div>
