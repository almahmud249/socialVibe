<form action="{{ route('client.template.store') }}" method="post" class="form" enctype="multipart/form-data">
	@csrf
	@method('post')
	<div class="row gx-20">
		<div class="col-lg-12">
			<div class="mb-4">
				<label for="title"
				       class="form-label">{{__('title') }} <span
							class="text-danger">*</span></label>
				<input type="text" class="form-control rounded-2" id="title"
				       name="title" placeholder="{{ __('title') }}">
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
				@if(setting('is_facebook_activated'))
					<option value="1">{{__('facebook')}}</option>
				@endif
				@if(setting('is_instagram_activated'))
					<option value="2">{{__('instagram')}}</option>
				@endif
				@if(setting('is_linkedin_activated'))
					<option value="3">{{__('linkedin')}}</option>
				@endif
				@if(setting('is_x_activated'))
					<option value="4">{{__('twitter')}}</option>
				@endif
				@if(setting('is_threads_activated'))
					<option value="5">{{__('threads')}}</option>
				@endif
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
				          id="description"></textarea>
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
				          id="prompt"></textarea>
				<div class="nk-block-des text-danger">
					<p class="prompt_error error"></p>
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-end align-items-center mt-30">
			<button type="submit" class="btn sg-btn-primary">{{ __('submit') }}</button>
			@include('backend.common.loading-btn',['class' => 'btn sg-btn-primary'])
		</div>
	</div>
</form>