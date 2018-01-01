@if (!is_null($cruiseRoute->cruise->detail))
<?php
	$detail = $cruiseRoute->cruise->detail;
?>
	<div class="{{-- height-{{ $cruiseRouteKey == 0 ? 980 : 1000 }} px --}} p-5">
		<div>
			<div class="box-stack">
				<img src="{{ $detail->image }}" class="img-thmb">
				<b  class="font-size-20px">{{ $detail->name }}</b>
				<span>
					{!! $detail->starRatingHtml !!}
				</span>
				<hr/>
				<i>Check In : {{ $detail->startDate }} | Check Out : {{ $detail->endDate }}</i>
				<br/>
				<span><b>Location: </b>{{ $detail->location }}</span>
				<br/><br/>
				<b>About Hotel : </b>
				<span>{!! $detail->description !!}</span>
			</div>
		</div>       
	</div>
	@if ($cruiseRoute->count()-1 != $cruiseRouteKey)
		<hr {{-- class="hr-gold" --}}>
	@endif
@endif
