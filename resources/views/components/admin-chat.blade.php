
<div x-data='adminChat(@json(auth()->check() ? auth()->user()->name : null))' x-init="init()" x-on:open-admin-chat.window="toggleChat()" class="relative z-50" x-on:keydown.escape.window="showDeleteModal = false">
    <!-- Floating Trigger Button -->
    <button @click="toggleChat()" 
            class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-[#0a2622] hover:bg-[#0f3832] text-white px-4 py-3.5 rounded-full shadow-2xl border border-[#1e4d45] transition-all duration-300 transform hover:scale-105 active:scale-95 group"
            aria-label="Chat Admin">
        <div class="relative flex items-center justify-center">
            <svg class="w-6 h-6 text-white group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <template x-if="hasUnreadAdmin">
                <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 border border-white"></span>
                </span>
            </template>
        </div>
    </button>

    <!-- Chat Popup Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300 transform" 
         x-transition:enter-start="opacity-0 translate-y-8 scale-95" 
         x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
         x-transition:leave="transition ease-in duration-200 transform" 
         x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
         x-transition:leave-end="opacity-0 translate-y-8 scale-95" 
         @click.outside="isOpen = false"
         class="fixed bottom-24 right-4 sm:right-6 z-50 w-[92vw] sm:w-[380px] h-[520px] max-h-[80vh] bg-white border border-gray-200 rounded-xl shadow-2xl flex flex-col overflow-hidden"
         style="display: none;">
        
        <!-- Chat Header -->
        <div class="bg-[#0a2622] px-4 py-3.5 border-b border-[#0a2622]/20 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="{{ asset('images/culture/culture01.jpg') }}" 
                         alt="Admin Javier" 
                         class="w-10 h-10 rounded-full object-cover shadow-sm">
                    <template x-if="hasUnreadAdmin">
                        <span class="absolute bottom-0 right-0 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 border-2 border-[#0a2622]"></span>
                        </span>
                    </template>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white leading-tight flex items-center gap-1.5">
                        Admin Jelajah Madura
                    </h4>
                    <p class="text-[11px] text-gray-500 font-medium flex items-center gap-1">
                        <span class="truncate max-w-[160px]" x-text="'Sesi: ' + userName"></span>
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-1">
                <!-- Clear History Button -->
                <button @click="showDeleteModal = true" class="p-1.5 text-white/60 hover:text-rose-300 hover:bg-white/10 rounded-lg transition-colors" title="Hapus Riwayat Chat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                <!-- Close Button -->
                <button @click="isOpen = false" class="p-1.5 text-white/60 hover:text-white hover:bg-white/10 rounded-lg transition-colors" title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat Body / Messages -->
        <div x-ref="chatBody" class="flex-1 p-4 overflow-y-auto space-y-3 bg-gray-50">
            <div class="text-center my-1">
                <span class="text-[10px] font-semibold text-gray-400 bg-white border border-gray-200 px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">Live Support Chat</span>
            </div>

            <template x-for="msg in messages" :key="msg.id">
                <div :class="msg.sender === 'user' ? 'flex flex-col items-end' : 'flex items-start gap-2.5'">
                    <!-- Admin Avatar if Admin -->
                    <template x-if="msg.sender === 'admin'">
                        <img src="{{ asset('images/culture/culture01.jpg') }}" alt="Admin" class="w-7 h-7 rounded-full object-cover border-2 border-emerald-400 mt-1 shrink-0 shadow-sm">
                    </template>

                    <div class="max-w-[82%]">
                        <div :class="msg.sender === 'user' 
                                ? 'bg-[#0a2622] text-white rounded-2xl rounded-tr-sm px-4 py-2.5 text-xs sm:text-sm font-normal shadow-sm' 
                                : 'bg-white text-gray-800 border border-gray-200 rounded-2xl rounded-tl-sm px-4 py-2.5 text-xs sm:text-sm leading-relaxed shadow-sm'"
                             x-text="msg.text">
                        </div>
                        <span :class="msg.sender === 'user' ? 'text-right block' : 'text-left block'" 
                              class="text-[10px] text-gray-400 mt-1 px-1" 
                              x-text="msg.time"></span>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex items-start gap-2.5">
                <img src="{{ asset('images/culture/culture01.jpg') }}" alt="Admin" class="w-7 h-7 rounded-full object-cover border-2 border-emerald-400 mt-1 shadow-sm">
                <div class="bg-white border border-gray-200 rounded-2xl rounded-tl-sm px-4 py-3 text-xs text-gray-400 flex items-center gap-1.5 shadow-sm">
                    <span class="w-1.5 h-1.5 bg-[#0a2622] rounded-full animate-bounce"></span>
                    <span class="w-1.5 h-1.5 bg-[#0a2622] rounded-full animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-1.5 h-1.5 bg-[#0a2622] rounded-full animate-bounce [animation-delay:0.4s]"></span>
                </div>
            </div>
        </div>

        <!-- Quick Reply Options -->
        <div class="px-3 py-2 bg-white border-t border-gray-100 flex gap-1.5 overflow-x-auto">
            <template x-for="reply in quickReplies" :key="reply">
                <button @click="sendMessage(reply)" 
                        class="whitespace-nowrap bg-gray-50 hover:bg-[#0a2622] hover:text-white border border-gray-200 hover:border-[#0a2622] text-gray-600 text-[11px] font-medium px-3 py-1.5 rounded-full transition-all duration-200">
                    <span x-text="reply"></span>
                </button>
            </template>
        </div>

        <!-- Input Bar -->
        <div class="p-3 bg-white border-t border-gray-100">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                <div class="flex-1 bg-gray-50 border border-gray-200 rounded-full px-3.5 py-1.5 flex items-center gap-2 focus-within:border-[#0a2622] transition-colors">
                    <input type="text" 
                           x-model="inputMessage" 
                           placeholder="Ketik pesan ke admin..." 
                           class="w-full bg-transparent border-none text-gray-800 placeholder-gray-400 text-xs sm:text-sm focus:outline-none">
                </div>
                <button type="submit" 
                        :disabled="!inputMessage.trim()"
                        class="bg-[#0a2622] hover:bg-[#0f3832] disabled:opacity-40 text-white p-2.5 rounded-full transition-all duration-200 shadow-md flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <x-confirm-modal
        show-var="showDeleteModal"
        on-confirm="clearHistory()"
        title="Hapus Riwayat Chat?"
        description="Seluruh riwayat percakapan akan dihapus permanen dan tidak bisa dikembalikan."
    />
</div>
