@extends('backend.layouts.master')
@section('title', __('post'))
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-8">
				<div class="header-top d-flex justify-content-between align-items-center">
					<h3 class="section-title">{{ __('create_post') }}</h3>
				</div>
				<div class="default-tab-list table-responsive default-tab-list-v2 activeItem-bd-md bg-white redious-border p-20 p-sm-30">
					<div class="default-list-table">
						<form class="form" action="{{ route('client.posts.store') }}" method="POST"
						      enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-lg-12 ">
									<div class="mb-4">
										<label for="title" class="form-label">{{ __('title') }}</label>
										<input type="text" class="form-control rounded-2" id="title"
										       name="title" value="{{ old('title') }}"
										       placeholder="{{ __('enter_title') }}">
										<div class="nk-block-des text-danger">
											<p class="title_error error">{{ $errors->first('title') }}</p>
										</div>
									</div>
								</div>
								<div class="col-lg-12 mb-4">
									<label for="profile" class="form-label">{{ __('profile') }}
										<span class="text-danger">*</span>
									</label>
									<select class="checkbox__select form-select rounded-0 mb-3 with_search "
									        aria-label=".form-select-lg example" id="profile" name="profile_id[]"
									        style="width: 100%" multiple>
									</select>
									<div class="nk-block-des text-danger">
										<p class="client_id_error error"></p>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-4">
										<div class="d-flex align-items-center justify-content-between mb-2 flex-wrap">
											<label for="description" class="form-label">{{ __('compose_your_post') }}
											</label>
											<div class="d-flex align-items-center gap-2 create__dropdown flex-wrap">
												<label for="post_template">{{__('post_template')}}:</label>
												<select class="form-select rounded-0 mb-3 with_search "
												        aria-label=".form-select-lg example" id="post_template"
												        name="post_template"
												        style="width: 100%">
													<option value="#">{{__('select_template')}}</option>
													@foreach($post_templates as $post_template )
														<option value="{{ $post_template->id }}"
														        data-content="{{ $post_template->post_content }}">{{ $post_template->title }}</option>
													@endforeach
												</select>
												<a href="#" class="btn sg-btn-primary" data-bs-toggle="modal"
												   data-bs-target="#aiModal">{{ __('ai_assistant') }}
												</a>
											</div>
										</div>
										<textarea class="form-control" name="description"
										          placeholder="{{ __('description') }}"
										          id="description"></textarea>
										<div class="nk-block-des text-danger">
											<p class="description_error error"></p>
										</div>
									</div>
								</div>
								<div class="col-12 col-lg-12 col-md-8 mb-4 ">
									<div class="post__wrap ">
										<label for="when_post" class="form-label">{{__('when_to_post')}}</label>
										<select class="form-select rounded-0 mb-3 with_search"
										        aria-label=".form-select-lg example" id="when_post" name="when_post"
										        style="width: 100%">
											<option value="1">{{__('immediately')}}</option>
											<option value="2">{{__('schedule_&_repost')}}</option>
											<option value="3">{{__('specific_days_&_times')}}</option>
											<option value="4">{{__('draft')}}</option>
										</select>

										<div class="post__by" data-option="2">
											<div class="card-body border rounded-2 mt-2 p-20">
												<div class="row ">
													<div class="col-sm-6 mb-3">
														<label for="time_post" class="mb-2">Time post</label>
														<input type="text" class="datepicker form-control rounded-2"
														       name="time_post" id="time_post"
														       placeholder="Select Date & Time">

														<!-- <input type="datetime-local" class="form-control rounded-2" name="time_post" id="time_post" placeholder="e.g.40" value=""> -->
													</div>
													<div class="col-sm-6 mb-3">
														<label for="interval_per_post" class="mb-2">Interval per post
															(minute)</label>
														<input type="number" class="form-control" autocomplete="off"
														       id="interval_per_post" name="interval_per_post"
														       value="5">
													</div>
													<div class="col-sm-6 mb-3">
														<label for="repost_frequency" class="mb-2">Repost frequency
															(day)</label>
														<select class="form-select rounded-0 mb-3 with_search"
														        aria-label=".form-select-lg example"
														        id="repost_frequency" name="repost_frequency"
														        style="width: 100%">

															<option value="0">Disable</option>
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>
															<option value="6">6</option>
															<option value="7">7</option>
															<option value="8">8</option>
															<option value="9">9</option>
															<option value="10">10</option>
															<option value="11">11</option>
															<option value="12">12</option>
															<option value="13">13</option>
															<option value="14">14</option>
															<option value="15">15</option>
															<option value="16">16</option>
															<option value="17">17</option>
															<option value="18">18</option>
															<option value="19">19</option>
															<option value="20">20</option>
															<option value="21">21</option>
															<option value="22">22</option>
															<option value="23">23</option>
															<option value="24">24</option>
															<option value="25">25</option>
															<option value="26">26</option>
															<option value="27">27</option>
															<option value="28">28</option>
															<option value="29">29</option>
															<option value="30">30</option>
															<option value="31">31</option>
															<option value="32">32</option>
															<option value="33">33</option>
															<option value="34">34</option>
															<option value="35">35</option>
															<option value="36">36</option>
															<option value="37">37</option>
															<option value="38">38</option>
															<option value="39">39</option>
															<option value="40">40</option>
															<option value="41">41</option>
															<option value="42">42</option>
															<option value="43">43</option>
															<option value="44">44</option>
															<option value="45">45</option>
															<option value="46">46</option>
															<option value="47">47</option>
															<option value="48">48</option>
															<option value="49">49</option>
															<option value="50">50</option>
															<option value="51">51</option>
															<option value="52">52</option>
															<option value="53">53</option>
															<option value="54">54</option>
															<option value="55">55</option>
															<option value="56">56</option>
															<option value="57">57</option>
															<option value="58">58</option>
															<option value="59">59</option>
															<option value="60">60</option>
														</select>
													</div>
													<div class="col-sm-6 mb-3">
														<label for="repost_until" class="mb-2">Repost until</label>
														<input type="text" class="datepicker form-control rounded-2"
														       name="repost_until" id="repost_until"
														       placeholder="Select Date">
													</div>
												</div>
											</div>
										</div>
										<!-- ================== -->
										<div class="post__by" data-option="3">
											<div class="card-body border rounded-2 mt-2 p-20 pb-2">
												<div class="items__container ">
													<div class="dateItem my-1">
														<input type="text" class="datepicker form-control rounded-0"
														       name="day_time_post[]" id="day_time_post"
														       placeholder="Select Date & Time">
														<!-- <input type="datetime-local" class="form-control rounded-0" name="time_posts" id="time_posts" placeholder="e.g.40" value=""> -->
														<button type="button" class="btn delete_btn"><i
																	class="las la-trash-alt"></i></button>
													</div>
												</div>
												<div class="card-footer border-top mt-3">
													<a href="javascript:void(0);" class="btn add_btn">
														<i class="las la-plus"></i> {{__('add_more_scheduled_times')}}
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12 ">
									<div class="mb-4">
										<label for="link" class="form-label">{{ __('link') }}</label>
										<input type="text" class="form-control rounded-2" id="link"
										       name="link" value="{{ old('link') }}"
										       placeholder="{{ __('enter_link') }}">
										<div class="nk-block-des text-danger">
											<p class="link_error error">{{ $errors->first('link') }}</p>
										</div>
									</div>
								</div>

								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label mb-1">{{ __('Image/Video') }}</label>
										<label for="images" class="file-upload-text">
											<p></p>
											<span class="file-btn">{{ __('choose_file') }}</span>
										</label>
										<input class="d-none file_picker" type="file" id="images"
										       name="images[]" multiple>
										<div class="nk-block-des text-danger">
											<p class="image_error error">{{ $errors->first('images') }}</p>
										</div>
									</div>
									<div class="selected-files d-flex flex-wrap gap-20" id="description_image_modal">

									</div>
								</div>
							</div> <!-- End row -->

							<!-- End Package Status -->
							<div class="d-flex justify-content-end align-items-center mt-30">
								<button type="submit" class="btn sg-btn-primary">{{ __('save') }}</button>
								@include('backend.common.loading-btn', [
									'class' => 'btn sg-btn-primary',
								])
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="header-top d-flex justify-content-between align-items-center">
					<h3 class="section-title">{{ __('post_preview') }}</h3>
				</div>
				<div class=" custom__tab col-md-12 default-tab-list default-tab-list-v2 activeItem-bd-md bg-white redious-border p-20 p-sm-30">
					<nav>
						<div class="nav nav-tabs justify-content-between mb-4" id="nav-tab" role="tablist">
							<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
							        data-bs-target="#facebook" type="button" role="tab"
							        aria-controls="nav-home" aria-selected="true">
								{{ __('facebook') }}</button>
							<button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
							        data-bs-target="#linkedIn" type="button" role="tab"
							        aria-controls="nav-contact" aria-selected="false">
								{{ __('linkedIn') }}</button>
							<button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
							        data-bs-target="#instagram" type="button" role="tab"
							        aria-controls="nav-contact" aria-selected="false">
								{{ __('instagram') }}</button>
							<button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
							        data-bs-target="#twitter" type="button" role="tab"
							        aria-controls="nav-contact" aria-selected="false">
								{{ __('twitter') }}</button>
						</div>
					</nav>
					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="facebook" role="tabpanel"
						     aria-labelledby="nav-home-tab">
							<div class="social-post">
								<div class="social-header">
									<span class="text-primary">{{ __('facebook') }}</span> - <strong>John Doe</strong>
									shared a post
								</div>
								<div class="content">
									<p class="mb-3">..........</p>
									<div class="image-previews"></div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="linkedIn" role="tabpanel" aria-labelledby="nav-contact-tab">
							<div class="social-post">
								<div class="social-header">
									<span class="text-primary">{{ __('linkedIn') }}</span> - <strong>John Doe</strong>
									shared a post
								</div>
								<div class="content">
									<p class="mb-3">.........</p>
									<div class="image-previews"></div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="instagram" role="tabpanel" aria-labelledby="nav-contact-tab">
							<div class="social-post">
								<div class="social-header">
									<span class="text-primary">{{ __('instagram') }}</span> - <strong>John Doe</strong>
									shared a post
								</div>
								<div class="content">
									<p class="mb-3">.........</p>
									<div class="image-previews"></div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="twitter" role="tabpanel" aria-labelledby="nav-contact-tab">
							<div class="social-post">
								<div class="social-header">
									<span class="text-primary">{{ __('twitter') }}</span> - <strong>John Doe</strong>
									shared a post
								</div>
								<div class="content">
									<p class="mb-3">..........</p>
									<div class="image-previews"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('backend.common.delete-script')
	@include('backend.common.change-status-script')
	@include('backend.client.post.ai_modal')
