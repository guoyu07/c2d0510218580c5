<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-plane"></i>
		<span>Flights</span>
		<span class="badge bg-green">{{ ifset($menus->flights->count) }}</span>
	</a>
	<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		@if (ifset($menus->flights->flightsResult))
			
			@forelse( $menus->flights->flightsResult as $booked_Flight)
				<li>
					<a>
						<div>
							@if (ifset($booked_Flight->trips->tripOption))
								@foreach ($booked_Flight->trips->tripOption as $menuTripOption)
								{{-- {{dd_pre_echo($menuTripOption)}} --}}
									<div class="col-md-10 col-sm-10 col-xs-12 nopadding">
										<div class="row">
											@foreach ($menuTripOption->flightInfo as $flightInfo)
												@if (isset($flightInfo->flights->airline))
													@foreach ($flightInfo->flights->airline as $flightInfoAirline)
														<div class="col-md-12 col-sm-12 col-xs-12">
															<h2>{{ifset($flightInfoAirline->name)}}</h2>
														</div>
													@endforeach

													<div class="col-md-12 col-sm-12 col-xs-12">
														<div class="col-md-5 col-sm-5 col-xs-12">
															Date: {{ ifset($booked_Flight->request->arrival) }}
														</div>
														<div class="col-md-7 col-sm-7 col-xs-12">
															{!! str_replace('|', '→', ifset($flightInfo->stops)) !!}
														</div>
													</div>
												@endif
											@endforeach
										</div>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 nopadding text-right">
										<i class="fa fa-rupee font-size-15"></i>
										<span class="font-size-15">{{ ifset($menuTripOption->totalCost->inInr) }}</span>
									</div>
								@endforeach
							@endif
						</div>
					</a>
				</li>
			@empty
				<li>No Flight</li>
			@endforelse

			{{-- @if (bool_array($menus->flights)) --}}
				<li>
					<div class="text-center">
						<a href="{{ urlPackageAll($urlVariable->id, $urlVariable->packageDbId) }}">
							<strong>See All Flights</strong>
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</li>
			{{-- @endif --}}

			@else
			<li>No Flight</li>
		@endif
	</ul>
</li>