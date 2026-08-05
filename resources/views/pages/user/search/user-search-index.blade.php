@extends('layouts.layout')
@section('title', 'Cari Destinasi — Jelajah Madura')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
{{-- Hero Section --}}
<section class="relative w-full h-[50vh] md:h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="{{ asset('images/culture/culture08.jpg') }}" 
             alt="Search" 
             data-parallax
             data-parallax-speed="0.25"
             data-parallax-scale="1.35"
             class="w-full h-full object-cover origin-center will-change-transform"
             onerror="this.src='{{ asset('images/pantai.png') }}'">
        <div class="absolute inset-0 bg-[#0a2622]/40 mix-blend-overlay"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a2622]/70 via-[#0a2622]/30 to-[#fafafa]"></div>
    </div>

    <div class="relative z-10 w-full max-w-3xl px-4 mx-auto text-center">
        <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold text-white mb-6 drop-shadow-[0_4px_4px_rgba(0,0,0,0.4)] tracking-wide">
            Cari Destinasi Madura
        </h1>

        {{-- Search Bar --}}
        <form action="/search" method="GET" class="relative max-w-2xl mx-auto">
            <div class="relative bg-white/95 backdrop-blur-md border border-white/60 rounded-full p-1.5 flex items-center shadow-2xl">
                <div class="pl-4 pr-2 flex items-center pointer-events-none text-gray-400">
                    <x-lucide-search class="w-5 h-5 stroke-[2.5]" />
                </div>
                <input type="text" 
                       name="q" 
                       value="{{ $query }}"
                       placeholder="Cari wisata, kuliner, UMKM, atau spot foto..." 
                       autocomplete="off"
                       class="block w-full h-11 bg-transparent border-none text-[#0f172a] placeholder-gray-400 focus:outline-none text-sm md:text-base text-left pl-2 pr-24">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 h-10 px-6 md:px-8 bg-[#af4926] hover:bg-[#8e381b] text-white text-sm font-semibold rounded-full transition-all duration-200 shadow-md">
                    Cari
                </button>
            </div>
        </form>
    </div>
</section>

{{-- Results Section --}}
<section class="py-12 md:py-20 bg-[#fafafa] min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-4 md:px-6 w-full">

        @if(strlen(trim($query)) >= 2)
            {{-- Category Filters --}}
            <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
                <a href="/search?q={{ urlencode($query) }}" 
                   class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 {{ !request('category') ? 'bg-[#af4926] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="/search?q={{ urlencode($query) }}&category={{ $cat->slug }}" 
                       class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 {{ request('category') === $cat->slug ? 'bg-[#af4926] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:border-gray-300' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Results Header --}}
            <div class="mb-8 text-center">
                <p class="text-sm text-gray-500 font-medium">
                    @if($contents instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        Ditemukan <span class="font-bold text-[#0f172a]">{{ $contents->total() }}</span> hasil untuk
                    @else
                        Hasil pencarian untuk
                    @endif
                    "<span class="font-bold text-[#af4926]">{{ $query }}</span>"
                </p>
            </div>

            {{-- Content Grid (reuse Nando's card pattern) --}}
            @if($contents instanceof \Illuminate\Pagination\LengthAwarePaginator && $contents->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($contents as $item)
                        <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1">
                            {{-- Thumbnail --}}
                            <div class="relative w-full aspect-[4/3] overflow-hidden bg-gray-100">
                                @if($item->primaryPhoto)
                                    <img src="{{ $item->primaryPhoto->resolved_url }}" 
                                         alt="{{ $item->title }}" 
                                         loading="lazy"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                         onerror="this.src='{{ asset('images/culture/culture05.jpg') }}'">
                                @else
                                    <img src="{{ asset('images/placeholder.jpg') }}" 
                                         alt="Placeholder" 
                                         loading="lazy"
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @endif

                                {{-- Category Badge --}}
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-xs font-bold text-[#af4926] shadow-sm uppercase tracking-wider">
                                    <x-lucide-tag class="w-3 h-3 inline-block mr-1" />
                                    {{ $item->category->name }}
                                </div>

                                {{-- Regency Badge --}}
                                <div class="absolute top-3 right-3 bg-black/50 backdrop-blur-sm px-2.5 py-1 rounded-lg text-[10px] font-bold text-white uppercase tracking-wider">
                                    {{ $item->regency->name }}
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="text-lg font-bold text-[#0f172a] mb-2 line-clamp-2 group-hover:text-[#af4926] transition-colors duration-200">
                                    {{ $item->title }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($item->description), 100) }}
                                </p>
                                
                                <div class="mt-auto">
                                    <div class="flex items-center text-xs text-gray-500 mb-4">
                                        <x-lucide-map-pin class="w-4 h-4 mr-1.5 text-[#af4926]" />
                                        <span class="truncate">{{ $item->address ?? $item->regency->name }}</span>
                                    </div>
                                    <a href="/explore/{{ $item->regency->slug }}/{{ $item->slug }}" 
                                       class="inline-flex items-center justify-center w-full py-2.5 rounded-xl bg-gray-50 text-[#0f172a] font-semibold text-sm hover:bg-[#af4926] hover:text-white transition-colors duration-300 border border-gray-100 hover:border-transparent">
                                        Lihat Detail
                                        <x-lucide-arrow-right class="w-4 h-4 ml-2" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-12 flex justify-center">
                    {{ $contents->links() }}
                </div>

            @else
                {{-- Empty Results --}}
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <x-lucide-search-x class="w-10 h-10 text-gray-400" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ditemukan</h3>
                    <p class="text-gray-500 max-w-sm">
                        Tidak ada destinasi yang cocok dengan pencarian "{{ $query }}". Coba kata kunci lain atau jelajahi per kabupaten.
                    </p>
                    <a href="/explore" class="mt-6 inline-flex items-center px-5 py-2.5 rounded-full bg-[#af4926] text-white font-semibold text-sm hover:bg-[#8e381b] transition-colors shadow-sm">
                        <x-lucide-compass class="w-4 h-4 mr-2" />
                        Jelajahi Madura
                    </a>
                </div>
            @endif

        @else
            {{-- Initial State (no query yet) --}}
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                <div class="w-20 h-20 bg-[#f0fdfa] rounded-full flex items-center justify-center mb-4">
                    <x-lucide-search class="w-10 h-10 text-[#0d9488]" />
                </div>
                <h3 class="text-xl font-bold text-[#0f172a] mb-2">Mulai Pencarian</h3>
                <p class="text-gray-500 max-w-md">
                    Ketik minimal 2 karakter untuk mencari destinasi wisata, kuliner, UMKM, atau spot foto di seluruh Madura.
                </p>
            </div>
        @endif
    </div>
</section>
@endsection
