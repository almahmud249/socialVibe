@extends('backend.layouts.master')
@section('title', __('plans'))
@section('content')
    <section class="oftions">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center justify-content-between mb-12">
                        <h3 class="section-title">{{__('available_plans')}}</h3>
                    </div>
                    @include('backend.common.flash')
                    <div class="pricingTab__area">
                        <!-- Tab List -->
                        <div class="tablist">
                            <div class="custom__tabs text-center">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link active"
                                            id="monthly_pricing-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#monthly_pricing"
                                            type="button"
                                            role="tab"
                                            aria-controls="monthly_pricing"
                                            aria-selected="true"
                                        >
                                            monthly
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button
                                            class="nav-link"
                                            id="yearly_pricing-tab"
                                            data-bs-toggle="pill"
                                            data-bs-target="#yearly_pricing"
                                            type="button"
                                            role="tab"
                                            aria-controls="yearly_pricing"
                                            aria-selected="false"
                                            tabindex="-1"
                                        >
                                            Yearly
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Tab Content Start -->
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="monthly_pricing" role="tabpanel">
                                <div class="row gx-20 justify-content-center">
                                    @foreach( $monthlyPackages as $key => $package)
                                        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                                            <div class="package-default mb-4 mb-xl-0">

                                                <div class="package-header package-header-color text-center">
                                                    <h4 class="pt-2 pb-2">{{ $package->name }}</h4>
                                                    <p>{{ $package->description }}</p>
                                                </div>

                                                <div class="package-content">
                                                    <h2 class="package-pirce text-center">{{ get_price($package->price)}}</h2>
                                                    <ul>
                                                        <li class="d-flex align-items-center justify-content-between py-2 px-30">
                                                            <p>{{ __('profile_limit') }}</p>
                                                            <span>{{ $package->profile_limit === -1 ? __('unlimited') : $package->profile_limit }}</span>
                                                        </li>
                                                        <li class="d-flex align-items-center justify-content-between py-2 px-30">
                                                            <p>{{ __('post_limit') }}</p>
                                                            <span>{{ $package->post_limit === -1 ? __('unlimited') : $package->post_limit }}</span>
                                                        </li>
                                                        <li class="d-flex align-items-center justify-content-between py-2 px-30">
                                                            <p>{{ __('team_limit') }}</p>
                                                            <span>{{ $package->team_limit === -1 ? __('unlimited') : $package->team_limit }}</span>
                                                        </li>
                                                        <li class="d-flex align-items-center justify-content-between py-2 px-30">
                                                            <p>{{ __('billing_period') }}</p>
                                                            <span>{{ ucwords($package->billing_period) }}</span>
                                                        </li>
                                                    </ul>
                                                    <div class="mt-2 mb-4 text-center">
                                                        @if(@auth()->user()->client->activeSubscription->plan_id == $package->id)
                                                            <a class="btn btn-sm btn-secondary btn-lg disabled">
                                                                <span>{{__('current_subscription')}}</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('client.upgrade.plan', $package->id) }}" class="btn sg-btn-primary">
                                                                <span>{{__('upgrade')}}</span>
                                                            </a>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="yearly_pricing" role="tabpanel">
                                <div class="row gx-20 justify-content-center">
                                    @foreach( $yearlyPackages as $key => $package)
                                        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                                            <div class="package-default mb-4 mb-xl-0">

                                                <div class="package-header package-header-color text-center">
                                                    <h4 class="pt-2 pb-2">{{ $package->name }}</h4>
                                                    <p>{{ $package->description }}</p>
                                                </div>

                                                <div class="package-content">
                                                    <h2 class="package-pirce text-center">{{ get_price($package->price)}}</h2>
                                                    <ul>
                                                        <li class="d-flex align-items-center justify-content-between py-2 px-30">
                                                            <p>{{ __('profile_limit') }}</p>
                                                            <span>{{ $package->profile_limit === -1 ? __('unlimited') : $package->profile_limit }}</span>
                                                        </li>
                                                        <li class="d-flex align-items-center justify-content-between py-2 px-30">
                                                            <p>{{ __('post_limit') }}</p>
                                                            <span>{{ $package->post_limit === -1 ? __('unlimited') : $package->post_limit }}</span>
                                                        </li>
                                                        <li class="d-flex align-items-center justify-content-between py-2 px-30">
                                                            <p>{{ __('team_limit') }}</p>
                                                            <span>{{ $package->team_limit === -1 ? __('unlimited') : $package->team_limit }}</span>
                                                        </li>
                                                        <li class="d-flex align-items-center justify-content-between py-2 px-30">
                                                            <p>{{ __('billing_period') }}</p>
                                                            <span>{{ ucwords($package->billing_period) }}</span>
                                                        </li>
                                                    </ul>
                                                    <div class="mt-2 mb-4 text-center">
                                                        @if(@auth()->user()->client->activeSubscription->plan_id == $package->id)
                                                            <a class="btn btn-sm btn-secondary btn-lg disabled">
                                                                <span>{{__('current_subscription')}}</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('client.upgrade.plan', $package->id) }}" class="btn sg-btn-primary">
                                                                <span>{{__('upgrade')}}</span>
                                                            </a>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

