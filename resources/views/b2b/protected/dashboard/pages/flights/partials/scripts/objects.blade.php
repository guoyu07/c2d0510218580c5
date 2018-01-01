<?php 
	$rid =  [];
	$did =  [];
	$idObject = [];
	foreach ($package->flightRoutes as $flightRouteKey  => $flightRoute) {
		$objectKey = 'flight_'.$flightRoute->id;

		$idObject[$objectKey] = [
				'next_rid' 		=> 'NaN',
				'elem_id' 		=> $objectKey,
				'rid' 				=> $flightRoute->id,
				'origin' 			=> $flightRoute->origin,
				'destination' => $flightRoute->destination,
			];

		$nextFlightRouteKey = $flightRouteKey+1;
		
		if ($nextFlightRouteKey < $package->flightRoutes->count()) {
			$idObject[$objectKey]['next_rid'] = $package
																					->flightRoutes[$nextFlightRouteKey]->id;
		}

		$rid[] = $flightRoute->id;
	}

	$idObject['rid'] = $rid;
	$idObject['crid'] = $package->flightRoutes[0]->id;
	$idObject = rejson_decode($idObject);
?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
</script>
{{-- /making an object which contain some ids --}}
