@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="min-h-screen bg-[#f7f7f5] py-10 px-4 md:px-8">
    <div class="max-w-6xl mx-auto">
        
        <div class="flex items-start gap-3 md:gap-4 mb-8">
            <a href="/dashboard" class="mt-1 shrink-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#0f172a]">Tambah Konten</h1>
                <p class="text-sm text-gray-500 mt-1.5">Bagikan informasi menarik tentang destinasi wisata, kuliner, produk UMKM, atau spot foto di Madura. Pastikan informasi yang Anda berikan akurat dan berkualitas.</p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- FORM SECTION (Kiri) -->
            <div class="w-full lg:w-2/3 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                <form action="/contents" method="POST" enctype="multipart/form-data" 
                      x-data="contentForm()">
                    @csrf
                    
                    {{-- Informasi Dasar --}}
                    <h2 class="text-lg font-bold text-[#0f172a] mb-5">Informasi Dasar</h2>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-[#0f172a] mb-1.5 flex gap-1">Judul Konten <span class="text-red-500">*</span></label>
                            <input type="text" name="title" x-model="title" maxlength="60" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-white"
                                   placeholder="Masukkan judul yang menarik (Maks. 60 karakter)">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-[#0f172a] mb-1.5 flex gap-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-white shadow-sm hover:border-gray-300 transition-colors">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-[#0f172a] mb-1.5 flex gap-1">Kabupaten <span class="text-red-500">*</span></label>
                                <select name="regency_id" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-white shadow-sm hover:border-gray-300 transition-colors">
                                    <option value="" disabled selected>Pilih Kabupaten</option>
                                    @foreach($regencies as $regency)
                                        <option value="{{ $regency->id }}">{{ $regency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#0f172a] mb-1.5 flex gap-1">Deskripsi Detail <span class="text-red-500">*</span></label>
                            <textarea name="description" x-model="description" maxlength="1000" rows="5" required
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-white resize-none"
                                      placeholder="Ceritakan detail menarik, fasilitas, harga tiket, jam buka, dll."></textarea>
                            <div class="flex justify-between mt-1.5 px-0.5 text-[11px] text-gray-500 font-medium">
                                <span>Gunakan bahasa yang informatif dan menarik.</span>
                                <span><span x-text="description.length"></span> / 1000 karakter</span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-8">

                    {{-- Lokasi --}}
                    <h2 class="text-lg font-bold text-[#0f172a] mb-5">Lokasi</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-[#0f172a] mb-1.5">Alamat Lengkap (Opsional)</label>
                            <input type="text" name="address" 
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-white"
                                   placeholder="Contoh: Jl. Trunojoyo No. 1, Pamekasan">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-[#0f172a] mb-1.5">Link Google Maps (Opsional)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <input type="url" name="maps_url" 
                                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-white"
                                       placeholder="https://maps.app.goo.gl/...">
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-8">

                    {{-- Media Promosi --}}
                    <h2 class="text-lg font-bold text-[#0f172a] mb-5">Media Promosi</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-[#0f172a] mb-1.5 flex gap-1">Unggah Foto <span class="text-red-500">*</span></label>
                            
                            {{-- Dropzone Area --}}
                            <div class="relative w-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 hover:border-gray-400 transition-colors py-10 px-8 flex flex-col items-center justify-center text-center cursor-pointer"
                                 @dragover.prevent="$el.classList.add('border-[#ed8a53]', 'bg-orange-50/50')"
                                 @dragleave.prevent="$el.classList.remove('border-[#ed8a53]', 'bg-orange-50/50')"
                                 @drop.prevent="handleDrop($event, $el)"
                                 @click="$refs.fileInput.click()">
                                
                                <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3">
                                    <svg class="w-5 h-5 text-[#0f172a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <p class="text-[13px] font-bold text-[#0f172a]">Klik untuk unggah atau seret file ke sini</p>
                                <p class="text-[11px] text-gray-500 mt-1 font-medium">Format JPG, PNG (Maks. 5MB per foto)<br>Dapat mengunggah hingga 5 foto. Foto pertama akan menjadi cover utama.</p>
                                <input type="file" name="photos[]" x-ref="fileInput" @change="handleFiles" multiple accept="image/jpeg, image/png, image/webp" class="hidden" required>
                            </div>

                            {{-- Preview Area --}}
                            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-3 mt-4" x-show="previewUrls.length > 0">
                                <template x-for="(url, index) in previewUrls" :key="index">
                                    <div class="relative group rounded-xl overflow-hidden aspect-square border border-gray-200 bg-gray-50">
                                        <img :src="url" class="w-full h-full object-cover">
                                        <button type="button" @click.stop="removePhoto(index)" class="absolute top-1.5 right-1.5 w-6 h-6 bg-white/90 rounded-full shadow-sm flex items-center justify-center text-red-500 hover:bg-white hover:text-red-600 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                        <div x-show="index === 0" class="absolute bottom-1.5 left-1.5 bg-[#af4926] text-white text-[9px] font-bold px-1.5 py-0.5 rounded-md">
                                            Cover
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-10 pt-5 pr-2">
                        <a href="/dashboard" class="px-5 py-2.5 rounded-xl border border-gray-300 bg-white text-sm font-semibold text-[#0f172a] hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#ac4322] text-white text-sm font-semibold hover:bg-[#863319] shadow-sm transition-colors flex items-center gap-2">
                            Simpan Konten
                        </button>
                    </div>
                </form>
            </div>

            <!-- SIDEBAR SECTION (Kanan) -->
            <div class="w-full lg:w-1/3 flex flex-col gap-5">
                {{-- Panduan Card --}}
                <div class="bg-[#dcf2ea] rounded-2xl p-6 shadow-sm border border-[#cbe4db]">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-[#0c3c2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        <h3 class="text-base font-bold text-[#0c3c2e]">Panduan Kontribusi</h3>
                    </div>
                    <ul class="text-[13px] text-[#205344] space-y-3 list-none pl-1">
                        <li class="flex items-start gap-2">
                            <div class="w-1.5 h-1.5 bg-[#4c8473] rounded-full mt-1.5 shrink-0"></div>
                            Gunakan foto asli dengan pencahayaan yang baik, hindari watermark berlebih.
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-1.5 h-1.5 bg-[#4c8473] rounded-full mt-1.5 shrink-0"></div>
                            Pastikan alamat dan titik koordinat maps sesuai dengan lokasi sebenarnya.
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-1.5 h-1.5 bg-[#4c8473] rounded-full mt-1.5 shrink-0"></div>
                            Berikan deskripsi yang jujur dan informatif agar bermanfaat bagi wisatawan.
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-1.5 h-1.5 bg-[#4c8473] rounded-full mt-1.5 shrink-0"></div>
                            Konten akan ditinjau oleh tim moderator sebelum dipublikasikan.
                        </li>
                    </ul>
                </div>

                {{-- Image Preview Illustration --}}
                <div class="relative rounded-2xl overflow-hidden aspect-[4/3] shadow-sm group">
                    <img src="https://images.unsplash.com/photo-1596404179374-601980072bba?q=80&w=2670&auto=format&fit=crop" alt="Ilustrasi Gili Iyang" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a]/90 via-[#0f172a]/30 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5">
                        <span class="inline-flex items-center justify-center bg-[#25c46b] text-white text-[9px] font-bold px-2 py-0.5 rounded-sm mb-2 tracking-wider">Inspirasi</span>
                        <h4 class="text-white font-semibold text-base leading-[1.3] truncate whitespace-normal line-clamp-2">Gili Iyang, Oksigen Terbaik Kedua di Dunia</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contentForm', () => ({
        title: '',
        description: '',
        files: [],
        previewUrls: [],
        
        handleFiles(event) {
            this.addFiles(event.target.files);
        },
        
        handleDrop(event, element) {
            element.classList.remove('border-[#ed8a53]', 'bg-orange-50/50');
            this.addFiles(event.dataTransfer.files);
        },

        addFiles(newFiles) {
            const filesArray = Array.from(newFiles);
            if (this.files.length + filesArray.length > 5) {
                alert('Maksimal 5 foto yang dapat diunggah.');
                return;
            }

            filesArray.forEach(file => {
                if(file.size > 5 * 1024 * 1024) {
                     alert(`File ${file.name} melebihi 5MB.`);
                     return;
                }
                this.files.push(file);
                this.previewUrls.push(URL.createObjectURL(file));
            });
            
             this.updateInputFiles();
        },
        
        removePhoto(index) {
            this.files.splice(index, 1);
            this.previewUrls.splice(index, 1);
            this.updateInputFiles();
        },
        
        updateInputFiles() {
            const dt = new DataTransfer();
            this.files.forEach(file => dt.items.add(file));
            this.$refs.fileInput.files = dt.files;
        }
    }))
})
</script>
@endsection
