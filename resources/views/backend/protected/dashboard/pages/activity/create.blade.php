@extends('backend.protected.dashboard.main')

@section('css')
	<link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/>
	<link rel="stylesheet" href="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="col-md-9 col-sm-9 col-xs-12">
					<h2>Add Activity</h2>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<a href="{{ url('dashboard/activities') }}" class="btn btn-primary btn-block">Back to Activities List</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				{{-- <form class="form-horizontal form-label-left input_mask"> --}}
					<div class="form-group">
						<div class="col-md-3 col-sm-3 col-xs-12">
							<select class="select2_single form-control countries">
								<option value="">Select Country</option>
								@foreach ($countries as $country)
									<option value="{{ $country->fgf_countrycode }}|{{ $country->currencyCode }}">{{ $country->country }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12">
							<select class="select2_single form-control destinations">
								<option value="">Select Destinaiton?</option>
							</select>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<select class="select2_single form-control currency">
								<option value="">Currency?</option>
								@foreach ($countries as $country)
									<option value="{{ $country->currencyCode }}">{{ $country->currency }} ({{ $country->currencyCode }})</option>
								@endforeach
							</select>
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
							<input type="text" class="span2 form-control has-feedback activityValidFrom" id="fromDate" data-date-format="dd/mm/yyyy" placeholder="ValidFrom" value="01/01/2016" required="">
							<i class="fa fa-calendar form-control-feedback right" aria-hidden="true"></i>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">
							<input type="text" class="span2 form-control has-feedback activityValidTo" id="toDate" data-date-format="dd/mm/yyyy" placeholder="ValidTo" value="01/01/2018" required="">
							<i class="fa fa-calendar form-control-feedback right" aria-hidden="true"></i>
						</div>

					</div>
					
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10">
						<input type="text" class="form-control has-feedback-left activityName" id="inputSuccess2" placeholder="Activity Name">
						<i class="fa fa-futbol-o form-control-feedback left" aria-hidden="true"></i>
					</div>

					<div class="form-group" hidden>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
							<div class="col-md-12 col-sm-12 col-xs-12 border-gray m-top-10">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label><h2>Sic Section</h2></label>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="row">
										<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
											<input type="text" class="form-control has-feedback-left sic-adultPrice" id="inputSuccess2" placeholder="Adult Cost">
											<i class="fa fa-money form-control-feedback left" aria-hidden="true"></i>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
											<input type="text" class="form-control has-feedback-left sic-childPrice" id="inputSuccess2" placeholder="Child (2 > 12)">
											<i class="fa fa-money form-control-feedback left" aria-hidden="true"></i>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
											<input type="text" class="form-control has-feedback-left sic-infantPrice" id="inputSuccess2" placeholder="Infant (0 > 2)">
											<i class="fa fa-money form-control-feedback left" aria-hidden="true"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group" hidden>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
							<div class="col-md-12 col-sm-12 col-xs-12 border-gray m-top-10">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label><h2>Private Section</h2></label>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="row">
									<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
										<input type="text" class="form-control has-feedback-left private-adultPrice" id="inputSuccess2" placeholder="Adult Cost">
										<i class="fa fa-money form-control-feedback left" aria-hidden="true"></i>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
										<input type="text" class="form-control has-feedback-left private-childPrice" id="inputSuccess2" placeholder="Child (2 > 12)">
										<i class="fa fa-money form-control-feedback left" aria-hidden="true"></i>
									</div>
									<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
										<input type="text" class="form-control has-feedback-left private-infantPrice" id="inputSuccess2" placeholder="Infant (0 > 2)">
										<i class="fa fa-money form-control-feedback left" aria-hidden="true"></i>
									</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div id="activityCarDiv">
										
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 m-tb-10px">
									{{-- Add Room button --}}
									<div class="col-md-12 col-sm-12 col-xs-12 p-bottom-1">
										<div >
											<a id="btn-addCar" class="btn-link cursor-pointer">Add Car</a>
											<span id="pipeSapr" hidden> | </span>
											<a id="btn-removeCar" class="btn-link cursor-pointer" hidden>Remove Car</a>
										</div>
									</div>
									{{-- /Add Room button --}}
								</div>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
							<div class="col-md-12 col-sm-12 col-xs-12 border-gray m-top-10">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label><h2>Activity Timing</h2></label>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div id="activityTiming">
										<div id="activityTiming_1" class="row activity-timing">
											<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
												<label for="">Opening Time</label>
												<input type="text" class="form-control has-feedback-left datetimepicker opening-time" id="inputSuccess2" placeholder="Opening Time" value="10:00">
												<i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
												<label for="">Duration</label>
												<input type="text" class="form-control has-feedback-left datetimepicker duration" id="inputSuccess2" placeholder="Duration" value="01:00">
												<i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
												<label for="">Closing Time</label>
												<input type="text" class="form-control has-feedback-left datetimepicker closing-time" id="inputSuccess2" placeholder="Closing Time" value="21:00">
												<i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 m-tb-10px">
									{{-- Add Room button --}}
									<div class="col-md-12 col-sm-12 col-xs-12 p-bottom-1">
										<div >
											<a id="btn-addTiming" class="btn-link cursor-pointer">Add Timing</a>
											<span id="pipeTimeSapr" hidden> | </span>
											<a id="btn-removeTiming" class="btn-link cursor-pointer" hidden>Remove Timing</a>
										</div>
									</div>
									{{-- /Add Room button --}}
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-12 col-sm-12 col-xs-12 m-top-10">Activity Description<span class="required">*</span>
						</label>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<textarea class="form-control activity-Description" rows="5"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 m-tb-20px">
							<form id="uploadform" class="uploadform dropzone no-margin nopadding dz-clickable min-max-height-170px bg-color-gray" data-path="" data-host="">	
								{{ csrf_field() }}
								<div class="dz-default dz-message">
									<div class="row">
										<div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
											<div class="height-100px vertical-parent">
												<div class="vertical-child">
													Drop activity image here
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>

							{{-- <form method="POST" action="{{ url('dashboard/activities/saveimage') }}" enctype="multipart/form-data">
								{{csrf_field()}}
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12">
								  	<input type="file" name="img[]" class="btn btn-block btn-default" multiple>
								  </div>
							  </div>
							  <input type="text" name="countryCode" id="countryCodeImg" value="" hidden>
							  <input type="text" name="activityId" id="activityId" value="" hidden>
							  <input type="submit" id="uploadImage" hidden>
							</form> --}}
						</div>
					</div>

					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12 m-tb-10px">
									<a href="" class="btn btn-primary btn-block">Cancel</a>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 m-tb-10px">
									<button type="button" id="formSubmit" class="btn btn-success btn-block">Save</button>
								</div>
							</div>
						</div>
					</div>

				{{-- </form> --}}
			</div>
		</div>
	</div>
</div>

@endsection


@section('aftercontent')
<div hidden>
	<div id="activityCarTemp">
		<div id="activityCarTempId" class="row activity-car-inner">
			<div class="col-md-12 col-sm-12 col-xs-12"><h2>Car Temp_CarCount</h2></div>
			<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
				<input type="text" class="form-control has-feedback-left carName" id="inputSuccess2" placeholder="Car Name">
				<i class="fa fa-car form-control-feedback left" aria-hidden="true"></i>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
				<input type="text" class="span2 dpdStartTempCount form-control has-feedback carValidFrom" id="fromDate" data-date-format="dd/mm/yyyy" placeholder="From" required="">
				<i class="fa fa-calendar form-control-feedback right" aria-hidden="true"></i>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
				<input type="text" class="span2 dpdEndTempCount form-control has-feedback carValidTo" id="toDate" data-date-format="dd/mm/yyyy" placeholder="To" required="">
				<i class="fa fa-calendar form-control-feedback right" aria-hidden="true"></i>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				<select class="select2_single form-control carCapcity">
					<option value="">Car Capacity?</option>
					@for ($i = 4; $i <= 8 ; $i++)
						<option value="{{ $i }}">{{ $i }} Seater</option>
						<?php ++$i; ?>
					@endfor
				</select>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
				<input type="text" class="form-control has-feedback-left carPrice" id="inputSuccess2" placeholder="Price">
				<i class="fa fa-money form-control-feedback left" aria-hidden="true"></i>
			</div>
		</div>
	</div>

	<div id="activityTimingTemp">
		<div id="activityTimingCountTemp" class="row activity-timing">
			<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
				<input type="text" class="form-control has-feedback-left datetimepicker" id="inputSuccess2" placeholder="Opening Time" value="10:00">
				<i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
				<input type="text" class="form-control has-feedback-left datetimepicker" id="inputSuccess2" placeholder="Duration" value="01:00">
				<i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
				<input type="text" class="form-control has-feedback-left datetimepicker" id="inputSuccess2" placeholder="Closing Time" value="21:00">
				<i class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></i>
			</div>
		</div>
	</div>
</div>
@endsection

@section('jquery')
	<script type="text/javascript" src="{{ commonAsset('datepicker/jquery.min.js') }}"></script>
@endsection

@section('js')
	{{-- bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ commonAsset('js/bootstrap-datepicker.js') }}"></script>
	<script src="{{ commonAsset('datetimepicker/jquery.datetimepicker.full.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

	<script src="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>

	{{-- <script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script> --}}

@endsection

@section('scripts')
	@include('backend.protected.dashboard.pages.activity.create_partials._scripts')
	@include('backend.protected.dashboard.pages.activity.common_partials._scripts')
@endsection
