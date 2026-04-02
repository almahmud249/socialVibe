<!-- Clients Area Start -->
<div class="clients__area">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="clients__content" data-aos="fade-up" data-aos-duration="700">
					<h5 class="title">{{__('our_clients')}}:</h5>
					<div class="clients__wrapper">
						<!-- Clients Item Start -->
						@foreach($ourClients as $ourClient)
						<div class="clients__item">
							<img src="{{ getFileLink('original_image',  $ourClient->image) }}" alt="clients" />
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Clients Area End -->