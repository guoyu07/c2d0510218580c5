<?php 
	$rid =  [];
	$did =  [];
	$idObject = [];
	foreach ($package->cruiseRoutes as $hotelRouteKey  => $hotelRoute) {
		$objectKey = 'cruise_'.$hotelRoute->id;
		$hid = '';
		$hdid = '';
		$dbRooms = [];

		if (!is_null($hotelRoute->fusion)) {
			$hid = $hotelRoute->fusion->hotel_code;
			$hdid = $hotelRoute->fusion->id;
			foreach ($hotelRoute->fusion->packageRooms as $packageRoom) {
				$dbRooms[$packageRoom->roomtype_code] = $packageRoom->id;
			}
		}

		$idObject[$objectKey] = [
				'next_rid' 		=> 'NaN',
				'elem_id' 		=> $objectKey,
				'rid' 				=> $hotelRoute->id,
				'origin'			=> $hotelRoute->origin,
				'destination' => $hotelRoute->destination,
				'hid' 	=> $hid,
				'hdid' 	=> $hdid,
				'rooms'				=> $dbRooms
			];

		$nesthotelRouteKey = $hotelRouteKey+1;
		
		if ($nesthotelRouteKey < $package->cruiseRoutes->count()) {
			$idObject[$objectKey]['next_rid'] = $package
																					->cruiseRoutes[$nesthotelRouteKey]->id;
		}
		
		$rid[] = $hotelRoute->id;
	}

	$idObject['rid'] = $rid;
	$idObject = rejson_decode($idObject);
?>
{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
</script>
