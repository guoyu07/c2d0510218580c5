<div class="p-top-15px bg-color-theme font-size-40px text-center p-10"><i>Your Package Detail</i></div>
	<div class="bg-color-theme p-10">
		<table class="color-white font-size-20px" width="100%">
			<tr>
				<td width="50%">
					<table><tr>
						<td><img src=" {{ urlImage('images/pdf/Location-icon-white.png') }}" width="35px"></td>
						<td>
							<table>
								<tr><td>Package Id: </td></tr>
								<tr><td>{{ $package->uid }}</td></tr>
							</table>
						</td>
					</tr></table>
				</td>
				<td width="50%">
					<table><tr>
						<td><img src=" {{ urlImage('images/pdf/duration.png') }}" width="35px"></td>
						<td>
							<table>
								<tr><td>Duration: </td></tr>
								<tr><td>
									{{ $package->nights }} Nights {{ $package->nights+1 }} Days
								</td></tr>
							</table>
						</td>
					</tr></table>
				</td>
			</tr>
			<tr>
				<td width="50%">
					<table><tr>
						<td><img src=" {{ urlImage('images/pdf/dateoftravel.png') }}" width="35px"></td>
						<td>
							<table>
								<tr><td>Date of Travel: </td></tr>
								<tr><td>
									{{ $package->start_date->format('d-M-Y') }} to 
									{{ $package->end_date->format('d-M-Y') }}
								</td></tr>
							</table>
						</td>
					</tr></table>
				</td>
				<td width="50%">
					<table><tr>
						<td><img src=" {{ urlImage('images/pdf/passanger.png') }}" width="35px"></td>
						<td>
							<table>
								<tr><td>Package Cost: </td></tr>
								<tr><td>
									{{ isset($package->cost->total_cost) ? '₹ '.$package->cost->total_cost : "" }}
								</td></tr>
							</table>
						</td>
					</tr></table>
				</td>
			</tr>
		</table>
	</div>