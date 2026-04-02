<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    @if(setting('meta_title') != '')
        <title>{{setting('meta_title')}}</title>
    @else
        <title>{{ setting('system_name') }}</title>
    @endif
    <meta name="description" content="Demo - Html Template"/>

    <!--====== LineAwesome ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/line-awesome.min.css') }}">
    <!--====== Dropzone CSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/dropzone.min.css') }}">
    <!--====== Summernote CSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/summernote-lite.min.css') }}">
    <!--====== Choices CSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/choices.min.css') }}">
    <!--====== AppCSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/app.css') }}">
    <!--====== ResponsiveCSS ======-->
    <link rel="stylesheet" href="{{ static_asset('admin/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('admin/css/auth.css') }}">


    <link rel="shortcut icon" href="{{ static_asset('admin/images/logo/favicon.svg')}}" type="image/f-icon"/>

    <link rel="stylesheet" href="{{ static_asset('admin/css/line-awesome.min.css') }}">
    <!-- Remix Icon -->
    <link rel="stylesheet" href="{{ static_asset('admin/css/remixicon.css')}}"/>
    <!-- bootstraph -->
    <link rel="stylesheet" href="{{ static_asset('admin/css/bootstrap.min.css')}}"/>
    <!-- FancyBox -->
    <link rel="stylesheet" href="{{ static_asset('admin/css/jquery.fancybox.min.css')}}"/>
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{ static_asset('admin/css/swiper-bundle.min.css')}}"/>
    <!-- Aos Animation -->
    <link rel="stylesheet" href="{{ static_asset('admin/css/aos.css')}}"/>
    <!-- User's CSS Here -->
    <link rel="stylesheet" href="{{ static_asset('admin/css/style.css')}}"/>
    @php
        $icon = setting('admin_favicon');
    @endphp
    @if ($icon)
        <link rel="apple-touch-icon" sizes="57x57"
              href="{{ $icon != [] && @is_file_exists($icon['image_57x57_url']) ? static_asset($icon['image_57x57_url']) : static_asset('images/default/favicon/favicon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60"
              href="{{ $icon != [] && @is_file_exists($icon['image_60x60_url']) ? static_asset($icon['image_60x60_url']) : static_asset('images/default/favicon/favicon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72"
              href="{{ $icon != [] && @is_file_exists($icon['image_72x72_url']) ? static_asset($icon['image_72x72_url']) : static_asset('images/default/favicon/favicon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76"
              href="{{ $icon != [] && @is_file_exists($icon['image_76x76_url']) ? static_asset($icon['image_76x76_url']) : static_asset('images/default/favicon/favicon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114"
              href="{{ $icon != [] && @is_file_exists($icon['image_114x114_url']) ? static_asset($icon['image_114x114_url']) : static_asset('images/default/favicon/favicon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120"
              href="{{ $icon != [] && @is_file_exists($icon['image_120x120_url']) ? static_asset($icon['image_120x120_url']) : static_asset('images/default/favicon/favicon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144"
              href="{{ $icon != [] && @is_file_exists($icon['image_144x144_url']) ? static_asset($icon['image_144x144_url']) : static_asset('images/default/favicon/favicon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152"
              href="{{ $icon != [] && @is_file_exists($icon['image_152x152_url']) ? static_asset($icon['image_152x152_url']) : static_asset('images/default/favicon/favicon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180"
              href="{{ $icon != [] && @is_file_exists($icon['image_180x180_url']) ? static_asset($icon['image_180x180_url']) : static_asset('images/default/favicon/favicon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"
              href="{{ $icon != [] && @is_file_exists($icon['image_192x192_url']) ? static_asset($icon['image_192x192_url']) : static_asset('images/favicon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32"
              href="{{ $icon != [] && @is_file_exists($icon['image_32x32_url']) ? static_asset($icon['image_32x32_url']) : static_asset('images/default/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96"
              href="{{ $icon != [] && @is_file_exists($icon['image_96x96_url']) ? static_asset($icon['image_96x96_url']) : static_asset('images/default/favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16"
              href="{{ $icon != [] && @is_file_exists($icon['image_16x16_url']) ? static_asset($icon['image_16x16_url']) : static_asset('images/default/favicon/favicon-16x16.png') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage"
              content="{{ $icon != [] && @is_file_exists($icon['image_144x144_url']) ? static_asset($icon['image_144x144_url']) : static_asset('images/default/favicon/favicon-144x144.png') }}">
    @else
        <link rel="apple-touch-icon" sizes="57x57"
              href="{{ static_asset('images/default/favicon/apple-icon-57x57.png')}}">
        <link rel="apple-touch-icon" sizes="60x60"
              href="{{ static_asset('images/default/favicon/apple-icon-60x60.png')}}">
        <link rel="apple-touch-icon" sizes="72x72"
              href="{{ static_asset('images/default/favicon/apple-icon-72x72.png')}}">
        <link rel="apple-touch-icon" sizes="76x76"
              href="{{ static_asset('images/default/favicon/apple-icon-76x76.png')}}">
        <link rel="apple-touch-icon" sizes="114x114"
              href="{{ static_asset('images/default/favicon/apple-icon-114x114.png')}}">
        <link rel="apple-touch-icon" sizes="120x120"
              href="{{ static_asset('images/default/favicon/apple-icon-120x120.png')}}">
        <link rel="apple-touch-icon" sizes="144x144"
              href="{{ static_asset('images/default/favicon/apple-icon-144x144.png')}}">
        <link rel="apple-touch-icon" sizes="152x152"
              href="{{ static_asset('images/default/favicon/apple-icon-152x152.png')}}">
        <link rel="apple-touch-icon" sizes="180x180"
              href="{{ static_asset('images/default/favicon/apple-icon-180x180.png')}}">
        <link rel="icon" type="image/png" sizes="192x192"
              href="{{ static_asset('images/default/favicon/android-icon-192x192.png')}}">
        <link rel="icon" type="image/png" sizes="32x32"
              href="{{ static_asset('images/default/favicon/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="96x96"
              href="{{ static_asset('images/default/favicon/favicon-96x96.png')}}">
        <link rel="icon" type="image/png" sizes="16x16"
              href="{{ static_asset('images/default/favicon/favicon-16x16.png')}}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ static_asset('images/default/favicon/ms-icon-144x144.png')}}">
        <meta name="theme-color" content="#ffffff">
    @endif

