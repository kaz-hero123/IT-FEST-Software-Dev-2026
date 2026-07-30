
<section class="py-16 bg-white overflow-hidden">
  
  <div class="max-w-6xl mx-auto px-6">
    
    <!-- Header Section -->
    <div class="mb-10 text-center">
      <h2 class="text-2xl md:text-3xl font-bold text-[#1A1A1A]">
        Popular & <span class="text-[#FF7A59]">Terbaru</span>
      </h2>
      <p class="text-xs md:text-sm text-[#7D7D7D] mt-2">
        Destinasi favorit pilihan wisatawan minggu ini
      </p>
    </div>

    @if($popularContents->isNotEmpty())
      <!-- Cards Grid: 1 kolom di HP (2 kartu), 3 kolom di Desktop (6 kartu) -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($popularContents as $index => $item)
          @php
            $coverUrl = asset('images/food.png');
            if ($item->primaryPhoto) {
                $path = $item->primaryPhoto->file_path;
                $coverUrl = str_starts_with($path, 'images/') ? asset($path) : Storage::url($path);
            }
          @endphp

          <div class="{{ $index >= 2 ? 'hidden lg:block' : '' }} bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-[#F1F1F1]">
            <a href="/explore/{{ $item->regency->slug }}/{{ $item->slug }}" class="block">
              <div class="relative aspect-video">
                <img src="{{ $coverUrl }}"
                     alt="{{ $item->title }}"
                     loading="lazy"
                     class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                     onerror="this.src='{{ asset('images/food.png') }}'"/>
                  <span class="absolute top-4 right-4 bg-[#00D2C4] text-white text-xs font-medium px-3 py-1.5 rounded-full">
                    Terbaru
                  </span>
              </div>
              <div class="p-5">
                <h3 class="text-base font-bold text-[#1A1A1A] mb-2 line-clamp-1">{{ $item->title }}</h3>
                <div class="flex items-center justify-between text-xs text-[#7D7D7D]">
                  <div class="flex items-center gap-1.5">
                    <span>{{ $item->regency->name ?? '' }}, Madura</span>
                  </div>
                  @if($item->category)
                  <div class="flex items-center text-[#FF7A59] font-semibold text-[10px] sm:text-xs border border-[#FF7A59] px-2 py-0.5 rounded-md">
                    <span>{{ $item->category->name }}</span>
                  </div>
                  @endif
                </div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    @else
      <!-- Empty state jika belum ada konten approved -->
      <div class="flex flex-col items-center justify-center py-16 text-center text-gray-400">
        <svg class="w-12 h-12 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-sm font-medium">Belum ada destinasi yang tersedia.</p>
      </div>
    @endif

    <!-- Bottom Link -->
    <div class="mt-12 text-center">
      <a href="/explore" class="inline-flex items-center gap-2 text-sm font-semibold text-[#FF7A59] hover:text-[#e0694b] transition-colors">
        Lihat Semua
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
      </a>
    </div>

  </div>
</section>