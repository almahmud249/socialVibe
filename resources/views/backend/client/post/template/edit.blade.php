@extends('backend.layouts.master')
@section('title', __('edit_post_template'))
@section('content')
    <div class="main-content-wrapper">
        <section class="oftions">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h3 class="section-title">{{ __('edit_post_template') }}</h3>
                        <form class="form" action="{{ route('client.post.template.update',$postTemplate->id) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="bg-white redious-border p-20 p-sm-30">
                                <div class="row gx-20 add-coupon">
                                    <input type="hidden" class="is_modal" value="0"/>
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <label for="title"
                                                   class="form-label">{{__('title') }} <span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control rounded-2" id="title"
                                                   name="title" value="{{ old('title',$postTemplate->title) }}" placeholder="{{ __('title') }}">
                                            <div class="nk-block-des text-danger">
                                                <p class="title_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <label for="sort_description" class="form-label">{{ __('sort_description') }} <span
                                                        class="text-danger">*</span></label>
                                            <textarea class="form-control" style="min-height: 70px;" name="sort_description"
                                                      placeholder="{{ __('description') }}"
                                                      id="sort_description" >{{ old('description',$postTemplate->sort_description) }}</textarea>
                                            <div class="nk-block-des text-danger">
                                                <p class="sort_description_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <label for="post_content" class="form-label">{{ __('post_content') }} <span
                                                        class="text-danger">*</span></label>
                                            <textarea class="form-control" name="post_content"
                                                      placeholder="{{ __('prompt') }}"
                                                      id="post_content">{{ old('prompt',$postTemplate->post_content) }}</textarea>
                                            <div class="nk-block-des text-danger">
                                                <p class="post_content_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center mt-30">
                                        <button type="submit" class="btn sg-btn-primary">{{ __('update') }}</button>
                                        @include('backend.common.loading-btn', [
											'class' => 'btn sg-btn-primary',
										])
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
