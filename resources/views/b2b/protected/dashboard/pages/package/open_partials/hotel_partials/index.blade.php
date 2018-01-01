<?php
	$hotelDetails = $hotelRoute->accommodations();
?>
@if($hotelDetails->count())
	<ul class="list list-unstyled">
		@foreach ($hotelDetails as $hotelDetail)
			<li class="m-top-10">
				<div class="x_panel glowing-border nopadding">
					<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
						<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
							<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
								<img src="{{ $hotelDetail->get('image') }}" alt="" height="100%" width="100%">
							</div>
						</div>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<h2>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h3 class="nopadding hotelName">{{ $hotelDetail->get('name') }} {!! starRating($hotelDetail->get('star_rating')) !!}
										<a href="{{ route('accommo',[$package->token]) }}?{{ http_build_query(['only' => [$hotelRoute->token]]) }}" class="btn btn-success pull-right">Modify</a>
									</h3>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
									<i class="fa fa-map-marker"></i>
									<span>{{ $hotelDetail->get('address') }}</span>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 ">
									<div hidden>
										<p class="starRating" >{{ $hotelDetail->get('star_rating') }}</p>
									</div>
									<ul class="pipe font-size-13 nopadding m-top-5">
										<li><b>Check In : </b>{{ $hotelRoute->start_date }}</li>
										<li><b>Check Out : </b>{{ $hotelRoute->end_date }}</li>
										<li><b>Breakfast : </b>{{ $hotelRoute->is_breakfast ? 'Yes' : 'No' }}</li>
										<li><b>Lunch : </b>{{ $hotelRoute->is_lunch ? 'Yes' : 'No' }}</li>
										<li><b>Dinner : </b>{{ $hotelRoute->is_dinner ? 'Yes' : 'No' }}</li>
									</ul>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 font-size-13 m-top-5">
									<b>RoomType : </b>{{ $hotelDetail->get('properties', collect())->pluck('roomtype')->implode(' | ') }}
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
									{{ sub_string($hotelDetail->get('description')) }}
									<button 
										class="btn-link cursor-pointer btn-model" 
										data-title="{{ $hotelDetail->get('name') }} : Description" 
										data-bodyid="hotelDescription_{{ $hotelDetail->get('code') }}">More
									</button>
									<div id="hotelDescription_{{ $hotelDetail->get('code') }}" hidden>
										{!! $hotelDetail->get('description') !!}
									</div>
								</div>

							</h2>
						</div>
					</div>
				</div>
			</li>
		@endforeach
	</ul>
@endif