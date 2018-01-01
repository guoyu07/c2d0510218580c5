@if ($package->hotelRoutes->count())
<div class="bg-color-theme font-size-40px text-center">Inclusion</div>
<div class="width-95p m-10x-auto">
	@foreach ($package->hotelRoutes as $hotelRoute)
		<?php 
			$location = $hotelRoute->destination_detail;
			$selectedActivities = $hotelRoute->activities->selectedActivities;
		?>
		@foreach ($selectedActivities as $selectedActivity)
			@include('b2b.protected.dashboard.pages.package.pdf_partials.activities_partials.index')
		@endforeach
	@endforeach
</div>
@endif
