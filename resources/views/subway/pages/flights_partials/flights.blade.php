@if ($package->flightRoutes->count())
	<article class="item">
		<header>
			<h1 class="title">flights</h1>
		</header>
		@foreach ($package->flightRoutes as $key => $route)
			<div class="content clearfix p-10">
				@foreach ($route->flights() as $flight)
					@foreach ($flight->get('connections', []) as $flightDetail)
						<?php 
							$depDateTime = now()->parse($flightDetail
																		->get('departure_date_time'));

							$arrDateTime = now()->parse($flightDetail
																		->get('arrival_date_time'));
						?>
						<div class="row">
							<div class="col-md-5 col-sm-5 col-xs-12">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12 text-left">
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-12">
												<div class="row">
													<div class="m-tb-15-5">
														<div class="vertical-parent">
															<div class="vertical-child div-60" >
																<img src="{{ flightImage($flightDetail->get('airline_code')) }}" alt="{{$flightDetail->get('airline_name')}}" onerror="this.src = `{{ urlImage('images/airlineImages/__.gif') }}`">
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-12 m-top-15">
												<div class="flightName font-size-15">
													{{ str_replace('Limited', '', $flightDetail->get('airline_name'))  }}
												</div>
												<div class="font-size-10">
													<i>{{ $flightDetail->get('airline_code').$flightDetail->get('airline_number') }}</i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-7 col-sm-7 col-xs-12">
								<div class="row m-top-15">
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="text-center">
											<div class="font-size-15">
												{{ $depDateTime->format('H:i') }} 
												<span class="font-size-10">
													<i>({{ $depDateTime->format('d-M-Y') }})</i>
												</span>
											</div>
											<div>
												{{ $flightDetail->get('origin') }} 
												<span class="font-size-10">
													<i>({{ $flightDetail->get('origin_code') }})</i>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="text-center">
											<div class="font-size-15">
												{{ $arrDateTime->format('H:i') }} 
												<span class="font-size-10">
													<i>({{ $arrDateTime->format('d-M-Y') }})</i>
												</span>
											</div>
											<div>
												{{ $flightDetail->get('destination') }}
												<span class="font-size-10">
													<i>({{ $flightDetail->get('destination_code') }})</i>
												</span> 
											</div>
										</div>
									</div>		
								</div>	
							</div>
						</div>
					@endforeach
				@endforeach
			</div>
		@endforeach
	</article>
@endif
