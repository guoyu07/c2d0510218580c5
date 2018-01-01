@if (!is_null($hotelRoute->hotel->detail))
<?php
	$hotelDetail = $hotelRoute->hotel->detail;
?>
	<div class="{{-- height-{{ $hotelRouteKey == 0 ? 980 : 1000 }} px --}} p-5">
		<div>
			<div class="box-stack">
				<img src="{{ $hotelDetail->image }}" class="img-thmb">
				<b  class="font-size-20px">{{ $hotelDetail->name }}</b>
				<span>
					{!! $hotelDetail->starRatingHtml !!}
				</span>
				<hr/>
				<i>Check In : {{ $hotelDetail->startDate }} | Check Out : {{ $hotelDetail->endDate }}</i>
				<br/>
				<span><b>Location: </b>{{ $hotelDetail->location }}</span>
				<br/><br/>
				<b>About Hotel : </b>
				<span>{!! $hotelDetail->description !!}</span>
			</div>
		</div>       
	</div>
	@if ($hotelRoute->count()-1 != $hotelRouteKey)
		<hr {{-- class="hr-gold" --}}>
	@endif
@endif
