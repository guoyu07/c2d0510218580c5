<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="glyphicon glyphicon-home"></i>
		<span>Hotels</span>
		<span class="badge bg-green">{{ ifset($menus->hotels->count) }}</span>
	</a>
	<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		@if (ifset($menus->hotels->hotelsResult))
			
			@forelse( $menus->hotels->hotelsResult as $booked_Hotel)
				@if (!empty($booked_Hotel))
					<li>
						<a>
							<div>
								<h2>{{ ifset($booked_Hotel->HotelName) }} <span>{!! starRating($booked_Hotel->StarRating) !!}</span></h2>
							</div>
							<div>
								{{ ifset($booked_Hotel->Location->destination).', '.ifset($booked_Hotel->Location->country) }}
							</div>
							<div>
								<span>Check In : {{ date_formatter(ifset($booked_Hotel->CheckInDate), 'Y-m-d', 'd-M-Y') }}</span>
								<span> | </span>
								<span>Check Out : {{ date_formatter(ifset($booked_Hotel->CheckOutDate), 'Y-m-d', 'd-M-Y') }}</span>
							</div>
							<div>
								<div class="row">
									<div class="col-md-10 col-sm-10 col-xs-12">
										{{ ifset($booked_Hotel->RoomTypeName) }}
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 text-right">
										<i class="fa fa-rupee font-size-15"></i>
										<span class="font-size-15">{{ ifset($booked_Hotel->Price) }}</span>
									</div>
								</div>
							</div>
						</a>
					</li>
				@endif
			@empty
				<li>No Hotel Booked</li>
			@endforelse

			@if (bool_array($menus->hotels->hotelsResult))
				<li>
					<div class="text-center">
						<a href="{{ urlPackageAll($urlVariable->id, $urlVariable->packageDbId) }}">
							<strong>See All Hotels</strong>
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
				</li>
			@endif
		@else
			<li>No Hotel Selected</li>
		@endif
	</ul>
</li>