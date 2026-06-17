@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
    {{-- Dashboard --}}
    @include('pages.guest.guest-dashboard-section')

    {{-- Visi --}}
    @include('pages.guest.guest-visi-section')
@endsection

