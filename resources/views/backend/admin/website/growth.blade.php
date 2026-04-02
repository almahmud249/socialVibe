@extends('backend.layouts.master')
@section('title', __('hero_section_content'))
@section('content')
    <section class="oftions">
        <div class="container-fluid">
            <div class="row">
                @include('backend.admin.website.sidebar_component')
                <div class="col-xxl-9 col-lg-8 col-md-8">
                    <h3 class="section-title">{{ __('growth_section_content') }}</h3>

                    <div class="bg-white redious-border p-20 p-sm-30">
                        <form action="{{ route('admin.growth.section') }}" method="POST" class="form" enctype="multipart/form-data">@csrf
                            <div class="row gx-20">
                                <input type="hidden" value="0" class="is_modal" name="is_modal">
                                <input type="hidden" name="site_lang" value="{{$lang}}">

                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label for="growth_description" class="form-label">{{ __('description') }}</label>
                                        <textarea class="form-control" id="growth_description"
                                                  name="growth_description">{{ setting('growth_description', $lang) }}</textarea>
                                        <div class="nk-block-des text-danger">
                                            <p class="growth_description_error error">{{ $errors->first('lang') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label for="growth_action_url" class="form-label">{{ __('video_url') }}</label>
                                        <input type="url" class="form-control rounded-2" id="growth_action_url"
                                                name="growth_action_url" value="{{ setting('growth_action_url') }}">
                                        <div class="nk-block-des text-danger">
                                            <p class="growth_action_url_error error">{{ $errors->first('lang') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 input_file_div mb-3">
                                    <div class="mb-3">
                                        <label for="image1" class="form-label mb-1">{{ __('thumbnail') }}</label>
                                        <label for="image1" class="file-upload-text">
                                            <p>0 {{ __('choose_file') }}</p>
                                            <span class="file-btn">{{ __('choose_file') }}</span>
                                        </label>
                                        <input class="d-none file_picker" type="file" name="growth_section_thumbnail" id="image1" accept=".jpg,.png">
                                        <div class="nk-block-des text-danger">
                                            <p class="growth_section_thumbnail_error error">{{ $errors->first('growth_section_thumbnail') }}</p>
                                        </div>
                                    </div>
                                    <div class="selected-files d-flex flex-wrap gap-20">
                                        <div class="selected-files-item">
                                            <img class="selected-img" src="{{  getFileLink('80x80',setting('growth_section_thumbnail')) }}" alt="favicon">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-12 sandbox_mode_div mb-4">
                                    <input type="hidden" name="growth_section_enable" value="{{ setting('growth_section_enable') == 1 ? 1 : 0 }}">
                                    <label class="form-label"
                                           for="growth_section_enable">{{ __('enable') }}</label>
                                    <div class="setting-check">
                                        <input type="checkbox" value="1" id="growth_section_enable"
                                               class="sandbox_mode" {{ setting('growth_section_enable') == 1 ? 'checked' : '' }}>
                                        <label for="growth_section_enable"></label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start align-items-center mt-30">
                                    <button type="submit" class="btn sg-btn-primary">{{ __('update') }}</button>
                                    @include('backend.common.loading-btn',['class' => 'btn sg-btn-primary'])
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-12 mt-5 col-md-8">
                        <div class="header-top d-flex justify-content-between align-items-center">
                            <h3 class="section-title">{{ __('growth_list') }}</h3>
                            @can('feature.create')
                                <div class="oftions-content-right mb-12">
                                    <a href="{{ route('growths.store') }}" data-bs-toggle="modal" data-bs-target="#growth_list" class="d-flex align-items-center btn sg-btn-primary gap-2">
                                        <i class="las la-plus"></i>
                                        <span>{{__('add_growth_list') }}</span>
                                    </a>
                                </div>
                            @endcan
                        </div>
                        <div class="default-tab-list default-tab-list-v2  bg-white redious-border p-20 p-sm-30">
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
        </div>
    </section>
    <div class="modal fade" id="growth_list" tabindex="-1" aria-labelledby="content" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <h6 class="sub-title create_sub_title">{{__('add_growth_list') }}</h6>
                <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @include('backend.admin.website.growth_list.create')
            </div>
        </div>
    </div>
    @include('backend.common.gallery-modal')
    @include('backend.common.delete-script')
@endsection
@push('js')
    {{ $dataTable->scripts() }}
@endpush
@push('css_asset')
    <link rel="stylesheet" href="{{ static_asset('admin/css/dropzone.min.css') }}">
@endpush


