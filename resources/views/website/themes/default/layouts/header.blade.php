<!-- Header Start -->
<header class="header">
	<!-- Nav Start -->
	<nav class="nav p-0 m-0">
		<div class="container">
			<div class="header__wrapper">
				<!-- Header Logo End -->
				<div class="header__logo">
					<a href="{{ url('/') }}">
						@php
							$src = setting('dark_logo') && @is_file_exists(setting('dark_logo')['original_image']) ? get_media(setting('dark_logo')['original_image']) :  get_media('images/default/logo/logo-dark.png');
						@endphp
						<img src="{{ $src }}" alt="{!! setting('company_name', app()->getLocale()) !!}"/>
					</a>
				</div>
				<!-- Header Logo End -->
				<!-- Header Menu Start -->
				<div class="header__menu">
					<ul class="main__menu">
						@if (setting('show_default_menu_link') == 1)
							@if (
								$menu_language && is_array(setting('header_menu'))
									? count(setting('header_menu'))
									: 0 != 0 && setting('header_menu') != []
							)
								@foreach ($menu_language as $key => $value)
									<li><a href="{{ @$value['url'] }}">{{ @$value['label'] }}</a></li>
								@endforeach
							@endif
						@endif
						@if (Auth::check())
							@if (Auth::user()->role_id == 1)
								<li class="header__btn d-md-none">
									<a href="{{ route('admin.dashboard') }}"
									   class="sg-btn sg-btn-dark">{{__('dashboard')}}</a>
								</li>
							@else
								<li class="header__btn d-md-none">
									<a href="{{ route('client.dashboard') }}"
									   class="sg-btn sg-btn-dark">{{__('dashboard')}}</a>
								</li>
							@endif
						@else
							<li class="header__btn d-md-none">
								<a href="{{ route('login') }}" class="sg-btn sg-btn-outline">{{__('login')}}</a>
							</li>
							<li class="header__btn d-md-none">
								<a href="{{ route('register') }}" class="sg-btn sg-btn-dark">{{__('get_started')}}</a>
							</li>
						@endif
					</ul>
				</div>
				<!-- Header Menu End -->
				<!-- Header Meta Start -->
				<div class="header__meta">
					@php
						$active_locale = 'English';
						$languages = app('languages');
						$locale_language = $languages->where('locale', app()->getLocale())->first();
						if ($locale_language) {
							$active_locale = $locale_language->name;
						}
					@endphp
					@if((setting('language_switcher') == 1))
						<div class="language__dropdown">
							<a href="#" class="selected">{{ $active_locale }}</a>
							<ul class="language__list dropdown__list">
								@foreach ($languages as $language)
								<li><a href="{{ setLanguageRedirect($language->locale) }}">{{ $language->name }}</a></li>
								@endforeach
							</ul>
						</div>
					@endif
					<div class="header__btn d-md-flex d-none">
						@if (Auth::check())
							@if (Auth::user()->role_id == 1)
								<a class="sg-btn sg-btn-dark"
								   href="{{ route('admin.dashboard') }}">{{ __('dashboard') }}<i
											class="las la-angle-right"></i></a>
							@else
								<a class="sg-btn sg-btn-dark"
								   href="{{ route('client.dashboard') }}">{{ __('dashboard') }}<i
											class="las la-angle-right"></i></a>
							@endif
						@else
							<a href="{{ route('login') }}" class="sg-btn sg-btn-outline">{{__('login')}}</a>
							<a href="{{ route('register') }}" class="sg-btn sg-btn-dark">{{__('get_started')}}</a>
						@endif
					</div>
					<!-- Header Toggle Start -->
					<div class="header__toggle">
						<div class="toggle__bar"></div>
					</div>
					<!-- Hrader Toggle End -->
				</div>
				<!-- Header Meta End -->
			</div>
		</div>
	</nav>
	<!-- Nav End -->
</header>
<!-- Header End -->
