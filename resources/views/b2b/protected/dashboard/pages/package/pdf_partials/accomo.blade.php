@if ($package->accomoRoutes->count())
<div class="m-bottom-20px">
	<div class="bg-color-theme font-size-40px text-center">Accommodation</div>
	<div class="width-95p m-10x-auto text-justify">
		@foreach ($package->accomoRoutes as $accomoRoute)
			@include('b2b.protected.dashboard.pages.package.pdf_partials.accomo_partials.index')
		@endforeach
	</div>
</div>
@endif