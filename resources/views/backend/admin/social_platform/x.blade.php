<div class="col-xxl-4 col-xl-6 col-lg-6 col-md-12">
    <div class="payment-box">
        <div class="payment-icon">
            <img class="social" src="{{ static_asset('images/social-icon/x.svg') }}" alt="{{__('x')}}">
            <span class="title">{{ __('x') }}</span>
        </div>
        @can('payment_methods.edit')
        <div class="payment-settings">
            <div class="payment-settings-btn">
                <a href="#" class="btn btn-md sg-btn-outline-primary" data-bs-toggle="modal" data-bs-target="#x"><i
                        class="las la-cog"></i> <span>{{ __('config') }}</span></a>
            </div>

            <div class="setting-check">
                <input type="checkbox" id="is_x_activated" value="setting-status-change/is_x_activated"
                       class="status-change" {{ setting('is_x_activated') ? 'checked' : '' }}>
                <label for="is_x_activated"></label>
            </div>
        </div>
        @endcan
    </div>
</div>
<!-- End Payment box -->
<div class="modal fade" id="x" tabindex="-1" aria-labelledby="paymentMethodLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <h6 class="sub-title">{{ __('x') }} {{ __('configuration') }}</h6>
            <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <form action="{{ route('social.platform.setting') }}" method="post" class="form">@csrf
                <div class="row gx-20">
                    <input type="hidden" name="is_modal" class="is_modal" value="0">
                    <input type="hidden" name="payment_method" value="x">
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('api_key') }}</label>
                            <input type="text" class="form-control rounded-2" name="x_api_key"
                                   placeholder="{{ __('enter_api_key') }}"
                                   value="{{ isDemoMode() ? '******************' : old('x_api_key',setting('x_api_key')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="x_client_id_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('secret_key') }}</label>
                            <input type="text" class="form-control rounded-2" name="x_secret_key"
                                   placeholder="{{ __('enter_secret_key') }}"
                                   value="{{ isDemoMode() ? '******************' : old('x_secret_key',setting('x_secret_key')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="x_secret_key_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('access_token') }}</label>
                            <input type="text" class="form-control rounded-2" name="x_access_token"
                                   placeholder="{{ __('access_token') }}"
                                   value="{{ isDemoMode() ? '******************' : old('x_access_token',setting('x_access_token')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="x_client_secret_error error"></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('access_token_secret') }}</label>
                            <input type="text" class="form-control rounded-2" name="x_access_token_secret"
                                   placeholder="{{ __('access_token_secret') }}"
                                   value="{{ isDemoMode() ? '******************' : old('x_access_token_secret',setting('x_access_token_secret')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="x_access_token_secret_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('client_id') }}</label>
                            <input type="text" class="form-control rounded-2" name="x_client_id"
                                   placeholder="{{ __('client_id') }}"
                                   value="{{ isDemoMode() ? '******************' : old('x_client_id',setting('x_client_id')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="x_client_id_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('client_secret') }}</label>
                            <input type="text" class="form-control rounded-2" name="x_client_secret"
                                   placeholder="{{ __('client_secret') }}"
                                   value="{{ isDemoMode() ? '******************' : old('x_client_secret',setting('x_client_secret')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="x_client_secret_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('callback_url') }}</label>
                            <input type="text" class="form-control rounded-2" name="facebook_app_version"
                                   value="{{ route('client.accounts.callback', ['plat_form' => 'twitter']) }}" disabled>
                        </div>
                    </div>
                </div>
                <!-- END Permissions Tab====== -->
                <div class="d-flex justify-content-end align-items-center mt-30">
                    <button type="submit" class="btn sg-btn-primary">{{ __('save') }}</button>
                    @include('backend.common.loading-btn',['class' => 'btn sg-btn-primary'])
                </div>
            </form>
        </div>
    </div>
</div>
