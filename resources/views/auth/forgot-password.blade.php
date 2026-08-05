@extends('layouts.layout')
@section('title', 'Lupa Password — Jelajah Madura')

@section('navbar')
    <nav class="bg-white border-b border-gray-100 py-4 px-6 md:px-12 flex justify-between items-center">
        <a href="/" class="flex items-center gap-2">
            <span class="font-bold text-xl text-[#b84c22]">Jelajah Madura</span>
        </a>
    </nav>
@endsection

@section('content')
<div class="min-h-[70vh] flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 w-full max-w-md">
        <h1 class="text-2xl font-bold text-[#0f172a] mb-2">Lupa Password?</h1>
        <p class="text-sm text-gray-500 mb-6">Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password Anda.</p>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-bold text-[#0f172a] mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#ff7b00]/20 focus:border-[#ff7b00] transition-all">
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-[#ff7b00] hover:bg-[#e66f00] text-white font-bold rounded-xl transition-all">
                Kirim Tautan Reset
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm font-bold text-[#ff7b00] hover:text-[#e66f00] transition-colors">
                Kembali ke Login
            </a>
        </div>
    </div>
</div>
@endsection
