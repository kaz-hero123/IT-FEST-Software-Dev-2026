<div x-data="toastComponent()" 
     class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 items-end pointer-events-none">
    
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.visible"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
             class="pointer-events-auto w-full max-w-sm overflow-hidden bg-white rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-gray-100 flex items-start gap-3 p-4"
             :class="{'border-l-4 border-l-[#25c46b]': toast.type === 'success', 'border-l-4 border-l-red-500': toast.type === 'error'}">
             
            <!-- Icon -->
            <div class="shrink-0 mt-0.5">
                <!-- Success Icon -->
                <svg x-show="toast.type === 'success'" class="w-5 h-5 text-[#25c46b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <!-- Error Icon -->
                <svg x-show="toast.type === 'error'" class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>

            <!-- Message -->
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-900" x-text="toast.title"></p>
                <p class="text-[13px] text-gray-500 mt-0.5 leading-snug" x-text="toast.message"></p>
            </div>

            <!-- Close Button -->
            <button @click="remove(toast.id)" class="shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('toastComponent', () => ({
        toasts: [],
        add(type, title, message) {
            const id = Date.now() + Math.random().toString(36).substring(2);
            this.toasts.push({ id, type, title, message, visible: true });
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                this.remove(id);
            }, 5000);
        },
        remove(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index !== -1) {
                this.toasts[index].visible = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300); // Wait for transition
            }
        },
        init() {
            // Listen for custom events from anywhere
            window.addEventListener('notify', (e) => {
                this.add(e.detail.type, e.detail.title, e.detail.message);
            });

            // Initialize with Laravel Flash Sessions if present
            @if(session('success'))
                setTimeout(() => {
                    this.add('success', 'Berhasil', {!! json_encode(session('success')) !!});
                }, 100);
            @endif

            @if(session('error'))
                setTimeout(() => {
                    this.add('error', 'Gagal', {!! json_encode(session('error')) !!});
                }, 100);
            @endif

            // Validation Errors catch-all
            @if($errors->any())
                setTimeout(() => {
                    this.add('error', 'Validasi Gagal', 'Silakan periksa kembali isian formulir Anda.');
                }, 100);
            @endif
        }
    }));
});
</script>
