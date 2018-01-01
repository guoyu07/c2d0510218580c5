<?php 
	$rid =  [];
	$did =  [];
	$idObject = [];
	foreach ($package->hotelRoutes as $hotelRouteKey  => $hotelRoute) {
		$objectKey = 'hotel_'.$hotelRoute->id;
		$hid = '';
		$hdid = '';
		$hotelRooms = [];

		if (!is_null($hotelRoute->fusion)) {
			$hid = $hotelRoute->fusion->hotel_code;
			$hdid = $hotelRoute->fusion->id;
			foreach ($hotelRoute->fusion->packageRooms as $packageRoom) {
				$hotelRooms[$packageRoom->roomtype_code] = $packageRoom->id;
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
				'rooms'				=> $hotelRooms
			];

		$nesthotelRouteKey = $hotelRouteKey+1;
		
		if ($nesthotelRouteKey < $package->hotelRoutes->count()) {
			$idObject[$objectKey]['next_rid'] = $package
																					->hotelRoutes[$nesthotelRouteKey]->id;
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
