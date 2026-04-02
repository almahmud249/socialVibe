@extends('backend.layouts.master')
@section('title', __('Social Accounts'))
@section('content')
    <section class="oftions">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-top d-flex justify-content-between align-items-center">
                        <h3 class="section-title">
                            @if($plat_form=='facebook')
                                {{ __('manage_facebook_profile') }}
                            @elseif($plat_form=='instagram')
                                {{ __('manage_instagram_profile') }}
                            @elseif($plat_form=='linkedin')
                                {{ __('manage_linkedin_profile') }}
                            @elseif($plat_form=='twitter')
                                {{ __('manage_twitter_profile') }}
                            @elseif($plat_form=='tiktok')
                                {{ __('manage_tiktok_profile') }}
                            @elseif($plat_form=='threads')
                                {{ __('manage_threads_profile') }}
                            @endif
                        </h3>
                        <div class="oftions-content-right mb-12">
                            <a href="{{ route('client.accounts.create', ['plat_form' => $plat_form]) }}"
                               class="d-flex align-items-center btn sg-btn-primary gap-2">
                                <i class="las la-plus"></i>
                                @if($plat_form=='facebook')
                                    <span>{{ __('connect_facebook') }}</span>
                                @elseif($plat_form=='instagram')
                                        <span>{{ __('connect_instagram') }}</span>
                                @elseif($plat_form=='linkedin')
                                    <span>{{ __('connect_linkedin') }}</span>
                                @elseif($plat_form=='twitter')
                                    <span>{{ __('connect_twitter') }}</span>
                                @elseif($plat_form=='tiktok')
                                    <span>{{ __('connect_tiktok') }}</span>
                                @elseif($plat_form=='threads')
                                    <span>{{ __('connect_threads') }}</span>
                                @endif
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