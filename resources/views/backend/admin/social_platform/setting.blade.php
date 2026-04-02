@extends('backend.layouts.master')
@section('title', __('social-platform_setting'))
@section('content')
    <section class="oftions">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="section-title">{{ __('social_platforms') }}</h3>
                    <div class="bg-white redious-border p-20 p-sm-30 pt-sm-30">
                        <div class="row align-items-center g-20">
                            @include('backend.admin.social_platform.facebook')
                            @include('backend.admin.social_platform.instagram')
                            @include('backend.admin.social_platform.linkedin')
                            @include('backend.admin.social_platform.x')
                            @include('backend.admin.social_platform.threads')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
