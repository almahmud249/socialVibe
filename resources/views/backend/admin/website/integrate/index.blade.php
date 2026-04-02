@extends('backend.layouts.master')
@section('title', __('integrate_section_content'))
@section('content')
	<section class="oftions">
		<div class="container-fluid">
			<div class="row">
				@include('backend.admin.website.sidebar_component')
				<div class="col-xxl-9 col-lg-8 col-md-8">
					<h3 class="section-title">{{ __('integrate_section_content') }}</h3>
					<div class="bg-white redious-border p-20 p-sm-30">
						<form action="{{ route('integrate.content.store') }}" method="POST" class="form"
						      enctype="multipart/form-data">@csrf
							<div class="row gx-20">
								<input type="hidden" value="0" class="is_modal" name="is_modal">
								<input type="hidden" name="site_lang" value="{{$lang}}">
								<div class="col-12 col-lg-12">
									<div class="mb-4">
										<label for="title" class="form-label">{{ __('title') }}</label>
										<input type="text" class="form-control rounded-2" id="title"
										       name="integrate_title" value="{{ setting('integrate_title',$lang) }}">
										<div class="nk-block-des text-danger">
											<p class="integrate_title_error error">{{ $errors->first('lang') }}</p>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-4">
										<label for="integrate_description"
										       class="form-label">{{ __('description') }}</label>
										<textarea class="form-control" id="integrate_description"
										          name="integrate_description">{{ setting('integrate_description', $lang) }}</textarea>
										<div class="nk-block-des text-danger">
											<p class="integrate_description_error error">{{ $errors->first('lang') }}</p>
										</div>
									</div>
								</div>
								<div class="col-3 col-lg-3">
									<div class="mb-4">
										<label for="integrate_action_btn_label"
										       class="form-label">{{ __('btn_label') }}</label>
										<input type="text" class="form-control rounded-2"
										       id="integrate_action_btn_label"
										       name="integrate_action_btn_label"
										       value="{{ setting('integrate_action_btn_label', $lang) }}">
										<div class="nk-block-des text-danger">
											<p class="integrate_action_btn_label_error error">{{ $errors->first('lang') }}</p>
										</div>
									</div>
								</div>
								<div class="col-9 col-lg-9">
									<div class="mb-4">
										<label for="integrate_action_btn_url"
										       class="form-label">{{ __('btn_url') }}</label>
										<input type="text" class="form-control rounded-2" id="integrate_action_btn_url"
										       name="integrate_action_btn_url"
										       value="{{ setting('integrate_action_btn_url') }}">
										<div class="nk-block-des text-danger">
											<p class="integrate_action_btn_url_error error">{{ $errors->first('lang') }}</p>
										</div>
									</div>
								</div>

								<div class="d-flex gap-12 sandbox_mode_div mt-4">
									<input type="hidden" name="integrate_section_enable"
									       value="{{ setting('integrate_section_enable') == 1 ? 1 : 0 }}">
									<label class="form-label"
									       for="integrate_section_enable">{{ __('enable') }}</label>
									<div class="setting-check">
										<input type="checkbox" value="1" id="integrate_section_enable"
										       class="sandbox_mode" {{ setting('integrate_section_enable') == 1 ? 'checked' : '' }}>
										<label for="integrate_section_enable"></label>
									</div>
								</div>

								<div class="d-flex justify-content-between align-items-center mt-30">
									<button type="submit" class="btn sg-btn-primary">{{ __('update') }}</button>
									@include('backend.common.loading-btn',['class' => 'btn sg-btn-primary'])
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-12 mt-5 col-md-8">
						<div class="header-top d-flex justify-content-between align-items-center">
							<h3 class="section-title">{{ __('integrate_list') }}</h3>
							@can('feature.create')
								<div class="oftions-content-right mb-12">
									<a href="#" data-bs-toggle="modal" data-bs-target="#integrate" class="d-flex align-items-center btn sg-btn-primary gap-2">
										<i class="las la-plus"></i>
										<span>{{__('add_new') }}</span>
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
	<div class="modal fade" id="integrate" tabindex="-1" aria-labelledby="content" aria-hidden="false">
		<div class="modal-dialog modal-dialog-centered modal-md">
			<div class="modal-content">
				<h6 class="sub-title create_sub_title">{{__('new_integrate') }}</h6>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
				@include('backend.admin.website.integrate.create')
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


