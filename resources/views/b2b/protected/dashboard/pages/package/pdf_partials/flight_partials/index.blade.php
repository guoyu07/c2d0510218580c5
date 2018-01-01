<div class="border-gray m-top-20px">
	<table width="100%">
	@foreach ($flightRoute->flight->flight_details as $flightDetail)
		<tr>
			<td width="40%">
				<table width="100%">
						<tr>
							<td width="30%">
								<div>
									<img 
										src="{{ urlImageAirline($flightDetail->code) }}" 
										alt="{{ $flightDetail->name }}" 
										style="height: 50px; width:50px;"
									>
								</div>
							</td>
							<td width="70%">
								<div>
									<div>{{ $flightDetail->name }}</div>
									<div>
										<small class="m-top-10px">
											{{ $flightDetail->code.$flightDetail->flightNumber }}
										</small>
									</div>
								</div>
							</td>
						</tr>
				</table>
			</td>
			<td width="30%">
				<table width="100%">
						<tr>
							<td>
								<div>{{ $flightDetail->departureTime }}</div>
								<div class="{{-- m-top-10px --}}">
									<small>
										{{ date_formatter($flightDetail->departureDate, null, 'd/m/Y') }}
									</small>
								</div>
							</td>
							<td>
								<div>{{ $flightDetail->arrivalTime }}</div>
								<div class="{{-- m-top-10px --}}">
									<small>
										{{ date_formatter($flightDetail->arrivalDate, null, 'd/m/Y') }}
									</small>
								</div>
							</td>
						</tr>
				</table>
			</td>
			<td>
				<span>{{ $flightDetail->originCode }} → {{ $flightDetail->destinationCode }}</span>
			</td>
		</tr>
	@endforeach
	</table>
</div>
