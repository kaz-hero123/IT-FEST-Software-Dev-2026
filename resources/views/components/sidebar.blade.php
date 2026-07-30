<aside id="sidebar"
       style="width:220px; min-width:220px;"
       class="fixed md:relative z-30 h-full bg-[#f7f8f9] border-r border-gray-200 flex flex-col justify-between shrink-0
              -translate-x-full md:translate-x-0">

    <div class="px-4 pt-7 pb-4">
        {{-- Close button (mobile only) --}}
        <button onclick="closeSidebar()" class="md:hidden absolute top-4 right-4 p-1.5 rounded-lg text-gray-400 hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Profile --}}
        <div class="flex flex-col items-center text-center mb-8">
            <div class="w-[62px] h-[62px] rounded-full overflow-hidden border-2 border-white shadow mb-2.5">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop"
                     alt="Admin" class="w-full h-full object-cover">
            </div>
            <p class="text-[14px] font-bold text-[#0f172a] leading-tight">{{ Auth::user()->name }}</p>
            <p class="text-[11px] text-gray-400 font-medium mt-0.5">{{ Auth::user()->email }}</p>
        </div>

        {{-- Navigation --}}
        <nav class="space-y-1">
            <a href="/admin/dashboard"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-bold transition-colors
                      {{ request()->is('admin/dashboard') ? 'bg-[#b84c22] text-white' : 'text-[#374151] hover:bg-gray-200/60' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            <a href="/admin/moderation"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-bold transition-colors
                      {{ request()->is('admin/moderation*') ? 'bg-[#b84c22] text-white' : 'text-[#374151] hover:bg-gray-200/60' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
                Moderation
            </a>

            <a href="/admin/contents"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-bold transition-colors
                      {{ request()->is('admin/contents*') ? 'bg-[#b84c22] text-white' : 'text-[#374151] hover:bg-gray-200/60' }}">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Published
            </a>

            {{-- Removed Settings link as per request
            <a href="#"
               class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-bold text-[#374151] hover:bg-gray-200/60 transition-colors">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>
            --}}
        </nav>
    </div>

    {{-- Bottom --}}
    <div class="px-4 pb-7 space-y-2">
        <a href="/contents/create"
           class="flex items-center justify-center w-full py-2.5 bg-[#0a1512] hover:bg-black text-white text-[12.5px] font-bold rounded-xl transition-colors">
            Add Content
        </a>
        <form method="POST" action="/admin/logout">
            @csrf
            <button type="submit"
                    class="flex items-center gap-2 w-full px-1 py-2 text-[13px] font-bold text-[#374151] hover:text-[#0f172a] transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
