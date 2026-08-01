/**
 * ==========================================================================
 *  CHAT SUPPORT — Jelajah Madura
 * ==========================================================================
 *
 *  Lokasi: public/js/chat-support.js (SATU-SATUNYA FILE CHAT JS)
 *
 *  Dimuat synchronous via <script src> SEBELUM Alpine.js CDN di:
 *    - layouts/layout.blade.php        (halaman user)
 *    - layouts/admin-layout.blade.php  (halaman admin)
 *
 *  Berisi 2 fungsi Alpine.js:
 *    1. adminChat()        → Widget chat pengunjung (components/admin-chat.blade.php)
 *    2. adminChatCenter()  → Dashboard chat admin   (pages/admin/chat/admin-chat-index.blade.php)
 *
 *  API Endpoints:
 *    GET  /api/chat/messages?session_id=...
 *    POST /api/chat/send
 *    GET  /api/chat/admin/conversations
 *    POST /api/chat/clear
 * ==========================================================================
 */


/* -----------------------------------------------------------------------
 *  HELPER
 * ----------------------------------------------------------------------- */
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}


/* -----------------------------------------------------------------------
 *  1. adminChat(authUserName)
 *     Widget chat melayang di pojok kanan bawah (sisi pengunjung/user).
 *     Blade: components/admin-chat.blade.php
 * ----------------------------------------------------------------------- */
function adminChat(authUserName = null) {
    const IDENTITY_KEY = 'jelajah_madura_visitor_session_id';

    // Buat atau ambil session ID dari localStorage
    let sessionId = localStorage.getItem(IDENTITY_KEY);
    if (!sessionId) {
        sessionId = 'session_' + Math.random().toString(36).substring(2, 9) + '_' + Date.now();
        localStorage.setItem(IDENTITY_KEY, sessionId);
    }

    const userName = authUserName || ('Wisatawan #' + sessionId.substring(8, 12));

    return {
        // State
        isOpen: false,
        isTyping: false,
        inputMessage: '',
        messages: [],
        userName,
        sessionId,
        unreadCount: 0,
        hasUnreadAdmin: false,
        lastMsgId: 0,
        pollInterval: null,
        errorCount: 0,
        showDeleteModal: false,

        quickReplies: [
            'Rekomendasi Wisata 🏖️',
            'Cara Jadi Kontributor 📝',
            'Bantuan Akun 🔐',
        ],

        // Lifecycle
        init() {
            this.fetchMessages();
            this.pollInterval = setInterval(() => this.fetchMessages(true), 5000);
        },

        // Buka / tutup popup chat
        toggleChat() {
            this.isOpen = !this.isOpen;
            if (!this.isOpen) return;

            this.unreadCount = 0;
            this.hasUnreadAdmin = false;
            if (this.messages.length) {
                this.lastMsgId = this.messages[this.messages.length - 1].id;
            }
            this.fetchMessages();

            // Restart polling kalau sempat mati karena error
            if (!this.pollInterval) {
                this.errorCount = 0;
                this.pollInterval = setInterval(() => this.fetchMessages(true), 5000);
            }
            this.scrollToBottom();
        },

        // Ambil pesan dari server
        async fetchMessages(silent = false) {
            try {
                const res = await fetch('/api/chat/messages?session_id=' + encodeURIComponent(this.sessionId));
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();

                if (data.status !== 'success') return;
                this.errorCount = 0;
                const prevCount = this.messages.length;
                this.messages = data.messages;

                // Deteksi pesan baru dari admin saat widget tertutup
                if (this.messages.length) {
                    const last = this.messages[this.messages.length - 1];
                    if (last.sender === 'admin' && last.id > this.lastMsgId && silent && !this.isOpen) {
                        this.unreadCount += (this.messages.length - prevCount);
                        this.hasUnreadAdmin = true;
                    }
                }
                if (!silent) this.scrollToBottom();
            } catch {
                this.errorCount++;
                if (this.errorCount >= 5) {
                    clearInterval(this.pollInterval);
                    this.pollInterval = null;
                }
            }
        },

        // Kirim pesan user
        async sendMessage(customText = null) {
            const text = customText || this.inputMessage.trim();
            if (!text) return;
            if (!customText) this.inputMessage = '';

            try {
                const res = await fetch('/api/chat/send', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                    body: JSON.stringify({
                        session_id: this.sessionId,
                        sender_name: this.userName,
                        sender_type: 'user',
                        message: text,
                    }),
                });
                const data = await res.json();
                if (data.status === 'success') {
                    await this.fetchMessages();
                    this.unreadCount = 0;
                    this.hasUnreadAdmin = false;
                    if (this.messages.length) this.lastMsgId = this.messages[this.messages.length - 1].id;
                    this.scrollToBottom();
                }
            } catch (e) {
                console.error('[chat] sendMessage error:', e);
            }
        },

        // Hapus seluruh riwayat chat sesi ini
        async clearHistory() {
            try {
                await fetch('/api/chat/clear', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                    body: JSON.stringify({ session_id: this.sessionId }),
                });
                this.unreadCount = 0;
                this.hasUnreadAdmin = false;
                await this.fetchMessages();
            } catch (e) {
                console.error('[chat] clearHistory error:', e);
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const el = this.$refs.chatBody;
                if (el) el.scrollTop = el.scrollHeight;
            });
        },
    };
}


