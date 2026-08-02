@extends('layouts.admin-layout')

@section('title', 'Review: {{ $content->title }} – Admin')

@section('content')
<div class="flex flex-col min-h-full px-4 sm:px-6 md:px-8 pt-6 md:pt-8 pb-0">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-[12px] text-gray-400 font-semibold mb-4">
        <a href="/admin/moderation" class="hover:text-[#0f172a] transition-colors">Antrean Moderasi</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#0f172a]">Tinjau Pengajuan</span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <div class="flex items-center gap-3 flex-wrap">
            <h1 class="text-[22px] md:text-[26px] font-bold text-[#0f172a] tracking-tight">
                Tinjau: {{ $content->title }}
            </h1>
            @if($content->status === 'approved')
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-green-100 text-green-700 border border-green-200">
                    Disetujui
                </span>
            @elseif($content->status === 'rejected')
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-red-100 text-red-700 border border-red-200">
                    Ditolak
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                    ⏳ Menunggu
                </span>
            @endif
        </div>
        <a href="/admin/moderation"
           class="flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 bg-white text-[12.5px] font-bold text-gray-600 hover:bg-gray-50 transition-colors shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Antrean
        </a>
    </div>

    <p class="text-[12.5px] text-gray-400 font-medium mb-5">
        Diajukan pada {{ $content->created_at->format('d M Y') }} oleh {{ $content->user->name ?? 'Tidak diketahui' }}
    </p>

    {{-- Preview: flex-1 agar isi sisa tinggi --}}
    <div class="flex-1 flex flex-col min-h-0">
        @include('pages.admin.components.moderation.admin-preview', compact('content', 'moderationNotes'))
    </div>

</div>
@endsection
