@if ($package->cruiseRoutes->count())
<div class="bg-color-theme font-size-40px text-center">Cruises Details</div>
<div class="m-top-10px width-95p m-10x-auto text-justify">
	@foreach ($package->cruiseRoutes as $cruiseRouteKey => $cruiseRoute)
		@include('b2b.protected.dashboard.pages.package.pdf_partials.cruise_partials.index')
	@endforeach
</div>
@endif