<?php 
	$carRequest = $car->request;
	$days = $car->days;
	$skyScannerCar = $car->skyScannerCar->car;
?>

@if (!is_null($skyScannerCar))
	<div class="border-gray m-top-20px">
		<table width="100%">
			<tbody>
				<tr>
					<td width="20%">
						<img src="{{ ifset($skyScannerCar->image_url) }}" style="height: 100px; width:130px;">
					</td>
					<td width="100%">
						<table width="100%">
							<tbody>
								<tr>
									<td colspan="2" width="100%">
										<h2>{{ ifset($skyScannerCar->vehicle) }}</h2>
									</td>
								</tr>
								<tr>
									<td colspan="2" width="100%">
										<b>Days : </b>{{ $days }} | 
										<b>Car Type : </b>{{ ifset($skyScannerCar->sipp) }} | 
										<b>Seats : </b>{{ ifset($skyScannerCar->seats) }} | 
										<b>Doors : </b>{{ ifset($skyScannerCar->doors) }} | 
										<b>Air Conditioning : </b>
										{{ ifset($skyScannerCar->air_conditioning) ? "Yes" : "No" }}
									</td>
								</tr>
								<tr>
									<td width="50%">
										<b>From : </b>{{ ifset($carRequest->start_place) }}
									</td>
									<td width="50%">
										<b>To : </b>{{ ifset($carRequest->end_place) }}
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
@endif