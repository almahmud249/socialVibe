<div class="col-xxl-4 col-xl-6 col-lg-6 col-md-12">
    <div class="payment-box">
        <div class="payment-icon">
            <img class="social" src="{{ static_asset('images/social-icon/linkedin.svg') }}" alt="{{__('linkedin')}}">
            <span class="title">{{ __('linkedin') }}</span>
        </div>
        @can('payment_methods.edit')
        <div class="payment-settings">
            <div class="payment-settings-btn">
                <a href="#" class="btn btn-md sg-btn-outline-primary" data-bs-toggle="modal" data-bs-target="#linkedin"><i
                        class="las la-cog"></i> <span>{{ __('config') }}</span></a>
            </div>

            <div class="setting-check">
                <input type="checkbox" id="is_linkedin_activated" value="setting-status-change/is_linkedin_activated"
                       class="status-change" {{ setting('is_linkedin_activated') ? 'checked' : '' }}>
                <label for="is_linkedin_activated"></label>
            </div>
        </div>
        @endcan
    </div>
</div>
<!-- End Payment box -->
<div class="modal fade" id="linkedin" tabindex="-1" aria-labelledby="paymentMethodLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <h6 class="sub-title">{{ __('linkedin') }} {{ __('configuration') }}</h6>
            <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <form action="{{ route('social.platform.setting') }}" method="post" class="form">@csrf
                <div class="row gx-20">
                    <input type="hidden" name="is_modal" class="is_modal" value="0">
                    <input type="hidden" name="payment_method" value="linkedin">
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('client_id') }}</label>
                            <input type="text" class="form-control rounded-2" name="linkedin_client_id"
                                   placeholder="{{ __('enter_secret_key') }}"
                                   value="{{ isDemoMode() ? '******************' : old('linkedin_client_id',setting('linkedin_client_id')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="linkedin_client_id_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('client_secret') }}</label>
                            <input type="text" class="form-control rounded-2" name="linkedin_client_secret"
                                   placeholder="{{ __('client_secret') }}"
                                   value="{{ isDemoMode() ? '******************' : old('linkedin_client_secret',setting('linkedin_client_secret')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="linkedin_client_secret_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('callback_url') }}</label>
                            <input type="text" class="form-control rounded-2" name="facebook_app_version"
                                   value="{{ route('client.accounts.callback', ['plat_form' => 'linkedin']) }}" disabled>
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
