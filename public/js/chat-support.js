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
        defaultReplySent: false,

        quickReplies: [
            'Rekomendasi Wisata 🏖️',
            'Cara Jadi Kontributor 📝',
            'Bantuan Akun 🔐',
        ],

        // Lifecycle
        init() {
            this.fetchMessages();
            this.startPolling();
        },

        // Polling cerdas: 5 detik saat terbuka, 30 detik saat tertutup
        startPolling() {
            if (this.pollInterval) clearTimeout(this.pollInterval);
            const interval = this.isOpen ? 5000 : 30000;
            this.pollInterval = setTimeout(async () => {
                await this.fetchMessages(true);
                this.startPolling();
            }, interval);
        },

        // Buka / tutup popup chat
        toggleChat() {
            this.isOpen = !this.isOpen;
            if (!this.isOpen) {
                this.startPolling(); // Sesuaikan interval ke 30s
                return;
            }

            this.unreadCount = 0;
            this.hasUnreadAdmin = false;
            if (this.messages.length) {
                this.lastMsgId = this.messages[this.messages.length - 1].id;
            }
            this.fetchMessages();

            this.startPolling(); // Sesuaikan interval ke 5s
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
            } catch (e) {
                this.errorCount++;
                console.error('[chat] fetch error:', e);
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

                    // Trigger auto-reply berdasarkan keyword
                    this.autoReply(text);
                }
            } catch (e) {
                console.error('[chat] sendMessage error:', e);
            }
        },

        // Auto-reply: deteksi keyword dari pesan user, balas otomatis sebagai Admin Rara
        autoReply(userText) {
            const t = userText.toLowerCase();
            const rules = [
                { keys: ['halo','hai','hi','hei','assalamu','selamat pagi','selamat siang','selamat sore','selamat malam','permisi','pagi','siang','sore','malam'],
                  reply: 'Halo! 👋 Selamat datang di Jelajah Madura. Saya Rara, ada yang bisa saya bantu hari ini?' },
                { keys: ['bantuan akun','lupa password','tidak bisa login'],
                  reply: 'Jika Anda mengalami kendala login atau lupa password, silakan gunakan fitur Reset Password di halaman login. Jika masih bermasalah, mohon sebutkan alamat email yang terdaftar.' },
                { keys: ['wisata','destinasi','tempat','rekomendasi','liburan','jalan-jalan','jalan jalan','pantai','alam'],
                  reply: 'Madura punya banyak destinasi keren! 🌊 Mulai dari Pantai Lombang, Api Tak Kunjung Padam, hingga Bukit Jaddih. Cek halaman Wisata di aplikasi kami untuk detail lengkapnya!' },
                { keys: ['kuliner','makanan','makan','sate','bebek','oleh-oleh','oleh oleh','khas','enak'],
                  reply: 'Kuliner Madura memang juara! 🍢 Sate Madura, Bebek Songkem, dan Lorjuk wajib dicoba. Cek halaman Kuliner kami untuk rekomendasi tempat makan terbaik!' },
                { keys: ['umkm','belanja','kerajinan','batik','souvenir'],
                  reply: 'Madura punya banyak UMKM unggulan! 🛍️ Batik Madura, kerajinan tangan, hingga produk olahan lokal. Jelajahi halaman UMKM kami!' },
                { keys: ['kontributor','bergabung','join','tambah tempat',],
                  reply: 'Tertarik jadi Kontributor Jelajah Madura? 📝 Caranya: Register → Login → Upload Foto & Cerita → Ajukan verifikasi di halaman Kontributor. Tim kami verifikasi dalam 1-2 hari kerja!' },
                { keys: ['harga','tiket','biaya','berapa','gratis','bayar'],
                  reply: 'Info harga tiket tertera di halaman detail masing-masing destinasi. Karena bisa berubah, sebaiknya konfirmasi langsung ke lokasi ya! 😊' },
                { keys: ['terima kasih','makasih','thanks','thank you','ok','oke','siap','mantap'],
                  reply: 'Sama-sama! 😊 Senang bisa membantu. Kalau ada pertanyaan lain, jangan ragu chat lagi. Selamat menjelajahi Madura! 🌊' },
            ];

            let matchedReply = null;
            for (const rule of rules) {
                if (rule.keys.some(k => t.includes(k))) { matchedReply = rule.reply; break; }
            }

            // Pesan default hanya dikirim 1x per sesi
            if (!matchedReply) {
                if (this.defaultReplySent) return;
                this.defaultReplySent = true;
                matchedReply = 'Halo! Pesan Anda sudah kami terima 🙏 Admin Rara akan segera merespons...';
            }

            // Tampilkan balasan tanpa jeda agar user tidak perlu menunggu
            const delay = 0;
            this.isTyping = true;
            this.scrollToBottom();

            setTimeout(async () => {
                this.isTyping = false;
                try {
                    await fetch('/api/chat/send', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
                        body: JSON.stringify({ session_id: this.sessionId, sender_name: 'Rara', sender_type: 'admin', message: matchedReply }),
                    });
                    await this.fetchMessages();
                    this.scrollToBottom();
                } catch (e) { console.error('[chat] autoReply error:', e); }
            }, delay);
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
            this.startPolling();
        },

        startPolling() {
            if (this.pollInterval) clearTimeout(this.pollInterval);
            this.pollInterval = setTimeout(async () => {
                await this.fetchConversations(true);
                this.startPolling();
            }, 5000); // Admin polling setiap 5 detik (dikurangi dari 2.5s)
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
                        sender_name: 'Rara',
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
