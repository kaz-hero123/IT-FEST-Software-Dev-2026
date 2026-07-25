@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
    {{-- Dashboard --}}
    @include('pages.user.home.components.user-home-hero')

    {{-- Visi --}}
    @include('pages.user.home.components.user-home-visi')

    {{-- Popular --}}
    @include('pages.user.home.components.user-home-popular')

    {{-- Smart Island Impact Dashboard --}}
    @include('pages.user.home.components.user-home-impact')

    {{-- Contributor --}}
    @include('pages.user.home.components.user-home-contributor')
@endsection

