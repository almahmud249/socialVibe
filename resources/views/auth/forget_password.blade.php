{{--<!doctype html>--}}
{{--<html lang="en" dir="ltr">--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <title>{{__('login')}}</title>--}}
{{--    <!--====== LineAwesome ======-->--}}
{{--    <link rel="stylesheet" href="{{ static_asset('admin/css/line-awesome.min.css') }}">--}}
{{--    <!--====== Dropzone CSS ======-->--}}
{{--    <link rel="stylesheet" href="{{ static_asset('admin/css/dropzone.min.css') }}">--}}
{{--    <!--====== Summernote CSS ======-->--}}
{{--    <link rel="stylesheet" href="{{ static_asset('admin/css/summernote-lite.min.css') }}">--}}
{{--    <!--====== Choices CSS ======-->--}}
{{--    <link rel="stylesheet" href="{{ static_asset('admin/css/choices.min.css') }}">--}}
{{--    <!--====== AppCSS ======-->--}}
{{--    <link rel="stylesheet" href="{{ static_asset('admin/css/app.css') }}">--}}
{{--    <!--====== ResponsiveCSS ======-->--}}
{{--    <link rel="stylesheet" href="{{ static_asset('admin/css/responsive.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ static_asset('admin/css/toastr.min.css') }}">--}}
{{--    @php--}}
{{--        $icon = setting('admin_favicon');--}}
{{--    @endphp--}}
{{--    @if ($icon)--}}
{{--        <link rel="apple-touch-icon" sizes="57x57"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_57x57_url']) ? static_asset($icon['image_57x57_url']) : static_asset('images/default/favicon/favicon-57x57.png') }}">--}}
{{--        <link rel="apple-touch-icon" sizes="60x60"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_60x60_url']) ? static_asset($icon['image_60x60_url']) : static_asset('images/default/favicon/favicon-60x60.png') }}">--}}
{{--        <link rel="apple-touch-icon" sizes="72x72"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_72x72_url']) ? static_asset($icon['image_72x72_url']) : static_asset('images/default/favicon/favicon-72x72.png') }}">--}}
{{--        <link rel="apple-touch-icon" sizes="76x76"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_76x76_url']) ? static_asset($icon['image_76x76_url']) : static_asset('images/default/favicon/favicon-76x76.png') }}">--}}
{{--        <link rel="apple-touch-icon" sizes="114x114"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_114x114_url']) ? static_asset($icon['image_114x114_url']) : static_asset('images/default/favicon/favicon-114x114.png') }}">--}}
{{--        <link rel="apple-touch-icon" sizes="120x120"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_120x120_url']) ? static_asset($icon['image_120x120_url']) : static_asset('images/default/favicon/favicon-120x120.png') }}">--}}
{{--        <link rel="apple-touch-icon" sizes="144x144"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_144x144_url']) ? static_asset($icon['image_144x144_url']) : static_asset('images/default/favicon/favicon-144x144.png') }}">--}}
{{--        <link rel="apple-touch-icon" sizes="152x152"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_152x152_url']) ? static_asset($icon['image_152x152_url']) : static_asset('images/default/favicon/favicon-152x152.png') }}">--}}
{{--        <link rel="apple-touch-icon" sizes="180x180"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_180x180_url']) ? static_asset($icon['image_180x180_url']) : static_asset('images/default/favicon/favicon-180x180.png') }}">--}}
{{--        <link rel="icon" type="image/png" sizes="192x192"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_192x192_url']) ? static_asset($icon['image_192x192_url']) : static_asset('images/favicon-192x192.png') }}">--}}
{{--        <link rel="icon" type="image/png" sizes="32x32"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_32x32_url']) ? static_asset($icon['image_32x32_url']) : static_asset('images/default/favicon/favicon-32x32.png') }}">--}}
{{--        <link rel="icon" type="image/png" sizes="96x96"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_96x96_url']) ? static_asset($icon['image_96x96_url']) : static_asset('images/default/favicon/favicon-96x96.png') }}">--}}
{{--        <link rel="icon" type="image/png" sizes="16x16"--}}
{{--              href="{{ $icon != [] && @is_file_exists($icon['image_16x16_url']) ? static_asset($icon['image_16x16_url']) : static_asset('images/default/favicon/favicon-16x16.png') }}">--}}
{{--        <meta name="msapplication-TileColor" content="#ffffff">--}}
{{--        <meta name="msapplication-TileImage"--}}
{{--              content="{{ $icon != [] && @is_file_exists($icon['image_144x144_url']) ? static_asset($icon['image_144x144_url']) : static_asset('images/default/favicon/favicon-144x144.png') }}">--}}
{{--    @else--}}
{{--        <link rel="apple-touch-icon" sizes="57x57"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-57x57.png')}}">--}}
{{--        <link rel="apple-touch-icon" sizes="60x60"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-60x60.png')}}">--}}
{{--        <link rel="apple-touch-icon" sizes="72x72"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-72x72.png')}}">--}}
{{--        <link rel="apple-touch-icon" sizes="76x76"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-76x76.png')}}">--}}
{{--        <link rel="apple-touch-icon" sizes="114x114"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-114x114.png')}}">--}}
{{--        <link rel="apple-touch-icon" sizes="120x120"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-120x120.png')}}">--}}
{{--        <link rel="apple-touch-icon" sizes="144x144"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-144x144.png')}}">--}}
{{--        <link rel="apple-touch-icon" sizes="152x152"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-152x152.png')}}">--}}
{{--        <link rel="apple-touch-icon" sizes="180x180"--}}
{{--              href="{{ static_asset('images/default/favicon/apple-icon-180x180.png')}}">--}}
{{--        <link rel="icon" type="image/png" sizes="192x192"--}}
{{--              href="{{ static_asset('images/default/favicon/android-icon-192x192.png')}}">--}}
{{--        <link rel="icon" type="image/png" sizes="32x32"--}}
{{--              href="{{ static_asset('images/default/favicon/favicon-32x32.png')}}">--}}
{{--        <link rel="icon" type="image/png" sizes="96x96"--}}
{{--              href="{{ static_asset('images/default/favicon/favicon-96x96.png')}}">--}}
{{--        <link rel="icon" type="image/png" sizes="16x16"--}}
{{--              href="{{ static_asset('images/default/favicon/favicon-16x16.png')}}">--}}
{{--        <meta name="msapplication-TileColor" content="#ffffff">--}}
{{--        <meta name="msapplication-TileImage" content="{{ static_asset('images/default/favicon/ms-icon-144x144.png')}}">--}}
{{--        <meta name="theme-color" content="#ffffff">--}}
{{--    @endif--}}
{{--</head>--}}
{{--<body>--}}
{{--<section class="signup-section">--}}
{{--    <div class="container">--}}
{{--        <div class="row justify-content-center align-items-center min-vh-100">--}}
{{--            <div class="col-lg-5 col-md-8 col-sm-10 position-relative">--}}

{{--                <img src="{{ static_asset('admin/img/shape/rect.svg') }}" alt="Rect Shape" class="bg-rect-shape">--}}
{{--                <img src="{{ static_asset('admin/img/shape/circle.svg') }}" alt="Rect Shape" class="bg-circle-shape">--}}
{{--                <img src="{{ static_asset('admin/img/shape/circle-block.svg') }}" alt="Rect Shape" class="bg-circle-block-shape">--}}

{{--                <div class="login-form bg-white rounded-20">--}}
{{--                    @include('backend.common.flash')--}}
{{--                    <div class="logo d-flex justify-content-center items-center mb-4">--}}
{{--                        <a  href="{{url('/')}}">--}}
{{--                            <img style="max-height: 35px" src="{{ setting('dark_logo') && @is_file_exists(setting('dark_logo')['original_image']) ? get_media(setting('dark_logo')['original_image']) : get_media('images/default/logo/logo-dark.png') }}" alt="Corporate Logo">--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <h3>{{__('forgot_password')}}</h3>--}}
{{--                    <p>{{__('enter_your_email_address_to_recover_your_password') }}</p>--}}

{{--                    <form method="POST" action="{{ route('forgot.password-email') }}" class="needs-validation" novalidate>--}}
{{--                        @csrf--}}
{{--                        <div class="mb-30">--}}
{{--                            <label for="email" class="form-label">{{__('email')}} *</label>--}}
{{--                            <input type="text" class="form-control rounded-2" id="email" value="" name="email"  placeholder="{{ __('email') }}" required autofocus>--}}
{{--                            <x-input-error :messages="$errors->get('email')" class="mt-2 nk-block-des text-danger" />--}}
{{--                        </div>--}}
{{--                        @if (setting('is_recaptcha_activated') && setting('recaptcha_site_key'))--}}
{{--                            <div class="mb-30">--}}
{{--                                <div id="html_element" class="g-recaptcha" data-sitekey="{{setting('recaptcha_site_key')}}"></div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <div class="mb-30"><button type="submit" class="btn btn-lg sg-btn-primary d-block w-100">{{__('submit')}}</button></div>--}}
{{--                        <span class="text-center d-block">{{__('back_to')}} <a href="{{ route('login') }}" class="sg-text-primary">{{__('sign_in')}}</a>?</span>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
{{--<!-- JS Files -->--}}
{{--<!--====== jQuery ======-->--}}
{{--<script src="{{ static_asset('admin/js/jquery.min.js') }}"></script>--}}
{{--<!--====== Bootstrap & Popper JS ======-->--}}
{{--<script src="{{ static_asset('admin/js/bootstrap.bundle.min.js') }}"></script>--}}
{{--<!--====== NiceScroll ======-->--}}
{{--<script src="{{ static_asset('admin/js/jquery.nicescroll.min.js') }}"></script>--}}
{{--<!--====== Bootstrap-Select JS ======-->--}}
{{--<script src="{{ static_asset('admin/js/choices.min.js') }}"></script>--}}
{{--<!--====== Summernote JS ======-->--}}
{{--<script src="{{ static_asset('admin/js/summernote-lite.min.js') }}"></script>--}}
{{--<!--====== Dropzone JS ======-->--}}

{{--<!--====== ReCAPTCHA ======-->--}}
{{--<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>--}}
{{--<!--====== MainJS ======-->--}}
{{--<script src="{{ static_asset('admin/js/app.js') }}"></script>--}}

{{--<script src="{{ static_asset('admin/js/toastr.min.js') }}"></script>--}}
{{--{!! Toastr::message() !!}--}}
{{--@if (setting('is_recaptcha_activated') && setting('recaptcha_site_key'))--}}
{{--    <script type="text/javascript">--}}
{{--        var onloadCallback = function() {--}}
{{--            grecaptcha.render('html_element', {--}}
{{--                'sitekey' : '{{setting('recaptcha_site_key')}}',--}}
{{--                'size' : 'md'--}}
{{--            });--}}
{{--        };--}}
{{--    </script>--}}
{{--@endif--}}
{{--</body>--}}
{{--</html>--}}


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
    <link rel="shortcut icon" href="{{ static_asset('admin/images/logo/favicon.svg')}}" type="image/f-icon"/>

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
                        <form action="{{ route('forgot.password-email') }}" class="needs-validation" novalidate
                              method="POST">@csrf
                            <div class="heading__content">
                                <h2 class="title">{{__('forgot_password')}}?</h2>
                                <p class="desc">{{__('enter_your_email_address_to_recover_your_password')}}</p>
                            </div>
                            <div class="form-group">
                                <label for="email"> {{__('email')}} <span class="required">*</span> </label>
                                <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        id="email"
                                        placeholder="Your Email"
                                        required
                                />
                                @error('email')
                                <div class="badges failed">
                                    <div class="icon"><i class="ri-close-line"></i></div>
                                    <span>{{ $message }}</span>
                                </div>
                                @enderror
                            </div>
                            @if (session('success'))
                                <div class="badges">
                                    <div class="icon"><i class="ri-check-line"></i></div>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="badges failed">
                                    <div class="icon"><i class="ri-close-line"></i></div>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif
                            <div class="btn__group">
                                <button type="submit" name="btn"
                                        class="sg-btn sg-btn-primary w-100">{{__('submit')}}</button>
                            </div>
                            <div class="back__text justify-content-center">
                                <i class="ri-arrow-left-line"></i>{{__('back_to')}} <a
                                        href="{{ route('login') }}">{{__('login')}}</a>
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
                                            <img src="{{ static_asset('website/themes/default/assets/images/login-thumb.png')}}"
                                                 alt="avatar"/>
                                            {{--                                            <img src="{{ getFileLink('original_image',  $content->image,null,'400X387') }}" alt="avatar" />--}}
                                        </div>
                                        <div class="login__content">
                                            <h4 class="title">{{ $content->lang_title }}
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
</body>
</html>
