@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<section class="py-12 md:py-20 bg-[#fafafa] min-h-screen flex flex-col justify-center">
    <div class="max-w-5xl mx-auto px-4 md:px-6 w-full">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-10 md:mb-12">
            <h1 class="text-[26px] md:text-[30px] font-bold text-[#0f172a] mb-3">
                Pilih Kabupaten untuk Dijelajahi
            </h1>
            <p class="text-gray-500 text-[13px] md:text-[14px] leading-relaxed">
                Temukan pesona budaya, keindahan alam, dan kuliner khas dari empat kabupaten di Pulau Madura.
            </p>
        </div>

        <!-- Grid Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
            @foreach($regencies as $item)
            <div class="relative rounded-2xl overflow-hidden group shadow-sm border border-gray-200 aspect-[5/3] md:aspect-[16/9] bg-gray-200">

                <!-- Background Image -->
                <img src="{{ asset($item->img) }}"
                     class="absolute inset-0 w-full h-full object-cover origin-center transition-transform duration-700 group-hover:scale-105 z-0"
                     alt="{{ $item->name }}"
                     onerror="this.src='{{ asset('images/pantai.png') }}'">

                <!-- Bottom Shadow -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent z-10 pointer-events-none"></div>

                <!-- Glass Bar -->
                <div class="absolute bottom-3 left-3 right-3 md:bottom-4 md:left-4 md:right-4 bg-white/75 backdrop-blur-md rounded-xl p-3 md:p-4 flex items-center justify-between z-20 border border-white/40 shadow-md group-hover:bg-white/85 transition-colors duration-300">
                    <div>
                        <h2 class="text-[17px] md:text-[19px] font-bold text-[#0f172a] mb-1">{{ $item->name }}</h2>
                        <div class="text-[11px] md:text-[12px] text-[#334155] font-semibold flex items-center gap-1.5 opacity-90">
                            <x-lucide-check-circle-2 class="w-3.5 h-3.5 text-gray-500" stroke-width="2.5" />
                            {{ $item->approved_contents_count }} Konten
                        </div>
                    </div>
                    <a href="/explore/{{ $item->slug }}" class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#af4926] hover:bg-[#8e381b] flex items-center justify-center text-white shrink-0 shadow-sm transition-colors duration-200">
                        <x-lucide-arrow-right class="w-4 h-4 md:w-5 md:h-5" stroke-width="2.5" />
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection
