<!-- Pricing Section Start -->
<section class="pricing__section py-60 py-sm-40" id="pricing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title-wrapper text-center" data-aos="fade-up" data-aos-duration="800">
                    <div class="section__title">
                        <h4 class="subtitle">
                            Pricing
                            <img src="{{ static_asset('website/themes/default/assets/images/pricing.svg')}}" alt="icon" />
                        </h4>
                        <h2 class="title">{!! setting('pricing_section_title', app()->getLocale()) !!}</h2>
                        <p class="desc">{!! setting('pricing_section_subtitle', app()->getLocale()) !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" data-aos="fade-up" data-aos-duration="700">
                <!-- Pricing Tab Start -->
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
                                        {{__('monthly')}}
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
                                        {{__('yearly')}}
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Tab Content Start -->
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="monthly_pricing" role="tabpanel">
                            <div class="pricing__grid">
                                <!-- Pricing Item -->
                                @foreach ($monthlyPlans as $value)
                                <div class="pricing__item @if($value->featured == 1) active @endif">
                                    <div class="pricing__header">
                                        <h3 class="title">{{ $value->name }}</h3>
                                        <p class="desc">{{ $value->description }}</p>
                                    </div>
                                    <div class="pricing__tag">
                                        <span>{{ get_symbol() }}</span>
                                        <span class="price">{{ convert_price_without_symbol($value->price) }}/ <sub>{{ $value->billing_period }}</sub></span>
                                    </div>

                                    <ul class="pricing__features">
                                        <li>
                                            <i class="ri-checkbox-circle-fill"></i>
                                            <span>{{ $value->profile_limit === -1 ? __('unlimited') : $value->profile_limit }} {{__('social_profile')}}</span>
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-circle-fill"></i>
                                            <span>{{ $value->post_limit === -1 ? __('unlimited') : $value->post_limit }} {{__('posts_social')}}</span>
                                        </li>
                                        <li>
                                            <i class="ri-checkbox-circle-fill"></i>
                                            <span>{{ $value->team_limit === -1 ? __('unlimited') : $value->team_limit }} {{__('team_member')}}</span>
                                        </li>
                                    </ul>
                                    <div class="pricing__btn">
                                        <a class="sg-btn sg-btn-white w-100" href="#">{{__('subscribe')}}</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="yearly_pricing" role="tabpanel">
                            <div class="pricing__grid">
                                <!-- Pricing Item -->
                                @foreach ($yearlyPlans as $value)
                                    <div class="pricing__item @if($value->featured == 1) active @endif">
                                        <div class="pricing__header">
                                            <h3 class="title">{{ $value->name }}</h3>
                                            <p class="desc">{{ $value->description }}</p>
                                        </div>
                                        <div class="pricing__tag">
                                            <span>{{ get_symbol() }}</span>
                                            <span class="price">{{ convert_price_without_symbol($value->price) }}/ <sub>{{ $value->billing_period }}</sub></span>
                                        </div>

                                        <ul class="pricing__features">
                                            <li>
                                                <i class="ri-checkbox-circle-fill"></i>
                                                <span>{{ $value->profile_limit === -1 ? __('unlimited') : $value->profile_limit }} {{__('social_profile')}}</span>
                                            </li>
                                            <li>
                                                <i class="ri-checkbox-circle-fill"></i>
                                                <span>{{ $value->post_limit === -1 ? __('unlimited') : $value->post_limit }} {{__('posts_social')}}</span>
                                            </li>
                                            <li>
                                                <i class="ri-checkbox-circle-fill"></i>
                                                <span>{{ $value->team_limit === -1 ? __('unlimited') : $value->team_limit }} {{__('team_member')}}</span>
                                            </li>
                                        </ul>
                                        <div class="pricing__btn">
                                            <a class="sg-btn sg-btn-white w-100" href="#">{{__('subscribe')}}</a>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Pricing Item -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pricing Tab End -->
            </div>
        </div>
    </div>
</section>
<!-- Pricing Section End -->
