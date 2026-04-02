<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{__('login')}}</title>
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
<section class="signup-section">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-5 col-md-8 col-sm-10 position-relative">

                <img src="{{ static_asset('admin/img/shape/rect.svg') }}" alt="Rect Shape" class="bg-rect-shape">
                <img src="{{ static_asset('admin/img/shape/circle.svg') }}" alt="Rect Shape" class="bg-circle-shape">
                <img src="{{ static_asset('admin/img/shape/circle-block.svg') }}" alt="Rect Shape" class="bg-circle-block-shape">

                <div class="login-form bg-white rounded-20">
                    <div class="logo">
                        <a href="{{ url('/') }}" class="">
                            <img class="logo mx-auto d-block mb-30" src="{{ setting('light_logo') && @is_file_exists(setting('light_logo')['original_image']) ? get_media(setting('light_logo')['original_image']) : get_media('images/default/logo/logo-dark.png') }}" alt="Corporate Logo">
                        </a>
                    </div>
                    <h3>{{__('confirm_your_password') }}</h3>
                    <form method="POST" action="{{ route('user.password-update') }}" class="form needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-12 password-input">
                                <label for="password">{{__('password') }} *</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="{{__('choose_password')}}" data-lpignore="true" required>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 nk-block-des text-danger" />
                                <div class="invalid-feedback">
                                    {{__('please_add_a_password') }}.
                                </div>
                                <div class="valid-feedback">
                                    {{__('looks_good') }}!
                                </div>
                                <span id="#password" class="fa fa-fw fa-eye toggle-password"></span>
                                @if($errors->has('password'))
                                    <div class="nk-block-des text-danger">
                                        <p>{{ $errors->first('password') }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 password-input mt-2">
                                <label for="password_confirmation">{{__('confirm_password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="{{__('choose_password')}}" data-lpignore="true" required>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 nk-block-des text-danger" />
                                <div class="invalid-feedback">
                                    {{__('please_add_a_confirm_password') }}.
                                </div>
                                <div class="valid-feedback">
                                    {{__('looks_good') }}!
                                </div>
                                <span id="#password_confirmation" class="fa fa-fw fa-eye toggle-password"></span>
                                @if($errors->has('password_confirmation'))
                                    <div class="nk-block-des text-danger">
                                        <p>{{ $errors->first('password_confirmation') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-30 mt-20"><button type="submit" class="btn btn-lg sg-btn-primary d-block w-100">{{__('submit')}}</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- JS Files -->
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

<!--====== ReCAPTCHA ======-->
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<!--====== MainJS ======-->
<script src="{{ static_asset('admin/js/app.js') }}"></script>

<script src="{{ static_asset('admin/js/toastr.min.js') }}"></script>
{!! Toastr::message() !!}
@if (setting('is_recaptcha_activated') && setting('recaptcha_site_key'))
    <script type="text/javascript">
        var onloadCallback = function() {
            grecaptcha.render('html_element', {
                'sitekey' : '{{setting('recaptcha_site_key')}}',
                'size' : 'md'
            });
        };
    </script>
@endif
</body>
</html>

