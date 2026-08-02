<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – Jelajah Madura</title>
    <link rel="icon" type="image/png" href="{{ asset('images/jelajah_madura_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/jelajah_madura_logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@700,500,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Satoshi', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gray-100 flex flex-col items-center justify-center p-4 relative">

    {{-- Top Left: Back Link --}}
    <div class="absolute top-6 left-6">
        <a href="/" class="inline-flex items-center gap-1.5 text-[13.5px] font-medium text-gray-500 hover:text-gray-800 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>
    </div>

    {{-- Card --}}
    <div class="w-full max-w-sm bg-white rounded-3xl shadow-lg shadow-gray-200/70 px-8 py-10">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-[32px] font-bold text-[#0f172a] tracking-tight leading-none mb-3">Jelajah Madura</h1>
            <span class="inline-block bg-[#fce9e3] text-[#c95c38] text-[10.5px] font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-5">
                Akses Admin
            </span>
            <h2 class="text-[19px] font-bold text-[#1e293b] mb-1.5">Login Admin</h2>
            <p class="text-[13px] text-gray-400 leading-relaxed">
                Masuk ke panel manajemen konten Jelajah<br>Madura.
            </p>
        </div>

        {{-- Error Session --}}
        @if (session('error'))
            <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-100 text-red-600 text-[13px] font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="/admin/login" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">Email Admin</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="admin@jelajahmadura.go.id"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-[13.5px] text-[#0f172a] placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-800/20 focus:border-gray-700 transition bg-white"
                >
                @error('email')
                    <p class="mt-1.5 text-[12px] font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-[12.5px] font-semibold text-[#374151] mb-1.5">Kata Sandi</label>
                <div class="relative" x-data="{ showPass: false }">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input
                        :type="showPass ? 'text' : 'password'"
                        type="password"
                        name="password"
                        required
                        placeholder="••••••••"
                        class="w-full pl-11 pr-11 py-3 rounded-xl border border-gray-200 text-[13.5px] text-[#0f172a] placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-800/20 focus:border-gray-700 transition bg-white"
                    >
                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                        <svg x-show="!showPass" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showPass" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-[#0a1512] hover:bg-black text-white font-bold text-[13.5px] py-3.5 rounded-xl transition-colors"
                >
                    Masuk sebagai Admin
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    {{-- Footer --}}
    <p class="mt-7 text-center text-[11.5px] text-gray-400">
        © 2024 Jelajah Madura. Sistem Manajemen Internal.
    </p>

</body>
</html>
