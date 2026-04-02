@extends('backend.layouts.master')
@section('title', isset($plan) ? __('edit_plan') : __('create_plan'))
@section('content')
    <section class="oftions">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="section-title">{{ isset($plan) ? __('edit_plan') : __('create_plan') }}</h3>
                    <div class="bg-white redious-border p-20 p-sm-30">
                        @php
                            $route = isset($plan) ? route('plans.update', $plan->id) : route('plans.store');
                        @endphp
                        <form action="{{ $route }}" class="form-validate form" method="POST">
                            @csrf
                            @isset($plan)
                                @method('PUT')
                            @endisset
                            <div class="row gx-20">
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label for="planName" class="form-label">{{ __('plan_name') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-2" id="planName" name="name"
                                            value="{{ isset($plan) ? $plan->name : '' }}"
                                            placeholder="{{ __('plan_name') }}">
                                        <div class="nk-block-des text-danger">
                                            <p class="name_error error"></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Package Name -->

                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <label for="description" class="form-label">{{ __('description') }}</label>
                                        <textarea class="form-control" name="description" placeholder="{{ __('description') }}" id="description">{{ isset($plan) ? $plan->description : '' }}</textarea>
                                        <div class="nk-block-des text-danger">
                                            <p class="description_error error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 custom-control custom-checkbox contacts-list">
                                    <div class="mb-2 mt-2">
                                        <label for="is_free" class="custom-control-label pb-4">
                                            <input type="checkbox" class="custom-control-input read common-key pb-4"
                                                   name="is_free" value="1" id="is_free"
                                                    {{ @$plan->is_free == 1 ? 'checked' : '' }}>
                                            <span>{{ __('is_free') }}</span>
                                        </label>
                                        <div class="nk-block-des text-danger">
                                            <p class="is_free_error error"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class=col-lg-3>
                                    <div class="mb-4">
                                        <label for="planPrice" class="form-label">{{ __('plan_price') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control rounded-2"
                                            value="{{ isset($plan) ? priceFormatUpdate($plan->price, '*') : '' }}"
                                            id="planPrice" name="price" placeholder="{{ __('plan_price') }}"
                                            min="-1" step="0.01">
                                        <div class="nk-block-des text-danger">
                                            <p class="price_error error"></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Package Price -->

                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="planValidity" class="form-label">{{ __('billing_period') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="select-type-v2">
                                            <select id="planValidity" name="billing_period"
                                                class="form-select form-select-lg mb-3 without_search">
                                                <option value="monthly" @selected(isset($plan) ? $plan->billing_period == 'monthly' : '')>{{ __('monthly') }}
                                                </option>
                                                <option value="yearly" @selected(isset($plan) ? $plan->billing_period == 'yearly' : '')>{{ __('yearly') }}
                                                </option>
                                            </select>
                                            <div class="nk-block-des text-danger">
                                                <p class="billing_period_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Package Validity -->

                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="profile_limit" class="form-label">{{ __('profile_limit') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control rounded-2" id="profile_limit"
                                            name="profile_limit" value="{{ isset($plan) ? $plan->profile_limit : '' }}"
                                            placeholder="{{ __('profile_limit') }} (enter -1 for unlimited)" min="-1">
                                        <small> <span style="font-style: italic;"
                                                class="text-muted text-sm">{{ __('set_to_unlimited_if_negative_one') }}</span></small>
                                        <div class="nk-block-des text-danger">
                                            <p class="profile_limit_error error"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- End Course Upload Limit -->

                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="post_limit" class="form-label">{{ __('post_limit') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="select-type-v2">
                                            <input type="number" class="form-control rounded-2" id="post_limit"
                                                name="post_limit"
                                                value="{{ isset($plan) ? $plan->post_limit : '' }}"
                                                placeholder="{{ __('post_limit') }}" min="-1">
                                            <small> <span style="font-style: italic;"
                                                    class="text-muted text-sm">{{ __('set_to_unlimited_if_negative_one') }}</span></small>
                                            <div class="nk-block-des text-danger">
                                                <p class="post_limit_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Course Bundle -->
                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="team_limit" class="form-label">{{ __('team_limit') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control rounded-2" id="team_limit"
                                            name="team_limit" value="{{ isset($plan) ? $plan->team_limit : '' }}"
                                            placeholder="{{ __('team_limit') }}" min="-1">
                                        <small> <span style="font-style: italic;"
                                                class="text-muted text-sm">{{ __('set_to_unlimited_if_negative_one') }}</span></small>
                                        <div class="nk-block-des text-danger">
                                            <p class="team_limit_error error"></p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="color" class="form-label">{{ __('color') }}</label>
                                        <input type="color" class="colorpicker form-control rounded-2" id="colorPicker"
                                            name="color" value="{{ isset($plan) ? $plan->color : '#e0e8f9' }}"
                                            placeholder="{{ __('color') }}">
                                        <div class="nk-block-des text-danger">
                                            <p class="color_error error"></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Course Upload Limit -->


                                @if (setting('is_stripe_activated') && setting('stripe_secret') && setting('stripe_key'))
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="stripe_plan_key"
                                                class="form-label">{{ __('stripe_plan_key') }}<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" value="{{ $stripe_key ?? '' }}"
                                                class="form-control rounded-2" id="stripe_plan_key" name="stripe"
                                                placeholder="{{ __('stripe_plan_key') }}">
                                            <div class="nk-block-des text-danger">
                                                <p class="stripe_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (setting('paypal_client_id') && setting('paypal_client_secret') && setting('is_paypal_activated'))
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="paypal_plan_id" class="form-label">{{ __('paypal_plan_id') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control rounded-2" id="paypal_plan_id"
                                                name="paypal" placeholder="{{ __('paypal_plan_id') }}"
                                                value="{{ $paypal ?? '' }}">
                                            <div class="nk-block-des text-danger">
                                                <p class="paypal_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (setting('paddle_api_key') && setting('is_paddle_activated'))
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="paypal_plan_id" class="form-label">{{ __('paddle_price_id') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control rounded-2" id="price_id"
                                                name="paddle" placeholder="{{ __('paddle_price_id') }}"
                                                value="{{ $paddle ?? '' }}">
                                            <div class="nk-block-des text-danger">
                                                <p class="paddle_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (setting('razor_pay_key') && setting('razor_pay_secret') && setting('is_razor_pay_activated'))
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label for="paypal_plan_id" class="form-label">{{ __('razor_pay_plan_id') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control rounded-2" id="razor_pay_plan_id"
                                                name="razor_pay" placeholder="{{ __('razor_pay_plan_id') }}"
                                                value="{{ $razor_pay ?? '' }}">
                                            <div class="nk-block-des text-danger">
                                                <p class="razor_pay_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="featured" class="form-label">{{ __('featured') }}</label>
                                        <div class="select-type-v2">
                                            <select id="featured" class="form-select form-select-lg mb-3 without_search"
                                                name="featured">
                                                <option value="1" @selected(isset($plan) && $plan->featured == '1')>{{ __('yes') }}
                                                </option>
                                                <option value="0" @selected(isset($plan) && $plan->featured != '1')>{{ __('no') }}
                                                </option>
                                            </select>
                                            <div class="nk-block-des text-danger">
                                                <p class="featured_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Live Class Facilities -->

                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="planStatus" class="form-label">{{ __('plan_status') }}</label>
                                        <div class="select-type-v2">
                                            <select id="planStatus" class="form-select form-select-lg mb-3 without_search"
                                                name="status">
                                                <option @selected(isset($plan) && $plan->status == '1') value="1" selected>
                                                    {{ __('active') }}</option>
                                                <option @selected(isset($plan) && $plan->status != '1') value="0">{{ __('inactive') }}
                                                </option>
                                            </select>
                                            <div class="nk-block-des text-danger">
                                                <p class="status_error error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Package Status -->
                                <div class="d-flex justify-content-end align-items-center mt-30">
                                    <button type="submit" class="btn sg-btn-primary">{{ __('submit') }}</button>
                                    @include('backend.common.loading-btn', [
                                        'class' => 'btn sg-btn-primary',
                                    ])
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('js')
        <script>
            $(document).ready(function() {
                $('#is_free').change(function() {
                    var isFreeChecked = $(this).is(':checked');
                    var planPriceInput = $('#planPrice');

                    if (isFreeChecked) {
                        planPriceInput.val('0').prop('readonly', true);
                    } else {
                        planPriceInput.val('').prop('readonly', false);
                    }
                });
            });
        </script>
    @endpush
@endsection
