@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
    {{-- Dashboard --}}
    @include('pages.guest.guest-dashboard-section')

    {{-- Visi --}}
    @include('pages.guest.guest-visi-section')

    {{-- Popular --}}
    @include('pages.guest.guest-popular-section')

    {{-- Contributor --}}
    @include('pages.guest.guest-contributor-section')
@endsection

