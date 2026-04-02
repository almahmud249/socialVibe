<!-- End Payment box -->
<div class="modal fade" id="aiModal" tabindex="-1" aria-labelledby="aiModalLabel" aria-hidden="false">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content">
			<h6 class="sub-title">{{ __('generate_ai_content') }}</h6>
			<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			<div class="row">
				<div class="col-xl-4">
					<div class="platform__wrapper">
						<!-- Social PlatForm Start -->
						<div class="social__platform">
							<label class="social__select">
								<input type="radio" name="social" value="1" id="facebook">
								<div class="social__item">
									<div class="icon">
										<svg width="28" height="28" viewBox="0 0 28 28" fill="none"
										     xmlns="http://www.w3.org/2000/svg">
											<path d="M28 14.0068C28 20.7823 22.8737 26.3992 16.1817 27.4185V17.9574H19.4355L20.055 14.043H16.1817V11.5032C16.1817 10.4319 16.723 9.3888 18.4567 9.3888H20.2172V6.05595C20.2172 6.05595 18.6188 5.79122 17.0917 5.79122C13.902 5.79122 11.8183 7.66581 11.8183 11.0586V14.0419H8.27283V17.9562H11.8183V27.4174C5.1275 26.397 0 20.7811 0 14.0068C0 6.50961 6.2685 0.431061 14 0.431061C21.7315 0.431061 28 6.50847 28 14.0068Z"
											      fill="black"/>
										</svg>
									</div>
									<!-- Facebook -->
								</div>
							</label>
							<label class="social__select">
								<input type="radio" name="social" value="2" id="instagram">
								<div class="social__item">
									<div class="icon">
										<svg width="25" height="25" viewBox="0 0 25 25" fill="none"
										     xmlns="http://www.w3.org/2000/svg">
											<path d="M12.5 2.25208C15.8375 2.25208 16.2333 2.26458 17.551 2.325C18.9135 2.3875 20.3167 2.69792 21.3094 3.69062C22.3115 4.69271 22.6125 6.08229 22.675 7.44896C22.7354 8.76667 22.7479 9.1625 22.7479 12.5C22.7479 15.8375 22.7354 16.2333 22.675 17.551C22.6135 18.9062 22.2958 20.3229 21.3094 21.3094C20.3073 22.3115 18.9188 22.6125 17.551 22.675C16.2333 22.7354 15.8375 22.7479 12.5 22.7479C9.1625 22.7479 8.76667 22.7354 7.44896 22.675C6.10417 22.6135 4.66875 22.2885 3.69062 21.3094C2.69375 20.3125 2.3875 18.9094 2.325 17.551C2.26458 16.2333 2.25208 15.8375 2.25208 12.5C2.25208 9.1625 2.26458 8.76667 2.325 7.44896C2.38646 6.09896 2.70729 4.67396 3.69062 3.69062C4.69062 2.69062 6.08542 2.3875 7.44896 2.325C8.76667 2.26458 9.1625 2.25208 12.5 2.25208ZM12.5 0C9.10521 0 8.67917 0.0145833 7.34583 0.075C5.41354 0.163542 3.49479 0.701042 2.09792 2.09792C0.695833 3.5 0.163542 5.41458 0.075 7.34583C0.0145833 8.67917 0 9.10521 0 12.5C0 15.8948 0.0145833 16.3208 0.075 17.6542C0.163542 19.5844 0.703125 21.5083 2.09792 22.9021C3.49896 24.3031 5.41667 24.8365 7.34583 24.925C8.67917 24.9854 9.10521 25 12.5 25C15.8948 25 16.3208 24.9854 17.6542 24.925C19.5854 24.8365 21.5062 24.2979 22.9021 22.9021C24.3052 21.499 24.8365 19.5854 24.925 17.6542C24.9854 16.3208 25 15.8948 25 12.5C25 9.10521 24.9854 8.67917 24.925 7.34583C24.8365 5.41354 24.2979 3.49375 22.9021 2.09792C21.5031 0.698958 19.5802 0.1625 17.6542 0.075C16.3208 0.0145833 15.8948 0 12.5 0Z"
											      fill="black"/>
											<path d="M12.4998 6.08124C8.95501 6.08124 6.08105 8.9552 6.08105 12.5C6.08105 16.0448 8.95501 18.9187 12.4998 18.9187C16.0446 18.9187 18.9186 16.0448 18.9186 12.5C18.9186 8.9552 16.0446 6.08124 12.4998 6.08124ZM12.4998 16.6667C10.1988 16.6667 8.33314 14.801 8.33314 12.5C8.33314 10.1989 10.1988 8.33332 12.4998 8.33332C14.8008 8.33332 16.6665 10.1989 16.6665 12.5C16.6665 14.801 14.8008 16.6667 12.4998 16.6667Z"
											      fill="black"/>
											<path d="M19.1729 7.32709C20.0013 7.32709 20.6729 6.65551 20.6729 5.82709C20.6729 4.99866 20.0013 4.32709 19.1729 4.32709C18.3444 4.32709 17.6729 4.99866 17.6729 5.82709C17.6729 6.65551 18.3444 7.32709 19.1729 7.32709Z"
											      fill="black"/>
										</svg>
									</div>
									<!-- Instagram -->
								</div>
							</label>
							<label class="social__select">
								<input type="radio" name="social" value="3" id="linkedin">
								<div class="social__item">
									<div class="icon">
										<svg width="29" height="25" viewBox="0 0 29 25" fill="none"
										     xmlns="http://www.w3.org/2000/svg">
											<path d="M27.3358 23.6813H27.6007L27.0932 22.9137C27.4035 22.9137 27.568 22.7165 27.5703 22.475C27.5703 22.4657 27.5703 22.4552 27.5692 22.4458C27.5692 22.1168 27.3708 21.9593 26.9637 21.9593H26.3057V23.6813H26.553V22.9312H26.8575L27.3358 23.6813ZM26.84 22.7363H26.553V22.1542H26.917C27.1048 22.1542 27.3195 22.1845 27.3195 22.4307C27.3195 22.713 27.1037 22.7363 26.84 22.7363Z"
											      fill="black"/>
											<path d="M20.6728 20.7518H17.1647V15.258C17.1647 13.9478 17.1413 12.262 15.34 12.262C13.513 12.262 13.233 13.6888 13.233 15.1635V20.7518H9.726V9.45382H13.0942V10.9973H13.1408C13.828 9.82365 15.1043 9.12249 16.4635 9.17265C20.0195 9.17265 20.674 11.5118 20.674 14.5533L20.6728 20.7518ZM5.7675 7.90915C4.64283 7.90915 3.73167 6.99799 3.73167 5.87332C3.73167 4.74865 4.64283 3.83749 5.7675 3.83749C6.89217 3.83749 7.80333 4.74865 7.80333 5.87332C7.80333 6.99799 6.89217 7.90915 5.7675 7.90915ZM7.521 20.7518H4.00933V9.45382H7.521V20.7518ZM22.4217 0.580153H2.2465C1.29333 0.569653 0.511667 1.33382 0.5 2.28699V22.545C0.511667 23.4993 1.29333 24.2635 2.2465 24.253H22.4217C23.3772 24.2647 24.1623 23.5005 24.1752 22.545V2.28582C24.1612 1.33032 23.376 0.566153 22.4217 0.578986"
											      fill="black"/>
											<path d="M26.8704 21.1928C25.9791 21.201 25.2627 21.9313 25.2721 22.8226C25.2802 23.714 26.0106 24.4303 26.9019 24.421C27.7932 24.4128 28.5096 23.6825 28.5002 22.7911C28.4921 21.9115 27.7804 21.201 26.9019 21.1928H26.8704ZM26.9077 24.2355C26.1261 24.2483 25.4447 23.6265 25.4319 22.8448C25.4191 22.0631 26.0421 21.4191 26.8237 21.4063C27.6054 21.3935 28.2494 22.0165 28.2622 22.7981C28.2622 22.8063 28.2622 22.8133 28.2622 22.8215C28.2786 23.5856 27.6719 24.2191 26.9077 24.2355H26.8716H26.9077Z"
											      fill="black"/>
										</svg>
									</div>
									<!-- LinkedIn -->
								</div>
							</label>
							<label class="social__select">
								<input type="radio" name="social" value="4" id="twitter">
								<div class="social__item">
									<div class="icon">
										<svg width="28" height="29" viewBox="0 0 28 29" fill="none"
										     xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0_2159_1717)">
												<path d="M25.1335 8.788C25.1498 9.03417 25.1498 9.2815 25.1498 9.53C25.1498 17.1215 19.3702 25.875 8.80483 25.875V25.8703C5.684 25.875 2.62733 24.9813 0 23.2955C0.453833 23.3503 0.91 23.3772 1.36733 23.3783C3.955 23.3807 6.468 22.5127 8.5015 20.9143C6.04333 20.8677 3.88733 19.2647 3.13483 16.9243C3.99583 17.09 4.8825 17.0562 5.72833 16.8263C3.04733 16.285 1.12 13.9295 1.12 11.1948C1.12 11.1703 1.12 11.1458 1.12 11.1225C1.91917 11.5682 2.81283 11.8143 3.7275 11.8412C1.20283 10.1553 0.4235 6.79767 1.94833 4.17267C4.865 7.76133 9.16883 9.943 13.7877 10.1752C13.3245 8.18017 13.958 6.0895 15.449 4.686C17.7625 2.51017 21.4013 2.62217 23.5772 4.93567C24.864 4.6825 26.0972 4.21 27.2253 3.5415C26.796 4.8715 25.8988 6.00083 24.6995 6.7195C25.8393 6.583 26.9512 6.2785 28 5.81417C27.2288 6.968 26.2582 7.97483 25.1335 8.788Z"
												      fill="black"/>
											</g>
										</svg>
									</div>
									<!-- Twitter -->
								</div>
							</label>
						</div>
						<!-- Social PlatForm Start -->
						<!-- Content Idea Start -->
						<div class="contentIdea__wrapper">
							<h4 class="content__title">{{__('content_ideas')}}</h4>
							<div class="contentIdea__inner">
								@foreach($ai_templates as $ai_template)
									<div class="@if($ai_template->platform == 1) facebook @elseif($ai_template->platform == 2) instagram @elseif($ai_template->platform == 3) linkedin @elseif($ai_template->platform == 4) twitter @endif">
										<label class="social__select">
											<input type="radio" name="ai_template"
											       id="ai_template_{{ $ai_template->id }}"
											       data-prompt="{{ $ai_template->prompt }}">
											<div class="content__item">
												<h4 class="title">{{ $ai_template->title }}</h4>
												<p class="content">
													{{ $ai_template->description }}
												</p>
											</div>
										</label>
									</div>
								@endforeach
							</div>
						</div>
						<!-- Content Idea End -->
					</div>
				</div>
				<div class="col-xl-8 contentForm">
					<div class="">
						<div class="row">
							<div class="col-lg-12 mb-3">
								<div class="form-group">
									<label for="topic" class="form-label">{{__('topic')}}<span
												class="text-danger">*</span></label>
									<input type="text" class="form-control" name="text" id="use_case"
									       placeholder="Write here" required>
								</div>
							</div>
							<div class="col-lg-12 mb-3">
								<div class="form-group">
									<label for="ai_prompt" class="form-label">{{__('ai_prompt')}}<span
												class="text-danger">*</span></label>
									<textarea class="form-control" id="primary_keyword" rows="2" required></textarea>
								</div>
							</div>
							<div class="col-lg-12 mb-3">
								<div class="text-end">
									<a class="copy_text" href="javascript:void(0)">{{__('use')}}</a>
								</div>
								<div class="form-group">
									<label for="ai_content" class="form-label">{{__('ai_content')}}</label>
									<textarea id="summernote" class="form-control h-auto summernote ai_description" rows="10"
									          required></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="d-flex justify-content-end align-items-center mt-30 gap-3">
						<button type="button" class="btn-dark d-flex align-items-center gap-2 reset-button"><i
									class="las la-sync"></i> {{__('reset')}}
						</button>

						<button type="submit" data-url="{{ route('client.ai.content') }}"
						        class="btn sg-btn-primary generate_content_for_me d-flex align-items-center gap-2">{{ __('generate_content') }}
							<i class="las la-arrow-right"></i></button>
						@include('backend.common.loading-btn', [
							'class' => 'btn sg-btn-primary generator_loading_btn',
						])
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
