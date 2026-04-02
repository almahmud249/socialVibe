<div class="col-xxl-4 col-xl-6 col-lg-6 col-md-12">
    <div class="payment-box">
        <div class="payment-icon">
            <img class="social" src="{{ static_asset('images/social-icon/threads.svg') }}" alt="{{__('threads')}}">
            <span class="title">{{ __('threads') }}</span>
        </div>
        @can('payment_methods.edit')
        <div class="payment-settings">
            <div class="payment-settings-btn">
                <a href="#" class="btn btn-md sg-btn-outline-primary" data-bs-toggle="modal" data-bs-target="#threads"><i
                        class="las la-cog"></i> <span>{{ __('config') }}</span></a>
            </div>
            <div class="setting-check">
                <input type="checkbox" id="is_threads_activated" value="setting-status-change/is_threads_activated"
                       class="status-change" {{ setting('is_threads_activated') ? 'checked' : '' }}>
                <label for="is_threads_activated"></label>
            </div>
        </div>
        @endcan
    </div>
</div>
<!-- End Payment box -->
<div class="modal fade" id="threads" tabindex="-1" aria-labelledby="paymentMethodLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <h6 class="sub-title">{{ __('threads') }} {{ __('configuration') }}</h6>
            <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <form action="{{ route('social.platform.setting') }}" method="post" class="form">@csrf
                <div class="row gx-20">
                    <input type="hidden" name="is_modal" class="is_modal" value="0">
                    <input type="hidden" name="payment_method" value="threads">
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('client_id') }}</label>
                            <input type="text" class="form-control rounded-2" name="threads_client_id"
                                   placeholder="{{ __('enter_api_key') }}"
                                   value="{{ isDemoMode() ? '******************' : old('threads_client_id',setting('threads_client_id')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="x_client_id_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('client_secret') }}</label>
                            <input type="text" class="form-control rounded-2" name="threads_client_secret"
                                   placeholder="{{ __('enter_secret_key') }}"
                                   value="{{ isDemoMode() ? '******************' : old('threads_client_secret',setting('threads_client_secret')) }}">
                            <div class="nk-block-des text-danger">
                                <p class="x_secret_key_error error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">{{ __('callback_url') }}</label>
                            <input type="text" class="form-control rounded-2" name="thread_redirect_url"
                                   value="{{ route('client.accounts.callback', ['plat_form' => 'threads']) }}" disabled>
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
