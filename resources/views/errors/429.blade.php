{{-- Custom 429 Too Many Requests Error Page --}}
@extends('layouts.layout')

@section('title', 'Terlalu Banyak Permintaan')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full text-center bg-white p-8 rounded-3xl border border-gray-100 shadow-xl relative overflow-hidden">
        <div class="w-20 h-20 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-amber-100">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-[#0f172a] mb-2">Terlalu Banyak Permintaan</h1>
        <p class="text-gray-500 text-sm leading-relaxed mb-6">
            Terlalu banyak request di server, tolong tunggu sebentar sebelum mencoba kembali.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <button onclick="window.location.reload()" class="w-full sm:w-auto px-6 py-3 bg-[#0a2622] hover:bg-[#0f3832] text-white text-xs font-bold rounded-xl transition-all shadow-md">
                Coba Lagi
            </button>
            <a href="/" class="w-full sm:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
