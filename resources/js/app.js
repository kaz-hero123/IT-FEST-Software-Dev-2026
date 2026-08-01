import './auth';

// Initialization on DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    if (typeof window.initParallaxScroll === 'function') {
        window.initParallaxScroll();
    }
    if (typeof window.initTypewriter === 'function') {
        window.initTypewriter();
    }
});

// Typewriter Animation Component for Hero sections
window.initTypewriter = function () {
    const elements = document.querySelectorAll('[data-typing]');
    elements.forEach((el) => {
        if (el.dataset.typewriterInitialized) return;
        el.dataset.typewriterInitialized = 'true';

        let phrases = [];
        try {
            phrases = JSON.parse(el.dataset.typing);
        } catch (e) {
            phrases = [el.innerText.trim()];
        }

        if (!phrases.length) return;

        const targetEl = el.querySelector('.typing-target') || el;
        const speed = parseInt(el.dataset.typingSpeed) || 90;
        const pause = parseInt(el.dataset.typingPause) || 2200;
        const deleteSpeed = parseInt(el.dataset.typingDeleteSpeed) || 40;

        const loopAttr = el.dataset.loop;
        const shouldLoop = loopAttr !== undefined ? (loopAttr === 'true') : (phrases.length > 1);

        targetEl.textContent = '';

        let phraseIndex = 0;
        let charIndex = 0;
        let isDeleting = false;

        setTimeout(() => {
            function type() {
                const currentPhrase = phrases[phraseIndex];

                if (isDeleting) {
                    charIndex--;
                } else {
                    charIndex++;
                }

                targetEl.textContent = currentPhrase.substring(0, charIndex);

                let nextSpeed = isDeleting ? deleteSpeed : speed;

                if (!isDeleting && charIndex === currentPhrase.length) {
                    if (!shouldLoop) {  
                        return;
                    }
                    nextSpeed = pause;
                    isDeleting = true;
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    phraseIndex = (phraseIndex + 1) % phrases.length;
                    nextSpeed = 350;
                }

                setTimeout(type, nextSpeed);
            }
            type();
        }, 300);
    });
};

// Alpine.js Typewriter Component registration if Alpine is present
document.addEventListener('alpine:init', () => {
    if (typeof Alpine !== 'undefined') {
        Alpine.data('typewriter', (phrases = [], speed = 90, pause = 2200, deleteSpeed = 40, loop = null) => ({
            phrases: phrases.length ? phrases : ['Permata Tersembunyi'],
            displayText: '',
            phraseIndex: 0,
            charIndex: 0,
            isDeleting: false,
            shouldLoop: loop !== null ? loop : (phrases.length > 1),

            init() {
                setTimeout(() => this.type(), 300);
            },

            type() {
                const currentPhrase = this.phrases[this.phraseIndex];

                if (this.isDeleting) {
                    this.displayText = currentPhrase.substring(0, this.charIndex - 1);
                    this.charIndex--;
                } else {
                    this.displayText = currentPhrase.substring(0, this.charIndex + 1);
                    this.charIndex++;
                }

                let currentSpeed = this.isDeleting ? deleteSpeed : speed;

                if (!this.isDeleting && this.charIndex === currentPhrase.length) {
                    if (!this.shouldLoop) {
                        return;
                    }
                    currentSpeed = pause;
                    this.isDeleting = true;
                } else if (this.isDeleting && this.charIndex === 0) {
                    this.isDeleting = false;
                    this.phraseIndex = (this.phraseIndex + 1) % this.phrases.length;
                    currentSpeed = 350;
                }

                setTimeout(() => this.type(), currentSpeed);
            }
        }));
    }
});


// Parallax Scroll Effect for Banners
window.initParallaxScroll = function () {
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    if (!parallaxElements.length) return;

    let ticking = false;

    function updateParallax() {
        const windowHeight = window.innerHeight;

        parallaxElements.forEach((el) => {
            const speed = parseFloat(el.dataset.parallaxSpeed) || 0.25;
            const scale = parseFloat(el.dataset.parallaxScale) || 1.35;

            const parent = el.closest('section') || el.closest('.group') || el.parentElement;
            if (!parent) return;

            const rect = parent.getBoundingClientRect();

            if (rect.bottom >= -100 && rect.top <= windowHeight + 100) {
                const centerY = rect.top + rect.height / 2 - windowHeight / 2;

                // Extra height buffer from scaling = (height * (scale - 1)) / 2
                // Keep 10px safety cushion so edges NEVER show
                const maxTranslate = Math.max(0, (rect.height * (scale - 1)) / 2 - 10);
                const rawTranslate = centerY * speed;
                const translateY = Math.max(-maxTranslate, Math.min(maxTranslate, rawTranslate));

                el.style.transform = `translate3d(0, ${translateY.toFixed(2)}px, 0) scale(${scale})`;
            }
        });

        ticking = false;
    }

    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    updateParallax();
};

// FAQ ScrollSpy Component
window.scrollSpy = function () {
    return {
        activeSection: 'umum',
        init() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && entry.intersectionRatio > 0.1) {
                        this.activeSection = entry.target.id;
                    }
                });
            }, { rootMargin: '-20% 0px -70% 0px', threshold: [0, 0.25, 0.5, 0.75, 1] });

            document.querySelectorAll('.faq-section').forEach((el) => {
                observer.observe(el);
            });
        },
        scrollTo(id) {
            this.activeSection = id;
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }
}