@endsection
@push('js')
	<script>
        // AI Content value
        let default_language = "{{ Auth::user()->client->default_language }}";
        let default_length = "{{ Auth::user()->client->default_length }}";
        let default_tone = "{{ Auth::user()->client->default_tone }}";
        let default_level = "{{ Auth::user()->client->default_level }}";
	</script>
	<script src="{{ static_asset('admin/js/custom/client_ai_writer.js') }}"></script>
	<script>
        $(document).ready(function () {
            $("#post_template").on("change", function () {
                let content = $(this).find(":selected").data("content") || "";
                $("#description").val(content);
            });
        });

        $(document).ready(function () {
            $("input[name='ai_template']").on("change", function () {
                let selectedPrompt = $(this).data("prompt");
                $("#primary_keyword").val(selectedPrompt);
            });
        });


        $(document).ready(function () {
            // For selecting post template content
            $("#post_template").on("change", function () {
                let content = $(this).find(":selected").data("content") || "";
                $("#description").val(content);
            });

            // For selecting Generate AI Content
            $("input[name='social']").on("change", function () {
                let id = $(this).attr('id');
                let selector = $('.contentIdea__inner');
                selector.find('.facebook').addClass('d-none');
                selector.find('.instagram').addClass('d-none');
                selector.find('.twitter').addClass('d-none');
                selector.find('.linkedin').addClass('d-none');
                selector.find('.' + id).removeClass('d-none');
            });
        });
        $(document).ready(function () {
            $(document).on('change', '#images', function () {

                let input = this;

                if (input.files) {
                    $('#description_image_modal').empty();
                    var filesAmount = input.files.length;

                    for (let i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function (event) {
                            $($.parseHTML(`<div class="selected-files-item"><img class="selected-img" src="${event.target.result}"></div>`))
                                .appendTo('#description_image_modal');
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }
            })
        })
        document.addEventListener("DOMContentLoaded", function () {
            const descriptionField = document.getElementById('description');
            const imageField = document.getElementById('images');

            // Select the preview elements for each social media tab
            const previewContainers = {
                facebook: document.querySelector('#facebook .content .image-previews'),
                twitter: document.querySelector('#twitter .content .image-previews'),
                instagram: document.querySelector('#instagram .content .image-previews'),
                linkedIn: document.querySelector('#linkedIn .content .image-previews')
            };

            // Default placeholder image
            const placeholderImage = "https://placehold.co/600x400";

            // Function to update description text for each tab
            const updateDescriptionPreview = (descriptionValue) => {
                Object.values(previewContainers).forEach(container => {
                    container.previousElementSibling.textContent = descriptionValue || '..........';
                });
            };

            // Function to update image previews for each tab
            const updateImagePreviews = (files) => {
                Object.values(previewContainers).forEach(container => {
                    container.innerHTML = '';  // Clear previous previews

                    if (files.length > 0) {
                        Array.from(files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const imgElement = document.createElement('img');
                                imgElement.src = e.target.result;
                                imgElement.classList.add('preview-img');
                                container.appendChild(imgElement);
                            };
                            reader.readAsDataURL(file);
                        });
                    } else {
                        // Set placeholder image if no file is selected
                        container.innerHTML = `<img src="${placeholderImage}" class="preview-img" />`;
                    }
                });
            };

            // Update description text when input changes
            descriptionField.addEventListener('input', function () {
                updateDescriptionPreview(descriptionField.value);
            });

            // Update image previews when files are selected
            imageField.addEventListener('change', function () {
                updateImagePreviews(imageField.files);
            });
        });

        $(document).ready(function () {
            $("#when_post").on("change", function () {
                var selectedValue = $(this).val(); // Get selected value

                $(".post__by").hide(); // Hide all
                $(".post__by[data-option='" + selectedValue + "']").show(); // Show the matching one
            });
        });

        $(document).ready(function () {
            // Add new dateItem
            $(".add_btn").on("click", function () {
                var newDateItem = `
							<div class="dateItem mt-2">
							<input type="text" class="datepicker form-control rounded-0" name="day_time_post[]" id="time_post" placeholder="Select Date & Time">
								<button type="button" class="btn delete_btn"><i class="las la-trash-alt"></i></button>
							</div>
						`;
                $(".items__container").append(newDateItem);
            });

            // Delete dateItem
            $(document).on("click", ".delete_btn", function () {
                $(this).closest(".dateItem").remove();
            });
        });

        // Checkbox Select Here
        $(document).ready(function () {
            function formatOption(option) {
                if (!option.id) {
                    return option.text;
                }

                var optionWithImage = $(
                    '<span><img src="' + option.image + '" class="img-flag" /> ' + option.text + '</span>'
                );
                return optionWithImage;
            }

            var options = @json($profiles);

            $('.checkbox__select').select2({
                templateResult: formatOption,
                templateSelection: formatOption,
                data: options,
                minimumResultsForSearch: Infinity,
                dropdownCssClass: "selectBox_withImage" // Add custom class to dropdown
            });
            $(document).on('click', '.copy_text', function () {
                let val = $('.ai_description').summernote('code');
                $('#aiModal').modal('hide');
                $('#description').val(val);
            });
        });
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d H:i",
            // dateFormat: "Y-m-d", // Example: 2025-02-09
            minDate: "today", // Prevents selecting past dates
            maxDate: "2025-12-31", // Maximum date allowed for selection
            locale: "en", // Language setting (optional, defaults to English)
            enableTime: true,
            time_12hr: true,
        });

        $(document).on("click", ".reset-button", function () {
            $("#use_case").val('');
            $("#primary_keyword").val('');
        });
	</script>
@endpush
@push('css')
	<style>
        .social-post {
            border-radius: 8px;
            padding: 15px;
            background-color: #f7f7f7;
            margin: 20px 0;
        }

        .social-post img {
            max-width: 100%;
            border-radius: 8px;
        }

        .social-post .header {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .social-post .content {
            font-size: 1rem;
            margin-top: 10px;
        }
	</style>
@endpush()
