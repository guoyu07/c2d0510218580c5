<script>
	function getRidObject(rid) {
		return idObject['flight_'+rid];
	}

	function qpxDateTime(datetime) {
		var datetime = datetime.split('T');
		var time =  datetime[1].substring(0, 5);
		return {'date':datetime[0], 'time':time };
	}

	function objDateTime(datetime) {
		var datetime = datetime.split(' ');
		var time =  datetime[1].substring(0, 5);
		return {'date':datetime[0], 'time':time };
	}

	function ssDateTime(datetime) {
		var datetime = datetime.split('T');
		var time =  datetime[1].substring(0, 5);
		return {'date':datetime[0], 'time':time};
	}

	function getDate(datetime) {
		return moment(datetime).format("DD-MM-YYYY");
	}

	function getTime(datetime) {
		return moment(datetime).format("HH:mm");
	}


	function initDatetimePicker(thisObj) {
		$('.datetimepicker.init').datetimepicker({
			formatDate:'dd/mm/yyyy',
			formatTime:'H:i',
			minDate: 0,
		}).removeClass('init');

		{{--$(thisObj).find('.datepicker.init').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "D/M/YYYY",

		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		}).removeClass('init');--}}

	}


{{-- move to top --}}

	function moveToTop(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		$(parent).prepend(thisObj)
							.find('.border-green-2px')
								.removeClass('border-green-2px');

		$(thisObj).find('.x_panel.glowing-border').addClass('border-green-2px');
	}

