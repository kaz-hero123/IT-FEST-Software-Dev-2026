@php $mode = 'login'; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – Jelajah Madura</title>
    <link rel="icon" type="image/png" href="{{ asset('images/jelajah_madura_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/jelajah_madura_logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@700,600,500,400&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Satoshi', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Satoshi', sans-serif; }
        .eye-btn:focus { outline: none; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen md:h-screen md:w-screen md:overflow-hidden bg-white text-[#0f172a] antialiased">

<div id="auth-container" class="relative w-full min-h-screen md:h-full md:overflow-hidden flex flex-col md:flex-row bg-white">

    {{-- LEFT HALF CONTAINER (Active Login Form) --}}
    <div id="left-container" class="w-full md:w-1/2 min-h-screen md:h-full relative z-10 flex flex-col justify-center items-center px-6 sm:px-12 lg:px-16 py-8 md:py-6 overflow-y-auto md:overflow-hidden bg-white">
        
        {{-- LOGIN FORM CONTENT --}}
        <div id="login-form-wrapper" class="w-full max-w-md mx-auto my-auto flex flex-col justify-center transition-all duration-500 ease-in-out">
            {{-- Header --}}
            <div class="flex items-center justify-between w-full mb-6">
                <a href="/" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/jelajah_madura_logo.png') }}" alt="Logo" class="w-8 h-6 object-contain group-hover:scale-105 transition-transform">
                    <span class="text-xl font-bold text-[#0a2622]">Jelajah<span class="text-[#af4926]"> Madura</span></span>
                </a>
                <a href="/" class="text-xs font-semibold text-gray-400 hover:text-[#0f172a] transition-colors flex items-center gap-1">
                    &larr; Beranda
                </a>
            </div>

            {{-- Title & Subtitle --}}
            <div class="mb-5">
                <h1 class="text-2xl md:text-3xl font-bold text-[#0f172a] tracking-tight mb-1.5">Selamat Datang Kembali!</h1>
                <p class="text-sm text-gray-500 leading-relaxed">Masuk ke akun Anda untuk melanjutkan penjelajahan destinasi Madura.</p>
            </div>

            @if($errors->has('email'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl p-3 flex items-center gap-2.5">
                    <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $errors->first('email') }}</span>
                </div>
            @endif

            @if(session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-600 text-sm rounded-xl p-3 flex items-center gap-2.5">
                    <svg class="w-5 h-5 shrink-0 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="/login" class="space-y-4">
                @csrf
                <div>
                    <label for="login-email" class="block text-xs md:text-sm font-semibold text-[#0f172a] mb-1.5">Email</label>
                    <input id="login-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition @error('email') border-red-400 @enderror">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="login-password" class="text-xs md:text-sm font-semibold text-[#0f172a]">Kata Sandi</label>
                        <span class="text-xs text-gray-400 font-medium">Min. 8 karakter</span>
                    </div>
                    <div class="relative">
                        <input id="login-password" type="password" name="password" required autocomplete="current-password"
                            placeholder="Masukkan kata sandi"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-11 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition">
                        <button type="button" class="eye-btn absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePassword('login-password','eyeIconLogin')">
                            <svg id="eyeIconLogin" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2.5">
                    <input id="remember" type="checkbox" name="remember" class="w-4 h-4 accent-[#af4926] rounded cursor-pointer">
                    <label for="remember" class="text-xs text-gray-600 cursor-pointer">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-[#af4926] hover:bg-[#8e381b] text-white font-semibold text-sm py-3 rounded-xl transition-all shadow-sm hover:shadow-md active:scale-[0.99]">
                    Masuk Sekarang
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-5">
                Belum punya akun?
                <a href="/register" onclick="event.preventDefault(); switchTo('register')" class="text-[#af4926] font-bold hover:underline ml-1 inline-flex items-center gap-0.5">
                    Daftar di sini &rarr;
                </a>
            </p>

            {{-- Footer --}}
            <div class="text-xs text-gray-400 text-center mt-5">
                &copy; {{ date('Y') }} Jelajah Madura. All rights reserved.
            </div>
        </div>

    </div>

    {{-- RIGHT HALF CONTAINER (Hidden Register Form & Banner slot) --}}
    <div id="right-container" class="w-full md:w-1/2 min-h-screen md:h-full relative z-10 hidden md:flex flex-col justify-center items-center px-6 sm:px-12 lg:px-16 py-8 md:py-6 overflow-y-auto md:overflow-hidden bg-white">
        
        {{-- REGISTER FORM CONTENT (Hidden on Login page) --}}
        <div id="register-form-wrapper" class="w-full max-w-md mx-auto my-auto flex flex-col justify-center transition-all duration-500 ease-in-out hidden">
            {{-- Header --}}
            <div class="flex items-center justify-between w-full mb-4">
                <a href="/" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/jelajah_madura_logo.png') }}" alt="Logo" class="w-8 h-6 object-contain group-hover:scale-105 transition-transform">
                    <span class="text-xl font-bold text-[#0a2622]">Jelajah<span class="text-[#af4926]"> Madura</span></span>
                </a>
                <a href="/" class="text-xs font-semibold text-gray-400 hover:text-[#0f172a] transition-colors flex items-center gap-1">
                    &larr; Beranda
                </a>
            </div>

            {{-- Title & Subtitle --}}
            <div class="mb-3">
                <h1 class="text-2xl md:text-3xl font-bold text-[#0f172a] tracking-tight mb-1">Buat Akun Baru</h1>
                <p class="text-sm text-gray-500 leading-relaxed">Lengkapi data diri Anda untuk mendaftar sebagai kontributor.</p>
            </div>

            {{-- Register Form --}}
            <form method="POST" action="/register" class="space-y-2.5">
                @csrf
                <div>
                    <label class="flex items-center gap-3 border border-[#af4926]/30 bg-[#af4926]/5 rounded-xl p-2 cursor-pointer">
                        <div class="w-6 h-6 rounded-lg bg-[#af4926]/10 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-[#af4926]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-[#0f172a]">Peran: Kontributor</p>
                            <p class="text-[11px] text-gray-500">Unggah foto dan cerita destinasi wisata &amp; budaya.</p>
                        </div>
                        <input type="radio" name="role" value="contributor" checked class="accent-[#af4926]">
                    </label>
                </div>

                <div>
                    <label for="reg-name" class="block text-xs font-semibold text-[#0f172a] mb-0.5">Nama Lengkap</label>
                    <input id="reg-name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                        placeholder="Masukkan nama lengkap Anda"
                        class="w-full border border-gray-200 rounded-xl px-3.5 py-1.5 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition">
                </div>

                <div>
                    <label for="reg-email" class="block text-xs font-semibold text-[#0f172a] mb-0.5">Email</label>
                    <input id="reg-email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full border border-gray-200 rounded-xl px-3.5 py-1.5 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition">
                </div>

                <div>
                    <label for="reg-password" class="block text-xs font-semibold text-[#0f172a] mb-0.5">Kata Sandi</label>
                    <div class="relative">
                        <input id="reg-password" type="password" name="password" required autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full border border-gray-200 rounded-xl px-3.5 py-1.5 pr-10 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition">
                        <button type="button" class="eye-btn absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePassword('reg-password','eyeIconReg1')">
                            <svg id="eyeIconReg1" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="reg-password-confirmation" class="block text-xs font-semibold text-[#0f172a] mb-0.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input id="reg-password-confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi kata sandi"
                            class="w-full border border-gray-200 rounded-xl px-3.5 py-1.5 pr-10 text-sm text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#af4926]/40 focus:border-[#af4926] transition">
                        <button type="button" class="eye-btn absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" onclick="togglePassword('reg-password-confirmation','eyeIconReg2')">
                            <svg id="eyeIconReg2" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-start gap-2 pt-0.5">
                    <input id="terms" type="checkbox" name="terms" required class="mt-0.5 accent-[#af4926] w-4 h-4 shrink-0 cursor-pointer">
                    <label for="terms" class="text-xs text-gray-500 leading-tight cursor-pointer">
                        Saya menyetujui <span class="text-[#af4926] font-semibold">Syarat &amp; Ketentuan</span> dan <span class="text-[#af4926] font-semibold">Kebijakan Privasi</span>.
                    </label>
                </div>

                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-[#af4926] hover:bg-[#8e381b] text-white font-semibold text-sm py-2.5 rounded-xl transition-all shadow-sm hover:shadow-md active:scale-[0.99]">
                    Daftar Sekarang
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-3">
                Sudah punya akun?
                <a href="/login" onclick="event.preventDefault(); switchTo('login')" class="text-[#af4926] font-bold hover:underline ml-1 inline-flex items-center gap-0.5">
                    &larr; Masuk di sini
                </a>
            </p>

            {{-- Footer --}}
            <div class="text-xs text-gray-400 text-center mt-4">
                &copy; {{ date('Y') }} Jelajah Madura. All rights reserved.
            </div>
        </div>

    </div>

    {{-- SLIDING IMAGE BANNER OVERLAY --}}
    <div id="sliding-banner" class="hidden md:flex absolute top-0 bottom-0 w-1/2 h-full z-20 transition-all duration-700 ease-[cubic-bezier(0.65,0,0.35,1)] bg-[#0a2622] text-white p-12 lg:p-16 flex-col justify-end overflow-hidden" style="left: 50%;">
        
        {{-- Login Background Image --}}
        <img id="banner-img-login" src="{{ asset('images/culture/culture07.jpg') }}" alt="Madura Login Culture" class="absolute inset-0 w-full h-full object-cover origin-center transition-opacity duration-700 ease-in-out opacity-100">
        
        {{-- Register Background Image --}}
        <img id="banner-img-register" src="{{ asset('images/culture/culture03.jpg') }}" alt="Madura Register Culture" class="absolute inset-0 w-full h-full object-cover origin-center transition-opacity duration-700 ease-in-out opacity-0">

        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/20 z-10 pointer-events-none"></div>

        {{-- Bottom Content --}}
        <div class="relative z-20 max-w-lg">
            <h2 id="banner-title" class="text-3xl lg:text-4xl font-extrabold leading-tight mb-4 drop-shadow-md">
                Temukan Keindahan Tersembunyi Madura
            </h2>
            <p id="banner-desc" class="text-gray-200 text-sm leading-relaxed mb-6 drop-shadow">
                Nikmati eksotisme budaya, keindahan pantai, destinasi sejarah, dan kekayaan kuliner di empat kabupaten Madura dalam satu platform digital.
            </p>
            <div class="flex items-center gap-6 pt-4 border-t border-white/20">
                <div>
                    <p class="text-2xl font-bold text-white">4</p>
                    <p class="text-xs text-gray-300">Kabupaten</p>
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <div>
                    <p class="text-2xl font-bold text-white">{{ \App\Models\Content::where('status', 'approved')->count() }}+</p>
                    <p class="text-xs text-gray-300">Destinasi Wisata</p>
                </div>
                <div class="w-px h-8 bg-white/20"></div>
                <div>
                    <p class="text-2xl font-bold text-white">100%</p>
                    <p class="text-xs text-gray-300">Otentik</p>
                </div>
            </div>
        </div>
    </div>

</div>
<x-toast />
</body>
</html>
