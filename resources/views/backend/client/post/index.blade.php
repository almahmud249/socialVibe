@extends('backend.layouts.master')
@section('title', __('Posts'))
@section('content')
    <section class="oftions">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-top d-flex justify-content-between align-items-center">
                        <h3 class="section-title">
                            {{ menuActivation(['client/posts/index'], __('all_post')) }}
                            {{ menuActivation(['client/posts/draft'], __('draft_post')) }}
                            {{ menuActivation(['client/posts/schedule'], __('scheduled_post')) }}
                            {{ menuActivation(['client/posts/published'], __('published_post')) }}
                        </h3>
                        <div class="oftions-content-right mb-12">
                            <a href="{{ route('client.posts.create') }}"
                               class="d-flex align-items-center btn sg-btn-primary gap-2">
                                <i class="las la-plus"></i>
                                <span>{{ __('Create Post') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="bg-white redious-border p-20 p-sm-30 pt-sm-30">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="default-list-table table-responsive yajra-dataTable">
                                    {{ $dataTable->table() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('backend.common.delete-script')
@endsection
@push('js')
    {{ $dataTable->scripts() }}
@endpush