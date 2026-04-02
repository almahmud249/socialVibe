@extends('backend.layouts.master')
@section('title', __('template'))
@section('content')
	<div class="main-content-wrapper">
		<section class="oftions">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<h3 class="section-title">{{ __('edit_template') }}</h3>
						<form class="form" action="{{ route('client.template.update',$template->id) }}" method="post"
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
											       name="title" value="{{ old('title',$template->title) }}" placeholder="{{ __('title') }}">
											<div class="nk-block-des text-danger">
												<p class="title_error error"></p>
											</div>
										</div>
									</div>
									<div class="mb-4">
										<label for="platform" class="form-label">{{__('platform') }} <span
													class="text-danger">*</span></label>
										<select class="form-select rounded-0 mb-3 without_search"
										        aria-label=".form-select-lg example" id="platform" name="platform"
										        style="width: 100%">
											<option value="1" {{ old('platform', $template->platform) == 1 ? 'selected' : '' }}>{{ __('facebook') }}</option>
											<option value="2" {{ old('platform', $template->platform) == 2 ? 'selected' : '' }}>{{ __('instagram') }}</option>
											<option value="3" {{ old('platform', $template->platform) == 3 ? 'selected' : '' }}>{{ __('linkedin') }}</option>
											<option value="4" {{ old('platform', $template->platform) == 4 ? 'selected' : '' }}>{{ __('twitter') }}</option>
										</select>
										<div class="nk-block-des text-danger">
											<p class="platform_id_error error"></p>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="mb-4">
											<label for="description" class="form-label">{{ __('description') }} <span
														class="text-danger">*</span></label>
											<textarea class="form-control" style="min-height: 70px;" name="description"
											          placeholder="{{ __('description') }}"
											          id="description" >{{ old('description',$template->description) }}</textarea>
											<div class="nk-block-des text-danger">
												<p class="description_error error"></p>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div class="mb-4">
											<label for="prompt" class="form-label">{{ __('prompt') }} <span
														class="text-danger">*</span></label>
											<textarea class="form-control" name="prompt"
											          placeholder="{{ __('prompt') }}"
											          id="prompt">{{ old('prompt',$template->prompt) }}</textarea>
											<div class="nk-block-des text-danger">
												<p class="prompt_error error"></p>
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
