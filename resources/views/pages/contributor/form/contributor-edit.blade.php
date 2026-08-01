@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
<div class="min-h-screen bg-[#f7f7f5] py-10 px-4 md:px-8">
    <div class="max-w-6xl mx-auto">
        
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <a href="/dashboard" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-[26px] font-bold text-[#0f172a] leading-tight">Edit Content</h1>
                <p class="text-[13px] text-gray-500">Update details for "{{ $content->title }}"</p>
            </div>
        </div>

        {{-- Notice --}}
        <div class="bg-[#fffdf0] border border-[#f5ead3] rounded-[10px] p-4 mb-6 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-[#f6d078]"></div>
            <h4 class="text-[13px] font-bold text-[#8a5f00] mb-1 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-[#eaa400]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Status Update Notice
            </h4>
            <p class="text-[12px] text-[#8a5f00]/90 pl-5 leading-relaxed">Content will return to 'pending' status after saving changes. It will require moderation approval before becoming public again.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- FORM SECTION (Kiri) -->
            <div class="w-full lg:w-2/3 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                <form action="/contents/{{ $content->slug }}" method="POST" enctype="multipart/form-data" x-data="editForm()">
                @csrf
                @method('PUT')
                
                {{-- Title --}}
                <div class="mb-6">
                    <label class="block text-[13px] font-bold text-[#0f172a] mb-1.5 flex gap-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" x-model="title" maxlength="60" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-[#fafafa] text-[13.5px] transition-colors">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-[13px] font-bold text-[#0f172a] mb-1.5 flex gap-1">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-[#fafafa] text-[13.5px] appearance-none cursor-pointer transition-colors">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $content->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#0f172a] mb-1.5 flex gap-1">Regency <span class="text-red-500">*</span></label>
                        <select name="regency_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-[#fafafa] text-[13.5px] appearance-none cursor-pointer transition-colors">
                            @foreach($regencies as $regency)
                                <option value="{{ $regency->id }}" {{ $content->regency_id == $regency->id ? 'selected' : '' }}>{{ $regency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6 relative">
                    <div class="flex justify-between items-end mb-1.5">
                        <label class="block text-[13px] font-bold text-[#0f172a]">Detailed Description <span class="text-red-500">*</span></label>
                        <span class="text-[11px] text-gray-500 font-medium"><span x-text="description.length"></span>/1000</span>
                    </div>
                    <textarea name="description" x-model="description" maxlength="1000" rows="6" required
                              class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-[#fafafa] text-[13.5px] resize-none transition-colors"></textarea>
                </div>

                <hr class="border-gray-100 my-8">

                {{-- Location Details --}}
                <h2 class="text-lg font-bold text-[#0f172a] mb-5">Location Details</h2>
                
                <div class="mb-6">
                    <label class="block text-[13px] font-bold text-[#0f172a] mb-1.5">Full Address</label>
                    <input type="text" name="address" value="{{ $content->address }}"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-[#fafafa] text-[13.5px] transition-colors">
                </div>
                
                <div class="mb-6">
                    <label class="block text-[13px] font-bold text-[#0f172a] mb-1.5">Google Maps Link</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <input type="url" name="maps_url" value="{{ $content->maps_url }}"
                               class="w-full pl-9 pr-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-[#fafafa] text-[13.5px] transition-colors">
                    </div>
                </div>

                {{-- Jam Operasional --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-[13px] font-bold text-[#0f172a] mb-1.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#ed8a53]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Jam Buka
                        </label>
                        <input type="time" name="open_time" value="{{ $content->open_time ? \Carbon\Carbon::parse($content->open_time)->format('H:i') : '' }}"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-[#fafafa] text-[13.5px] transition-colors">
                        <p class="text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ada jam operasional</p>
                    </div>
                    <div>
                        <label class="block text-[13px] font-bold text-[#0f172a] mb-1.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#ed8a53]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Jam Tutup
                        </label>
                        <input type="time" name="close_time" value="{{ $content->close_time ? \Carbon\Carbon::parse($content->close_time)->format('H:i') : '' }}"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-[#ed8a53] focus:ring-2 focus:ring-[#ed8a53]/20 bg-[#fafafa] text-[13.5px] transition-colors">
                        <p class="text-[11px] text-gray-400 mt-1">Kosongkan jika tidak ada jam operasional</p>
                    </div>
                </div>

                <hr class="border-gray-100 my-8">

                {{-- Media --}}
                <h2 class="text-lg font-bold text-[#0f172a] mb-5">Media</h2>
                
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-[#0f172a] mb-2.5">Existing Photos</label>
                    <div class="flex flex-wrap gap-2.5">
                        {{-- Output exactly 5 blocks --}}
                        @for ($i = 0; $i < 5; $i++)
                            @if(isset($content->photos[$i]))
                                <div class="w-[85px] h-[85px] sm:w-[95px] sm:h-[95px] md:w-[105px] md:h-[105px] rounded-lg overflow-hidden border border-gray-200 relative">
                                    <img src="{{ $content->photos[$i]->resolved_url }}" class="w-full h-full object-cover">
                                    @if($i === 0)
                                    <div class="absolute top-1.5 left-1.5 bg-[#0f172a] text-white text-[7px] font-bold px-1.5 py-0.5 rounded-[4px] tracking-widest z-10">
                                        PRIMARY
                                    </div>
                                    @endif
                                </div>
                            @else
                                <div class="w-[85px] h-[85px] sm:w-[95px] sm:h-[95px] md:w-[105px] md:h-[105px] rounded-lg bg-[#efefef] border border-gray-200 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-[#b0b0b0]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block text-[11px] font-bold text-[#0f172a] mb-2.5">Replace Photos</label>
                    
                    <div class="relative w-full rounded-xl border border-dashed border-gray-300 bg-[#fafafa] hover:bg-gray-50 transition-colors py-7 border-[1.5px] flex flex-col items-center justify-center text-center cursor-pointer"
                         @dragover.prevent="$el.classList.add('border-gray-400', 'bg-gray-100')"
                         @dragleave.prevent="$el.classList.remove('border-gray-400', 'bg-gray-100')"
                         @drop.prevent="handleDrop($event, $el)"
                         @click="$refs.fileInput.click()"
                         x-show="previewUrls.length === 0">
                        
                        <div class="w-9 h-9 bg-[#efefef] rounded-full flex items-center justify-center mb-3">
                            <svg class="w-4 h-4 text-[#0f172a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <p class="text-[11.5px] font-bold text-[#0f172a]">Click to upload or drag and drop</p>
                        <p class="text-[11px] text-gray-500 mt-1 font-medium">Format JPG, PNG (Maks. 5MB per foto)<br>Dapat mengunggah hingga 5 foto. Foto pertama akan menjadi cover utama.</p>
                        <input type="file" name="photos[]" x-ref="fileInput" @change="handleFiles" multiple accept="image/jpeg, image/png, image/webp" class="hidden">
                    </div>

                    {{-- Preview Area for replacement photos --}}
                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-3 mt-3" x-show="previewUrls.length > 0">
                        <template x-for="(url, index) in previewUrls" :key="index">
                            <div class="relative group rounded-xl overflow-hidden aspect-square border border-gray-200 bg-gray-50">
                                <img :src="url" class="w-full h-full object-cover">
                                <button type="button" @click.stop="removePhoto(index)" class="absolute top-1.5 right-1.5 w-5 h-5 bg-white/90 rounded-full shadow-sm flex items-center justify-center text-red-500 hover:bg-white hover:text-red-600 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                <div x-show="index === 0" class="absolute top-1.5 left-1.5 bg-[#0f172a] text-white text-[7px] font-bold px-1.5 py-0.5 rounded-[4px] tracking-widest">
                                    PRIMARY
                                </div>
                            </div>
                        </template>
                    </div>

                    <p class="text-[10px] text-red-500 mt-2.5 flex items-center gap-1 font-medium">
                        <span class="text-xs">⚠️</span> Uploading new photos will replace ALL existing photos above.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3 mt-10 pt-5">
                    <a href="/dashboard" class="px-5 py-2.5 border border-gray-200 bg-white text-[13px] font-bold text-gray-700 hover:bg-gray-50 transition-colors rounded-xl">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-[#b24823] text-white text-[13px] font-bold hover:bg-[#8e381b] shadow-sm transition-colors rounded-xl">
                        Simpan Perubahan
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
    Alpine.data('editForm', () => ({
        title: {!! json_encode($content->title) !!},
        description: {!! json_encode($content->description) !!},
        files: [],
        previewUrls: [],
        
        handleFiles(event) {
            this.addFiles(event.target.files);
        },
        
        handleDrop(event, element) {
            element.classList.remove('border-gray-400', 'bg-gray-100');
            this.addFiles(event.dataTransfer.files);
        },

        addFiles(newFiles) {
            const filesArray = Array.from(newFiles);
            if (this.files.length + filesArray.length > 5) {
                alert('Maksimum 5 foto yang dapat diunggah.');
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
