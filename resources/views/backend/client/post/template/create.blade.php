<form action="{{route('client.post.template.store')}}" method="post" class="form" enctype="multipart/form-data">
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
		<div class="col-lg-12">
			<div class="mb-4">
				<label for="sort_description" class="form-label">{{ __('sort_description') }} <span
							class="text-danger">*</span></label>
				<textarea class="form-control" style="min-height: 70px;" name="sort_description"
				          placeholder="{{ __('description') }}"
				          id="sort_description"></textarea>
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
				          placeholder="{{ __('enter_your_content') }}"
				          id="post_content"></textarea>
				<div class="nk-block-des text-danger">
					<p class="post_content_error error"></p>
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-end align-items-center mt-30">
			<button type="submit" class="btn sg-btn-primary">{{ __('submit') }}</button>
			@include('backend.common.loading-btn',['class' => 'btn sg-btn-primary'])
		</div>
	</div>
</form>