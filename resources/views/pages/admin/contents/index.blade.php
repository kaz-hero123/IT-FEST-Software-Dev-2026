@extends('layouts.admin-layout')

@section('title', 'Content Management – Admin')

@section('content')
<div class="px-4 sm:px-6 md:px-8 py-6 md:py-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-[22px] md:text-[26px] font-bold text-[#0f172a] tracking-tight">Content Management</h1>
            <p class="text-[12px] md:text-[13px] text-gray-400 font-medium mt-1">
                Manage all approved and published content on the platform.
            </p>
        </div>

        {{-- Search --}}
        <form method="GET" action="/admin/contents" class="flex items-center gap-2 w-full sm:w-auto shrink-0">
            <div class="relative flex-1 sm:flex-none">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search content..."
                       class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 bg-white text-[13px] font-medium text-[#0f172a] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:w-44 md:w-56">
            </div>
            <button type="submit" class="flex items-center gap-1.5 px-4 py-2 rounded-xl border border-gray-200 bg-white text-[13px] font-bold text-[#374151] hover:bg-gray-50 transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Search
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl p-3 flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Content Table --}}
    @if($contents->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-5 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Content</th>
                        <th class="px-5 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden md:table-cell">Category</th>
                        <th class="px-5 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden md:table-cell">Regency</th>
                        <th class="px-5 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden lg:table-cell">Contributor</th>
                        <th class="px-5 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-5 py-3.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($contents as $content)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        {{-- Content --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                    @if($content->photos->count() > 0)
                                        <img src="{{ $content->photos->first()->resolved_url }}"
                                             alt="{{ $content->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[13px] font-bold text-[#0f172a] truncate max-w-[200px]">{{ $content->title }}</p>
                                    <p class="text-[11px] text-gray-400 font-medium">{{ $content->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="px-5 py-4 hidden md:table-cell">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                {{ $content->category->name ?? '-' }}
                            </span>
                        </td>

                        {{-- Regency --}}
                        <td class="px-5 py-4 hidden md:table-cell">
                            <span class="text-[12.5px] font-medium text-gray-600">{{ $content->regency->name ?? '-' }}</span>
                        </td>

                        {{-- Contributor --}}
                        <td class="px-5 py-4 hidden lg:table-cell">
                            <span class="text-[12.5px] font-medium text-gray-600">{{ $content->user->name ?? '-' }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-green-50 text-green-600 border border-green-100">
                                Published
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form x-data id="unpublish-form-{{ $content->id }}" method="POST" action="/admin/contents/{{ $content->slug }}/unpublish">
                                    @csrf
                                    <input type="hidden" name="note" value="Unpublished by admin from content management.">
                                    <button type="button"
                                            @click="$dispatch('confirm-action', {
                                                title: 'Unpublish Konten',
                                                message: 'Konten ini akan ditarik dari halaman publik dan dikembalikan ke status Pending.',
                                                confirmText: 'Ya, Unpublish',
                                                formId: 'unpublish-form-{{ $content->id }}',
                                                type: 'warning'
                                            })"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[11px] font-bold text-amber-600 bg-amber-50 border border-amber-100 hover:bg-amber-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                        Unpublish
                                    </button>
                                </form>
                                <form x-data id="delete-form-{{ $content->id }}" method="POST" action="/admin/contents/{{ $content->slug }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            @click="$dispatch('confirm-action', {
                                                title: 'Hapus Permanen',
                                                message: 'Konten ini akan dihapus secara permanen dari sistem.',
                                                confirmText: 'Ya, Hapus',
                                                formId: 'delete-form-{{ $content->id }}',
                                                type: 'danger'
                                            })"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-[11px] font-bold text-red-600 bg-red-50 border border-red-100 hover:bg-red-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($contents->hasPages())
    <div class="mt-6">
        {{ $contents->links() }}
    </div>
    @endif

    @else
    <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
        <svg class="w-12 h-12 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-[14px] font-bold text-gray-400 mb-1">No published content yet</h3>
        <p class="text-[12px] text-gray-400">Approved content will appear here.</p>
    </div>
    @endif

</div>
@endsection
