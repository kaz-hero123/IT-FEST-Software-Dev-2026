<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun – Jelajah Madura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@700,500,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Satoshi', sans-serif; }
        .eye-btn:focus { outline: none; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">

<div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden flex min-h-[520px]">

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

        <h1 class="text-2xl font-bold text-[#0f172a] mb-1">Daftar Akun</h1>
        <p class="text-sm text-gray-500 mb-6">Pilih peran Anda dan lengkapi data diri.</p>

        {{-- Error messages --}}
        @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/register" class="space-y-4">
            @csrf

            {{-- Role selector (only contributor for now) --}}
            <div>
                <p class="text-sm font-semibold text-[#0f172a] mb-2">Pilih Peran Anda</p>
                <label class="flex items-start gap-3 border border-gray-200 rounded-xl p-3.5 cursor-pointer hover:border-[#af4926] transition-colors group">
                    <div class="mt-0.5 w-8 h-8 rounded-lg bg-[#af4926]/10 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#af4926]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-[#0f172a]">Kontributor</p>
                        <p class="text-xs text-gray-500 leading-relaxed">Bagikan pesona daerahmu dengan mengunggah foto dan cerita.</p>
                    </div>
                    <input type="radio" name="role" value="contributor" checked class="mt-1 accent-[#af4926] shrink-0">
                </label>
            </div>

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-[#0f172a] mb-1.5">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                    placeholder="Masukkan nama lengkap Anda"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition @error('name') border-red-400 @enderror">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-[#0f172a] mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                    placeholder="nama@email.com"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition @error('email') border-red-400 @enderror">
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-[#0f172a] mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <input id="password" type="password" name="password" autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-11 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition @error('password') border-red-400 @enderror">
                    <button type="button" class="eye-btn absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('password','eyeIcon1')">
                        <svg id="eyeIcon1" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-[#0f172a] mb-1.5">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                        placeholder="Ulangi kata sandi"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-11 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition">
                    <button type="button" class="eye-btn absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" onclick="togglePassword('password_confirmation','eyeIcon2')">
                        <svg id="eyeIcon2" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                </div>
            </div>

            {{-- Terms --}}
            <div class="flex items-start gap-2.5">
                <input id="terms" type="checkbox" name="terms" class="mt-0.5 accent-[#af4926] w-4 h-4 shrink-0 cursor-pointer">
                <label for="terms" class="text-xs text-gray-500 leading-relaxed cursor-pointer">
                    Saya menyetujui <a href="#" class="text-[#af4926] font-semibold hover:underline">Syarat & Ketentuan</a> dan <a href="#" class="text-[#af4926] font-semibold hover:underline">Kebijakan Privasi</a> yang berlaku.
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-[#af4926] hover:bg-[#8e381b] text-white font-semibold text-sm py-3 rounded-xl transition-colors shadow-sm">
                Daftar Sekarang
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-5">
            Sudah punya akun?
            <a href="/login" class="text-[#af4926] font-semibold hover:underline">Masuk di sini</a>
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
