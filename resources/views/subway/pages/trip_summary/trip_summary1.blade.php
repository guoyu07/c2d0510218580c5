<article class="item">
	<header>
		<h1 class="title">trip summary</h1>
	</header>
	<div class="content clearfix">
		@if ($package->flightRoutes->count())
			<h3><strong>Flights Included ({{$package->flightRoutes->count()}} X Flight)</strong></h3>
			<ul>
				@foreach ($package->flightRoutes as $key => $value)
					<li>
						{{ $value->origin_detail->destination }} to 
						{{ $value->destination_detail->destination }}.
						@if ($key == 1 && $key < ($package->flightRoutes->count()-1))
							... <a href="{{ $urlObj->url('flights') }}">more</a>
							@break
						@endif
					</li>
				@endforeach
			</ul>
		@endif

		@if ($package->hotelRoutes->count())
			<h3><strong>Hotels Included ({{$package->hotelRoutes->count()}} X Hotel)</strong></h3>
			<ul>
				@foreach ($package->hotelRoutes as $key => $value)
					<li>
						{{ $value->hotelDetail()->name }}.
						@if ($key == 1 && $key < ($package->hotelRoutes->count()-1))
							... <a href="{{ $urlObj->url('accommodation') }}">more</a>
							@break
						@endif
					</li>
				@endforeach
			</ul>
		@endif

		@if ($package->cruiseRoutes->count())
			<h3><strong>Hotels Included ({{$package->hotelRoutes->count()}} X Cruise)</strong></h3>
			<ul>
				@foreach ($package->cruiseRoutes as $key => $value)
					<li>
						{{ $value->cruiseDetail()->name }}.
						@if ($key == 1 && $key < ($package->cruiseRoutes->count()-1))
							... <a href="{{ $urlObj->url('accommodation') }}">more</a>
							@break
						@endif
					</li>
				@endforeach
			</ul>
		@endif


		@if ($package->activities->count())
			<h3><strong>Activities Included ({{$package->activities->count()}} X Activity)</strong></h3>
			<ul>
				@foreach ($package->activities as $key => $value)
					<li>
						{{ $value->activityObject()->name }}.
						@if ($key == 1 && $key < ($package->activities->count()-1))
							... <a href="{{ $urlObj->url('activities') }}">more</a>
							@break
						@endif
					</li>
				@endforeach
			</ul>
		@endif
		
	</div>
</article>