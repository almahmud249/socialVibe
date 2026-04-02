<!-- Footer Section Start -->
<footer class="footer__section">
	<div class="container">
		<div class="row">
			<div class="col-md-7" data-aos="fade-up" data-aos-duration="800">
				<div class="footer__top">
					<div class="footer__logo">
						<a href="#">
							@php
								$src = setting('light_logo') && @is_file_exists(setting('light_logo')['original_image']) ? get_media(setting('light_logo')['original_image']) : get_media('images/default/logo/logo.png');
							@endphp
							<img src="{{$src}}" alt="logo"/>
						</a>
					</div>
					<div class="footer__slogun">
						<h5 class="title">{{ setting('high_lighted_text', app()->getLocale()) }}</h5>
						<p>
							{{ setting('footer_text', app()->getLocale()) }}
						</p>
						@if(setting('show_payment_method_banner') == 1)
							<div class="payment__icon">
								<a href="javascript:void(0)"><img
											src="{{ setting('payment_method_banner') && @is_file_exists(setting('payment_method_banner')['original_image']) ? get_media(setting('payment_method_banner')['original_image']) : get_media('frontend/img/payment-methods/footer-payment.png') }}"
											alt="payment"/></a>
							</div>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-5" data-aos="fade-up" data-aos-duration="800">
				<div class="footer__wrapper">
					<div class="footer__widget">
						<div class="widget__flex">
							@if (setting('show_useful_link') &&
                    is_array(setting('footer_useful_link_menu')) &&
                    count(setting('footer_useful_link_menu')) > 0)
								@php
									$useful_link_menu =
											headerFooterMenu('footer_useful_link_menu', app()->getLocale()) ?:
											headerFooterMenu('footer_useful_link_menu');
								@endphp
								<ul class="widget__list">
									@foreach ($useful_link_menu as $usefulLink)
										<li><a href="{{ $usefulLink['url'] }}">{{ $usefulLink['label'] }}</a></li>
									@endforeach
								</ul>
							@endif
							@if (setting('show_quick_link') &&
					is_array(setting('footer_quick_link_menu')) &&
					count(setting('footer_quick_link_menu')) > 0)
								@php
									$quick_link_menu = headerFooterMenu('footer_quick_link_menu', app()->getLocale()) ? : headerFooterMenu('footer_quick_link_menu');
								@endphp
								<ul class="widget__list">
									@foreach ($quick_link_menu as $quickLink)
										<li><a href="{{ $quickLink['url'] }}">{{ $quickLink['label'] }}</a></li>
									@endforeach
								</ul>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer__bottom">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="footer__copyright">
						@if (setting('show_copyright') != 0)
							<p class="copyright text-center">
								{!! setting('copyright_title', app()->getLocale()) !!}
							</p>
						@endif
						<div class="footer__toplink">
							<div class="footer__link d-flex align-items-center">
								<div class="icon">
									<img src="{{ static_asset('website/themes/default/assets/images/email.svg')}}"
									     alt="email"/>
								</div>
								<a href="mailto:{!! setting('contact_email', app()->getLocale()) !!}">{!! setting('contact_email', app()->getLocale()) !!}</a>
							</div>
							<div class="footer__link d-flex align-items-center">
								<div class="icon">
									<img src="{{ static_asset('website/themes/default/assets/images/phone.svg')}}"
									     alt="phone"/>
								</div>
								<a href="tel:{{ setting('contact_phone') }}">{!! setting('contact_phone', app()->getLocale()) !!}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- Footer Section End -->
