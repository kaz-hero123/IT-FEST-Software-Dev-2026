@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="min-h-screen bg-[#f7f7f5] py-10 px-4 md:px-8">
    <div class="max-w-6xl mx-auto">

        {{-- ── Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#0f172a]">Dashboard Contributor</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan pantau status konten Anda.</p>
            </div>
            <a href="/contents/create"
               class="inline-flex items-center gap-2 bg-[#af4926] hover:bg-[#8e381b] text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Konten
            </a>
        </div>

        {{-- ── Stat Cards ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">

            {{-- Approved --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5 flex flex-col gap-4 relative overflow-hidden">
                {{-- Decorative circle --}}
                <div class="absolute -top-5 -right-5 w-24 h-24 rounded-full bg-green-100 opacity-60"></div>
                <div class="flex items-center justify-between relative z-10">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Approved</span>
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-4xl font-bold text-[#0f172a]">{{ number_format($stats['approved']) }}</p>
                    <p class="text-xs text-green-600 font-semibold mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                        Live on platform
                    </p>
                </div>
            </div>

            {{-- Pending --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5 flex flex-col gap-4 relative overflow-hidden">
                <div class="absolute -top-5 -right-5 w-24 h-24 rounded-full bg-amber-100 opacity-60"></div>
                <div class="flex items-center justify-between relative z-10">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Pending</span>
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-4xl font-bold text-[#0f172a]">{{ number_format($stats['pending']) }}</p>
                    <p class="text-xs text-amber-600 font-semibold mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3"/><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                        Requires moderation
                    </p>
                </div>
            </div>

            {{-- Rejected --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-5 flex flex-col gap-4 relative overflow-hidden">
                <div class="absolute -top-5 -right-5 w-24 h-24 rounded-full bg-red-100 opacity-60"></div>
                <div class="flex items-center justify-between relative z-10">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Rejected</span>
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-4xl font-bold text-[#0f172a]">{{ number_format($stats['rejected']) }}</p>
                    <p class="text-xs text-red-500 font-semibold mt-1.5 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        Requires revision
                    </p>
                </div>
            </div>

        </div>

        {{-- ── Content Table ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-bold text-[#0f172a]">Konten Saya</h2>
                <span class="text-xs text-gray-400 font-medium">{{ $contents->total() }} total konten</span>
            </div>

            @if($contents->count() > 0)
            <div class="divide-y divide-gray-50">
                @foreach($contents as $content)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/60 transition-colors">

                    {{-- Thumbnail --}}
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                        @if($content->photos->count() > 0)
                            <img src="{{ $content->photos->first()->url }}"
                                 alt="{{ $content->title }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='{{ asset('images/culture/culture04.jpg') }}'">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-[#0f172a] truncate">{{ $content->title }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            <span class="text-xs text-gray-400">{{ $content->category->name ?? '-' }}</span>
                            <span class="text-gray-300">·</span>
                            <span class="text-xs text-gray-400">{{ $content->regency->name ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="shrink-0">
                        @if($content->status === 'approved')
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-full">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Approved
                            </span>
                        @elseif($content->status === 'pending')
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                Pending
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-red-700 bg-red-100 px-2.5 py-1 rounded-full">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                Rejected
                            </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="/contents/{{ $content->slug }}/edit"
                           class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="/contents/{{ $content->slug }}" onsubmit="return confirm('Hapus konten ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center text-red-400 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($contents->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $contents->links() }}
            </div>
            @endif

            @else
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 text-center px-4">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-base font-bold text-gray-700 mb-1">Belum Ada Konten</h3>
                <p class="text-sm text-gray-400 mb-5">Mulai bagikan pesona Madura dengan membuat konten pertamamu.</p>
                <a href="/contents/create"
                   class="inline-flex items-center gap-2 bg-[#af4926] hover:bg-[#8e381b] text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Buat Konten Pertama
                </a>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
