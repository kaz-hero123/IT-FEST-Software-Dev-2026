<div x-data="confirmModal()" 
     @confirm-action.window="openModal($event.detail)"
     class="relative z-[100]" 
     style="display: none;" 
     x-show="isOpen">
    
    <style>
        /* Fallback classes in case Tailwind JIT is not running */
        .btn-confirm-danger { background-color: #dc2626; color: white; }
        .btn-confirm-danger:hover { background-color: #b91c1c; }
        .btn-confirm-warning { background-color: #b24823; color: white; }
        .btn-confirm-warning:hover { background-color: #8e381b; }
    </style>

    <!-- Backdrop -->
    <div x-show="isOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-none"
         x-transition:enter-end="opacity-100 backdrop-blur-sm"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 backdrop-blur-sm"
         x-transition:leave-end="opacity-0 backdrop-blur-none"
         class="fixed inset-0 bg-black/40 transition-all"></div>

    <!-- Modal Panel -->
    <div class="fixed inset-0 z-[101] overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="isOpen"
                 @click.away="closeModal()"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <!-- Icon -->
                        <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        
                        <!-- Content -->
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-bold leading-6 text-[#0f172a]" x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 font-medium" x-text="message"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="bg-gray-50/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                    <button type="button" 
                            @click="confirm()"
                            :class="type === 'warning' ? 'btn-confirm-warning' : 'btn-confirm-danger'"
                            class="inline-flex w-full justify-center rounded-xl px-4 py-2.5 text-sm font-bold shadow-sm sm:ml-3 sm:w-auto transition-colors"
                            x-text="confirmText">
                    </button>
                    <button type="button" 
                            @click="closeModal()"
                            class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-[#374151] shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('confirmModal', () => ({
        isOpen: false,
        title: '',
        message: '',
        confirmText: 'Konfirmasi',
        formId: null,
        type: 'danger', // 'danger' or 'warning'
        
        openModal(detail) {
            this.title = detail.title || 'Konfirmasi Aksi';
            this.message = detail.message || 'Apakah Anda yakin ingin melanjutkan?';
            this.confirmText = detail.confirmText || 'Konfirmasi';
            this.formId = detail.formId;
            this.type = detail.type || 'danger';
            this.isOpen = true;
        },
        
        closeModal() {
            this.isOpen = false;
        },
        
        confirm() {
            if (this.formId) {
                const form = document.getElementById(this.formId);
                if (form) {
                    form.submit();
                }
            }
            this.closeModal();
        },
    }));
});
</script>
