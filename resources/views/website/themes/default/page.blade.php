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
						<h2 class="title">{!! $page_info->title !!}</h2>
						<div class="breadcrumb__meta">
							<p>{{ __('last_updated') }} {{ \Carbon\Carbon::parse($page_info->created_at)->format('jS F, Y') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Breadcrumb Section End -->

<!-- Privacy Policy Section Start -->
<section class="privacy__section py-40 pb-100">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="privacy__content" data-aos="fade-up" data-aos-duration="800">
					{!! $page_info->content !!}
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Privacy Policy Section End -->
@push('js')
@endpush
@endsection
