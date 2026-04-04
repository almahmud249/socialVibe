@extends('backend.layouts.master')
@section('title', __('dashboard'))
@push('css')
	<link rel="stylesheet" href="{{ static_asset('admin/css/dropzone.min.css') }}">
@endpush
@section('content')
	<section class="oftions">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-4">
					<div class="bg-white redious-border mb-4 p-20 p-sm-30">
						<div class="row">
							<div class="col-md-12 mb-3">
								<div class="analytics-content mb-1">
									<h4>{{ __('hello') }} {{ Auth()->user()->first_name }},</h4>
									<p>{{ __('empower_your_business_with') }} {{ setting('system_name') }}</p>
								</div>
							</div>
							<div class="col-md-12">
								<div class="analytics clr-6">
									<div class="analytics-icon">
										<i class="las la-check-double"></i>
									</div>
									<div class="analytics-content">
										<h4>Solo Workspace</h4>
										<p>{{ __('manage_post') }} & {{ __('social_profile') }}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xxl-9 col-xl-8 col-lg-8 col-md-8">
					<div class="row">
						<div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
							<a href="{{ route('client.posts.index', ['type' => 'index']) }}">
								<div class="bg-white redious-border mb-4 p-20 p-sm-30 analytics-box">
									<div class="analytics clr-2">
										<div class="analytics-icon">
											<svg width="28" height="28" viewBox="0 0 24 24"
											     xmlns="http://www.w3.org/2000/svg" data-name="Layer 1">
												<path d="m23.121.879c-1.17-1.17-3.072-1.17-4.242 0l-6.707 6.707c-.756.755-1.172 1.76-1.172 2.828v1.586c0 .552.447 1 1 1h1.586c1.068 0 2.073-.417 2.828-1.172l6.707-6.707c1.164-1.117 1.164-3.126 0-4.243zm-1.414 2.828-6.707 6.707c-.378.378-.88.586-1.414.586h-.586v-.586c0-.526.214-1.042.586-1.414l6.707-6.707c.391-.39 1.023-.39 1.414 0 .388.372.388 1.042 0 1.414zm-9.707 14.293c-.553 0-1-.447-1-1s.447-1 1-1h3c.553 0 1 .447 1 1s-.447 1-1 1zm8-4v5c0 2.757-2.243 5-5 5h-10c-2.757 0-5-2.243-5-5v-14c0-2.757 2.243-5 5-5h9c.553 0 1 .448 1 1s-.447 1-1 1h-9c-1.654 0-3 1.346-3 3v14c0 1.654 1.346 3 3 3h10c1.654 0 3-1.346 3-3v-5c0-.553.447-1 1-1s1 .447 1 1zm-10.833-2.333-1.687 1.687c-.431.431-.995.648-1.561.648-.533 0-1.066-.193-1.491-.582l-.669-.579c-.417-.362-.462-.994-.101-1.411.363-.419.994-.461 1.411-.101l.689.598c.103.093.228.092.307.013l1.687-1.687c.391-.391 1.023-.391 1.414 0s.391 1.023 0 1.414zm0-4.96-1.687 1.687c-.431.431-.995.648-1.561.648-.533 0-1.066-.193-1.491-.582l-.669-.579c-.417-.362-.462-.994-.101-1.411.363-.418.994-.461 1.411-.101l.689.598c.103.094.228.092.307.013l1.687-1.687c.391-.391 1.023-.391 1.414 0s.391 1.023 0 1.414zm0 8.546c.391.391.391 1.023 0 1.414l-1.687 1.687c-.431.431-.995.648-1.561.648-.533 0-1.066-.193-1.491-.582l-.669-.579c-.417-.362-.462-.993-.101-1.411.363-.417.994-.462 1.411-.101l.689.598c.103.093.228.092.307.013l1.687-1.687c.391-.391 1.023-.391 1.414 0z" fill="#3F52E3"/>
											</svg>
										</div>
										<div class="analytics-content">
											<h4>{{ $usages['post'] }}</h4>
											<p>{{ __('total_post') }}</p>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
							<div class="bg-white redious-border mb-4 p-20 p-sm-30 analytics-box">
								<div class="analytics clr-6">
									<div class="analytics-icon">
										<i class="las la-users"></i>
									</div>
									<div class="analytics-content">
										<h4>{{ ReadableNumbers::make($usages['total_social_profile']) }}</h4>
										<p>{{ __('social_profile') }}</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
							<a href="{{ route('client.posts.index', ['type' => 'index']) }}">
								<div class="bg-white redious-border mb-4 p-20 p-sm-30 analytics-box">
									<div class="analytics clr-3">
										<div class="analytics-icon">
											<svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" id="Layer_1"
											     data-name="Layer 1" viewBox="0 0 24 24">
												<path d="m10,5.857h2v5.731l-4.372,2.429-.971-1.748,3.343-1.857v-4.555ZM2,11C2,6.038,6.037,2,11,2c4.109,0,7.694,2.775,8.716,6.749,0,0,0,0,0,.001.106.409.175.828.221,1.25h2c-.054-.591-.137-1.178-.284-1.75,0,0,0,0,0-.002C20.402,3.392,16.022,0,11,0,4.935,0,0,4.935,0,11c0,4.762,3.037,8.961,7.557,10.45.792.261,1.611.426,2.443.501v-2.03c-.618-.068-1.229-.177-1.818-.371-3.697-1.218-6.182-4.654-6.182-8.55Zm22,5v8h-12v-8c0-1.103.897-2,2-2v-2h2v2h4v-2h2v2c1.103,0,2,.897,2,2Zm-2,6v-4h-8v4h8Z"
												      fill="#3F52E3"/>
											</svg>
										</div>
										<div class="analytics-content">
											<h4>{{ReadableNumbers::make($usages['scheduled_post']) }}</h4>
											<p>{{ __('scheduled_post') }}</p>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
							<a href="{{ route('client.posts.index', ['type' => 'index']) }}">
								<div class="bg-white redious-border mb-4 p-20 p-sm-30 analytics-box">
									<div class="analytics clr-4">
										<div class="analytics-icon">
											<i class="las la-file-alt"></i>
										</div>
										<div class="analytics-content">
											<h4>{{ReadableNumbers::make($usages['draft_post']) }}</h4>
											<p>{{ __('draft_post') }}</p>
										</div>

									</div>
								</div>
							</a>
						</div>
						<div class="col-xxl-4 col-xl-4 col-md-6 col-sm-6">
							<a href="{{ route('client.posts.index', ['type' => 'index']) }}">
								<div class="bg-white redious-border mb-4 p-20 p-sm-30 analytics-box">
									<div class="analytics clr-2">
										<div class="analytics-icon">
											<i class="las la-bullhorn"></i>
										</div>
										<div class="analytics-content">
											<h4>{{ ReadableNumbers::make($usages['public_post']) }}</h4>
											<p>{{ __('published_post') }}</p>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-6 col-md-6">
					<div class="bg-white redious-border mb-4 pt-20 p-30">
						<div class="section-top">
							<h4>{{ __('post_statistic') }}</h4>
						</div>
						<div class="statistics-report">
							<div class="row">
							</div>
						</div>
						<div class="statistics-report-chart">
							<canvas id="post_statistic"></canvas>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-md-6">
					<div class="bg-white redious-border mb-4 pt-20 p-30">
						<div class="section-top">
							<h4>{{ __('today_scheduled_post') }}</h4>
						</div>
						<div class="statistics-report">
							<div class="row">
							</div>
						</div>
						<div class="statistics-report-chart">
							<canvas id="today_scheduled_post"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="bg-white redious-border mb-4 pt-20 p-30">
						<div class="section-top">
							<h4>{{ __('scheduled_post') }}</h4>
						</div>
						<div class="statistics-report">
							<div class="row">
							</div>
						</div>
						<div class="statistics-report-chart">
							<canvas id="scheduled_post_statistic"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<input type="hidden" id="today_scheduled_post_charts_data" value="{{ json_encode($today_scheduled_post_charts) }}">
	<input type="hidden" id="scheduled_post_charts_data" value="{{ json_encode($scheduled_post_charts) }}">
	<input type="hidden" id="post_statistic_charts_data" value="{{ json_encode($post_statistic_charts) }}">
@endsection
@push('js')
	<script src="{{ static_asset('admin/js/chart.min.js') }}"></script>
@endpush
@push('js')
	<script src="{{ static_asset('admin\js\custom\dashboard\client_dashboard_chart.js') }}"></script>
@endpush
