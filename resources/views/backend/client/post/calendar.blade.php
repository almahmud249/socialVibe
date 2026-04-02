@extends('backend.layouts.master')
@section('title', __('post'))
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="header-top d-flex justify-content-between align-items-center">
					<h3 class="section-title">{{ __('create_post') }}</h3>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="bg-white redious-border p-20 p-sm-30">
					<div id="calendar"></div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script src='{{ static_asset('client/js/full-calendar.min.js') }}'></script>
	<script>
        document.addEventListener('DOMContentLoaded', function() {
            let events = @json($schedules);
            const parsedEvents = events.map(event => ({
                title: event.title,
                start: event.start,
                end: event.end,
                {{--url: '{{ url('/client/posts/index') }}'+'/'+event.post_id--}}
                url: '{{ url('/client/posts/index') }}'
            }));
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',  // Left section of toolbar
                    center: 'title',          // Center section (Month name, Year)
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,list' // Right section buttons
                },
                buttonText : {
                    today:    '{{ __('Today') }}',
                    month:    '{{ __('Month') }}',
                    week:     '{{ __('Week') }}',
                    day:      '{{ __('Day') }}',
                    list:     '{{ __('List') }}'
                },
                weekNumbers : true,
                eventSources: [
                    // your event source
                    {
                        /*url: '{{ url()->current() }}',
                        method: 'GET',
                        extraParams: {
                            custom_param1: 'something',
                        },
                        failure: function(response) {
                            alert('there was an error while fetching events!');
                        },
                        success: function (response) {


                            calendar.addEventSource(parsedEvents);
                        },*/
                        color: 'var(--bs-primary)',
                        textColor: 'black',
                        backgroundColor : 'var(--bs-primary)',
                    }

                    // any other sources...

                ],
	            events : parsedEvents
            });
            calendar.render();
        });
	</script>
@endpush