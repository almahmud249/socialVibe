<!-- Banner Section Start -->
<section class="banner__section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="banner__wrapper">
					<div class="banner__text" data-aos="fade-up" data-aos-duration="700">
						<h5 class="subtitle">
							{!! setting('hero_subtitle', app()->getLocale()) !!}
							<img src="{{ static_asset('website/themes/default/assets/images/sparkles.svg')}}"
							     alt="icon"/>
						</h5>
						<h1 class="title">
							{!! setting('hero_title', app()->getLocale()) !!}
						</h1>
						<p class="desc">
							{!! setting('hero_description', app()->getLocale()) !!}
						</p>
						@if (setting('hero_main_action_btn_enable') || setting('hero_secondary_action_btn_enable'))
							<div class="btn__group">
								@if (setting('hero_main_action_btn_enable'))
									<a href="{!! setting('hero_main_action_btn_url', app()->getLocale()) !!}"
									   class="sg-btn sg-btn-primary">
										{!! setting('hero_main_action_btn_label', app()->getLocale()) !!}</a>
								@endif
								@if (setting('hero_secondary_action_btn_enable'))
									<a
											data-fancybox
											data-width=""
											data-height=""
											class="popup__btn"
											href="{!! setting('hero_secondary_action_btn_url', app()->getLocale()) !!}"
									>
										<svg width="13" height="14" viewBox="0 0 13 14" fill="none"
										     xmlns="http://www.w3.org/2000/svg">
											<path
													d="M10.9537 4.64859L5.38984 0.568759C4.95527 0.250542 4.44107 0.058875 3.90424 0.0150028C3.36741 -0.0288694 2.82891 0.0767673 2.34845 0.320203C1.86798 0.56364 1.4643 0.935367 1.18216 1.39418C0.900023 1.85299 0.750444 2.38097 0.750004 2.91959V11.0833C0.749166 11.6225 0.897963 12.1513 1.17983 12.6109C1.4617 13.0705 1.86559 13.4428 2.34652 13.6865C2.82746 13.9302 3.36659 14.0356 3.9039 13.9911C4.4412 13.9465 4.9556 13.7537 5.38984 13.4342L10.9537 9.35434C11.3229 9.08341 11.6231 8.72937 11.83 8.32086C12.0369 7.91234 12.1447 7.46085 12.1447 7.00293C12.1447 6.545 12.0369 6.09351 11.83 5.685C11.6231 5.27649 11.3229 4.92244 10.9537 4.65151V4.64859Z"
													fill="#333333"
											/>
										</svg>
									</a>
								@endif
							</div>
						@endif
					</div>
					<div class="banner__thumb" data-aos="fade-up" data-aos-duration="800">
						<img src="{{ getFileLink('original_image', setting('header1_hero_image1'),null,'1080x720') }}"
						     alt="banner-thumb"/>
						<img src="{{ static_asset('website/themes/default/assets/images/banner/banner-avatar.png')}}"
						     class="banner__avatar" alt="avatar"/>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Banner Section End -->
