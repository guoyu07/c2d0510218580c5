@if ($package->cars->count())
	<div class="bg-color-theme font-size-40px text-center">Cars Details</div>
	<div class="m-top-10px width-95p m-10x-auto">
		@foreach ($package->cars as $car)
			@if ($car->selected_car_vendor == 'ss')
				@include('b2b.protected.dashboard.pages.package.pdf_partials.car_partials.skyscanner_cars')
			@endif
		@endforeach
	</div>
@endif