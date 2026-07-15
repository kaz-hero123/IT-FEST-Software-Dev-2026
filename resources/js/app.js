// Lucide Icons Initialization
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

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
