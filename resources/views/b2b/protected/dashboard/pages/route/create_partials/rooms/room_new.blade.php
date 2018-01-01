<div id="room_1" class="room-guest inctv" data-id="">
	<div class="row">
		{{-- Rooms --}}
		<div class="col-md-2 col-sm-2 col-xs-12">
			<div class="row">
				<div class="col-md-7 col-sm-7 col-xs-12 font-size-16 m-top-5">
					Room {{-- X --}}
				</div>
				<div class="col-md-5 col-sm-5 col-xs-12" hidden>
					<select class="form-control nopadding room-count">
						@for ($i = 1; $i <= 12; $i++)
							<option value="{{ $i }}">{{ $i }}</option>
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
						<button type="button" class="btn btn-default btn-number noradius bg-color-gray btn-decrease" field="#count_adult_1">
							<span class="glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<span class="form-control text-center nopadding-right">
						<input type="text" id="count_adult_1" class="width-20 nostyle adults" value="2" data-min="1" data-max="12" data-singular="Adult" data-plural="Adults">
						<span>Adults</span>
					</span>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0 btn-increase" field="#count_adult_1">
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
						<button type="button" class="btn btn-default btn-number noradius bg-color-gray btn-decrease btn-child" field="#count_child_1">
							<span class="glyphicon glyphicon-minus"></span>
						</button>
					</span>
					<span class="form-control text-center nopadding-right">
						<input type="text" id="count_child_1" class="width-20 nostyle children" value="0" data-min="0" data-max="4" data-singular="Child" data-plural="Children">
						<span>Child</span>
					</span>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0 btn-increase btn-child" field="#count_child_1">
							<span class="glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>				
			</div>
		</div>
		{{-- /Child Button --}}

		{{-- Age html --}}
		<div class="col-md-3 col-sm-3 col-xs-12 age"></div>
		{{-- /age html --}}
		<div class="col-md-1 col-sm-1 col-xs-12 text-center">
			{{-- <a class="rmv-room cursor-pointer">
				<i class="fa fa-times-circle font-size-30 m-top-2"></i>
			</a> --}}
		</div>
	</div>
</div>