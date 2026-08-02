@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <!-- Badges -->
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-200/70 text-gray-700 text-xs font-semibold">
                        <x-lucide-utensils class="w-3.5 h-3.5 mr-1.5" />
                        {{ $content->category->name }}
                    </span>
                </div>
                <!-- Title & Address -->
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#0a2622] mb-2 tracking-tight">
                    {{ $content->title }}
                </h1>
                <div class="flex items-center text-gray-500 text-sm">
                    <x-lucide-map-pin class="w-4 h-4 mr-1.5 text-[#d35a39]" />
                    {{ $content->address ?? $content->regency->name }}
                </div>
            </div>


        </div>

        <!-- Photo Gallery (Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4 mb-10 h-auto md:h-[500px]">
            <!-- Big Image -->
            <div class="md:col-span-3 rounded-2xl overflow-hidden h-64 md:h-full relative group min-h-0 min-w-0">
                @if($content->primaryPhoto)
                    <img src="{{ $content->primaryPhoto->resolved_url }}" 
                         alt="{{ $content->title }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                         onerror="this.src='{{ asset('images/pantai.png') }}'">
                @else
                    <img src="{{ asset('images/pantai.png') }}" 
                         alt="{{ $content->title }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                @endif
            </div>
            <!-- Small Images Right Column -->
            <div class="md:col-span-1 flex flex-col gap-3 md:gap-4 h-auto md:h-full min-h-0 min-w-0">
                <!-- Fetch rest of photos, max 3 -->
                @php $secondaryPhotos = $content->photos->where('is_primary', false)->take(3); @endphp
                
                <!-- 1st Small Image -->
                <div class="rounded-2xl overflow-hidden flex-1 relative hidden md:block min-h-0 bg-gray-100">
                    @if($secondaryPhotos->values()->get(0))
                        <img src="{{ $secondaryPhotos->values()->get(0)->resolved_url }}" 
                             alt="Gallery 1" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <x-lucide-image class="w-8 h-8 text-gray-300" />
                        </div>
                    @endif
                </div>
                
                <!-- 2nd Small Image -->
                <div class="rounded-2xl overflow-hidden flex-1 relative hidden md:block min-h-0 bg-gray-100">
                    @if($secondaryPhotos->values()->get(1))
                        <img src="{{ $secondaryPhotos->values()->get(1)->resolved_url }}" 
                             alt="Gallery 2" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <x-lucide-image class="w-8 h-8 text-gray-300" />
                        </div>
                    @endif
                </div>
                
                <!-- 3rd Small Image with overlay -->
                <div class="rounded-2xl overflow-hidden flex-1 relative cursor-pointer group hidden md:block min-h-0 bg-gray-100">
                    @if($secondaryPhotos->values()->get(2))
                        <img src="{{ $secondaryPhotos->values()->get(2)->resolved_url }}" 
                             alt="Gallery 3" class="w-full h-full object-cover">
                        <!-- Overlay hanya jika ada foto -->
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/50 transition-colors">
                            <span class="text-white font-semibold flex items-center">
                                <x-lucide-image class="w-5 h-5 mr-2" />
                                Lihat {{ $content->photos->count() }} Foto
                            </span>
                        </div>
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <x-lucide-image class="w-8 h-8 text-gray-300" />
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content (2 Columns) -->
        <div class="flex flex-col lg:flex-row gap-8 items-start relative">
            
            <!-- Left Column: Tentang & Fasilitas -->
            <div class="w-full lg:w-2/3 flex flex-col gap-8 lg:sticky lg:top-24">
                
                <!-- Tentang Section -->
                <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.02)]">
                    <h2 class="text-xl font-bold text-[#0a2622] mb-5">Tentang Tempat Ini</h2>
                    
                    <div class="prose prose-gray max-w-none prose-p:leading-relaxed prose-p:text-gray-600 prose-p:mb-5">
                        <!-- Convert markdown-like syntax / linebreaks from description -->
                        {!! nl2br(e($content->description)) !!}
                    </div>
                </div>

                {{-- Fasilitas section hidden — hardcoded data, semua konten menampilkan fasilitas yang sama.
                     Akan di-uncomment setelah fasilitas dibuat dynamic per konten. --}}
                {{--
                <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.02)]">
                    <h2 class="text-base font-bold text-gray-800 uppercase tracking-wider mb-6">FASILITAS</h2>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="flex items-center text-sm font-medium text-gray-700">
                            <x-lucide-circle-parking class="w-5 h-5 text-gray-400 mr-3" /> Area Parkir Luas
                        </div>
                        <div class="flex items-center text-sm font-medium text-gray-700">
                            <x-lucide-droplets class="w-5 h-5 text-gray-400 mr-3" /> Toilet Bersih
                        </div>
                        <div class="flex items-center text-sm font-medium text-gray-700">
                            <x-lucide-moon class="w-5 h-5 text-gray-400 mr-3" /> Mushola
                        </div>
                        <div class="flex items-center text-sm font-medium text-gray-700">
                            <x-lucide-shopping-bag class="w-5 h-5 text-gray-400 mr-3" /> Pusat Oleh-oleh
                        </div>
                        <div class="flex items-center text-sm font-medium text-gray-700">
                            <x-lucide-snowflake class="w-5 h-5 text-gray-400 mr-3" /> Ruangan Ber-AC (VIP)
                        </div>
                    </div>
                </div>
                --}}
            </div>

            <!-- Right Column: Lokasi & Kontributor Info -->
            <div class="w-full lg:w-1/3 space-y-6">
                <!-- Widget Lokasi -->
                <div class="bg-white rounded-3xl p-6 md:p-7 border border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.02)]">
                    <h3 class="text-base font-extrabold text-[#0a2622] mb-4">Lokasi & Kontak</h3>
                    
                    <!-- Real Interactive Google Maps Embed -->
                    <div class="w-full h-52 bg-gray-100 rounded-2xl mb-4 overflow-hidden relative border border-gray-200 shadow-sm">
                        @php
                            $mapLocationQuery = urlencode(($content->title ?? '') . ', ' . ($content->address ?? 'Madura'));
                        @endphp
                        <iframe 
                            class="w-full h-full border-0" 
                            src="https://maps.google.com/maps?q={{ $mapLocationQuery }}&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <!-- Address Text -->
                    <div class="flex items-start mb-4">
                        <x-lucide-map-pin class="w-5 h-5 text-[#d35a39] mr-3 shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-600 font-medium leading-relaxed">{{ $content->address }}</span>
                    </div>

                    <!-- Jam Buka Text -->
                    @if($content->open_time || $content->close_time)
                    @php
                        $now = \Carbon\Carbon::now('Asia/Jakarta');
                        $openTime  = $content->open_time  ? \Carbon\Carbon::createFromFormat('H:i:s', $content->open_time)  : null;
                        $closeTime = $content->close_time ? \Carbon\Carbon::createFromFormat('H:i:s', $content->close_time) : null;
                        $isOpen = ($openTime && $closeTime)
                            ? $now->between(
                                \Carbon\Carbon::today('Asia/Jakarta')->setTimeFrom($openTime),
                                \Carbon\Carbon::today('Asia/Jakarta')->setTimeFrom($closeTime)
                              )
                            : false;
                        $openLabel  = $openTime  ? $openTime->format('H.i')  : '--:--';
                        $closeLabel = $closeTime ? $closeTime->format('H.i') : '--:--';
                    @endphp
                    <div class="flex items-start mb-6">
                        <x-lucide-clock class="w-5 h-5 {{ $isOpen ? 'text-green-500' : 'text-red-400' }} mr-3 shrink-0 mt-0.5" />
                        <div class="flex flex-col">
                            <span class="text-sm font-bold {{ $isOpen ? 'text-green-600' : 'text-red-500' }} mb-0.5">
                                {{ $isOpen ? 'Buka Sekarang' : 'Tutup Sekarang' }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $openLabel }} – {{ $closeLabel }} WIB
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($content->maps_url)
                        <a href="{{ $content->maps_url }}" target="_blank" class="flex items-center justify-center w-full py-3 rounded-xl bg-[#c54e2e] hover:bg-[#a93f23] text-white font-semibold text-sm transition-colors shadow-sm">
                            <x-lucide-map class="w-4 h-4 mr-2" />
                            Buka di Google Maps
                        </a>
                    @else
                        <div class="flex items-center justify-center w-full py-3 rounded-xl bg-gray-100 text-gray-400 font-semibold text-sm cursor-not-allowed">
                            <x-lucide-map-pin-off class="w-4 h-4 mr-2" />
                            Lokasi Tidak Tersedia
                        </div>
                    @endif
                </div>

                <!-- Info Kontributor -->
                <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.02)] flex items-center bg-[#f7f9f8]">
                    <div class="w-12 h-12 rounded-full bg-[#d7e5df] flex items-center justify-center text-[#0a2622] font-bold text-lg mr-4 shrink-0">
                        {{ strtoupper(substr($content->user->name ?? 'U', 0, 2)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-[11px] text-gray-500 font-semibold mb-0.5">Ditambahkan oleh</p>
                        <p class="text-sm font-bold text-[#0a2622] leading-tight">{{ $content->user->name ?? 'Kontributor' }}</p>
                    </div>
                    <x-lucide-badge-check class="w-6 h-6 text-green-500 shrink-0" />
                </div>

                {{-- Eco-Tourism Tips --}}
                @include('components.eco-tips')
            </div>
        </div>

        <!-- Tempat Terkait (Related Contents) -->
        <div class="mt-20 border-t border-gray-200 pt-10 pb-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-[#0a2622] mb-1">Tempat Terkait di {{ $content->regency->name }}</h2>
                    <p class="text-sm text-gray-500">Rekomendasi destinasi menarik lainnya yang patut Anda kunjungi</p>
                </div>
                <a href="/explore/{{ $content->regency->slug }}" class="text-[#c54e2e] font-semibold text-sm flex items-center hover:underline">
                    Lihat Semua
                    <x-lucide-arrow-right class="w-4 h-4 ml-1" />
                </a>
            </div>

            <!-- Related Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($relatedContents as $related)
                <a href="/explore/{{ $content->regency->slug }}/{{ $related->slug }}" class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="relative w-full aspect-[4/3] bg-gray-200">
                        <img src="{{ $related->primaryPhoto ? $related->primaryPhoto->resolved_url : asset('images/culture/culture05.jpg') }}" alt="{{ $related->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" onerror="this.src='{{ asset('images/pantai.png') }}'">
                        <!-- Kategori Badge -->
                        <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md px-2.5 py-1 rounded-md text-[10px] font-bold text-white flex items-center uppercase tracking-wider">
                            <x-lucide-tag class="w-3 h-3 mr-1" />
                            {{ $related->category->name ?? 'Wisata' }}
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-[15px] font-bold text-[#0a2622] mb-1.5 line-clamp-1 group-hover:text-[#c54e2e] transition-colors">
                            {{ $related->title }}
                        </h3>
                        <div class="flex items-center text-[12px] text-gray-500 font-medium">
                            <x-lucide-map-pin class="w-3.5 h-3.5 mr-1 text-gray-400" />
                            {{ $related->address }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
