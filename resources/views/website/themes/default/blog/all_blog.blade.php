@extends('website.themes.' . active_theme() . '.master')
@section('content')
	@push('css')
	@endpush
	<section class="breadcrumb__section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="breadcrumb__wrapper" data-aos="fade-up" data-aos-duration="700">
						<div class="breadcrumb__header text-center">
							<h2 class="title">{!! setting('blog_section_title', app()->getLocale()) !!}</h2>
							<p>{!! setting('blog_section_subtitle', app()->getLocale()) !!}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Breadcrumb Section End -->

	<!-- BlogPage Section Start -->
	<section class="blogPage__section py-60 py-sm-40 pb-100" data-aos="fade-up" data-aos-delay="300">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="filter__area">
						<div class="search__filter">
							<select class="form-select" aria-label="Default select example">
								<option value="1">{{__('newest')}}</option>
								<option value="2">{{__('oldest')}}</option>
							</select>
						</div>
						<form action="#" class="search__form">
							<div class="form-group">
								<input type="search" name="search" class="form-control" placeholder="Search blog"/>
								<button type="submit" class="submit"><i class="ri-search-line"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row blog_list" id="blog-cards">
				@foreach($blogs as $key => $blog)
					@php if($key == 6) continue; @endphp
					<div class="col-lg-4 col-md-6 blog-single-card" data-aos="fade-up" data-aos-delay="300">
						<div class="blogPost">
							<div class="thumb">
								<img src="{{ getFileLink('original_image',  $blog->image,null,'1200x630') }}"
								     alt="{{ $blog->title }}"/>
								<div class="meta">
									<span>{{ $blog->user->name }}</span>
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
									<span>Date - {{ \Carbon\Carbon::parse($blog->published_date)->format('M d, Y') }}</span>
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
			@if(count($blogs) > 6)
				<div class="col-12">
					<div class="loadMore__btn text-center mt-10">
						<a href="javascript:void(0)" class="sg-btn sg-btn-primary"
						   onclick="loadMore()">{{__('load_more')}}</a>
					</div>
				</div>
			@endif
		</div>
	</section>
	@push('js')
		<script>
            function loadMore() {
                var count = $('.blog-single-card').length;
                $.ajax({
                    url: "{{ route('all.blog') }}",
                    type: "GET",
                    data: {limit: count},
                    success: function (response) {
                        console.log(response);
                        let blogList = $("#blog-cards");
                        if (response.length > 0) {
                            response.forEach(function (blog) {
                                blogList.append(`
                                <div class="col-lg-4 col-md-6 blog-single-card" data-aos="fade-up" data-aos-delay="300">
                                    <div class="blogPost">
                                        <div class="thumb">
                                            <img src="{{ getFileLink('original_image',  $blog->image,null,'1200x630') }}" alt="${blog.title}" />
                                            <div class="meta">
                                                <span><a href="#">${blog.user.first_name + ' ' + blog.user.last_name}</a></span>
                                                <span><a href="#">${blog.category.title}</a></span>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="title">
                                                <a href="/blog/${blog.slug}">${blog.title}</a>
                                            </div>
                                            <p class="desc">${blog.short_description}</p>
                                            <div class="blog__footer">
                                                <span>Date - {{ \Carbon\Carbon::parse($blog->published_date)->format('M d, Y') }}</span>
                                                <span>
                                                    <a href="/blog/${blog.slug}" class="solid__btn">Read more<i class="ri-arrow-right-line"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                            })
                        }
                        if (response.length < 6) {
                            $(".loadMore__btn").addClass('d-none');
                        }
                    }
                })
            }

            $(document).ready(function () {

                function fetchBlogs() {
                    let searchQuery = $('input[name="search"]').val();
                    let sortBy = $('.search__filter select').val();

                    $.ajax({
                        url: "{{ route('filter.blogs') }}",
                        type: "GET",
                        data: {search: searchQuery, sort: sortBy},
                        success: function (response) {
                            let blogList = $(".blog_list");
                            blogList.empty();

                            if (response.length > 0) {
                                response.forEach(function (blog) {
                                    blogList.append(`
                                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                                    <div class="blogPost">
                                        <div class="thumb">
                                            <img src="{{ getFileLink('original_image',  $blog->image,null,'1200x630') }}" alt="${blog.title}" />
                                            <div class="meta">
                                                <span><a href="#">${blog.user.first_name + ' ' + blog.user.last_name}</a></span>
                                                <span><a href="#">${blog.category.title}</a></span>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="title">
                                                <a href="/blog/${blog.slug}">${blog.title}</a>
                                            </div>
                                            <p class="desc">${blog.short_description}</p>
                                            <div class="blog__footer">
                                                <span>Date - {{ \Carbon\Carbon::parse($blog->published_date)->format('M d, Y') }}</span>
                                                <span>
                                                    <a href="/blog/${blog.slug}" class="solid__btn">Read more<i class="ri-arrow-right-line"></i></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                                });
                            } else {
                                blogList.append('<div class="col-12"><p>{{__('no_blogs_found.')}}</p></div>');
                            }
                        }
                    });
                }

                // Trigger fetchBlogs on search and sort change
                $('input[name="search"]').on('keyup', fetchBlogs);
                $('.search__filter select').on('change', fetchBlogs);
            });
		</script>
	@endpush
@endsection