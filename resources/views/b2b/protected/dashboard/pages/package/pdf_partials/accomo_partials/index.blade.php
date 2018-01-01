<?php
	$detail = null;
	$roomTypeWord = '';
	if ($accomoRoute->mode == 'hotel') {
		$detail = $accomoRoute->hotel->detail;
		$roomTypeWord = 'Room Type';
	}
	elseif ($accomoRoute->mode == 'cruise') {
		$detail = $accomoRoute->cruise->detail;
		$roomTypeWord = 'Cabin';
	}
?>
@if (!is_null($detail))
	<div class="border-gray m-top-20px">
		<table width="100%">
			<tbody>
				<tr>
					<td width="20%">
						<img src="{{ $detail->image }}" style="height: 100px; width:130px;">
					</td>
					<td width="70%">
						<div>
							<b>{{ $detail->name }}</b>
							<span>{!! $detail->starRatingHtml !!}</span>
						</div>
						<div class="m-top-5px">
							<b>Location: </b><span>{{ $detail->location }}</span>
						</div>
						<div class="m-top-5px">
							<b>{{ $roomTypeWord }}: </b><span>{{ $detail->roomType }}</span>
						</div>
						<div class="m-top-20px">
							<i>Check In : {{ $detail->startDate }} | Check Out : {{ $detail->endDate }}</i>
						</div>
					</td>
					<td width="10%">
						<span>{{ $detail->nights }} Nights</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
@endif
