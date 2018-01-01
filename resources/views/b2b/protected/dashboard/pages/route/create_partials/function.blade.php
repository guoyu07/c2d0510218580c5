<script>

	function initTimePicker(elem, option = {}){
		var option = $.extend({}, {twentyFour: true}, option);
		$(elem).wickedpicker(option);

		/*$(parent).find('.datetimepicker').timepicker();*/

		/*$(parent).find('.datetimepicker').datetimepicker({
			formatDate:'d/m/Y',
			formatTime:'H:i',
			minDate: 0,
		});*/
	}



	function initDateTime(elem) {
		$(elem).datetimepicker({
			formatDate:'d/m/Y',
			formatTime:'H:i',
			minDate: 0,
		});
	}



	function addDestCount() {
		var totalDest = $('#btn-addDestination').attr('data-count');
		var totalDest = parseInt(totalDest);
		var totalDest = totalDest+1;
		$('#btn-addDestination').attr('data-count', totalDest);
		return totalDest;
	}



	function postRemoveRoute(rid) {
		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/route') }}/"+rid+"/d",
			data: {"_token" : csrf_token}
		});
	}



	function checkStartDate() {
		var startDate = $('#startDate').val();

		if(startDate != ''){
			$('#startDate').addClass('border-blue-2px');
			$('#startDate').removeClass('border-red');
			return true;
		}
		else{
			$('#startDate').addClass('border-red');
			$('#startDate').removeClass('border-blue-2px');

			$.alert({
				title: '<i class="fa fa-exclamation-triangle"></i> Warning.', 
				content : 'Please select <b class="red">start date</b> ...',
				buttons: {
					Okay: function () {
						$('#startDate').click();
					},
				}
			});

			return false;
		}
	}



	function checkMode() {
		var mode = $('.destinationList').find('.mode.inctv');
		if (mode.length) {
			$(mode).addClass('border-red').prop('selectedIndex',0);;
			$.alert('I think you forgot to select mode. it\'s vary easy just click on mode and select.');
			return false;
		}
		else{
			return true;
		}
	}



	function checkLocation() {
		var location = $('.destinationList').find('.location.inctv');
		if (location.length) {
			$(location).addClass('border-red');
			$.alert('You forgot to write location.');
			return false;
		}
		else{
			return true;
		}
	}



	function checkNights() {
		var nights = $('.destinationList').find('.nights.inctv');
		if (nights.length) {
			$(nights).addClass('border-red');
			$.alert('You forgot to select nights.');
			return false;
		}
		else{
			return true;
		}
	}



	function checkInputs() {
		if (checkStartDate() && checkMode() && checkLocation() && checkNights()) {
			return true;
		}
		else{
			return false;
		}
	}



	function changeInRoute(route) {
		$(route).addClass('no-rid');
	}



	function getRoute() {
		var route = []; 
		var routeCount = $('.destinationList').length;

		$('.destinationList').each(function(){
			var mode = $(this).find('.mode').val();
			if (mode == '') {
				$(this).find('.mode').addClass('border-red')
															.prop('selectedIndex',0);
				$.alert('I think you forgot to select mode. it\'s vary easy just click on mode and select.');
				return false;
			}else{
				$(this).find('.mode').removeClass('border-red');
			}

			var origin = $(this).find('.origin').val();
			var origin_code = $(this).find('.origin').attr('data-code');
			if (origin == '' && mode == 'flight') {
				$(this).find('.origin').addClass('border-red');
				$.alert('You forgot to write origin.');
				return false;
			}
			if((mode == 'flight' || mode == 'train' || mode == 'ferry') && origin.indexOf(', ') == -1){
				$(this).find('.origin').addClass('border-red');
				$.alert('You forgot to write origin.');
				return false;
			}
			else{
				$(this).find('.origin').removeClass('border-red');
			}

			var destination = $(this).find('.destination').val();
			var destination_code = $(this).find('.destination').attr('data-code');
			if (destination == '') {
				$(this).find('.destination').addClass('border-red');
				$.alert('You forgot to write destination.');
				return false;
			}if(destination.indexOf(', ')  == -1){
				$(this).find('.destination').addClass('border-red');
				$.alert('You forgot to write destination.');
				return false;
			}else{
				$(this).find('.destination').removeClass('border-red');
			}

			var nights = $(this).find('.nights').val();
			if (nights == '') {
				$(this).find('.nights').addClass('border-red');
				$.alert('You forgot to select nights.');
				return false;
			}else{
				$(this).find('.nights').removeClass('border-red');
			}

			var origin_time = $(this).find('.origin-time').val();
			var destination_time = $(this).find('.destination-time').val();

			var routeData = {
				"mode" : mode,
				"origin" : origin,
				"origin_code" : origin_code,
				"origin_time" : origin_time,
				"destination" : destination,
				"destination_code" : destination_code,
				"destination_time" : destination_time,
				"nights" : nights,
			};

			route.push(routeData);
		});
		if (route.length == routeCount) {
			return route;
		}else{
			return false;
		}
	
	}



	function postRoute() {
		if (checkInputs()) {
			$('.destinationList.no-rid').each(function(){
				var thisElem = $(this);
				var rid = $(this).attr("data-rid");
				var mode = $(this).find('.mode').val();
				var origin = $(this).find('.origin').val();
				var origin_code = $(this).find('.origin').attr('data-code');
				var nights = $(this).find('.nights').val();
				var destination = $(this).find('.destination').val();
				var destination_code = $(this).find('.destination').attr('data-code');
				var origin_time = $(this).find('.origin-time').val();
				var destination_time = $(this).find('.destination-time').val();
				var pid = $('#startDate').attr('data-pid');

				var data = {
					"rid" : rid,
					"mode" : mode,
					"origin" : origin,
					"nights" : nights,
					"_token" : csrf_token,
					"origin_code" : origin_code,
					"origin_time" : origin_time,
					"destination" : destination,
					"destination_code" : destination_code,
					"destination_time" : destination_time
				};

				$.ajax({
					type:"post",
					url: "{{ url('dashboard/package/route/'.$package->token.'/r') }}",
					data: data,
					success : function (rid) {
						$(thisElem).attr('data-rid', rid);
					}
				});

				$(this).removeClass('no-rid');
				return true;
			});
			return true;
		}
		else{
			return false;
		}
	}


	function bootSubmitEvent(thisObj) {
		showWaitingLogo();
		$(thisObj).addClass('disabled');
		$(thisObj).prop('disabled', true);
	}


	function formSubmit(thisObj) {
		var startDate = $('#startDate').val();
		var pid = $('#startDate').attr('data-pid');

		/*var roomGuests = $('.room-guest:visible').map(function() {

			var childAge = $(this).find('.age-elem').map(function() {
				return $(this).val();
			}).get();

			return {
				'NoOfAdults': $(this).find('.adults').val(),
				'ChildAge': childAge,
			}
		}).get();*/


		var req = $('#show_req').text();
		var data = {
			"_token" : csrf_token,
			"pid" : pid,
			"req" : req,
			"startDate" : startDate,
			"order" : getOrderRouteData()
			// "roomGuests" : roomGuests
		}

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/route/'.$package->token.'/u') }}",
			data: data,
			dataType : 'JSON',
			success: function(response, textStatus, xhr) {
				if(xhr.status == 200){
					document.location.href = response.nextUrl;
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
			}
		});
	}

	function saveDate() {
		if (windata.is_date_saved == 0) {
			var startDate = $('#startDate').val();
			updatePackageAttributes({ "start_date" : startDate });
		}
	}



	function savePackageTitle() {
		var title = $('#package_title').text();
		if ($('#package_title').attr('data-saved') == 0) {
			updatePackageAttributes({ "title" : title });
			$('#package_title').attr('data-saved', 1);
		}
	}

	function savePackageReq() {
		var title = $('#show_req').text();
		if ($('#show_req').attr('data-saved') == 0) {
			updatePackageAttributes({ "req" : title });
			$('#show_req').attr('data-saved', 1);
		}
	}

	function clickTitlePopUp(){
		if ($('#package_title').attr('data-saved') == 0) {
			$('#btn_package_title').click();
		}
	};

	function updatePackageAttributes(data){

		data['_token'] = csrf_token;

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/route/'.$package->token.'/ua') }}",
			data: data,
			dataType : 'JSON',
			success: function(response) {
				if (response.status == 200) {
				}
			}
		});
	}


	function addRoom() {
		var count = parseInt($('#btn-addRoom').attr('data-count'), 10);
		count++;
		$('#btn-addRoom').attr('data-count', count);
		var html = '{!! myView($viewPath.'.create_partials.rooms.room_temp') !!}';
		$('#room').append(html);
	}

	function storeRoom() {
		$('.room-guest.inctv').each(function (i, v) {
			var id = $(this).attr('data-id');
			var rooms = $(this).find('.room-count').val();
			var adults = $(this).find('.adults').val();
			var childAge = $(this).find('.age-elem').map(function() {
					return {
							'id' : $(this).attr('data-id'),
							'age': $(this).val()
						};
				}).get();

			var data = {
				"id" : id,
				"rooms" : rooms,
				"adults" : adults,
				"_token" : csrf_token,
				"children_age" : childAge
			};

			$.ajax({
				type:"post",
				url: "{{ url('dashboard/package/route/'.$package->token.'/room') }}",
				data: data,
				dataType : "JSON",
				success : function (response) {
					$(v).attr('data-id', response.id).removeClass('inctv');
					setAgeId(v, response.age_ids);
				}
			});
		});
		return true;
	}


	function removeRoom(thisObj) {
		var roomGuest = $(thisObj).closest('.room-guest');
		var id = parseInt($(roomGuest).attr('data-id'), 10);
		if (id > 0) {
			$.ajax({
				type:"post",
				url: "{{ url('dashboard/package/route') }}/"+id+"/removeroom",
				data: {"_token" : csrf_token},
				dataType : "JSON",
				success : function (response) {
					if (response.status == 200) {
						$(roomGuest).remove();
					}
				}
			});
		}
		else{
			$(roomGuest).remove();
		}
	}

	function setAgeId(thisObj, data) {
		$(thisObj).find('.age-elem').each(function (i, v) {
			var value = data[i];
			$(this).attr('data-id', value.id);
		});
		return false;
	}

	function getOrderRouteData() {
		var route_order = [];
		$('.destinationList').each(function (i, v) {
			var order = i+1;
			var rid = $(v).attr('data-rid');
			$(v).attr('data-order', order);
			route_order.push({"order" : order, "rid" : rid});
		});

		windata.route_order = route_order;
		return windata.route_order;
	}


	function syncRouteOrder() {
		var result = false;
		var data = {"_token" : csrf_token, "order" : getOrderRouteData() };
		$.ajax({
			url : "{{url('dashboard/package/route/'.$package->token.'/ro')}}",
			type : "post",
			dataType : 'JSON',
			data : data,
			success : function (response) {
				if (response.status == 200) {
					result = true;
					return true
				}
			}
		});
		return result;
	}
</script>