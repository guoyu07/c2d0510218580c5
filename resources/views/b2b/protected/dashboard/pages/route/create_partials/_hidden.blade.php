<div hidden>
	{{-- age html --}}
	<div id="age_temp">
		<div class="col-md-3 col-sm-3 col-xs-12 p-bottom-1 form-group has-feedback nopadding">
			<select class="form-control nopadding age-elem" data-id="">
				<option selected>Age</option>
				@for ($i = 1; $i <= 12; $i++)
					<option value="{{ $i }}">{{ $i }}</option>
				@endfor
			</select>
		</div>
	</div>
	{{-- /age html --}}

	{{-- Destination Html --}}

	<div id="destinationListHtml">
		<div id="destination_count" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList_temp no-rid" data-destination="data_destination_count" data-rid="" data-order="">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row">
					<div class="col-md-2 col-sm-2 col-xs-1">
						<i class="fa fa-arrows font-size-20 m-top-5"></i>
					</div>
					<div class="col-md-10 col-sm-10 col-xs-11">
						<select class="form-control nopadding p-left-10 mode" data-parsley-type="value" required="">
							<option value="" selected>Select Mode</option>
							{!! $indication->htmlOptions('route_mode') !!}
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="row location-input-div"></div>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-12 text-center">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 text-center">
						<a class="rmv-destlist cursor-pointer">
							<i class="fa fa-times-circle font-size-30 m-top-2"></i>
						</a>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-center">
						<a class="btn-add-route green cursor-pointer">
							<i class="fa fa-plus-square font-size-30 m-top-2"></i>
						</a>
					</div>
				</div>
			</div>

				{{-- <div class="col-md-4 col-sm-4 col-xs-12">
					<input type="text" class="form-control has-feedback origin location p-right-40" placeholder="Origin" name="origin" required="">
					<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<input type="text" class="form-control has-feedback destination location p-right-40" placeholder="Destination" name="destination" required="">
					<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-12">
					<select class="form-control nopadding p-left-10 nights" required="" data-parsley-type="integer" data-parsley-gt="0">
						<option value="" selected>Select Night</option>
						@for ($i = 1; $i <= 12 ; $i++)
							<option value="{{ $i }}">{{ $i == 1 ? $i.' Night' : $i.' Nights' }}</option>
						@endfor
						<option value="0">End Tour</option>
					</select>
				</div> --}}
		</div>
	</div>
	{{-- Destination Html --}}

	<div id="originFlightTemp">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control has-feedback location origin inctv p-right-40" placeholder="Origin" name="origin" data-match="" required="">
			<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
		</div>
	</div>

	<div id="destinationTemp">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" class="form-control has-feedback location destination inctv p-right-40" placeholder="Destination" name="destination" data-match="" data-code="" required="">
			<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
		</div>
	</div>

	<div id="nightTemp">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<select class="form-control nopadding p-left-10 nights inctv" required="" data-parsley-type="integer" data-parsley-gt="0">
				<option value="" selected>Select Night</option>
				@for ($i = 1; $i <= 12 ; $i++)
					<option value="{{ $i }}">{{ $i == 1 ? $i.' Night' : $i.' Nights' }}</option>
				@endfor
				<option value="0">End Tour</option>
			</select>
		</div>
	</div>

	<div id="destinationWithDatetimeTemp">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="col-md-9 col-sm-9 col-xs-12">
				<div class="row">
					<input type="text" class="form-control has-feedback location temp-class inctv" data-match="" data-code="" placeholder="Location">
				</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div class="row">
					<input type="text" class="form-control has-feedback-left datetimepicker temp-class-time p-left-10">
				</div>
			</div>
		</div>
	</div>

</div>