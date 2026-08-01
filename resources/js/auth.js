/**
 * auth.js
 * Handles toggle password visibility and slide transition between Login & Register panels.
 */

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input || !icon) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

function switchTo(target) {
    const banner           = document.getElementById('sliding-banner');
    const imgLogin         = document.getElementById('banner-img-login');
    const imgRegister      = document.getElementById('banner-img-register');
    const loginFormWrapper = document.getElementById('login-form-wrapper');
    const regFormWrapper   = document.getElementById('register-form-wrapper');
    const bannerTitle      = document.getElementById('banner-title');
    const bannerDesc       = document.getElementById('banner-desc');
    const leftContainer    = document.getElementById('left-container');
    const rightContainer   = document.getElementById('right-container');

    if (!banner || !loginFormWrapper || !regFormWrapper) {
        window.location.href = target === 'register' ? '/register' : '/login';
        return;
    }

    if (target === 'register') {
        // Slide banner to Left half (0%)
        banner.style.left = '0%';

        // Cross-fade: Login image out, Register image in
        if (imgLogin)    { imgLogin.classList.remove('opacity-100');    imgLogin.classList.add('opacity-0'); }
        if (imgRegister) { imgRegister.classList.remove('opacity-0');   imgRegister.classList.add('opacity-100'); }

        // Swap forms
        loginFormWrapper.classList.add('hidden');
        regFormWrapper.classList.remove('hidden');

        // Swap containers on mobile
        if (leftContainer) {
            leftContainer.classList.remove('flex');
            leftContainer.classList.add('hidden');
        }
        if (rightContainer) {
            rightContainer.classList.remove('hidden');
            rightContainer.classList.add('flex');
        }

        setTimeout(() => {
            if (bannerTitle) bannerTitle.innerText = 'Jadilah Kontributor Jelajah Madura';
            if (bannerDesc)  bannerDesc.innerText  = 'Bagikan keindahan alam, kisah sejarah, festival budaya, dan tempat favoritmu kepada wisatawan di seluruh Nusantara.';
        }, 200);

        history.pushState({}, '', '/register');
        document.title = 'Daftar Akun – Jelajah Madura';

    } else {
        // Slide banner to Right half (50%)
        banner.style.left = '50%';

        // Cross-fade: Register image out, Login image in
        if (imgRegister) { imgRegister.classList.remove('opacity-100'); imgRegister.classList.add('opacity-0'); }
        if (imgLogin)    { imgLogin.classList.remove('opacity-0');       imgLogin.classList.add('opacity-100'); }

        // Swap forms
        regFormWrapper.classList.add('hidden');
        loginFormWrapper.classList.remove('hidden');

        // Swap containers on mobile
        if (rightContainer) {
            rightContainer.classList.remove('flex');
            rightContainer.classList.add('hidden');
        }
        if (leftContainer) {
            leftContainer.classList.remove('hidden');
            leftContainer.classList.add('flex');
        }

        setTimeout(() => {
            if (bannerTitle) bannerTitle.innerText = 'Temukan Keindahan Tersembunyi Madura';
            if (bannerDesc)  bannerDesc.innerText  = 'Nikmati eksotisme budaya, keindahan pantai, destinasi sejarah, dan kekayaan kuliner di empat kabupaten Madura dalam satu platform digital.';
        }, 200);

        history.pushState({}, '', '/login');
        document.title = 'Masuk – Jelajah Madura';
    }
}

// Handle back/forward browser navigation
window.addEventListener('popstate', () => {
    const isRegister = window.location.pathname.includes('register');
    switchTo(isRegister ? 'register' : 'login');
});

// Attach to window object for inline HTML event handlers (onclick)
window.togglePassword = togglePassword;
window.switchTo = switchTo;
