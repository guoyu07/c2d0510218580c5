@if ($package->flightRoutes->count())
<div class="m-bottom-20px{{-- min-height-1000px --}}">
	<div class="bg-color-theme font-size-40px text-center">Flights</div>
	<div class="width-95p m-10x-auto text-justify">
		@foreach ($package->flightRoutes as $flightRoute)
			@if (isset($flightRoute->flight->flight_details) && 
			!is_null($flightRoute->flight->flight_details))
				@include('b2b.protected.dashboard.pages.package.pdf_partials.flight_partials.index')
			@endif
		@endforeach
	</div>
</div>
@endif