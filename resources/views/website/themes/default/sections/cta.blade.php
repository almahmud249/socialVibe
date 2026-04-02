<!-- CtaBox Section Start -->
@if(setting('cta_enable')== 1)
	<section class="ctaBox__section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="ctaBox__wrapper" data-aos="fade-up" data-aos-duration="700">
						<div class="ctaBox__content" data-aos="fade-up" data-aos-duration="800">
							<h2 class="title">{!! setting('cta_title', app()->getLocale()) !!}</h2>
							<p class="desc">
								{!! setting('cta_subtitle', app()->getLocale()) !!}
							</p>
						</div>
						<div class="btn__group" data-aos="fade-up" data-aos-duration="800">
							<a href="{{ setting('cta_main_action_btn_url') }}" class="sg-btn sg-btn-dark">{{__('get_started')}}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endif
<!-- CtaBox Section End -->
