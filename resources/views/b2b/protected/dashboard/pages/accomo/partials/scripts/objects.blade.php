<?php


	$rid =  [];
	$did =  [];
	$idObject = [];
	foreach ($accomoRoutes as $accomoRouteKey  => $accomoRoute) {
		$objectKey = 'rid_'.$accomoRoute->id;
		$fid = '';
		$fdid = '';
		$accomoProps = [];
		$isAccomo = 0;

		if (!is_null($accomoRoute->fusion)) {
			$isAccomo = 1;
			$fdid = $accomoRoute->fusion->id;
			if($accomoRoute->checkMode('hotel')){
				$fid = $accomoRoute->fusion->hotel_code;
				foreach ($accomoRoute->fusion->packageRooms as $packageRoom) {
					$selRooms = ['id' => $packageRoom->id, 'vdr' => $packageRoom->vendor];
					$accomoProps[$packageRoom->roomtype_code] = $selRooms;
				}
			}
			elseif ($accomoRoute->checkMode('cruise')) {
				$fid = $accomoRoute->fusion->cruise_code;
				foreach ($accomoRoute->fusion->packageCabins as $packageCabins) {
					$selCabins = ['id' => $packageCabins->id, 'vdr' => $packageCabins->vendor];
					$accomoProps[$packageCabins->cabintype_code] = $selCabins;
				}
			}
		}

		$idObject[$objectKey] = [
				'fid' 				=> $fid,
				'nrid' 				=> 'NaN',
				'fdid' 				=> $fdid,
				'elem_id' 		=> $objectKey,
				'props'				=> $accomoProps,
				'rid' 				=> $accomoRoute->id,
				'mode'				=> $accomoRoute->mode,
				'origin'			=> $accomoRoute->origin,
				'destination' => $accomoRoute->destination,
				'breakfast'		=> $accomoRoute->is_breakfast,
				'is_drop_off'	=> $accomoRoute->is_drop_off,
				'is_pick_up'	=> $accomoRoute->is_pick_up,
				'drop_off'		=> $accomoRoute->drop_off,
				'dinner'			=> $accomoRoute->is_dinner,
				'lunch'				=> $accomoRoute->is_lunch,
				'pick_up'			=> $accomoRoute->pick_up,
				'is_accommo'	=> $isAccomo,
			];

		$nextAccomoRouteKey = $accomoRouteKey+1;
		
		if ($nextAccomoRouteKey < $accomoRoutes->count()) {
			$idObject[$objectKey]['nrid'] = $package
																			->accomoRoutes[$nextAccomoRouteKey]->id;
		}
		
		$rid[] = $accomoRoute->id;
	}

	$idObject['rid'] = $rid;
	$idObject['crid'] = $accomoRoutes[0]->id;
	$idObject = rejson_decode($idObject);

	// dd($accomoRoutes->pluck('route_formatted', 'token'));
?>

{{-- making an object which contain some ids --}}
<script>
	var idObject = {!! json_encode($idObject) !!};
</script>
