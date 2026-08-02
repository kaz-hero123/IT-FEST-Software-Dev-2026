@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="min-h-[80vh] flex items-center justify-center bg-gray-50/50 px-4">
    <div class="text-center max-w-lg mx-auto">
        <!-- Illustration / Error Code -->
        <div class="relative mb-8">
            <h1 class="text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-[#ed8a53] drop-shadow-sm select-none">
                404
            </h1>
            <div class="absolute inset-0 flex items-center justify-center mix-blend-overlay opacity-30">
                <x-lucide-compass class="w-24 h-24 text-gray-900 animate-pulse" />
            </div>
        </div>

        <!-- Copywriting -->
        <h2 class="text-3xl font-bold text-[#0a2622] mb-4">Waduh! Tersesat di Madura?</h2>
        <p class="text-gray-500 mb-8 text-lg leading-relaxed">
            Halaman yang Anda tuju sepertinya sudah pindah, atau memang tidak pernah ada. Mari kita kembali ke jalur yang benar.
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/" class="w-full sm:w-auto px-8 py-3.5 bg-[#ed8a53] hover:bg-[#d87843] text-white font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                <x-lucide-home class="w-5 h-5" />
                Kembali ke Beranda
            </a>
            <a href="/explore" class="w-full sm:w-auto px-8 py-3.5 bg-white border-2 border-gray-200 text-gray-700 hover:border-teal-500 hover:text-teal-600 font-bold rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
                <x-lucide-map class="w-5 h-5" />
                Lanjutkan Jelajah
            </a>
        </div>
    </div>
</div>
@endsection
