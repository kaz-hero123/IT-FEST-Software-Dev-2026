@props(['question'])

<div x-data="{ open: false }" class="border border-gray-200 rounded-2xl bg-white overflow-hidden hover:border-[#d35a39]/40 hover:shadow-md transition-all duration-300">
    <button @click="open = !open" class="flex justify-between items-center w-full px-6 py-5 text-left font-semibold text-gray-800 text-[15px] md:text-base focus:outline-none bg-white">
        <span x-bind:class="open ? 'text-[#d35a39]' : 'text-gray-800'" class="transition-colors pr-4">{{ $question }}</span>
        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center shrink-0 transition-colors duration-300" x-bind:class="open ? 'bg-[#f8ede8]' : ''">
            <x-lucide-chevron-down class="w-5 h-5 text-gray-500 transition-transform duration-300" x-bind:class="open ? 'rotate-180 text-[#d35a39]' : ''" />
        </div>
    </button>
    <div x-show="open" x-collapse x-cloak>
        <div class="px-6 pb-6 text-[14px] md:text-[15px] text-gray-600 leading-wider bg-white">
            {{ $slot }}
        </div>
    </div>
</div>
