// Lucide Icons Initialization
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    window.initParallaxScroll();
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

