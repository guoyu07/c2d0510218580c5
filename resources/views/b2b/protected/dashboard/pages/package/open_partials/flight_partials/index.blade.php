<ul class="list list-unstyled">
	@foreach ($flightRoute->flights() as $flight)
		<li class="min-height-110px">
			<div class="x_panel glowing-border">
				<div class="col-md-10 col-sm-10 col-xs-12">
					@foreach ($flight->get('connections', []) as $flightDetail)
						<?php
							$depDateTime = now()->parse($flightDetail->get('departure_date_time'));
							$arrDateTime = now()->parse($flightDetail->get('arrival_date_time'));
						?>
						<div class="row">
							<div class="col-md-5 col-sm-5 col-xs-12">
								<div class="row m-tb-10px">
									<div class="col-md-12 col-sm-12 col-xs-12 text-left">
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-12">
												<div class="row">
													<img src="{{ urlImage('images/airlineImages/'.$flightDetail->get('airline_code').'.gif') }}" alt="">
												</div>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<div class="flightName font-size-15">
													{{ str_replace('Limited', '', $flightDetail->get('airline_name'))  }}
												</div>
												<div>
													<small>
														{{ $flightDetail->get('airline_code').$flightDetail->get('airline_number') }}
													</small>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="text-center">
											<h2>
												{{ $depDateTime->format('H:i') }} 
												<small>({{ $depDateTime->format('d-M-Y') }})</small>
											</h2>
											<div>
												{{ $flightDetail->get('origin') }} 
												<small>({{ $flightDetail->get('origin_code') }})</small>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="text-center">
											<h2>
												{{ $arrDateTime->format('H:i') }} 
												<small>({{ $arrDateTime->format('d-M-Y') }})</small>
											</h2>
											<div>
												{{ $flightDetail->get('destination') }} 
												<small>({{ $flightDetail->get('destination_code') }})</small>
											</div>
										</div>
									</div>		
								</div>	
							</div>
						</div>
					@endforeach
				</div>
				<div class="col-md-2 col-sm-2 col-xs-12">
					<a href="{{ route('flights',[$package->token]) }}?{{ http_build_query(['only' => [$flightRoute->token]]) }}" class="btn btn-success pull-right">Modify</a>
					<h2 class="flightPrice text-center">
						{{-- <i class="fa fa-rupee"></i> --}}
						{{-- <span>{{ ifset($tripOption->saleTotal) }}</span> --}}
						{{-- <span>/-</span> --}}
					</h2>
					{{-- <div class="row m-tb-20px">
						<a href="{{ urlFlightsResult($flightRoute->flight->id) }}" class="btn btn-primary btn-block btn-bookFlight">Change</a>
					</div> --}}
				</div>
			</div>
		</li>
	@endforeach
</ul>