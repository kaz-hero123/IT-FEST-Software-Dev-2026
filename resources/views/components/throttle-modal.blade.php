{{-- Rate Limit / Throttle Warning Modal Component --}}
<div x-data="{ 
        isOpen: false, 
        title: 'Terlalu Banyak Permintaan', 
        message: 'Terlalu banyak request di server, tolong tunggu sebentar.' 
     }" 
     @throttle-warning.window="isOpen = true; if($event.detail && $event.detail.message) message = $event.detail.message"
     x-on:keydown.escape.window="isOpen = false"
     class="relative z-[150]" 
     style="display: none;" 
     x-show="isOpen">

    <!-- Backdrop -->
    <div x-show="isOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

    <!-- Modal Panel -->
    <div class="fixed inset-0 z-[151] overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="isOpen"
                 @click.away="isOpen = false"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-amber-100">
                
                <div class="bg-white px-5 pb-5 pt-6 sm:p-6">
                    <div class="flex items-start gap-4">
                        <!-- Warning Icon -->
                        <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 sm:mx-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        
                        <!-- Content -->
                        <div class="mt-0 text-left flex-1">
                            <h3 class="text-base font-bold leading-6 text-[#0f172a]" x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-xs text-gray-500 font-medium leading-relaxed" x-text="message"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action -->
                <div class="bg-gray-50/80 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                    <button type="button" 
                            @click="isOpen = false"
                            class="inline-flex w-full justify-center rounded-xl bg-[#0a2622] hover:bg-[#0f3832] px-5 py-2.5 text-xs font-bold text-white shadow-sm sm:w-auto transition-all cursor-pointer">
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