{{-- /move to top --}}



	function refreashFlights(ids) {
		$('#loging_log').show();
		$('#'+ids.elem_id).append('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button data-vendor="'+ids.vendor+'" data-did="'+ids.did+'" data-rid="'+ids.rid+'" class="btn btn-primary btn-block refreash-flights">Refreash</button></div></div></div>');
	}



	function clickAtab(thisObj) {
		var rid = $(thisObj).attr('data-rid');
		var ridObject = getRidObject(rid);
		var origin = ridObject.origin;
		var destination = ridObject.destination;
		$('#modify_origin').val(origin);
		$('#modify_destination').val(destination);
		$('#modify_search').attr('data-rid', rid);
	}



	function modifySearch(thisObj) {
		$('#loging_log').show();
		var rid = $(thisObj).attr('data-rid');
		var origin = $('input.origin').val();
		var destination = $('input.destination').val();
		var origin_code = $('input.origin').attr('data-code');
		var destination_code = $('input.destination').attr('data-code');
		
		changeTabMenu(rid, origin, destination);

		idObject['flight_'+rid].origin = origin; {{--setting attribute here--}}
		idObject['flight_'+rid].destination = destination; {{--setting attribute here--}}
		
		{{--var arrival = $('input.arrival').val();
		var adult = $('input.adult').val();
		var child = $('input.child').val();
		var infant = $('input.infant').val();--}}

		var data = {
				"_token" : csrf_token,
				"origin" : origin,
				"destination" : destination,
				"origin_code" : origin_code,
				"destination_code" : destination_code
				{{--"arrival" : arrival,
				"adult" : adult,
				"child" : child,
				"infant" : infant,--}}
			};

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/route/update') }}/"+rid+"?format=json",
			dataType: "JSON",
			data: data,
			success: function(response) {
				/*console.log(response);*/
				if (response.status == 200) {
					$('#flight_'+rid).empty();
					fatchFlights(rid);
				}
      }
		});
	}




	function addToCart(thisObj) {
		$('#loging_log').show();

		$(thisObj).addClass('btn-danger')
								.removeClass('btn-primary')
									.text('Delete');

		var parent = $(thisObj).closest('.list.list-unstyled'); {{--parent ul element--}}
		$(parent).find('.btn-addtocart.btn-primary')
							 .addClass('btn-dark')
								 .removeClass('btn-primary');
		{{-- $('.btn-addtocart.btn-primary').prop('disabled', false); --}}

		postAddtoCartFlight(thisObj);
		moveToTop($(thisObj).closest('.main-list-item'));
	}


	function addToCartCustom(thisObj) {
		$('#loging_log').show();

		$(thisObj).addClass('btn-danger')
								.removeClass('btn-primary')
									.text('Delete');

		var parent = $(thisObj).closest('.list.list-unstyled');
		$(parent).find('.btn-addtocart.btn-primary')
							 .addClass('btn-dark')
								 .removeClass('btn-primary');

		var parentLi = $(thisObj).closest('.main-list-item');
		var segments = makeCustomFlightArray(parentLi);

		var rid = $(parent).attr('data-rid');
		var ind = $(thisObj).attr('data-ind');
		var vdr = $(thisObj).attr('data-vdr');
		var vid = $(thisObj).attr('data-vid');
		var ridObject = getRidObject(rid);
		var data = {
				"rid" : rid,
				"ind" : ind,
				"vdr" : vdr,
				"vid" : vid,
				"next_rid" : ridObject.next_rid,
				"segments" : segments,
				"_token" : csrf_token
			};
		saveCustomFlight(data, thisObj);
		moveToTop($(thisObj).closest('.main-list-item'));
	}


	function makeCustomFlightArray(thisObj) {
		var data = [];
		$(thisObj).find('.custom-flight-cart').each(function(){
			var uid = $(this).attr('data-uid');
			var vsid = $(this).attr('data-vsid');
			var flightName = $(this).find('.flight-name').val();
			var flightCode = $(this).find('.flight-name').attr('data-code');
			var flightNo = $(this).find('.flight-number').val();
			var origin = $(this).find('.origin').val();
			var origin_code = $(this).find('.origin').attr('data-code');
			var destination = $(this).find('.destination').val();
			var destination_code = $(this).find('.destination').attr('data-code');
			var arrival = $(this).find('.arrival').val();
			var departure = $(this).find('.departure').val();

			data.push({
					"uid" : uid,
					"vsid" : vsid,
					"name" : flightName,
					"code" : flightCode,
					"number" : flightNo,
					"origin" : origin,
					"origin_code" : origin_code,
					"destination" : destination,
					"destination_code" : destination_code,
					"arrival" : arrival,
					"departure" : departure
				});
		});
		return data;
	}
	


	function postAddtoCartFlight(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		var rid = $(parent).attr('data-rid'); {{-- route id --}}
		var ind = $(thisObj).attr('data-ind'); {{-- index --}}
		var vdr = $(thisObj).attr('data-vdr'); {{-- api vendor --}}
		var vid = $(thisObj).attr('data-vid'); {{-- api vendor db id --}}
		var ridObject = getRidObject(rid);
		var next_rid = ridObject.next_rid;
		var data = {
				"ind" : ind,
				"vdr" : vdr,
				"vid" : vid,
				"_token" : csrf_token
			};

		$.ajax({
			type	: "post",
			url 	:	"{{ urlFlightBook() }}"+rid,
			dataType: "JSON",
			data 	: data,
			success : function(response){
				if (response.status == 200) {
					if (next_rid != "NaN") {
						setTimeout(function () {
							if (isPulled(next_rid) == 0) {
								fatchFlights(next_rid);
							}
							else{
								$('#loging_log').hide();
							}
					  }, 2000);
					}
					else{
						setTimeout(function () {    
							document.location.href = "{{ $package->eventActionUrl('flights') }}";
					  }, 2000)
					}
					clickNext(next_rid);
				}
				else{
					alert('Something went wrong please try again.');
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				alert('Something went wrong please try again.');
			}
		});
	}


	function saveCustomFlight(dataObj, thisObj) {
		var data = dataObj;
		delete data.next_rid;
		var parent = $(thisObj).closest('.main-list-item');
		$.ajax({
			type	: "post",
			url 	:	"{{ url('custom/flights/add') }}/"+data.rid,
			dataType: "JSON",
			data 	: data,
			success : function(response){
				$(thisObj).attr('data-vdr', response.vdr);
				$(thisObj).attr('data-vid', response.vid);
				$(thisObj).attr('data-ind', response.vid);
				$.each(response.sres, function (i, v) {
					$(parent).find('[data-uid="'+i+'"]').attr('data-vsid', v);
				});
				postAddtoCartFlight(thisObj);
			}
		});
	}



	function getFlightStack(flight) {
		var appendHtml = '';
		var searchWord = '';
		@include($viewPath.'.partials.scripts.html')
		return appendHtml;
	}




	function dataIsPulled(rid) {
		$('#flight_'+rid).attr('data-ispulled', 1);
	}

	function isPulled(rid) {
		return $('#flight_'+rid).attr('data-ispulled');
	}


	function changeTabMenu(rid, origin, destination) {
		var originCode = origin.substring(0,3);
		var destinationCode = destination.substring(0,3);
		$('#a_flight_'+rid).text(originCode+' → '+destinationCode);
	}


	function clickNext(rid) {
		$('#a_flight_'+rid).click();
		$('#filter_search').val('');
		$('.search-stop').attr('checked', false);
	}

	function addCustomFlight(thisObj) {
		var parent = $('.tab-content.tab-content-box')
										.find('.tab-pane.active')
											.find('.list.list-unstyled');

		var html = '@include($viewPath.'.partials.add_flight.index')';
		$(parent).append(html);
		initDatetimePicker(parent);
		$("html, body").animate({ 
			scrollTop: $(document).height()-$(window).height()
		});
	}

	function addCustomFlightCart(thisObj) {
		var uid = parseInt($(thisObj).attr('data-count'))+1;
		var parent = $(thisObj).closest('.x_panel.glowing-border');
		var html = '@include($viewPath.'.partials.add_flight.cart')';
		html = html.replace(/class="hide"/g, '')
						.replace(/uid="A0"/g, 'uid="A'+uid+'"');
		$(parent).find('.custom-flight').append(html);
		initDatetimePicker(parent);
	}

	function removeCustomFlightCart(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		var cart = $(thisObj).closest('.custom-flight-cart');
		var vsid = $(cart).attr('data-vsid');
		var rid = $(parent).attr('data-rid');
		$.ajax({
			url 		:	"{{ url('custom/flights/remove') }}/"+rid,
			type		: "post",
			dataType: "JSON",
			data 		: {"vsid" : vsid, "_token" : csrf_token },
			success : function(response){
				$(cart).remove();
			}
		});
	}

	function defaultAirlineIcon(thisObj) {
		thisObj.src = "{{ urlImage('images/airlineImages/__.gif') }}";
		return false;
	}

	function fatchFlights(rid) {
		var vdr = ['qpx'];
		$.each(vdr, function (i, vdr) {
			url = "{{ url('api/flights/result') }}/"+vdr+"/"+rid+"?format=json";
			$.ajax({
				url 		:	url,
				type		: "post",
				dataType: "JSON",
				data 		: { "_token" : csrf_token },
				success : function(response){
					populateFlights(rid, response);
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					alert('Something went wrong please try again.');
				}
			});
		});
	}

	function populateFlights(rid, data) {
		$('#loging_log').hide();
		var ridObject = getRidObject(rid);
		var elem_id = ridObject.elem_id;

		if (data.flights.length) {
			$.each(data.flights, function (flightsKey, flights) {
				var stacks = [];
				$.each(flights, function (flightKey, flight) {
					var arrivalDateTime = objDateTime(flight.arrival_date_time);
					var departureDateTime = objDateTime(flight.departure_date_time);
					stacks.push({
						"name" : flight.airline_name.replace('Limited', ''),
						"code" : flight.airline_code,
						"flightNumber" : flight.airline_number, 
						"departureTime" : departureDateTime.time,
						"departureDate" : departureDateTime.date,
						"arrivalTime" : arrivalDateTime.time,
						"arrivalDate" : arrivalDateTime.date,
						"origin" : flight.origin,
						"originCode" : flight.origin_code,
						"destination" : flight.destination,
						"destinationCode" : flight.destination_code,
					});
				});

				var flightObj = {
						'vid' : data.db.id,
						'vdr' : data.db.vdr,
						'ind' : flightsKey,
						'stacks' : stacks,
						'stops' : stacks.length
					};

				var html = getFlightStack(flightObj);
				$('#'+elem_id).append(html);
			});
		}
		else{
			$.alert({
				title : 'Sorry...No Result Found.',
				content : 'you can <b class="red">add flight manually</b> or Modify Search.'
			});
		}

		dataIsPulled(rid);					
		filter.initFilter(rid);
	}


</script>

{{-- @include($viewPath.'.partials.scripts.qpx')
@include($viewPath.'.partials.scripts.ss') --}}