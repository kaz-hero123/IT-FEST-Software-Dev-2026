{{--
  |--------------------------------------------------------------------------
  | Reusable Confirmation Modal Component
  |--------------------------------------------------------------------------
  | Props:
  |   showVar      -> Nama variabel Alpine yang mengontrol visibilitas modal (string)
  |   onConfirm    -> Ekspresi Alpine.js yang dijalankan saat tombol konfirmasi diklik (string)
  |   title        -> Judul modal (string)
  |   description  -> Teks deskripsi statis (string, opsional jika pakai slot :description)
  |   dynamicDesc  -> Ekspresi Alpine x-text untuk deskripsi dinamis (string, opsional)
  |   confirmLabel -> Label tombol konfirmasi (default: 'Hapus')
  |   cancelLabel  -> Label tombol batal (default: 'Batal')
  |
  | Cara pakai:
  |   <x-confirm-modal
  |       show-var="showDeleteModal"
  |       on-confirm="clearHistory()"
  |       title="Hapus Riwayat Chat?"
  |       description="Seluruh riwayat akan dihapus permanen."
  |   />
  |
  |   Atau dengan deskripsi dinamis Alpine (x-text):
  |   <x-confirm-modal
  |       show-var="showDeleteModal"
  |       on-confirm="clearCurrentChat()"
  |       title="Hapus Obrolan Ini?"
  |       dynamic-desc="'Percakapan dengan ' + activeConv.userName + ' akan dihapus.'"
  |   />
  |--------------------------------------------------------------------------
--}}
@props([
    'showVar'      => 'showModal',
    'onConfirm'    => '',
    'title'        => 'Konfirmasi',
    'description'  => '',
    'dynamicDesc'  => '',
    'confirmLabel' => 'Hapus',
    'cancelLabel'  => 'Batal',
])

<div
    x-show="{{ $showVar }}"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
    style="display:none;">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
         @click="{{ $showVar }} = false"></div>

    {{-- Modal Box --}}
    <div
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">

        {{-- Icon --}}
        <div class="mx-auto mb-4 w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>

        {{-- Title --}}
        <h3 class="text-base font-bold text-gray-800 mb-1">{{ $title }}</h3>

        {{-- Description: static atau dinamis dari Alpine --}}
        @if($dynamicDesc)
            <p class="text-sm text-gray-500 mb-6" x-text="{{ $dynamicDesc }}"></p>
        @else
            <p class="text-sm text-gray-500 mb-6">{{ $description }}</p>
        @endif

        {{-- Actions --}}
        <div class="flex gap-3">
            <button @click="{{ $showVar }} = false"
                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                {{ $cancelLabel }}
            </button>
            <button @click="{{ $onConfirm }}; {{ $showVar }} = false"
                    class="flex-1 py-2.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-sm font-semibold transition-colors">
                {{ $confirmLabel }}
            </button>
        </div>
    </div>
</div>
