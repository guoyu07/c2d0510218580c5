<form action="{{ url('hotels') }}"  class="booking-item-dates-change mb40">
	<div class="row">
		<div class="col-md-4">
			<label>Where are you going?</label>
			<input class="autocomplete form-control" placeholder="City, Airport, Point of Interest or U.S. Zip Code" name="dest" type="text" value="{{ request()->dest }}" required />
			<input name="dest_code" type="hidden" value="{{ request()->dest_code }}" />
		</div>
		<div class="col-md-4">
			<div class="input-daterange" data-date-format="dd/mm/yyyy">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
							<label>Check in</label>
							<input class="form-control" name="start" type="text" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
							<label>Check out</label>
							<input class="form-control" name="end" type="text" />
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-7">
					<div class="form-group form-group-icon-left dropdown keep-open">
						<i class="fa fa-user input-icon input-icon-highlight"></i>
						<label>Rooms/Guests</label>
						<button data-toggle="dropdown" class="form-control dropdown-toggle text-right" type="button" aria-expanded="false"><span class="guests-word">2 Adults</span> <span class="caret"></span>
						</button>
						<ul role="menu" class="dropdown-menu min-width-600 right-0 left-auto">
							<li>
								<div class="rooms-container scroll-bar">
									@include('traveler.pages.hotel.common.room_inputs')

									{{-- <div class="room">
										<div class="col-md-4">
											<div class="form-group form-group-lg form-group-select-plus">
												<label>Adult</label>
												<div class="btn-group btn-group-select-num" data-toggle="buttons">
													@for ($i = 1; $i < 5; $i++)
														<label class="btn btn-primary {{ $i == 2 ? 'active' : '' }}"><input type="radio" class="adult" name="rooms[0][adult]" value="{{ $i }}" {{ $i == 2 ? 'checked' : '' }} />{{ $i }}</label>
													@endfor
													<label class="btn btn-primary hide"><input type="radio" name="adult"/></label>
												</div>
												<select class="form-control hidden">
													{!! selectOptions(array_diff(range(0, 6), [0=>0])) !!}
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-group-lg form-group-select-plus">
												<label>Kids</label>
												<div class="btn-group btn-group-select-num kids-box" data-toggle="buttons">
													@for ($i = 1; $i < 5 ; $i++)
														<label class="btn btn-primary"><input type="radio" name="rooms[0][kids]" class="kids" value="{{ $i }}" />{{ $i }}</label>
													@endfor
													
													<label class="fa fa-times cursor-pointer m-top-10 remove-kid hide"></label>

													<label class="btn btn-primary hide"><input type="radio" name="kid_age" />3+</label>
												</div>
												<select class="form-control hidden">
													{!! selectOptions(array_diff(range(0, 4), [0=>0])) !!}
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group form-group-lg form-group-select-plus kids-age-box">
												<label>Kids Age</label>
												@for ($i = 1; $i < 5; $i++)
													<div class="col-md-3 {{ $i == 1 ? 'm-left-n-15' : '' }}">
														<select class="my-form-control kids-age" name="rooms[0][kids_age][]" disabled>
															{!! selectOptions(array_diff(range(1, 12), [0=>0])) !!}
														</select>
													</div>
												@endfor
											</div>
										</div>
										<div class="row"></div>
									</div> --}}
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
				<div class="col-md-5">
					<label style="color: rgba(0, 0, 0, 0);">Submit</label>
					<input class="btn btn-primary" type="submit" value="Update Search" />
				</div>
			</div>
		</div>
	</div>
</form>