@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
    {{-- Dashboard --}}
    @include('pages.user.home.components.user-home-hero')

    {{-- Visi --}}
    @include('pages.user.home.components.user-home-visi')

    {{-- Peta Interaktif Madura --}}
    @include('pages.user.home.components.user-home-map')

    {{-- Popular --}}
    @include('pages.user.home.components.user-home-popular')

    {{-- Contributor --}}
    @include('pages.user.home.components.user-home-contributor')
@endsection

