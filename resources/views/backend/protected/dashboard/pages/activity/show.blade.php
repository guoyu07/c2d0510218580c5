@extends('backend.protected.dashboard.main')

@section('css')
	<link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="">
				<div class="col-md-9 col-sm-9 col-xs-12">
					<h2>{{ $activity->name }}</h2>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<a href="{{ url('dashboard/activities') }}" class="btn btn-primary btn-block">Back to Activities List</a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Location & Dates</h2>
				<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Country</td>
							<td>{{ isset($activity->location->country) ? $activity->location->country : 'Invalid Country' }} ({{ isset($activity->location->fgf_countrycode) ? $activity->location->fgf_countrycode : 'Invalid' }})</td>
						</tr>
						<tr>
							<td>Destination</td>
							<td>{{ isset($activity->location->destination) ? $activity->location->destination : 'Invalid' }} ({{ isset($activity->location->fgf_destinationcode) ? $activity->location->fgf_destinationcode : 'Invalid' }})</td>
						</tr>
						<tr>
							<td>Valid</td>
							<td>{{ date_formatter($activity->fromDate, 'Y-m-d', 'd/m/Y') }} to {{ date_formatter($activity->toDate, 'Y-m-d', 'd/m/Y') }}</td>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>

	@if ($activity->sicStatus)
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Sic Pricing <small>({{ $activity->currency }})</small></h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<table class="table table-striped">
						<tbody>
							<tr>
								<td>Adult</td>
								<td>{{ $activity->charges->SIC->adult }}</td>
							</tr>
							<tr>
								<td>Child</td>
								<td>{{ $activity->charges->SIC->child }}</td>
							</tr>
							<tr>
								<td>Infant</td>
								<td>{{ $activity->charges->SIC->infant }}</td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	@endif

	@if ($activity->privateStatus)
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Private Pricing <small>({{ $activity->currency }})</small></h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<table class="table table-striped">
						<tbody>
							<tr>
								<td>Adult</td>
								<td>{{ $activity->charges->Private->adult }}</td>
							</tr>
							<tr>
								<td>Child</td>
								<td>{{ $activity->charges->Private->child }}</td>
							</tr>
							<tr>
								<td>Infant</td>
								<td>{{ $activity->charges->Private->infant }}</td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	@endif

	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Activity Timing</h2>
				<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">

				@foreach ($activity->timing as $timing)
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>Opening Time</td>
								<td>{{ substr($timing->openingTime, 0, 5) }}</td>
							</tr>
							<tr>
								<td>Closing Time</td>
								<td>{{ substr($timing->closingTime, 0, 5) }}</td>
							</tr>
							<tr>
								<td>Duration</td>
								<td>{{ convertInHourMin($timing->duration) }}</td>
							</tr>
						</tbody>
					</table>
				@endforeach

			</div>
		</div>
	</div>

	@if ($activity->cars->count() > 0)
		<div class="col-md-8 col-sm-8 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Cars <small>({{ $activity->currency }})</small></h2>
					<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Car Name</th>
								<th>Valid From</th>
								<th>Valid To</th>
								<th>Capcity</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($activity->cars as $activityCar)
								<tr>
									<td>{{ $activityCar->carName }}</td>
									<td>{{ date_formatter($activityCar->fromDate, 'Y-m-d', 'd/m/Y') }}</td>
									<td>{{ date_formatter($activityCar->toDate, 'Y-m-d', 'd/m/Y') }}</td>
									<td>{{ $activityCar->capacity }} Seater</td>
									<td>{{ $activityCar->price }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	@endif

	<div class="col-md-8 col-sm-8 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Description</h2>
				<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">{{ $activity->description }}</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Activity Images</h2>
				<ul class="nav navbar-right panel_toolbox panel_toolbox1 pull-right">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				@foreach ($activity->images as $imageKey => $imagesTemp)
					<div class="{{$imageKey > 2 ? 'col-md-2 col-sm-2 height-100px m-top-10' : 'col-md-4 col-sm-4 height-200px' }} col-xs-12 ">
						<img src="{{ $imagesTemp->type == 'path' ? url($imagesTemp->imagePath) : $imagesTemp->url }}" alt="" height="100%" width="100%">
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="m-top-10">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<a href="{{ Request::url().'/edit' }}" class="btn btn-primary btn-block">Update</a>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
	    <a data-toggle="modal" data-target=".bs-example-modal-warning" class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Delete</a>
	    {{-- Small modal --}}
	      <div class="modal fade bs-example-modal-warning" tabindex="-1" role="dialog" aria-hidden="true">
	        <div class="modal-dialog modal-sm">
	          <div class="modal-content">

	            <div class="modal-header">
	              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
	              </button>
	              <h3 class="modal-title" id="myModalLabel2"><i class="fa fa-warning" ></i> Warning</h3>
	            </div>
	            <div class="modal-body">
	              <h4>Are you sure you want to delete?</h4>
	            </div>
	            <div class="modal-footer">
	            	<div class="col-md-6 col-sm-6 col-xs-12">
              		<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
              	</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
             			{!! Form::open(['url' => Request::url(), 'method' => 'DELETE']) !!}
               			<input type="submit" class="btn btn-danger btn-block" value="DELETE">
              		{!! Form::close() !!}
               	</div>
	            </div>

	          </div>
	        </div>
	      </div>
	    {{-- /modals --}}
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

	<script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>

@endsection

@section('scripts')

	{{-- <script type="text/javascript">
		$('#search_form').parsley();
	</script> --}}
	
	{{-- country change --}}
	<script>
		$(document).on('change', '.countries', function(){
			var countryObj = $(this).val();
			var countryObj = countryObj.split('|');
			console.log(countryObj);
			$('.currency').val(countryObj[1]);

			$('#countryCodeImg').val(countryObj[0]);
			
			var data = {
				"_token" : "{{ csrf_token() }}",
				"countryCode" : countryObj[0]
			}
			
			$.ajax({
				type:"post",
				url: "{{ url('/destination/option') }}",
				data: data,
				success: function(response, textStatus, xhr) {
					if(xhr.status == 200){
						$('select.destinations').html(response);
						// response_obj = JSON.parse(response);
						// console.log(response);

					}
				}
			});
		});
	</script>
	{{-- /country change --}}

	{{-- datepicker --}}
	<script>
		$(document).ready(function(){
			triggerDatePicker('.activityValidFrom', '.activityValidTo');
		});
		
		var checkInOut = function(inEl, outEl, now) {
			var checkin = inEl.datepicker({
				singleDatePicker: true,
				calender_style: "picker_3",
				onRender: function(date) {
					return date.valueOf() < now.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev) {
				if (ev.date.valueOf() > checkout.date.valueOf()) {
					var newDate = new Date(ev.date);
					newDate.setDate(newDate.getDate() + 1);
					checkout.setValue(newDate);
				}
				checkin.hide();
				outEl.focus();
			}).data('datepicker');
			var checkout = outEl.datepicker({
				onRender: function(date) {
					return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev) {
				checkout.hide();
			}).data('datepicker');
		};

		function triggerDatePicker(start, end) {
			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

			checkInOut($(start), $(end), now);
		}
	</script>
	{{-- /datepicker --}}

	{{-- datetimepicker --}}
	<script>
		$('.datetimepicker').datetimepicker({
			datepicker:false,
			format:'H:i'
		});
	</script>
	{{-- /datetimepicker --}}

	{{-- Adding or Removing-car --}}
	<script>
		$(document).on('click','#btn-addCar',function(){
			var activityCarHtml = $('#activityCarTemp').html();
			var currentCarCount = $('#activityCarDiv').children().length;
			activityCarHtml = activityCarHtml.replace('Temp_CarCount', (currentCarCount+1))
										.replace('activityCarTempId', 'activityCar_'+(currentCarCount+1))
										.replace('dpdStartTempCount', 'dpdStart_'+(currentCarCount+1))
										.replace('dpdEndTempCount', 'dpdEnd_'+(currentCarCount+1));

			$('#activityCarDiv').append(activityCarHtml);
			
			// adding datapicker of appending
			triggerDatePicker('.dpdStart_'+(currentCarCount+1), '.dpdEnd_'+(currentCarCount+1));
			// /adding datapicker of appending

			if(currentCarCount >= 0){
				$('#btn-removeCar, #pipeSapr').show();
			}
			// if(currentRoom == 2){
			// 	$('#btn-addCar, #pipeSapr').hide();
			// }
		});

		$(document).on('click','#btn-removeCar',function(){
			var currentCarCount = $('#activityCarDiv').children().length;

			$('#activityCar_'+currentCarCount).remove();

			if(currentCarCount == 1){
				$('#btn-removeCar, #pipeSapr').hide();
			}
			// if(currentRoom == 4){
			// 	$('#btn-addCar, #pipeSapr').show();
			// }
		});
	</script>
	{{-- /Adding or Removing-car --}}

	{{-- Adding or Removing-Timing --}}
	<script>
		$(document).on('click','#btn-addTiming',function(){
			var activityTimingHtml = $('#activityTimingTemp').html();
			var currentTimingCount = $('#activityTiming').children().length;
			activityTimingHtml = activityTimingHtml.replace('activityTimingCountTemp', 'activityTiming_'+(currentTimingCount+1));

			$('#activityTiming').append(activityTimingHtml);
			
			$('.datetimepicker').datetimepicker({
				datepicker:false,
				format:'H:i'
			});

			if(currentTimingCount == 1){
				$('#btn-removeTiming, #pipeTimeSapr').show();
			}
			// if(currentRoom == 2){
			// 	$('#btn-addTiming, #pipeSapr').hide();
			// }
		});

		$(document).on('click','#btn-removeTiming',function(){
			var currentTimingCount = $('#activityTiming').children().length;

			$('#activityTiming_'+currentTimingCount).remove();

			if(currentTimingCount == 2){
				$('#btn-removeTiming, #pipeTimeSapr').hide();
			}
			// if(currentRoom == 4){
			// 	$('#btn-addTiming, #pipeSapr').show();
			// }
		});
	</script>
	{{-- /Adding or Removing-Timing --}}

	{{-- form submition --}}
	<script>
		$(document).on('click','#formSubmit', function(){
			var countryObj = $('.countries').val();
			countryObj = countryObj.split('|');
			var currency = $('.currency').val();
			var destinationCode = $('.destinations').val();
			var activityName = $('.activityName').val();

			var activityValidFrom = $('.activityValidFrom').val();
			var activityValidTo = $('.activityValidTo').val();
			var sicAdultPrice = $('.sic-adultPrice').val();
			var sicChildPrice = $('.sic-childPrice').val();
			var sicInfantPrice = $('.sic-infantPrice').val();

			var privateAdultPrice = $('.private-adultPrice').val();
			var privateChildPrice = $('.private-childPrice').val();
			var privateInfantPrice = $('.private-infantPrice').val();

			var activityDescription = $('.activity-Description').val();

			var privateCar = [];

			var activityTiming = [];

			if(activityName != '' || destinationCode != ''){

				$('#activityCarDiv > .activity-car-inner').each(function(){
					
					var carName = $('.carName').val();
					var carValidFrom = $('.carValidFrom').val();
					var carValidTo = $('.carValidTo').val();
					var carCapcity = $('.carCapcity').val();
					var carPrice = $('.carPrice').val();

					var privateCarTemp = {
						'carName' : carName,
						'carValidFrom' : carValidFrom,
						'carValidTo' : carValidTo,
						'carCapcity' : carCapcity,
						'carPrice' : carPrice
					}

					privateCar.push(privateCarTemp);
				});

				$('#activityTiming > .activity-timing').each(function(){
					
					var openingTime = $('.opening-time').val();
					var duration = $('.duration').val();
					var closingTime = $('.closing-time').val();

					var activityTimingTemp = {
						'openingTime' : openingTime,
						'duration' : duration,
						'closingTime' : closingTime,
					}

					activityTiming.push(activityTimingTemp);
				});

				var data = {
					"_token":"{{ csrf_token() }}",
					"countryCode" : countryObj[0],
					"currency" : currency,
					"destinationCode" : destinationCode,
					"activityName" : activityName,
					"activityValidFrom" : activityValidFrom,
					"activityValidTo" : activityValidTo,
					"sicAdultPrice" : sicAdultPrice,
					"sicChildPrice" : sicChildPrice,
					"sicInfantPrice" : sicInfantPrice,
					"privateAdultPrice" : privateAdultPrice,
					"privateChildPrice" : privateChildPrice,
					"privateInfantPrice" : privateInfantPrice,
					"activityDescription" : activityDescription,
					"privateCar" : privateCar,
					"activityTiming" : activityTiming,
				}

				console.log(JSON.stringify(data));


				$.ajax({
					type:"post",
					url: "{{ url('dashboard/activities') }}",
					data: data,
					success: function(response, textStatus, xhr) {
						if(xhr.status == 200){
							response_obj = JSON.parse(response);
							$('#activityId').val(response_obj.response);
							$('#uploadImage').click();
						}
					},

					error: function(xhr, textStatus) {
						// console.log(textStatus);
						// console.log(xhr.status);
						if(xhr.status == 401){
							window.open("{{ url('login') }}", '_blank');
						}
					},

				});

			}
			else{
				alert('Enter Details Correctlly');
			}

		});
	</script>
	{{-- /form submition --}}

@endsection
