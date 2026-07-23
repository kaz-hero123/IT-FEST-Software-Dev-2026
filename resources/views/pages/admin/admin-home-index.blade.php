@extends('layouts.admin-layout')

@section('title', 'Admin Dashboard – Madura Smart Island')

@section('content')
<div class="px-4 sm:px-6 md:px-8 py-6 md:py-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-6 md:mb-7">
        <div>
            <h1 class="text-[22px] md:text-[26px] font-bold text-[#0f172a] tracking-tight">Dashboard Overview</h1>
            <p class="text-[12px] md:text-[13px] text-gray-400 font-medium mt-1">Platform statistics and recent moderation activity.</p>
        </div>
        <div class="shrink-0">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full border border-gray-200 bg-white text-[11px] font-semibold text-gray-500 shadow-sm">
                System Status: Optimal
            </span>
        </div>
    </div>

    @include('pages.admin.components.dashboard.admin-dashboard')
</div>
@endsection
