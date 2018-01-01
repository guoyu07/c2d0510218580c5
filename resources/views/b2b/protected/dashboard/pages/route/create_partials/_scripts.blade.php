<script>
	var windata = { 
			is_date_saved : {{ $package->is_start_date_set }},
			route_order : [],
			is_order_changed : false,
		}

	{{-- bootstrap-daterangepicker --}}

	$(document).ready(function() {
		if ($('#show_req').text().length < 1) {
			$('#edit_req').click(); // showing requirment popup
		}

		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_1",
			format : "DD/MM/YYYY",
			minDate : new Date(),
			startDate: new Date(),
		}, function(start, end, label) {
			// console.log(start.toISOString(), end.toISOString(), label);
		});

		$('.datetimepicker').each(function () {
			var time = $(this).val();
			initTimePicker(this, {now: time});
		});

		syncRouteOrder();

		$('.destinationClass').sortable({
			placeholder: "portlet-placeholder",
	    update: function(event, ui) {
	    	syncRouteOrder();
	    }
		});

	});

	{{-- /bootstrap-daterangepicker --}}


	{{-- Adding or Removing-room --}}

	$(document).on('click','#btn-addRoom',function(){
		storeRoom();
		addRoom();
	});

	$(document).on('click', '.rmv-room', function(){
		removeRoom(this);
	});

	{{-- /Adding or Removing-room --}}


	{{-- remove destination button --}}

	$('#btn-removeDestination').click(function(){
		var totalDestination = $('.destinationClass').children().length;
		$('#destination'+totalDestination).remove();

		if(totalDestination == 2){
			$('#btn-removeDestination, #pipeSaprDestination').hide();
		}
	});

	{{-- /remove destination button --}}



	{{-- requirement --}}

	$(document).on('click', '#edit_req', function() {

		var content = '<textarea id="confirm_package_req" class="width-100-p height-250px form-control has-feedback">'+$('#show_req').text()+'</textarea>'
		$.confirm({
			title : "Package requirements",
			content : content,
			buttons: {
				submit: {
					btnClass: 'btn-primary',
					action: function(){
						$('#show_req').text($('#confirm_package_req').val());
						$('#show_req').attr('data-saved', 0);
						clickTitlePopUp();
					}
				},
				cancel: function () {
					clickTitlePopUp();
				}
			}
		});

	});
	{{-- /requirement --}}


	{{-- package title --}}
	$(document).on('click', '#btn_package_title', function(){

		var content = '<input id="confirm_package_title" type="text" class="form-control has-feedback" value="'+$('#package_title').text()+'" placeholder="Singapore and bali..."/>'

		$.confirm({
			title : "Package title",
			content : content,
			buttons: {
				submit: {
					btnClass: 'btn-primary',
					action: function(){
						$('#package_title').text($('#confirm_package_title').val());
						$('#package_title').attr('data-saved', 0);
						$('#startDate').click();
					}
				},
				cancel: function () {
					$('#startDate').click();
				}
			}
		});
	});
	{{-- /package title --}}


	$(document).on('click', '.rmv-destlist', function () {
		var parant = $(this).closest('.destinationList');
		var rid = $(parant).attr('data-rid');

		if (rid != '') {
			postRemoveRoute(rid);
		}
		
		$(parant).remove();
		syncRouteOrder();
	});



	{{-- Adding or Removing-Destination --}}


	$(document).on('click', '.btn-add-route', function(){
		if (postRoute()) {
			saveDate();
			savePackageTitle();
			savePackageReq();
			/*var totalDestination = $('.destinationClass').children().length;*/
			var destinationListHtml = $('#destinationListHtml').html();
			var data_destination_count = addDestCount();
			var destinationId = 'destination'+data_destination_count;
			var inputDestinationId = 'inputDestination'+data_destination_count;

			destinationListHtml = destinationListHtml.replace('data_destination_count', data_destination_count);
			destinationListHtml = destinationListHtml.replace('selectNight_temp', 'selectNight');
			destinationListHtml = destinationListHtml.replace('destinationList_temp', 'destinationList');
			destinationListHtml = destinationListHtml.replace('destination_count', destinationId);
			destinationListHtml = destinationListHtml.replace('inputDestination_count', inputDestinationId);
			
			$(this).closest('.destinationList').after(destinationListHtml);
			syncRouteOrder();
		}
	});

	{{-- /Adding or Removing-Destination --}}


	$(document).on('change', '.nights', function () {
		var nights = $(this).val();

		if (nights == '') {
			$(this).addClass('inctv border-red');
			var parent = $(this).closest('.destinationList');
			changeInRoute(parent);
		}
		else{
			$(this).removeClass('inctv');
			$(this).removeClass('border-red');
		}
	});


	{{-- changing mode --}}

	$(document).on('change', '.mode', function(){
		var parent = $(this).closest('.destinationList');
		var workingElem = $(parent).find('.location-input-div');
		$(workingElem).addClass('inctv').html('');
		$(this).addClass('inctv');

		if(checkStartDate()){
			var thisVal = $(this).val();
			changeInRoute(parent);

			
			if (thisVal == '') {
				$(this).addClass('inctv border-red');
			}
			else{
				$(this).removeClass('inctv');
				$(this).removeClass('border-red');
			}

			if (thisVal == 'flight') {
				var originHtml = $('#originFlightTemp').html();
				var destinationTemp = $('#destinationTemp').html();

				$(workingElem).append(originHtml);
				$(workingElem).append(destinationTemp);
			}
			else if (thisVal == 'hotel' || thisVal == 'hotel_only' || thisVal == 'activity_only' || thisVal == 'cruise') {
				var destinationTemp = $('#destinationTemp').html();
				var nightTemp = $('#nightTemp').html();

				$(workingElem).append(destinationTemp);
				$(workingElem).append(nightTemp);
			}
			else if (thisVal == 'ferry' || thisVal == 'train' || thisVal == 'bus') {
				var destinationTemp = $('#destinationWithDatetimeTemp').html();
				var appendHtml = destinationTemp.replace(/temp-class/g, 'origin').replace(/"Location"/g, '"Origin"');
				appendHtml += destinationTemp.replace(/temp-class/g, 'destination').replace(/"Location"/g, '"Destination"');;
				$(workingElem).append(appendHtml);
				initTimePicker($(parent).find('.datetimepicker'), {now: "12:30"});
			}
			// $(parent).find('.location').val('');
		}else{
			$(this).prop('selectedIndex',0);
		}

	});

	{{-- /changing mode --}}


	$(document).on('keypress', '.datetimepicker', function(event) {
		event.preventDefault();
	});


	{{-- form submition --}}

	$(document).on('click','#formSubmit', function(){
		if(postRoute()){
			bootSubmitEvent(this);
			storeRoom();
			setTimeout(function () {
				formSubmit(this);
			}, 2000);
		}
	});

	{{-- /form submition --}}

</script>
@include('b2b.protected.dashboard.pages.common.guests.popup')
@include($viewPath.'.create_partials.autocomplete')
@include($viewPath.'.create_partials.function')