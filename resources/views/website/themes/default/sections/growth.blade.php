<!-- Growth Section Start -->
@if (setting('growth_section_enable') == 1)
<section class="growth__section py-60 py-sm-40">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title-wrapper text-center" data-aos="fade-up" data-aos-duration="800">
                    <div class="section__title">
                        <h2 class="title">{!! setting('growth_section_title', app()->getLocale()) !!}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flex-lg-row flex-column-reverse" data-aos="fade-up" data-aos-duration="700">
            <div class="col-xl-5 col-lg-6 col-md-12">
                <div class="custom__accordion">
                    <div class="accordion" id="accordionExample">
                        @foreach($growth_list as $growth)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                        class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $growth->id }}"
                                        aria-expanded="true"
                                        aria-controls="collapse{{ $growth->id }}"
                                >
                                    {{ $growth->language->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $growth->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p class="desc">
                                        {{ $growth->language->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 col-md-12">
                <div class="growth__thumb">
                    <img src="{{ getFileLink('original_image', setting('growth_section_thumbnail'),null,'484x314') }}" alt="growth" />
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- Growth Section End -->
