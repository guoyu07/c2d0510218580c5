{{-- making an object which contain some ids --}}
<?php 
	$rid =  [];
	$idObject = [];
	$crid = '';
	foreach ($package->activityRoutes as $activityRouteKey  => $activityRoute) {

		if ($activityRouteKey == 0) $crid = $activityRoute->id;

		// date object here
		$minDate = date_differences($activityRoute->start_date, date("Y-m-d"));
		$maxDate = date_differences($activityRoute->end_date, date("Y-m-d"));

	
		// id's object here
		$objectKey = 'rid_'.$activityRoute->id;

		$idObject[$objectKey] = [
				'rid' => $activityRoute->id,
				'nrid' => 'NaN',
				'origin' => $activityRoute->origin,
				'destination' => $activityRoute->destination,
				'startDate' => $activityRoute->start_datetime->format('d-m-Y'),
				'endDate' => $activityRoute->end_datetime->format('d-m-Y'),
				'minDate' => $minDate,
				'maxDate' => $maxDate
			];

		$nextactivityRouteKey = $activityRouteKey+1;
		
		if ($nextactivityRouteKey < $package->activityRoutes->count()) {
			$idObject[$objectKey]['nrid'] = $package
																					->activityRoutes[$nextactivityRouteKey]->id;
		}

		$rid[] = $activityRoute->id;
	}

	$idObject['rid'] = $rid;
	$idObject['crid'] = $crid;
	$idObject = rejson_decode($idObject);

?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
	var modeObj = {!! json_encode($indication->toKeyValue('act_mode', ['' => 'Mode'])) !!};

	var timingObj = {!! json_encode($indication->toKeyValue('timing', ['' => 'Timing'])) !!};
</script>