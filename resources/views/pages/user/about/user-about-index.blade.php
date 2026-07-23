@extends('layouts.layout')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
    @include('pages.user.about.components.user-about-hero')
    @include('pages.user.about.components.user-about-misi')
    @include('pages.user.about.components.user-about-how-it-works')
    @include('pages.user.about.components.user-about-values')
@endsection