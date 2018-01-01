<article class="item">
	<header>
		<h1 class="title">trip summary</h1>
	</header>
	<div class="content clearfix">
		<table width="100%" class="table-lborder table-trip-sum">
			<tr>
				<td>
					@if ($package->flightRoutes->count())
						<strong>Flights Included {{-- ({{$package->flightRoutes->count()}} X Hotel) --}}</strong>
						<ul class="nomargin">
							@foreach ($package->flightRoutes as $key => $value)
								<?php
									$line = $value->origin_detail->location.' to '.$value->destination_detail->location;
								?>
								@if ($key < 2)
									<li>
										{{ $line }}.
										@if ($key == 1 && $key < ($package->flightRoutes->count()-1))
											<a href="#" class="btn-more-less" >... more</a>
										@endif
									</li>
								@else
									<li class="more" style="display: none;">
										{{ $line }}.
										@if ($key == ($package->flightRoutes->count()-1))
											<a href="#" class="btn-more-less" style="display: none;">... less</a>
										@endif
									</li>
								@endif
							@endforeach
						</ul>
					@endif
					@if ($package->accomoRoutes->count())
						<strong>Hotels Included {{-- ({{$package->accomoRoutes->count()}} X Hotel) --}}</strong>
						<ul class="nomargin">
							@foreach ($package->accomoRoutes as $key => $value)
								@if ($key < 2)
									<li>
										{{ $value->accomo()->summary }}
										@if ($key == 1 && $key < ($package->accomoRoutes->count()-1))
											<a href="#" class="btn-more-less" >... more</a>
										@endif
									</li>
								@else
									<li class="more" style="display: none;">
										{{ $value->accomo()->summary }}
										@if ($key == ($package->accomoRoutes->count()-1))
											<a href="#" class="btn-more-less" style="display: none;">... less</a>
										@endif
									</li>
								@endif
							@endforeach
						</ul>
					@endif
					@if ($package->transferStringArray()->count())
						<strong>Transfers</strong>
						{{-- <ul class="nomargin">
							@foreach ($package->transferStringArray() as $transfer)
								<li>{{ $transfer }}</li>
							@endforeach
						</ul> --}}
						<ul class="nomargin">
							@foreach ($package->transferStringArray() as $key => $value)
								@if ($key < 2)
									<li>
										{{ $value }}
										@if ($key == 1 && $key < ($package->transferStringArray()->count()-1))
											<a href="#" class="btn-more-less" >... more</a>
										@endif
									</li>
								@else
									<li class="more" style="display: none;">
										{{ $value }}
										@if ($key == ($package->transferStringArray()->count()-1))
											<a href="#" class="btn-more-less" style="display: none;">... less</a>
										@endif
									</li>
								@endif
							@endforeach
						</ul>
					@endif

					@if ($package->cost->is_visa)
						<strong>Visa Included</strong>
					@endif
				</td>
				@if ($package->activities->count())
					<td>
						<strong>Activities : {{-- ({{$package->flightRoutes->count()}} X Hotel) --}}</strong>
						<ul class="nomargin">
							@foreach ($package->activities as $key => $value)
								@if ($key < 6)
									<li>
										{{ $value->activityObject()->name }} | {{ proper($value->activityObject()->mode) }} basis.
										@if ($key == 5 && $key < ($package->activities->count()-1))
											<a href="#" class="btn-more-less" >... more</a>
										@endif
									</li>
								@else
									<li class="more" style="display: none;">
										{{ $value->activityObject()->name }} | {{ proper($value->activityObject()->mode) }} basis.
										@if ($key == ($package->activities->count()-1))
											<a href="#" class="btn-more-less" style="display: none;">... less</a>
										@endif
									</li>
								@endif
							@endforeach
						</ul>
					</td>
				@endif
				
			</tr>
		</table>
		@if (strlen($package->extra_word))
			<hr>
			<label for="">More Details : </label>
			<div>{!! $package->extra_word !!}</div>
		@endif
	</div>
</article>