</head>
<body>
<!-- Login Wrapper Start -->
<div class="login__section">
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-lg-6">
                <div class="login__form">
                    <div class="login__logo">
                        <a href="{{ url('/') }}">
                            <img
                                    src="{{ setting('dark_logo') && @is_file_exists(setting('dark_logo')['original_image']) ? get_media(setting('dark_logo')['original_image']) : get_media('images/default/logo/logo-dark.png') }}"
                                    alt="Corporate Logo">
                        </a>
                    </div>
                    <div class="form__wrapper">
                        <form action="{{ route('signup.store') }}" method="POST">@csrf
                            <div class="heading__content">
                                <h2 class="title">{{__('sign_up')}}</h2>
                                <p class="desc">{{__('already_have_an_account')}}? <a href="{{ route('login') }}">{{__('login')}}</a></p>
                            </div>
                            <div class="form-group">
                                <label for="company_name">{{__('company_name')}}<span class="required">*</span></label>
                                <input
                                        type="text"
                                        class="form-control"
                                        id="company_name"
                                        value="{{ old('company_name') }}" name="company_name"
                                        placeholder="{{ __('company_name') }}" required autofocus
                                />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2 nk-block-des text-danger" />
                            </div>
                            <div class="flex__input">
                                <div class="form-group">
                                    <label for="first_name">{{__('first_name')}}<span class="required">*</span></label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="first_name"
                                            value="{{ old('first_name') }}" name="first_name"
                                            placeholder="{{ __('first_name') }}" required autofocus
                                    />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2 nk-block-des text-danger" />
                                </div>
                                <div class="form-group">
                                    <label for="last_name">{{__('last_name')}}<span class="required">*</span></label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            id="last_name"
                                            value="{{ old('last_name') }}" name="last_name"
                                            placeholder="{{ __('last_name') }}" required autofocus
                                    />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2 nk-block-des text-danger" />
                                </div>
                            </div>
                            <div class="flex__input">
                                <div class="form-group">
                                    <label for="email"> {{__('email')}} <span class="required">*</span> </label>
                                    <input
                                            type="email"
                                            class="form-control"
                                            id="email"
                                            value="{{ old('email') }}" name="email"
                                            placeholder="{{ __('email') }}" required autofocus
                                    />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2 nk-block-des text-danger" />
                                </div>
                                <div class="form-group">
                                    <label for="phone">
                                        {{__('phone')}} <span class="with-country-code">({{__('with_country_code')}})</span> <span class="required">*</span>
                                    </label>
                                    <input
                                            name="phone"
                                            class="form-control"
                                            id="phone"
                                            placeholder="{{__('Your_phone')}}"
                                            type="tel" value="{{ old('phone') }}" required
                                    />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2 nk-block-des text-danger" />
                                </div>
                            </div>
                            <div class="flex__input">
                                <div class="form-group">
                                    <label for="password">
                                        {{__('password')}}
                                        <span class="required">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input
                                                type="password"
                                                class="form-control password pe-5"
                                                id="password"
                                                placeholder="{{ __('password') }}" name="password" required autofocus
                                        />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2 nk-block-des text-danger" />
                                        <i class="ri-eye-off-line toggle__password"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">
                                        {{__('confirm_password')}}
                                        <span class="required">*</span>
                                    </label>
                                    <div class="position-relative">
                                        <input
                                                type="password"
                                                class="form-control password pe-5"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="{{ __('re_enter_password') }}" required autofocus
                                        />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 nk-block-des text-danger" />
                                        <i class="ri-eye-off-line toggle__password"></i>
                                    </div>
                                </div>
                                @if (setting('is_recaptcha_activated') && setting('recaptcha_site_key'))
                                    <div class="mb-30">
                                        <div id="html_element" class="g-recaptcha"
                                             data-sitekey="{{ setting('recaptcha_site_key') }}"></div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex__input d-flex gap-3 mb-20">
                                <div class="custom__checkbox">
                                    <input type="checkbox" class="form-check-input" id="policyCheck" />
                                    <label class="form-check-label" for="policyCheck">{{__('remember_me')}}</label>
                                </div>
                            </div>

                            <div class="btn__group">
                                <button type="submit" name="btn" class="sg-btn sg-btn-primary w-100">{{__('sign_up')}}</button>
                            </div>
                        </form>
                    </div>
                    @if (setting('show_copyright') != 0)
                        <div class="footer__copyright">
                            <p class="copyright">
                                {!! setting('copyright_title', app()->getLocale()) !!}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login__wrapper position-relative">
                    <div class="swiper login__slider">
                        <div class="swiper-wrapper">
                            @foreach($contents as $key=> $content)
                                <!-- Swiper Slide -->
                                <div class="swiper-slide">
                                    <div class="login__item text-center">
                                        <div class="avatar">
                                            <img src="{{ static_asset('website/themes/default/assets/images/login-thumb.png')}}" alt="avatar" />
                                            {{--                                            <img src="{{ getFileLink('original_image',  $content->image,null,'400X387') }}" alt="avatar" />--}}
                                        </div>
                                        <div class="login__content">
                                            <h4 class="title">{{  $content->language->title }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- Swiper Slide -->
                            @endforeach
                        </div>
                        <div class="swiper__pagination mt-15 text-center">
                            <div class="login-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Wrapper End -->

<!-- JS -->
<script src="{{ static_asset('admin/js/jquery-3.7.1.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{ static_asset('admin/js/bootstrap.min.js')}}"></script>
<!-- fancybox -->
<script src="{{ static_asset('admin/js/jquery.fancybox.min.js')}}"></script>
<!-- swiper slider -->
<script src="{{ static_asset('admin/js/swiper-bundle.min.js')}}"></script>
<!-- aos animation -->
<script src="{{ static_asset('admin/js/aos.js')}}"></script>
<!-- Smooth Scroll -->
<script src="{{ static_asset('admin/js/smooth-scroll.js')}}"></script>
<!-- main js -->
<script src="{{ static_asset('admin/js/scripts.js')}}"></script>

<!--====== jQuery ======-->
<script src="{{ static_asset('admin/js/jquery.min.js') }}"></script>
<!--====== Bootstrap & Popper JS ======-->
<script src="{{ static_asset('admin/js/bootstrap.bundle.min.js') }}"></script>
<!--====== NiceScroll ======-->
<script src="{{ static_asset('admin/js/jquery.nicescroll.min.js') }}"></script>
<!--====== Bootstrap-Select JS ======-->
<script src="{{ static_asset('admin/js/choices.min.js') }}"></script>
<!--====== Summernote JS ======-->
<script src="{{ static_asset('admin/js/summernote-lite.min.js') }}"></script>
<!--====== Dropzone JS ======-->
<script src="{{ static_asset('admin/js/toastr.min.js') }}"></script>
<!--====== ReCAPTCHA ======-->
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

{!! Toastr::message() !!}
@if (setting('is_recaptcha_activated') && setting('recaptcha_site_key'))
    <script type="text/javascript">
        var onloadCallback = function () {
            grecaptcha.render('html_element', {
                'sitekey': '{{ setting('recaptcha_site_key') }}',
                'size': 'md'
            });
        };
    </script>
@endif
<script>
    $(document).ready(function () {
        $(document).on('click', '.instant__login a', function () {
            var type = $(this).data('type');
            if (type == 'admin') {
                $('#email').val('admin@spagreen.net');
                $('#password').val('123456');
            } else if (type == 'client') {
                $('#email').val('client@spagreen.net');
                $('#password').val('123456');
            }
            $('.ajax_form').submit();
        });
    });
</script>
</body>
</html>

