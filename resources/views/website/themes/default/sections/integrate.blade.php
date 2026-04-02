<!-- Integrate Section Start -->
@if(setting('integrate_section_enable') == 1 )
<section class="integrate__section py-60 py-sm-40">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="integrate__wrapper" data-aos="fade-up" data-aos-duration="700">
					<div class="integrate__content" data-aos="fade-up" data-aos-duration="800">
						<h2 class="title">{!! setting('integrate_title', app()->getLocale()) !!}</h2>
						<p class="desc">{!! setting('integrate_description', app()->getLocale()) !!}</p>
						<div class="btn__group">
							<a href="{{ setting('integrate_action_btn_url') }}" class="sg-btn sg-btn-primary">{!! setting('integrate_action_btn_label', app()->getLocale()) !!}</a>
						</div>
					</div>
					<div class="integrate__channel" data-aos="fade-up" data-aos-duration="800">
						<ul class="channel__list">
							@foreach($integrate_list as $integrate)
							<li>
								<div class="icon"><img src="{{ getFileLink('original_image',  $integrate->image,null,'30x30') }}" alt="icon" /></div>
								{{ $integrate->langTitle }}
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endif
<!-- Integrate Section End -->