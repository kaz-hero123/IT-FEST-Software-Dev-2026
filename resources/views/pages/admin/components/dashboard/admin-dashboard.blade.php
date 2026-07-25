{{-- STATS CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-5 md:mb-6">

    {{-- Total Content --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-5">
        <div class="flex justify-between items-start mb-3 md:mb-4">
            <span class="text-[9.5px] md:text-[10.5px] font-bold text-gray-400 tracking-widest uppercase">Total Content</span>
            <div class="p-1.5 md:p-2 bg-gray-100 rounded-lg">
                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
            </div>
        </div>
        <h3 class="text-[24px] md:text-[30px] font-bold text-[#0f172a] leading-none mb-1.5 md:mb-2">{{ number_format($stats['total']) }}</h3>
        <p class="text-[10.5px] md:text-[11.5px] font-semibold text-gray-400">
            Total submissions
        </p>
    </div>

    {{-- Pending --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-5">
        <div class="flex justify-between items-start mb-3 md:mb-4">
            <span class="text-[9.5px] md:text-[10.5px] font-bold text-gray-400 tracking-widest uppercase">Pending</span>
            <div class="p-1.5 md:p-2 bg-yellow-50 rounded-lg">
                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
        </div>
        <h3 class="text-[24px] md:text-[30px] font-bold text-[#0f172a] leading-none mb-1.5 md:mb-2">{{ number_format($stats['pending']) }}</h3>
        <p class="text-[10.5px] md:text-[11.5px] font-semibold text-gray-400">Requires moderation</p>
    </div>

    {{-- Approved --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-5">
        <div class="flex justify-between items-start mb-3 md:mb-4">
            <span class="text-[9.5px] md:text-[10.5px] font-bold text-gray-400 tracking-widest uppercase">Approved</span>
            <div class="p-1.5 md:p-2 bg-green-50 rounded-lg">
                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-[24px] md:text-[30px] font-bold text-[#0f172a] leading-none mb-1.5 md:mb-2">{{ number_format($stats['approved']) }}</h3>
        <p class="text-[10.5px] md:text-[11.5px] font-semibold text-gray-400">Live on platform</p>
    </div>

    {{-- Rejected --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 md:p-5">
        <div class="flex justify-between items-start mb-3 md:mb-4">
            <span class="text-[9.5px] md:text-[10.5px] font-bold text-gray-400 tracking-widest uppercase">Rejected</span>
            <div class="p-1.5 md:p-2 bg-red-50 rounded-lg">
                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-[24px] md:text-[30px] font-bold text-[#0f172a] leading-none mb-1.5 md:mb-2">{{ number_format($stats['rejected']) }}</h3>
        <p class="text-[10.5px] md:text-[11.5px] font-semibold text-gray-400">Requires revision</p>
    </div>
</div>

{{-- Recent Pending Table --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-4 md:px-6 py-4 flex justify-between items-center border-b border-gray-100">
        <h2 class="text-[15px] md:text-[17px] font-bold text-[#0f172a]">Recent Pending</h2>
        <a href="/admin/moderation" class="text-[12px] md:text-[12.5px] font-bold text-[#b84c22] hover:text-[#8e3618] flex items-center gap-1 transition-colors">
            See All
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>

    {{-- Mobile Card View (< md) --}}
    <div class="md:hidden divide-y divide-gray-100">
        @forelse($recentPending as $content)
        <div class="px-4 py-4">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[13px] font-bold text-[#0f172a] leading-snug pr-4">{{ $content->title }}</p>
                <a href="/admin/moderation/{{ $content->slug ?? $content->id }}"
                   class="shrink-0 inline-flex items-center px-3 py-1 rounded-lg border border-[#e8c5b5] bg-white text-[#b84c22] text-[11.5px] font-bold hover:bg-[#b84c22] hover:text-white transition-colors">
                    Review
                </a>
            </div>
            <div class="flex flex-wrap gap-x-3 gap-y-1 text-[11px] text-gray-400 font-medium">
                <span>{{ $content->user->name ?? 'Unknown' }}</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 font-semibold">{{ $content->category->name ?? '-' }}</span>
                <span>{{ $content->regency->name ?? '-' }}</span>
                <span>{{ $content->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @empty
        <div class="px-4 py-8 text-center text-[13px] text-gray-400 font-medium">
            Tidak ada konten yang perlu ditinjau.
        </div>
        @endforelse
    </div>

    {{-- Desktop Table View (>= md) --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-gray-100 bg-[#fafafa]">
                    <th class="px-6 py-3 text-[10px] font-bold text-gray-400 tracking-widest uppercase">Title</th>
                    <th class="px-4 py-3 text-[10px] font-bold text-gray-400 tracking-widest uppercase">Contributor</th>
                    <th class="px-4 py-3 text-[10px] font-bold text-gray-400 tracking-widest uppercase">Category</th>
                    <th class="px-4 py-3 text-[10px] font-bold text-gray-400 tracking-widest uppercase">Regency</th>
                    <th class="px-4 py-3 text-[10px] font-bold text-gray-400 tracking-widest uppercase">Time</th>
                    <th class="px-4 py-3 text-[10px] font-bold text-gray-400 tracking-widest uppercase text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentPending as $content)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="px-6 py-4 text-[13.5px] font-bold text-[#0f172a]">{{ $content->title }}</td>
                    <td class="px-4 py-4 text-[13px] text-[#475569] font-medium">{{ $content->user->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-blue-50 text-blue-600 border border-blue-100">
                            {{ $content->category->name ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-[13px] text-[#64748b] font-medium">{{ $content->regency->name ?? '-' }}</td>
                    <td class="px-4 py-4 text-[12.5px] text-[#94a3b8] font-medium">{{ $content->created_at->diffForHumans() }}</td>
                    <td class="px-4 py-4 text-right">
                        <a href="/admin/moderation/{{ $content->slug ?? $content->id }}"
                           class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-lg border border-[#e8c5b5] bg-white text-[#b84c22] text-[12px] font-bold hover:bg-[#b84c22] hover:text-white transition-colors">
                            Review
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-[13px] text-gray-400 font-medium">
                        Tidak ada konten yang perlu ditinjau saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
