<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – Jelajah Madura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@700,500,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Satoshi', sans-serif; }
        .eye-btn:focus { outline: none; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">

<div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden flex min-h-[480px]">

    {{-- Left: Photo Panel --}}
    <div class="hidden md:flex w-5/12 relative flex-col justify-end p-8"
         style="background: url('{{ asset('images/culture/culture07-old.jpg') }}') center/cover no-repeat;">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent rounded-l-3xl"></div>
        <div class="relative z-10">
            <h2 class="text-white text-3xl font-bold leading-tight mb-2">Jelajah Madura</h2>
            <p class="text-gray-200 text-sm leading-relaxed">
                Gerbang Digital Wisata Pulau Garam. Bergabunglah dengan kami untuk menemukan pesona yang tersembunyi.
            </p>
        </div>
    </div>

    {{-- Right: Form Panel --}}
    <div class="flex-1 flex flex-col justify-center px-8 py-10 md:px-10">

        {{-- Logo (mobile only) --}}
        <div class="flex items-center gap-2 mb-6 md:hidden">
            <img src="{{ asset('images/jelajah_madura_logo.png') }}" alt="Logo" class="w-8 h-6 object-contain">
            <span class="text-lg font-bold text-[#0a2622]">Jelajah<span class="text-[#ed8a53]"> Madura</span></span>
        </div>

        <h1 class="text-2xl font-bold text-[#0f172a] mb-1">Selamat Datang</h1>
        <p class="text-sm text-gray-500 mb-6">Masuk ke akun Anda untuk melanjutkan.</p>

        {{-- Error message --}}
        @if($errors->has('email'))
            <div class="mb-4 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                <p class="text-sm text-red-600">{{ $errors->first('email') }}</p>
            </div>
        @endif

        {{-- Session success (e.g. after logout) --}}
        @if(session('status'))
            <div class="mb-4 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                <p class="text-sm text-green-600">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-[#0f172a] mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                    placeholder="nama@email.com"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition @error('email') border-red-400 @enderror">
            </div>

            {{-- Password --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="text-sm font-semibold text-[#0f172a]">Kata Sandi</label>
                    <a href="#" class="text-xs text-[#af4926] font-semibold hover:underline">Lupa password?</a>
                </div>
                <div class="relative">
                    <input id="password" type="password" name="password" autocomplete="current-password"
                        placeholder="Masukkan kata sandi"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-11 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition">
                    <button type="button" class="eye-btn absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('password','eyeIcon')">
                        <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center gap-2.5">
                <input id="remember" type="checkbox" name="remember" class="w-4 h-4 accent-[#af4926] cursor-pointer">
                <label for="remember" class="text-xs text-gray-500 cursor-pointer">Ingat saya di perangkat ini</label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-[#af4926] hover:bg-[#8e381b] text-white font-semibold text-sm py-3 rounded-xl transition-colors shadow-sm">
                Masuk Sekarang
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-5">
            Belum punya akun?
            <a href="/register" class="text-[#af4926] font-semibold hover:underline">Daftar di sini</a>
        </p>
    </div>
</div>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>
</body>
</html>
