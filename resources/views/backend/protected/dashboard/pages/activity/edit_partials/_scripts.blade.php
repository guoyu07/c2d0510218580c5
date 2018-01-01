
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
		triggerDatePicker('.carStartDate', '.carEndDate');
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

			var images = makeImagesObject();

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
				"images" : images
			}

			$.ajax({
				type:"post",
				url: "{{ url('dashboard/activities') }}",
				data: data,
				success: function(response, textStatus, xhr) {
					if(xhr.status == 200){
						response = JSON.parse(response);
						/*console.log(response.nextUrl);*/
						alert(response.response);
						document.location.href = response.nextUrl;

					}
        },

        error: function(xhr, textStatus) {
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
