@if ($package->hotelRoutes->count())
<div class="bg-color-theme font-size-40px text-center">Hotels Details</div>
<div class="m-top-10px width-95p m-10x-auto text-justify">
	@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
		@include('b2b.protected.dashboard.pages.package.pdf_partials.hotel_partials.index')
	@endforeach
</div>
@endif