/* -----------------------------------------------------------------------
 *  2. adminChatCenter()
 *     Dashboard live chat admin (/admin/chat).
 *     Blade: pages/admin/chat/admin-chat-index.blade.php
 * ----------------------------------------------------------------------- */
function adminChatCenter() {
    return {
        // State
        searchQuery: '',
        activeConvId: null,
        replyMessage: '',
        conversations: [],
        pollInterval: null,
        readMap: {},
        showDeleteModal: false,

        // Lifecycle
        init() {
            this.fetchConversations();
            this.pollInterval = setInterval(() => this.fetchConversations(true), 2500);
        },

        // Ambil semua percakapan dari server
        async fetchConversations(silent = false) {
            try {
                const res = await fetch('/api/chat/admin/conversations');
                const data = await res.json();
                if (data.status !== 'success') return;

                this.conversations = data.conversations;

                // Tandai pesan aktif sebagai sudah dibaca
                if (this.activeConvId && this.activeConv?.lastMsgId) {
                    this.readMap[this.activeConv.id] = this.activeConv.lastMsgId;
                }
                if (!silent) this.scrollToBottom();
            } catch (e) {
                console.error('[chat-admin] fetchConversations error:', e);
            }
        },

        // Total badge unread di sidebar
        get unreadTotal() {
            return this.conversations.reduce(
                (sum, c) => sum + (this.hasUnread(c) ? (c.unreadCount || 1) : 0), 0
            );
        },

        // Cek apakah percakapan punya pesan baru dari user
        hasUnread(conv) {
            if (!conv?.lastMsgId || conv.lastSender !== 'user') return false;
            if ((conv.unreadCount || 0) <= 0) return false;
            if (this.activeConvId === conv.id) return false;
            return conv.lastMsgId > (this.readMap[conv.id] || 0);
        },

        // Filter percakapan berdasarkan search query
        get filteredConversations() {
            if (!this.searchQuery.trim()) return this.conversations;
            const q = this.searchQuery.toLowerCase();
            return this.conversations.filter(c =>
                c.userName.toLowerCase().includes(q) || c.lastMessage.toLowerCase().includes(q)
            );
        },

        // Percakapan yang sedang aktif/dipilih
        get activeConv() {
            return this.conversations.find(c => c.id === this.activeConvId) || null;
        },

        // Pilih percakapan dari sidebar kiri
        selectConversation(id) {
            this.activeConvId = id;
            const conv = this.conversations.find(c => c.id === id);
            if (conv?.lastMsgId) this.readMap[id] = conv.lastMsgId;
            this.scrollToBottom();
        },

        // Kirim balasan admin
        async sendAdminReply() {
            const text = this.replyMessage.trim();
            if (!text || !this.activeConv) return;
            this.replyMessage = '';

            try {
                const res = await fetch('/api/chat/send', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                    body: JSON.stringify({
                        session_id: this.activeConv.sessionId,
                        sender_name: 'Javier',
                        sender_type: 'admin',
                        message: text,
                    }),
                });
                const data = await res.json();
                if (data.status === 'success') {
                    await this.fetchConversations();
                    if (this.activeConv?.lastMsgId) {
                        this.readMap[this.activeConv.id] = this.activeConv.lastMsgId;
                    }
                    this.scrollToBottom();
                }
            } catch (e) {
                console.error('[chat-admin] sendAdminReply error:', e);
            }
        },

        // Hapus percakapan yang sedang aktif
        async clearCurrentChat() {
            if (!this.activeConv) return;
            try {
                await fetch('/api/chat/clear', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                    body: JSON.stringify({ session_id: this.activeConv.sessionId }),
                });
                this.activeConvId = null;
                await this.fetchConversations();
            } catch (e) {
                console.error('[chat-admin] clearCurrentChat error:', e);
            }
        },

        // Template balasan cepat
        cannedTemplates: [
            'Halo! Terima kasih telah menghubungi Jelajah Madura. Ada yang bisa kami bantu?',
            'Untuk rekomendasi wisata terbaik di Madura, silakan cek halaman Explore kami ya! 🌴',
            'Pendaftaran kontributor dapat dilakukan dengan login terlebih dahulu lalu mengajukan draf artikel. 📝',
            'Terima kasih atas masukannya! Tim kami akan segera menindaklanjuti. 😊',
        ],

        scrollToBottom() {
            this.$nextTick(() => {
                const el = this.$refs.adminChatBody;
                if (el) el.scrollTop = el.scrollHeight;
            });
        },
    };
}


/* -----------------------------------------------------------------------
 *  REGISTER KE WINDOW (wajib untuk Alpine CDN)
 * ----------------------------------------------------------------------- */
window.adminChat = adminChat;
window.adminChatCenter = adminChatCenter;
