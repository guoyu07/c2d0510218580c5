<h3>Enter Passenger Details</h3>
@foreach ($data->rooms->hotels->request->RoomGuests as $key => $value)
	<div class="col-md-12 room-guest">
		<div class="row"><b><h5>Room {{ $key+1 }}:</h5></b></div>
		<div class="row m-bottom-10px">
			<input class="form-control phone" type="text"  placeholder="Contact No." />
		</div>
		<div class="row m-bottom-10px">
			<input class="form-control email" type="text"  placeholder="Email" />
		</div>
		@for ($i = 0; $i < $value->NoOfAdults; $i++)
			<div class="row m-bottom-10px guest-row">
				<div class="col-md-2">
					<div class="row">
						<select class="form-control prefix p-1-5px" name="">
							<option value="mr">Mr.</option>
							<option value="mrs">Mrs.</option>
							<option value="miss">Miss.</option>
						</select>
					</div>
				</div>
				<div class="col-md-8">
					<input class="form-control name" type="text"  placeholder="Full Name (Adult)" />
				</div>
				<div class="col-md-2">
					<div class="row">
						<input class="form-control age" type="text"  placeholder="Age" />
					</div>
				</div>
			</div>
		@endfor
		@foreach ($value->ChildAge as $childAge)
			<div class="row m-bottom-10px guest-row">
				<div class="col-md-2">
					<div class="row">
						<select class="form-control prefix p-1-5px" name="">
							<option value="mr">Master.</option>
							<option value="miss">Miss.</option>
						</select>
					</div>
				</div>
				<div class="col-md-8">
					<input class="form-control name" type="text"  placeholder="Full Name (Child)" />
				</div>
				<div class="col-md-2">
					<div class="row">
						<input class="form-control age" type="text"  placeholder="Age" value="{{ $childAge }}" />
					</div>
				</div>
			</div>
		@endforeach
	</div>
@endforeach
