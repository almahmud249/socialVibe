@extends('backend.layouts.master')
@section('title', __('our_client'))
@section('content')
    <section class="oftions">
        <div class="container-fluid">
            <div class="row">
                @include('backend.admin.website.sidebar_component')
                <div class="col-xxl-9 col-lg-8 col-md-8">
                    <h3 class="section-title">{{ __('edit_customer') }}</h3>
                    <div class="default-tab-list default-tab-list-v2  bg-white redious-border p-20 p-sm-30">
                        <form action="{{ route('integrate.update',$integrate->id) }}" method="post" class="form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row gx-20 add-coupon">
                                <input type="hidden" name="id" value="{{ $integrate->id }}">
                                <input type="hidden" value="{{ $lang }}" name="lang">
                                <input type="hidden"
                                       value="{{ @$integrate_language->translation_null == 'not-found' ? '' : @$integrate_language->id }}"
                                       name="translate_id">
                                <input type="hidden" class="is_modal" value="0"/>
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label for="title" class="form-label">{{ __('title') }}</label>
                                        <input type="text" class="form-control rounded-2 ai_content_name" id="title"
                                               name="title" value="{{ $integrate_language->title }}">
                                        <div class="nk-block-des text-danger">
                                            <p class="title_error error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 input_file_div mb-4">
                                    <div class="mb-3">
                                        <label class="form-label mb-1">{{__('image') }}</label>
                                        <label for="image" class="file-upload-text">
                                            <p></p>
                                            <span class="file-btn">{{__('choose_file') }}</span>
                                        </label>
                                        <input class="d-none file_picker" type="file" id="image"
                                               name="image" accept=".jpg,.png">
                                        <div class="nk-block-des text-danger">
                                            <p class="image_error error">{{ $errors->first('image') }}</p>
                                        </div>
                                    </div>
                                    <div class="selected-files d-flex flex-wrap gap-20">
                                        <div class="selected-files-item">
                                            <img class="selected-img" src="{{ getFileLink('original_image', $integrate->image) }}"
                                                 alt="favicon">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-12 sandbox_mode_div">
                                    <input type="hidden" name="status" value="{{ $integrate->status }}">
                                    <label class="form-label"
                                           for="status">{{ __('status') }}</label>
                                    <div class="setting-check">
                                        <input type="checkbox" value="1" id="status"
                                               class="sandbox_mode" {{ $integrate->status == 1 ? 'checked' : '' }} >
                                        <label for="status"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center mt-30">
                                <button type="submit" class="btn sg-btn-primary">{{__('submit') }}</button>
                                @include('backend.common.loading-btn',['class' => 'btn sg-btn-primary'])
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('backend.admin.website.component.new_menu')
    @include('backend.common.gallery-modal')
@endsection
