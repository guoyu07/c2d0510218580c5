<article class="item">
	<header>
		<h1 class="title">trip summary</h1>
	</header>
	<div class="content clearfix">
		<table width="100%" class="table-lborder table-trip-sum">
			<tr>
				<td>
					@if (count($package->trip_summary->get('flights', [])))
						<strong>Flights Included {{-- ({{$package->accomoRoutes->count()}} X Hotel) --}}</strong>
						<ul class="nomargin">
							@foreach ($package->trip_summary->get('flights', []) as $key => $value)
								<li {!! $key < 2 ? '' : 'class="more" style="display: none;"' !!}>
									{{ $value }}
									@if ($key == 1)
										<a href="#" class="btn-more-less" >... more</a>
									@endif
									@if ($key == (count($package->trip_summary->get('flights', []))-1))
										<a href="#" class="btn-more-less" style="display: none;">... less</a>
									@endif
								</li>
							@endforeach
						</ul>
					@endif
					
					@if (count($package->trip_summary->get('hotels', [])))
						<strong>Hotels Included {{-- ({{$package->accomoRoutes->count()}} X Hotel) --}}</strong>
						<ul class="nomargin">
							@foreach ($package->trip_summary->get('hotels', []) as $key => $value)
								<li {!! $key < 2 ? '' : 'class="more" style="display: none;"' !!}>
									{{ $value }}
									@if ($key == 1)
										<a href="#" class="btn-more-less" >... more</a>
									@endif
									@if ($key == (count($package->trip_summary->get('hotels', []))-1))
										<a href="#" class="btn-more-less" style="display: none;">... less</a>
									@endif
								</li>
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
				
				@if (count($package->trip_summary->get('activities', [])))
					<td>
						<strong>Activities : {{-- ({{$package->flightRoutes->count()}} X Hotel) --}}</strong>
						<ul class="nomargin">
							@foreach ($package->trip_summary->get('activities', []) as $key => $value)
								@if ($key < 6)
									<li>
										{{ $value }}.
										@if ($key == 5 && $key < (count($package->trip_summary->get('activities', []))-1))
											<a href="#" class="btn-more-less" >... more</a>
										@endif
									</li>
								@else
									<li class="more" style="display: none;">
										{{ $value }} basis.
										@if ($key == (count($package->trip_summary->get('activities', []))-1))
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