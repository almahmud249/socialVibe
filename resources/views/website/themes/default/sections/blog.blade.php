<!-- Blog Section Start -->
<section class="blog__section py-60 py-sm-40 pb-100" id="blog">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section__title-wrapper flex-item" data-aos="fade-up" data-aos-duration="800">
					<div class="section__title">
						<h2 class="title">{!! setting('blog_section_title', app()->getLocale()) !!}</h2>
					</div>
					<div class="btn__link">
						<a href="{{ route('all.blog') }}" class="solid__btn">{{__('see_all_blogs')}}<i class="ri-arrow-right-line"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			@foreach($blogs as $blog)
				<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
					<div class="blogPost">
						<div class="thumb">
							<img src="{{ getFileLink('original_image',  $blog->image,null,'1200x630') }}" alt="{{ $blog->title }}" />
							<div class="meta">
								<span>{{ $blog->user->name }} </span>
								<span>{{ $blog->category->title }} </span>
							</div>
						</div>

						<div class="content">
							<div class="title">
								<a href="{{ route('blog.details',$blog->slug) }}">{{ $blog->title }}</a>
							</div>
							<p class="desc">
								{{ $blog->short_description }}
							</p>
							<div class="blog__footer">
								<span>{{__('date')}} - {{ \Carbon\Carbon::parse($blog->published_date)->format('M d, Y') }}</span>
								<span>
										<a href="{{ route('blog.details',$blog->slug) }}" class="solid__btn">{{__('read_more')}}<i
													class="ri-arrow-right-line"></i></a>
									</span>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>
<!-- Blog Section End -->