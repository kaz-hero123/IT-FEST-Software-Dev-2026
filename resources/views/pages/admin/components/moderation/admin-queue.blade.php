{{-- QUEUE GRID --}}
@if($contents->isEmpty())
<div class="flex flex-col items-center justify-center py-20 text-center">
    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>
    <h3 class="text-[15px] font-bold text-[#0f172a] mb-1">Queue Empty</h3>
    <p class="text-[13px] text-gray-400 font-medium">All submissions have been reviewed. Great work!</p>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
    @foreach($contents as $item)
    @php
        $primaryPhoto = $item->photos->first();
    @endphp
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">

        {{-- Cover Image --}}
        <div class="relative h-[180px] bg-gray-100">
            @if($primaryPhoto)
                <img src="{{ Storage::url($primaryPhoto->file_path) }}"
                     alt="{{ $item->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            {{-- Status Badge --}}
            <div class="absolute top-3 left-3">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-400/90 text-yellow-900 uppercase tracking-wider">
                    Pending
                </span>
            </div>
        </div>

        {{-- Content Info --}}
        <div class="p-4 flex flex-col flex-1">
            <h3 class="text-[13.5px] font-bold text-[#0f172a] leading-snug mb-2 line-clamp-2">{{ $item->title }}</h3>

            <div class="flex items-center gap-1.5 text-[11.5px] text-gray-400 font-medium mb-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                {{ $item->user->name ?? 'Unknown' }}
                <span class="text-gray-300">•</span>
                {{ $item->created_at->diffForHumans() }}
            </div>

            <div class="flex items-center gap-2 mt-1 mb-4 flex-wrap">
                @if($item->category)
                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-600">
                    {{ $item->category->name }}
                </span>
                @endif
                @if($item->regency)
                <span class="inline-flex items-center gap-1 text-[11px] font-medium text-gray-400">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    {{ $item->regency->name }}
                </span>
                @endif
            </div>

            <div class="mt-auto">
                <a href="/admin/moderation/{{ $item->slug ?? $item->id }}"
                   class="flex items-center justify-center w-full py-2.5 bg-[#0a1512] hover:bg-black text-white text-[12.5px] font-bold rounded-xl transition-colors">
                    Review Content
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
