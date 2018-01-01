@foreach ($package->roomGuests as $key => $roomGuest)
	<div id="room_{{ $key }}" class="room-guest" data-id="{{ $roomGuest->id }}">
		<div class="row">
			{{-- Rooms --}}
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="col-md-7 col-sm-7 col-xs-12 font-size-16 m-top-5">
						Room {{-- X --}}
					</div>
					<div class="col-md-5 col-sm-5 col-xs-12" hidden>
						<select class="form-control nopadding room-count" >
							@for ($i = 1; $i <= 12; $i++)
								<option value="{{ $i }}" {{ $roomGuest->rooms == $i ? 'selected' : '' }}>{{ $i }}</option>
							@endfor
						</select>
					</div>
				</div>
			</div>
			{{-- /Rooms --}}

			{{-- Adult Button --}}
			<div class="col-md-3 col-sm-3 col-xs-12 p-bottom-1 m-bottom-n-5 form-group has-feedback">
				<div class="center">
					<div class="input-group">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-number noradius bg-color-gray btn-decrease" field="#count_adult_{{ $key }}">
								<span class="glyphicon glyphicon-minus"></span>
							</button>
						</span>
						<span class="form-control text-center nopadding-right">
							<input type="text" id="count_adult_{{ $key }}" class="width-20 nostyle adults" value="{{ $roomGuest->no_of_adult }}" data-min="1" data-max="12" data-singular="Adult" data-plural="Adults">
							<span>{{ str_plural('Adult', $roomGuest->no_of_adult) }}</span>
						</span>
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0 btn-increase" field="#count_adult_{{ $key }}">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>
				</div>
			</div>
			{{-- /Adult Button --}}

			{{-- Child Button --}}
			<div class="col-md-3 col-sm-3 col-xs-12 p-bottom-1 m-bottom-n-5 form-group has-feedback">
				<div class="center">
					<div class="input-group">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-number noradius bg-color-gray btn-decrease btn-child" field="#count_child_{{ $key }}">
								<span class="glyphicon glyphicon-minus"></span>
							</button>
						</span>
						<span class="form-control text-center nopadding-right">
							<input type="text" id="count_child_{{ $key }}" class="width-20 nostyle children" value="{{ $roomGuest->childAge->count() ? $roomGuest->childAge->count() : '' }}" data-min="0" data-max="4" data-singular="Child" data-plural="Children">
							<span>{{ str_plural('Child', $roomGuest->childAge->count()) }}</span>
						</span>
						<span class="input-group-btn">
							<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0 btn-increase btn-child" field="#count_child_{{ $key }}">
								<span class="glyphicon glyphicon-plus"></span>
							</button>
						</span>
					</div>				
				</div>
			</div>
			{{-- /Child Button --}}

			{{-- Age html --}}
			<div class="col-md-3 col-sm-3 col-xs-12 age">
				@foreach ($roomGuest->childAge as $childAge)
					<div class="col-md-3 col-sm-3 col-xs-12 p-bottom-1 form-group has-feedback nopadding">
						<select class="form-control nopadding age-elem" data-id="">
							<option>Age ?</option>
							@for ($i = 1; $i <= 12; $i++)
								<option value="{{ $i }}" {{ $childAge->age == $i ? 'selected' : '' }}>{{ $i }}</option>
							@endfor
						</select>
					</div>
				@endforeach
			</div>
			{{-- /age html --}}
			<div class="col-md-1 col-sm-1 col-xs-12 text-center">
				@if ($key)
					<a class="rmv-room cursor-pointer">
						<i class="fa fa-times-circle font-size-30 m-top-2"></i>
					</a>
				@endif
			</div>
		</div>
	</div>
@endforeach