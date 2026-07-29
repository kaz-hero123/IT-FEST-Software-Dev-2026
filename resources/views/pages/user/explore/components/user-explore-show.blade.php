@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<!-- Hero Section -->
<section class="relative w-full h-[85vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="{{ asset($regency->img) }}" 
             alt="{{ $regency->name }}" 
             data-parallax
             data-parallax-speed="0.35"
             data-parallax-scale="1.2"
             class="w-full h-full object-cover origin-center will-change-transform"
             onerror="this.src='{{ asset('images/pantai.png') }}'">
        <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/60 to-transparent"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 w-full max-w-4xl px-4 text-center mx-auto mt-4">
        <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-6 drop-shadow-[0_4px_4px_rgba(0,0,0,0.4)] leading-tight tracking-wide min-h-[1.3em]">
            <span class="inline-block text-white"
                  data-typing='["Pesonanya {{ $regency->name }}"]'
                  data-typing-speed="90"
                  data-loop="false">
                <span class="typing-target"></span><span class="inline-block w-[3px] md:w-[4px] h-[0.85em] bg-white ml-1 translate-y-[2px] animate-typing-cursor align-middle"></span>
            </span>
        </h1>
        <p class="text-sm md:text-lg text-white/80 max-w-xl mx-auto font-medium leading-relaxed drop-shadow-sm">
            Jelajahi keindahan budaya, alam, dan kuliner tersembunyi yang ada di wilayah {{ $regency->name }}.
        </p>
    </div>
</section>

<!-- Main Content Area -->
<section class="py-12 md:py-20 bg-[#fafafa] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 md:px-6 w-full">
        
        <!-- Filters -->
        <div class="flex flex-wrap items-center justify-center gap-3 mb-12">
            <a href="{{ url()->current() }}" 
               class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 {{ !request('category') ? 'bg-[#af4926] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                Semua Kategori
            </a>
            @foreach($categories as $category)
                <a href="{{ url()->current() }}?category={{ $category->slug }}" 
                   class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 {{ request('category') === $category->slug ? 'bg-[#af4926] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 hover:border-gray-300' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        <!-- Contents Grid -->
        @if($contents->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($contents as $item)
                    <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1">
                        <!-- Thumbnail -->
                        <div class="relative w-full aspect-[4/3] overflow-hidden bg-gray-100">
                            @if($item->photos->count() > 0)
                                <img src="{{ Storage::url($item->photos->first()->file_path) }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <img src="{{ asset('images/placeholder.jpg') }}" 
                                     alt="Placeholder" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-xs font-bold text-[#af4926] shadow-sm">
                                {{ $item->category->name }}
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-[#0f172a] mb-2 line-clamp-2 group-hover:text-[#af4926] transition-colors duration-200">
                                {{ $item->title }}
                            </h3>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($item->description), 100) }}
                            </p>
                            
                            <div class="mt-auto">
                                <div class="flex items-center text-xs text-gray-500 mb-4">
                                    <x-lucide-map-pin class="w-4 h-4 mr-1.5 text-gray-400" />
                                    <span class="truncate">{{ $item->address ?? $regency->name }}</span>
                                </div>
                                <a href="/explore/{{ $regency->slug }}/{{ $item->slug }}" 
                                   class="inline-flex items-center justify-center w-full py-2.5 rounded-xl bg-gray-50 text-[#0f172a] font-semibold text-sm hover:bg-[#af4926] hover:text-white transition-colors duration-300 border border-gray-100 hover:border-transparent">
                                    Lihat Detail
                                    <x-lucide-arrow-right class="w-4 h-4 ml-2" />
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $contents->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20 px-4 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <x-lucide-package-open class="w-10 h-10 text-gray-400" />
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Destinasi</h3>
                <p class="text-gray-500 max-w-sm">
                    Maaf, belum ada konten yang tersedia untuk kategori ini di {{ $regency->name }}.
                </p>
                @if(request('category'))
                <a href="{{ url()->current() }}" class="mt-6 text-[#af4926] font-semibold hover:underline">
                    Lihat Semua Kategori
                </a>
                @endif
            </div>
        @endif
    </div>
</section>
@endsection
