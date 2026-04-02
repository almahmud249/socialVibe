<!-- Feature Section Start -->
<section class="feature__section py-60 py-sm-40" id="features">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section__title-wrapper" data-aos="fade-up" data-aos-duration="800">
					<div class="section__title">
						<h4 class="subtitle">
							{{__('features')}}
							<img src="{{ static_asset('website/themes/default/assets/images/award.svg')}}" alt="icon"/>
						</h4>
						<h2 class="title">{!! setting('unique_feature_section_title', app()->getLocale()) !!}</h2>
					</div>
				</div>
			</div>
		</div>
		<div class="row" data-aos="fade-up" data-aos-duration="800">
			@foreach ($unique_features as $key => $unique_feature)
			<div class="col-lg-4 col-md-6 col-sm-6">
				<div class="featureBox">
					<div class="featureBox__icon">
						<img src="{{ getFileLink('original_image',  $unique_feature->icon,null,'120x40') }}" alt="icon"/>
					</div>
					<div class="featureBox__content">
						<h4 class="title">{{ @$unique_feature->language->title }}</h4>
						<p class="desc">{{ @$unique_feature->language->description }}</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>
<!-- Feature Section End -->