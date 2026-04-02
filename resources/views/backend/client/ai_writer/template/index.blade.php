@extends('backend.layouts.master')
@section('title', __('templates'))
@section('content')
	<section class="oftions">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col col-lg-12 col-md-9">
					<div class="header-top d-flex justify-content-between align-items-center">
						<h3 class="section-title">{{__('template') }}</h3>
						<div class="oftions-content-right mb-12 gap-2">
							<div>
								<a href="#" class="d-flex align-items-center btn sg-btn-primary gap-2">
									<i class="las la-sync"></i>
									<span>{{__('lode_template')}}</span>
								</a>
							</div>
							<a href="javascript:void(0)" class="d-flex align-items-center btn sg-btn-primary gap-2" data-bs-toggle="modal" data-bs-target="#template">
								<i class="las la-plus"></i>
								<span>{{__('add_new') }}</span>
							</a>
						</div>
					</div>
					<div class="bg-white redious-border p-20 p-sm-30 pt-sm-30">
						<div class="row">
							<div class="col-lg-12">
								<div class="default-list-table table-responsive yajra-dataTable">
									{{ $dataTable->table() }}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal fade" id="template" tabindex="-1" aria-labelledby="template" aria-hidden="false">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<h6 class="sub-title create_sub_title">{{__('create_templates') }}</h6>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
				@include('backend.client.ai_writer.template.create')
			</div>
		</div>
	</div>
	@include('backend.common.delete-script')
@endsection
@push('js')
	{{ $dataTable->scripts() }}
@endpush


