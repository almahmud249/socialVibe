@extends('backend.layouts.master')
@section('title', __('growth_list'))
@section('content')
	<section class="oftions">
		<div class="container-fluid">
			<div class="row">
				@include('backend.admin.website.sidebar_component')
				<div class="col-xxl-9 col-lg-8 col-md-8">
					<h3 class="section-title">{{ __('edit_growth_list') }}</h3>
					<div class="default-tab-list default-tab-list-v2  bg-white redious-border p-20 p-sm-30">
						<form action="{{ route('growths.update',$growth->id) }}" method="POST" class="form" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="row gx-20 add-coupon">
								<input type="hidden" name="id" value="{{ $growth->id }}">
								<input type="hidden" value="{{ $lang }}" name="lang">
								<input type="hidden"
								       value="{{ @$growth_language->translation_null == 'not-found' ? '' : @$growth_language->id }}"
								       name="translate_id">
								<input type="hidden" class="is_modal" value="0"/>
								<div class="col-lg-12">
									<div class="mb-4">
										<label for="title" class="form-label">{{ __('title') }}</label>
										<input type="text" class="form-control rounded-2 ai_content_name" id="title"
										       name="title" value="{{ @$growth_language->title }}">
										<div class="nk-block-des text-danger">
											<p class="title_error error"></p>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-4">
										<label for="description" class="form-label">{{ __('description') }}</label>
										<textarea class="form-control" id="description"
										          name="description">{{ @$growth_language->description }}</textarea>
										<div class="nk-block-des text-danger">
											<p class="description_error error">{{ $errors->first('lang') }}</p>
										</div>
									</div>
								</div>
								<div class="d-flex gap-12 sandbox_mode_div">
									<input type="hidden" name="status" value="{{ $growth->status }}">
									<label class="form-label"
									       for="status">{{ __('status') }}</label>
									<div class="setting-check">
										<input type="checkbox" value="1" id="status"
										       class="sandbox_mode" {{ $growth->status == 1 ? 'checked' : '' }} >
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
@push('css_asset')
	<link rel="stylesheet" href="{{ static_asset('admin/css/dropzone.min.css') }}">
@endpush
@push('js_asset')
	<!--====== media.js ======-->

	<script src="{{ static_asset('admin/js/ai_writer.js') }}"></script>
@endpush
@push('js')

@endpush
