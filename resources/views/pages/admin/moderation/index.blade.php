@extends('layouts.admin-layout')

@section('title', 'Moderation Queue – Admin')

@section('content')
<div class="px-4 sm:px-6 md:px-8 py-6 md:py-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-[22px] md:text-[26px] font-bold text-[#0f172a] tracking-tight">Antrean Moderasi</h1>
            <p class="text-[12px] md:text-[13px] text-gray-400 font-medium mt-1">
                Tinjau dan setujui pengajuan konten yang menunggu konfirmasi untuk platform Smart Island.
            </p>
        </div>

        {{-- Search --}}
        <form method="GET" action="/admin/moderation" class="flex items-center gap-2 w-full sm:w-auto shrink-0">
            <input type="hidden" name="status" value="{{ $status ?? 'pending' }}">
            <div class="relative flex-1 sm:flex-none">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul atau kontributor..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 bg-white text-[13px] font-medium text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:w-44 md:w-56">
            </div>
            <button type="submit" class="flex items-center gap-1.5 px-4 py-2 rounded-xl border border-gray-200 bg-white text-[13px] font-bold text-[#374151] hover:bg-gray-50 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
        </form>
    </div>

    {{-- Status Filter Tabs --}}
    <div class="flex items-center gap-2 mb-6 overflow-x-auto">
        @php
            $filters = [
                'pending' => ['label' => 'Menunggu', 'color' => 'amber'],
                'approved' => ['label' => 'Disetujui', 'color' => 'green'],
                'rejected' => ['label' => 'Ditolak', 'color' => 'red'],
                'all' => ['label' => 'Semua', 'color' => 'gray'],
            ];
        @endphp
        @foreach($filters as $key => $filter)
            <a href="/admin/moderation?status={{ $key }}{{ $search ? '&search=' . urlencode($search) : '' }}"
               class="px-4 py-2 rounded-xl text-[12px] font-bold transition-all duration-200 shrink-0
                      {{ ($status ?? 'pending') === $key 
                         ? 'bg-[#0f172a] text-white shadow-sm' 
                         : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }}">
                {{ $filter['label'] }}
            </a>
        @endforeach
    </div>

    @include('pages.admin.components.moderation.admin-queue', ['contents' => $contents])

    {{-- Pagination --}}
    @if($contents->hasPages())
    <div class="mt-6">
        {{ $contents->links() }}
    </div>
    @endif

</div>
@endsection
