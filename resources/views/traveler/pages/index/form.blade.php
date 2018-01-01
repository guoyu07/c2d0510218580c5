<form action="{{ url('hotels') }}">
	<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon"></i>
		<label>Where are you going?</label>
		<input class="autocomplete form-control" placeholder="City, Airport, Point of Interest or U.S. Zip Code" name="dest" type="text" value="{{ request()->dest }}" required />
		<input name="dest_code" type="hidden" value="{{ request()->dest_code }}" />
	</div>
	<div class="input-daterange" data-date-format="dd/mm/yyyy">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
					<label>Check-in</label>
					<input class="form-control" name="start" type="text" required />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-highlight"></i>
					<label>Check-out</label>
					<input class="form-control" name="end" type="text" required />
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group form-group-lg form-group-icon-left dropdown keep-open">
					<i class="fa fa-user input-icon input-icon-highlight"></i>
					<label>Rooms/Guests</label>
					<button data-toggle="dropdown" class="form-control dropdown-toggle text-right" type="button" aria-expanded="false"><span class="guests-word">2 Adults</span> <span class="caret"></span>
					</button>
					<ul role="menu" class="dropdown-menu min-width-600">
						<li>
							<div class="rooms-container scroll-bar">
								@include('traveler.pages.hotel.common.room_inputs')
							</div>
						</li>
						<li>
							<div class="col-md-12">
								<a class="add-room cursor-pointer" data-count="1">Add Rooms</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<button class="btn btn-primary btn-lg" type="submit">Search for Hotels</button>
</form>