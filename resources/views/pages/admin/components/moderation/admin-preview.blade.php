<div class="flex flex-col lg:flex-row gap-5 md:gap-6 flex-1 min-h-0 pb-6">

    {{-- RIGHT COLUMN (Moderation Decision) — di atas di mobile, kanan di desktop --}}
    <div class="order-first lg:order-last w-full lg:w-[300px] shrink-0 space-y-4 lg:sticky lg:top-0 lg:self-start">

        {{-- Moderation Decision --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <h2 class="text-[14px] font-bold text-[#0f172a] flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Keputusan Moderasi
            </h2>

            <p class="text-[11.5px] text-gray-400 font-medium mb-3 leading-relaxed">
                Jika konten memenuhi semua panduan dan tidak memerlukan perubahan.
            </p>
            <form method="POST" action="/admin/moderation/{{ $content->slug ?? $content->id }}/approve" id="form-approve" class="mb-5" x-data>
                @csrf
                <button type="button"
                        @click="$dispatch('confirm-action', { formId: 'form-approve', title: 'Setujui Konten', message: 'Apakah Anda yakin ingin menyetujui dan mempublikasikan konten ini?', confirmText: 'Setujui & Publikasikan', type: 'warning' })"
                        class="w-full flex items-center justify-center gap-2 py-2.5 bg-green-500 hover:bg-green-600 text-white text-[13px] font-bold rounded-xl transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Setujui & Publikasikan
                </button>
            </form>

            <hr class="border-gray-100 mb-4">

            <p class="text-[11.5px] text-gray-400 font-medium mb-2 leading-relaxed">
                Jika konten melanggar panduan atau memerlukan perbaikan signifikan.
            </p>
            <p class="text-[10.5px] font-bold text-gray-500 uppercase tracking-wider mb-2">Alasan Penolakan (Wajib)</p>
            <form method="POST" action="/admin/moderation/{{ $content->slug ?? $content->id }}/reject" id="form-reject" x-data="{ note: '' }">
                @csrf
                <textarea name="note" x-model="note" rows="3" required
                          placeholder="Tuliskan alasan mengapa pengajuan ini ditolak..."
                          class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-[12px] text-[#374151] placeholder-gray-300 font-medium focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-300 resize-none mb-3"></textarea>
                <button type="button"
                        @click="if(!note.trim()) { alert('Alasan penolakan wajib diisi!'); return; } $dispatch('confirm-action', { formId: 'form-reject', title: 'Tolak Konten', message: 'Apakah Anda yakin ingin menolak pengajuan ini?', confirmText: 'Tolak', type: 'danger' })"
                        class="w-full flex items-center justify-center gap-2 py-2.5 bg-red-500 hover:bg-red-600 text-white text-[13px] font-bold rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tolak Pengajuan
                </button>
            </form>
        </div>

        {{-- Contributor Info --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Kontributor</p>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[13.5px] font-bold text-[#0f172a]">{{ $content->user->name ?? 'Tidak diketahui' }}</p>
                    <p class="text-[11px] text-gray-400 font-medium">{{ $content->user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- LEFT COLUMN — Media, Info, History --}}
    <div class="flex-1 min-w-0 min-h-0 space-y-5 lg:overflow-y-auto lg:pr-1">

        {{-- Media Gallery --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <h2 class="text-[14px] font-bold text-[#0f172a] flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Galeri Media
            </h2>

            @php $photos = $content->photos; @endphp
            @if($photos->isNotEmpty())
                <div class="relative rounded-xl overflow-hidden mb-3 bg-gray-100" style="aspect-ratio:4/3;">
                    <img src="{{ $photos->first()->resolved_url }}"
                         alt="Sampul" class="w-full h-full object-cover">
                    <span class="absolute top-2.5 right-2.5 bg-white/90 text-[#0f172a] text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                        Sampul
                    </span>
                </div>
                @if($photos->count() > 1)
                @php
                    $remainingCount = $photos->count() - 1;
                    $gridCols = match($remainingCount) {
                        1 => 'grid-cols-1',
                        2, 4 => 'grid-cols-2',
                        3 => 'grid-cols-3',
                        default => 'grid-cols-3'
                    };
                @endphp
                <div class="grid {{ $gridCols }} gap-2">
                    @foreach($photos->skip(1) as $photo)
                    <div class="rounded-xl overflow-hidden aspect-square bg-gray-100">
                        <img src="{{ $photo->resolved_url }}" alt="Foto" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
            @else
                <div class="bg-gray-50 rounded-xl flex flex-col items-center justify-center text-gray-300 py-12">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[12px] font-medium">Tidak ada foto diunggah</span>
                </div>
            @endif
        </div>

        {{-- Information --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <h2 class="text-[14px] font-bold text-[#0f172a] flex items-center gap-2 mb-5">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informasi
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-5">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Kategori</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11.5px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                        {{ $content->category->name ?? '-' }}
                    </span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Kabupaten</p>
                    <p class="text-[14px] font-bold text-[#0f172a]">{{ $content->regency->name ?? '-' }}</p>
                </div>
            </div>

            <div class="mb-5">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi</p>
                <div class="text-[13px] text-[#374151] leading-relaxed font-medium whitespace-pre-line bg-gray-50 rounded-xl p-4 border border-gray-100">{{ $content->description }}</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-5">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Jam Buka</p>
                    <p class="text-[12.5px] font-bold text-[#0f172a]">{{ $content->open_time ? \Carbon\Carbon::parse($content->open_time)->format('H:i') . ' WIB' : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Jam Tutup</p>
                    <p class="text-[12.5px] font-bold text-[#0f172a]">{{ $content->close_time ? \Carbon\Carbon::parse($content->close_time)->format('H:i') . ' WIB' : '-' }}</p>
                </div>
            </div>

            @if($content->address || $content->maps_url)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if($content->address)
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Alamat</p>
                    <p class="text-[12.5px] text-[#374151] font-medium leading-relaxed">{{ $content->address }}</p>
                </div>
                @endif
                @if($content->maps_url)
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Tautan Google Maps</p>
                    <a href="{{ $content->maps_url }}" target="_blank"
                       class="text-[12.5px] text-blue-500 font-bold hover:underline flex items-center gap-1">
                        Lihat di Peta
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>

        {{-- Moderation History --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <h2 class="text-[14px] font-bold text-[#0f172a] flex items-center gap-2 mb-5">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat Moderasi
            </h2>

            <div class="space-y-4">
                <div class="flex gap-3">
                    <div class="shrink-0 w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center mt-0.5">
                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[12.5px] font-bold text-[#0f172a]">
                            Diajukan
                            <span class="text-gray-400 font-medium">oleh {{ $content->user->name ?? '-' }}</span>
                            <span class="text-gray-400 font-medium">• {{ $content->created_at->format('d M Y, H:i') }} WIB</span>
                        </p>
                        <p class="text-[12px] text-gray-500 font-medium mt-0.5">Pengajuan awal dibuat untuk ditinjau.</p>
                    </div>
                </div>

                @foreach($moderationNotes as $note)
                <div class="flex gap-3">
                    <div class="shrink-0 w-7 h-7 rounded-full flex items-center justify-center mt-0.5
                                {{ $note->action === 'approved' ? 'bg-green-100' : ($note->action === 'rejected' ? 'bg-red-100' : 'bg-blue-100') }}">
                        @if($note->action === 'approved')
                        <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        @elseif($note->action === 'rejected')
                        <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        @else
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01"/>
                        </svg>
                        @endif
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-0.5">
                            <span class="text-[11px] font-bold px-2 py-0.5 rounded-md
                                         {{ $note->action === 'approved' ? 'bg-green-100 text-green-700' : ($note->action === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600') }}">
                                {{ $note->action === 'approved' ? 'Disetujui' : ($note->action === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                            </span>
                            <span class="text-[11.5px] text-gray-400 font-medium">
                                oleh {{ $note->admin->name ?? 'Admin' }} • {{ $note->created_at->format('d M Y, H:i') }} WIB
                            </span>
                        </div>
                        @if($note->note)
                        <p class="text-[12px] text-gray-500 font-medium mt-1">{{ $note->note }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
