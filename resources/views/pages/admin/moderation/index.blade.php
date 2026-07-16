@extends('layouts.admin-layout')

@section('title', 'Moderation Queue – Admin')

@section('content')
<div class="px-4 sm:px-6 md:px-8 py-6 md:py-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-[22px] md:text-[26px] font-bold text-[#0f172a] tracking-tight">Moderation Queue</h1>
            <p class="text-[12px] md:text-[13px] text-gray-400 font-medium mt-1">
                Review and approve pending content submissions for the Smart Island platform.
            </p>
        </div>

        {{-- Search & Filter --}}
        <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
            <div class="relative flex-1 sm:flex-none">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" placeholder="Search queue..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 bg-white text-[13px] font-medium text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:w-44 md:w-56">
            </div>
            <button class="flex items-center gap-1.5 px-4 py-2 rounded-xl border border-gray-200 bg-white text-[13px] font-bold text-[#374151] hover:bg-gray-50 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filter
            </button>
        </div>
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
