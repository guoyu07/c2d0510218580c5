@foreach ($routes as $routeKey => $route)
	<div id="destination{{$routeKey}}" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList no-rid" data-destination="1" data-rid="{{$route->id}}" data-order="">
		<div class="col-md-3 col-sm-3 col-xs-12">
			<div class="row">
				<div class="col-md-2 col-sm-2 col-xs-1">
					<i class="fa fa-arrows font-size-20 m-top-5"></i>
				</div>
				<div class="col-md-10 col-sm-10 col-xs-11">
					<select class="form-control nopadding p-left-10 mode" data-parsley-type="value" required="">
						{!! $indication->htmlOptions('route_mode', $route->mode) !!}
					</select>
				</div>
			</div>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-12">
			<div class="row location-input-div">
				@if ($route->mode == 'flight')
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" class="form-control has-feedback location origin p-right-40" placeholder="Origin" value="{{$route->origin}}" name="origin" data-match="" data-code="{{ $route->origin_code }}" required="">
						<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" class="form-control has-feedback location destination p-right-40" placeholder="Destination" value="{{ $route->destination }}" name="destination" data-code="{{ $route->destination_code }}" data-match="" required="">
						<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
					</div>
				@elseif(in_array($route->mode, ['hotel', 'cruise', 'hotel_only', 'activity_only']))
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" class="form-control has-feedback location destination p-right-40" placeholder="Destination" name="destination" value="{{$route->destination}}" data-code="{{ $route->destination_code }}" data-match="" required="">
						<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
					</div>

					<div class="col-md-6 col-sm-6 col-xs-12">
						<select class="form-control nopadding p-left-10 nights" required="" data-parsley-type="integer" data-parsley-gt="0">
							<option value="" selected>Select Night</option>
							@for ($i = 1; $i <= 12 ; $i++)
								<option value="{{ $i }}" {{$route->nights == $i ? 'selected' : ''}}>
									{{ $i == 1 ? $i.' Night' : $i.' Nights' }}
								</option>
							@endfor
							<option value="0">End Tour</option>
						</select>
					</div>
				@elseif(in_array($route->mode, ['train', 'bus', 'ferry']))
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="row">
								<input type="text" class="form-control has-feedback location origin" data-match="" value="{{$route->origin}}" placeholder="Origin">
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<div class="row">
								<input type="text" class="form-control has-feedback-left datetimepicker origin-time p-left-10" value="{{ $route->start_datetime->format('h:i') }}">
							</div>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="row">
								<input type="text" class="form-control has-feedback location destination" data-match="" value="{{$route->destination}}" placeholder="Destination">
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<div class="row">
								<input type="text" class="form-control has-feedback-left datetimepicker destination-time p-left-10" value="{{ $route->end_datetime->format('h:i') }}">
							</div>
						</div>
					</div>
				@endif
			</div>
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
	</div>
@endforeach


