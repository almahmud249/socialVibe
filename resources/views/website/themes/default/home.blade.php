@extends('website.themes.' . active_theme() . '.master')
@section('content')
    @push('css')
    @endpush
    @include('website.themes.' . active_theme() . '.sections.hero')
    @include('website.themes.' . active_theme() . '.sections.client_area')
    @include('website.themes.' . active_theme() . '.sections.feature')
    @include('website.themes.' . active_theme() . '.sections.growth')
    @include('website.themes.' . active_theme() . '.sections.integrate')
    @include('website.themes.' . active_theme() . '.sections.pricing')
    @include('website.themes.' . active_theme() . '.sections.testimonial')
    @include('website.themes.' . active_theme() . '.sections.faq')
    @include('website.themes.' . active_theme() . '.sections.cta')
    @include('website.themes.' . active_theme() . '.sections.blog')
    @push('js')
    @endpush
@endsection
