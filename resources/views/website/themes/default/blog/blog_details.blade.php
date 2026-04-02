@extends('website.themes.' . active_theme() . '.master')
@section('content')
	@push('css')
	@endpush
<!-- Breadcrumb Section Start -->
<section class="breadcrumb__section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="breadcrumb__wrapper" data-aos="fade-up" data-aos-duration="700">
					<div class="breadcrumb__header text-center">
						<h2 class="title">{{ $blog->language->title }}</h2>
						<div class="breadcrumb__meta">
							<p><a href="{{ route('all.blog') }}">{{ setting('blog_section_title', $lang) }}</a></p>
							<p>{{__('blog_details')}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Breadcrumb Section End -->

<!-- Blog Single Page Start -->
<section class="blogSingle__section py-60 py-sm-40 pb-100" data-aos="fade-up" data-aos-delay="300">
	<div class="container">
		<div class="row">
			<div class="col-xl-9 col-lg-8">
				<div class="blogSingle__wrapper">
					<div class="blogPost v2">
						<div class="thumb">
							<img src="{{ getFileLink('original_image',  $blog->image,null,'1200x630') }}" alt="blog" />

							<div class="meta">
								<span>{{ $blog->user->Name }} </span>
								<span>{{ $blog->category->title }} </span>
							</div>
						</div>

						<div class="content">
							<div
									class="d-flex align-items-sm-center justify-content-between gap-3 pb-20 border-bottom mb-20 flex-sm-row flex-column"
							>
								<div class="title mb-0">
									{{ $blog->language->title }}
								</div>
								<div class="blog__footer mt-0">
									<span>{{__('date')}} - {{ \Carbon\Carbon::parse($blog->published_date)->format('M d, Y') }}</span>
								</div>
							</div>
							<p class="desc">
								{{ $blog->language->description }}
							</p>
						</div>
					</div>
					<!-- Pagination Start -->
					<div class="pagination">
						@if($previous_blogs)
							<a href="{{ route('blog.details', $previous_blogs->slug) }}" class="active">
								<i class="ri-arrow-left-s-line"></i>
							</a>
						@else
							<a href="javascript:void(0);" class="disabled">
								<i class="ri-arrow-left-s-line"></i>
							</a>
						@endif

						@if($next_blogs)
							<a href="{{ route('blog.details', $next_blogs->slug) }}">
								<i class="ri-arrow-right-s-line"></i>
							</a>
						@else
							<a href="javascript:void(0);" class="disabled">
								<i class="ri-arrow-right-s-line"></i>
							</a>
						@endif
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-4">
				<div class="blog__sidebar">
					<form action="#" class="search__form mw-100">
						<div class="form-group">
							<input type="search" name="search" class="form-control" placeholder="Search blog" />
							<button type="submit" class="submit"><i class="ri-search-line"></i></button>
						</div>
					</form>
					<!-- Aside Start -->
					@if($related_blogs->count()>0)
					<div class="aside">
						<h4 class="widget__title">{{__('related_blogs')}}</h4>
						<ul class="widget__list filter_blog">
							@foreach($related_blogs as $activeBlog)
							<li>
								<a href="{{ route('blog.details',$activeBlog->slug) }}" class="widget__item">
									<div class="thumb">
										<img src="{{ getFileLink('original_image',  $activeBlog->image,null,'60x60') }}" alt="blog" />
									</div>
									<div class="content">
										<h5>{{ $activeBlog->language->title }}</h5>
									</div>
								</a>
							</li>
							@endforeach
						</ul>
					</div>
					@endif
					<!-- Aside Start -->
					<div class="aside">
						<h4 class="widget__title">{{__('share_with')}}</h4>
						<div class="social__icon">
							@php
								$blogUrl = urlencode(route('blog.details', $blog->slug));
								$blogTitle = urlencode($blog->language->title);
							@endphp
							<a href="https://www.facebook.com/sharer/sharer.php?u={{ $blogUrl }}" target="_blank">
								<i class="ri-facebook-circle-fill"></i>
							</a>
{{--							<a href="#"><i class="ri-instagram-line"></i></a>--}}
							<!-- LinkedIn -->
							<a href="https://www.linkedin.com/shareArticle?url={{ $blogUrl }}&title={{ $blogTitle }}" target="_blank">
								<i class="ri-linkedin-box-fill"></i>
							</a>
							<!-- Twitter (X) -->
							<a href="https://twitter.com/intent/tweet?url={{ $blogUrl }}&text={{ $blogTitle }}" target="_blank">
								<i class="ri-twitter-fill"></i>
							</a>
{{--							<a href="#"><i class="ri-youtube-fill"></i></a>--}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- BlogPage Section End -->
	@push('js')
		<script>
            $(document).ready(function () {
                $('input[name="search"]').on('keyup', function () {
                    let searchQuery = $(this).val();

                    $.ajax({
                        url: "{{ route('filter.blogs') }}",
                        type: "GET",
                        data: { search: searchQuery },
                        success: function (response) {
                            let blogList = $(".filter_blog");
                            blogList.empty();

                            if (response.length > 0) {
                                response.forEach(function (blog) {
                                    blogList.append(`
                                <li>
                                    <a href="/blog/${blog.slug}" class="widget__item">
                                        <div class="thumb">
                                            <img src="{{ static_asset('website/themes/default/assets/images/blog/blog-01.jpg')}}" alt="blog" />
                                        </div>
                                        <div class="content">
                                            <h5>${blog.language.title}</h5>
                                        </div>
                                    </a>
                                </li>
                            `);
                                });
                            } else {
                                blogList.append('<li>No blogs found.</li>');
                            }
                        }
                    });
                });
            });
		</script>
	@endpush
@endsection