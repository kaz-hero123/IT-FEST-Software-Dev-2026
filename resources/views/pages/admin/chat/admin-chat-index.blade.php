@extends('layouts.admin-layout')

@section('title', 'Live Chat Support - Admin Portal')

@section('content')
<div x-data="adminChatCenter()" x-init="init()" x-on:keydown.escape.window="showDeleteModal = false" class="flex h-full overflow-hidden bg-gray-50 relative">
    <!-- Conversations List (Left Sidebar) -->
    <div class="w-full md:w-80 lg:w-96 border-r border-gray-200 bg-white flex flex-col shrink-0">
        <!-- Header -->
        <div class="p-4 border-b border-gray-100 bg-[#0a2622] text-white flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold flex items-center gap-2">
                    Live Chat Support
                </h2>
                <p class="text-[11px] text-emerald-400 font-medium">Pusat Bantuan & Layanan Pengunjung</p>
            </div>
            <span class="text-white text-xs font-bold px-2.5 py-1 rounded-full " x-text="conversations.length + ' Sesi'"></span>
        </div>

        <!-- Search Bar -->
        <div class="p-3 border-b border-gray-100 bg-gray-50">
            <div class="relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Cari nama pengguna / pesan..." 
                       class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-[#b84c22]">
            </div>
        </div>

        <!-- Conversations Stream -->
        <div class="flex-1 overflow-y-auto divide-y divide-gray-100">
            <template x-for="conv in filteredConversations" :key="conv.id">
                <div @click="selectConversation(conv.id)" 
                     :class="activeConvId === conv.id ? 'bg-[#b84c22]/10 border-l-4 border-[#b84c22]' : 'hover:bg-gray-50'"
                     class="p-4 cursor-pointer transition-colors relative">
                    <div class="flex items-start gap-3">
                        <div class="shrink-0">
                            <div class="w-10 h-10 rounded-full bg-[#0a2622] text-white flex items-center justify-center font-bold text-sm shadow-sm"
                                 x-text="conv.userName.charAt(0).toUpperCase()"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-xs font-bold text-[#0f172a] truncate" x-text="conv.userName"></h4>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <span class="text-[10px] text-gray-400 font-medium" x-text="conv.lastTime"></span>
                                    <template x-if="conv.unreadCount > 0 && activeConvId !== conv.id">
                                        <span class="bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full" x-text="conv.unreadCount"></span>
                                    </template>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 truncate" x-text="conv.lastMessage"></p>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="filteredConversations.length === 0">
                <div class="p-8 text-center text-gray-400">
                    <p class="text-xs font-medium">Belum ada percakapan aktif.</p>
                </div>
            </template>
        </div>
    </div>

    <!-- Active Chat Conversation (Right Panel) -->
    <div class="flex-1 flex flex-col h-full overflow-hidden bg-white">
        <template x-if="activeConv">
            <div class="flex-1 flex flex-col h-full overflow-hidden">
                <!-- Chat Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-white flex items-center justify-between shrink-0 shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#0a2622] text-white flex items-center justify-center font-bold text-sm shadow-sm"
                             x-text="activeConv.userName.charAt(0).toUpperCase()"></div>
                        <div>
                            <h3 class="text-sm font-bold text-[#0f172a] leading-tight flex items-center gap-2">
                                <span x-text="activeConv.userName"></span>
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Sesi Aktif</span>
                            </h3>
                            <p class="text-[11px] text-gray-400">Pengguna Jelajah Madura</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="showDeleteModal = true" class="px-3 py-1.5 border border-rose-200 hover:bg-rose-50 text-rose-600 text-xs font-semibold rounded-lg transition-colors">
                            Hapus Obrolan Ini
                        </button>
                    </div>
                </div>

                <!-- Messages Stream -->
                <div x-ref="adminChatBody" class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50/50">
                    <div class="text-center my-2">
                        <span class="text-[11px] font-semibold text-gray-400 bg-gray-200 px-3 py-1 rounded-full">Sesi Percakapan Langsung</span>
                    </div>

                    <template x-for="msg in activeConv.messages" :key="msg.id">
                        <div :class="msg.sender === 'admin' ? 'flex flex-col items-end' : 'flex items-start gap-3'">
                            <template x-if="msg.sender !== 'admin'">
                                <div class="w-8 h-8 rounded-full bg-[#0a2622] text-white text-xs font-bold flex items-center justify-center shrink-0"
                                     x-text="activeConv.userName.charAt(0).toUpperCase()"></div>
                            </template>

                            <div class="max-w-[70%] flex flex-col" :class="msg.sender === 'admin' ? 'items-end' : 'items-start'">
                                <div :class="msg.sender === 'admin'
                                        ? 'bg-[#b84c22] text-white rounded-2xl rounded-tr-xs px-4 py-2.5 text-xs sm:text-sm font-medium shadow-sm w-fit'
                                        : 'bg-white border border-gray-200 text-[#0f172a] rounded-2xl rounded-tl-xs px-4 py-2.5 text-xs sm:text-sm shadow-xs w-fit'"
                                     x-text="msg.text">
                                </div>
                                <span :class="msg.sender === 'admin' ? 'text-right block' : 'text-left block'" 
                                      class="text-[10px] text-gray-400 mt-1 px-1" 
                                      x-text="msg.time + (msg.sender === 'admin' ? ' • Admin Javier' : '')"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Canned Responses Quick Bar -->
                <div class="px-6 py-2 bg-gray-100 border-t border-gray-200 flex items-center gap-2 overflow-x-auto">
                    <span class="text-[11px] font-bold text-gray-500 whitespace-nowrap">Template Balasan:</span>
                    <template x-for="tmpl in cannedTemplates" :key="tmpl">
                        <button @click="replyMessage = tmpl" 
                                class="text-[11px] bg-white hover:bg-[#b84c22] hover:text-white border border-gray-200 px-3 py-1 rounded-full text-gray-700 font-medium whitespace-nowrap transition-colors shadow-2xs">
                            <span x-text="tmpl"></span>
                        </button>
                    </template>
                </div>

                <!-- Input Reply Bar -->
                <div class="p-4 bg-white border-t border-gray-200">
                    <form @submit.prevent="sendAdminReply()" class="flex items-center gap-3">
                        <input type="text" 
                               x-model="replyMessage" 
                               placeholder="Tulis balasan sebagai Admin Javier..." 
                               class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-[#b84c22] focus:bg-white transition-colors">
                        <button type="submit" 
                                :disabled="!replyMessage.trim()"
                                class="bg-[#b84c22] hover:bg-[#963c18] disabled:opacity-40 text-white font-bold px-6 py-3 rounded-xl text-xs sm:text-sm transition-all duration-200 shadow-sm flex items-center gap-2 shrink-0">
                            <span>Kirim Balasan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </template>

        <template x-if="!activeConv">
            <div class="flex-1 flex flex-col items-center justify-center p-8 text-center bg-gray-50/30">
                <div class="w-16 h-16 bg-[#b84c22]/10 text-[#b84c22] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-[#0f172a] mb-1">Pilih Percakapan Pengunjung</h3>
                <p class="text-xs text-gray-400 max-w-sm">Pilih salah satu obrolan pengguna di panel sebelah kiri untuk mulai merespons pertanyaan pengunjung secara real-time.</p>
            </div>
        </template>
    </div>

    {{-- Modal konfirmasi hapus — HARUS di dalam x-data scope --}}
    <x-confirm-modal
        show-var="showDeleteModal"
        on-confirm="clearCurrentChat()"
        title="Hapus Obrolan Ini?"
        dynamic-desc="'Seluruh riwayat percakapan dengan ' + (activeConv ? activeConv.userName : 'pengguna ini') + ' akan dihapus permanen.'"
    />
</div>

@endsection
