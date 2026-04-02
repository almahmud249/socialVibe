<!-- faq Section Start -->
<section class="accordion__section pb-60 pb-sm-40" id="faq">
    <div class="container">
        <div class="row">
            <div class="12">
                <div class="custom__accordion v2" data-aos="fade-up" data-aos-duration="700">
                    <div class="section__title-wrapper text-center" data-aos="fade-up" data-aos-duration="700">
                        <div class="section__title">
                            <h4 class="subtitle">
                                {{__('faq')}}
                                <img src="{{ static_asset('website/themes/default/assets/images/question.svg')}}" alt="icon" />
                            </h4>
                            <h2 class="title">{!! setting('faq_section_title', app()->getLocale()) !!}</h2>
                        </div>
                    </div>
                    <div class="accordion" id="accordionExample02" data-aos="fade-up" data-aos-duration="700">
                        @foreach ($faqs as $_key => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_{{ $_key }}">
                                <button
                                        class="accordion-button {{ $_key == '0' ? '' : 'collapsed' }}"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#faqcollapseOne_{{ $_key }}"
                                        aria-expanded="true"
                                        aria-controls="faqcollapseOne_{{ $_key }}"
                                >
                                    {{ $faq->lang_question }}
                                </button>
                            </h2>
                            <div id="faqcollapseOne_{{ $_key }}" class="accordion-collapse collapse {{ $_key == '0' ? 'show' : '' }}" data-bs-parent="#accordionExample02">
                                <div class="accordion-body">
                                    <p class="desc">
                                        {!! $faq->lang_answer !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- faq Section End -->
