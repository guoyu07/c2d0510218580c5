@include($viewPath.'.partials.scripts.objects')
<script>

	var windata = {
		current_rtoken : "{{ isset($flightRoutes->first()->token) ? $flightRoutes->first()->token : "" }}",
		routes : {!! $flightRoutes->pluck('route_formatted', 'token')->toJson() !!},
		routes_order : {!! $flightRoutes->pluck('token')->toJson() !!},
		search_name : '',
		is_searched : false,
		last_rtoken : "{{ isset($flightRoutes->last()->token) ? $flightRoutes->last()->token : "" }}",
		getCurrentRoute : function () {
			return this.getRouteData(this.current_rtoken);
		},

		getRouteData : function(rtoken){
			return this.routes[rtoken];
		},

		getNextRouteToken : function(rtoken){
			var isFound = false;
			var nextRtoken = "";
			
			$.each(this.routes_order, function(i, v){
				if (isFound) {
					nextRtoken = v;
					return false
				}

				if (rtoken == v) {
					isFound = true;
				}
			});

			return nextRtoken;
		},

		nextFlightEvent : function (current_rtoken) {
			$('#loging_log').show();

			if (current_rtoken == this.last_rtoken) {
				setTimeout(function () {    
					document.location.href = "{{ $package->eventActionUrl('flights') }}";
				}, 5000);
			}
			else{
				var rtoken = this.getNextRouteToken(current_rtoken);
				$('[href="#target_'+rtoken+'"]').click();
				this.fatchFlights(rtoken);
			}
		},

		setGuestDetails: function(){
			this.guest_details.data['rtoken'] = this.current_rtoken;
			this.guest_details.data.rooms = this.routes[this.current_rtoken].guest_details;
			this.guest_details.data.no_of_room = this.guest_details.data.rooms.length;
			this.makeGuestDetailtTitle();
		},

		setRouteInfo(rtoken){
			var route = this.getRouteData(rtoken);
			this.current_rtoken = rtoken;
			$('#modify_origin').val(_.get(route, 'origin'));
			$('#modify_origin').attr('data-code', _.get(route, 'origin_code'));
			$('#modify_destination').val(_.get(route, 'destination'));
			$('#modify_destination').attr('data-code', _.get(route, 'destination'));
			$('#filter_search').val('');
			
			$('.search-stop').prop('checked', false);
			this.setRouteStartDate(rtoken, _.get(route, 'start_date'));
		},

		setRouteStartDate(rtoken, date){
			route = this.getRouteData(rtoken);
			if (_.get(route, 'start_date', null) != null) {
				route.start_date = moment(date).format('YYYY-MM-DD');
				$('span.show-date').html(moment(date).format('DD-MMM-YYYY'));
			}
		},

		fatchFlights : function (rtoken) {
			thisObj = this;
			var vdrs = ['qpx'];
			$.each(vdrs, function (i, vdr) {
				url = "{{ url('api/flights/result') }}/"+vdr+"/"+rtoken+"?format=json";
				$.ajax({
					url 		:	url,
					type		: "post",
					dataType: "JSON",
					data 		: { "_token" : csrf_token },
					success : function(response){
						$('#loging_log').hide();
						thisObj.populateFlights(rtoken, response.flights);
					},
					error: function(xhr, textStatus) {
						$('#loging_log').hide();
						if(xhr.status == 401){
							window.open("{{ url('login') }}", '_blank');
						}
						$.alert('Something went wrong please try again.');
					}
				});
			});
		},

		populateSelectedFlights : function () {
			thisObj = this;
			$.each(this.routes, function (rtoken, route) {
				flights = _.get(route, 'package_flights', []);
				thisObj.populateFlights(route.token, flights, true);
			});
		},

		populateStoredFlights : function () {
			flights = _.get(getCurrentRoute(), 'stored_flights', []);
		},

		addFlightManually : function (rtoken) {
			var thisObj = this;
			var content = `<div class="add-flight-pop-up max-height-450px scroll-auto scroll-bar">@include($viewPath.'.partials.add_flight.index')</div>`;

			$.confirm({
				title : "Add Flight",
				columnClass: 'col-md-8 col-md-offset-2',
				content : content,
				onContentReady : function () {
					$(":input").inputmask();
					var startDate = moment(windata.getRouteData(rtoken).start_date, "YYYY-MM-DD");
					var endDate = moment(startDate).add(3, 'days');
					var optionSet = {
						singleDatePicker: true,
						calender_style: "picker_1",
						format : "DD/MM/YYYY",
						minDate : startDate,
						maxDate : endDate,
						startDate: new Date(startDate),
						endDate: new Date(endDate)
					};

					$('.datetimepicker.init').daterangepicker(optionSet);

					$('.add-flight-pop-up').find('.datetimepicker.departure-date')
																	.val(startDate.format("DD/MM/YYYY"));
					
				},
				buttons: {
					submit: {
						btnClass: 'btn-primary',
						action: function(){
							var obj = thisObj.makeFlightManuallyObject(rtoken);
							if (obj.empty) { return false; }
							thisObj.storeFlightManually(rtoken, _.get(obj, 'data'));
						}
					},
					cancel: function () {

					}
				}
			});
		},

		makeFlightManuallyObject : function (rtoken) {
			
			var result = {empty : false, data : [] };

			$('.custom-flight-cart').each(function () {

				$(this).find('input[type="text"]').each(function(){
				  if($(this).val() == ""){
				    result.empty = true;
				    result.data = [];
				    $(this).addClass('border-red').effect('shake');
				    return false;
				  }
				  $(this).removeClass('border-red');
				});

				if (result.empty) { return false; }

				var flightName = $(this).find('.flight-name').val();
				var flightCode = $(this).find('.flight-name').attr('data-code');
				var flightNo = $(this).find('.flight-number').val();
				var origin = $(this).find('.origin').val();
				var origin_code = $(this).find('.origin').attr('data-code');
				var destination = $(this).find('.destination').val();
				var destination_code = $(this).find('.destination').attr('data-code');
				var arrivalDate = $(this).find('.arrival-date').val();
				var departureDate = $(this).find('.departure-date').val();
				var arrivalTime = $(this).find('.arrival-time').val();
				var departureTime = $(this).find('.departure-time').val();

				result.data.push({
					"name" : flightName,
					"code" : flightCode,
					"number" : flightNo,
					"origin" : origin,
					"origin_code" : origin_code,
					"destination" : destination,
					"destination_code" : destination_code,
					"arrival" : arrivalDate+' '+arrivalTime,
					"departure" : departureDate+' '+departureTime
				});
			});

			return result;
		},

		storeFlightManually : function (rtoken, flights) {
			thisObj = this;
			$.ajax({
				url : "{{ url('custom/flights/add') }}",
				type : 'post',
				data : { _token : csrf_token, 'flights' : flights },
				dataType : 'JSON',
				success : function (response) {
					thisObj.populateFlights(rtoken, [response], false, false);
				}
			});
		},

		populateFlights : function (rtoken, flightData, isFixed = false, append=true) {
			console.log(rtoken);
			thisObj = this;

			if (flightData.length) {
				$.each(flightData, function (flightsKey, flights) {
					var stacks = [];
					$.each(flights.connections, function (flightKey, flight) {
						var arrDateTime = objDateTime(_.get(flight, 'arrival_date_time'));
						var depDateTime = objDateTime(_.get(flight, 'departure_date_time'));
						stacks.push({
							"name" : _.get(flight,'airline_name').replace('Limited', ''),
							"code" : _.get(flight, 'airline_code'),
							"flightNumber" : _.get(flight,'airline_number'), 
							"departureTime" : _.get(depDateTime,'time'),
							"departureDate" : _.get(depDateTime,'date'),
							"arrivalTime" : _.get(arrDateTime,'time'),
							"arrivalDate" : _.get(arrDateTime,'date'),
							"origin" : _.get(flight,'origin'),
							"originCode" : _.get(flight,'origin_code'),
							"destination" : _.get(flight,'destination'),
							"destinationCode" : _.get(flight,'destination_code'),
						});
					});
					var btnClass = isFixed ? 'danger' : 'primary';
					var btnName = isFixed ? 'Delete' : 'Select';

					var flightObj = {
							'vid' : _.get(flights,'vendor_id'),
							'vdr' : _.get(flights,'vendor'),
							'ind' : _.get(flights,'id'),
							'psid' : _.get(flights, 'package_service_id'),
							'stops' : _.get(flights,'stops'),
							'stacks' : stacks,
							'btnName' : btnName,
							'btnClass' : btnClass
						};

					var html = thisObj.makeFlightHtmlStack(flightObj);
					var container = isFixed ? '#fixed_' : '#result_';
					console.log(container+rtoken);
					if (append) {
						$(container+rtoken).append(html);
					}else{
						$(container+rtoken).prepend(html);
					}
				});
			}
			else{
				/*$.alert({
					title : 'Sorry...No Result Found.',
					content : 'you can <b class="red">add flight manually</b> or Modify Search.'
				});*/
			}

			if (!isFixed) {
				filter.initFilter(rtoken);
			}
		},

		makeFlightHtmlStack : function (flight) {
			var appendHtml = '';
			var searchWord = '';
			@include($viewPath.'.partials.scripts.html')
			return appendHtml;
		},

		addToCart : function (elem, rtoken) {
			thisObj = this;
			$('#loging_log').show();
			$(elem).toggleClass('btn-primary btn-danger').text('Delete');

			var data = {
					"_token" : csrf_token,
					"ind" : $(elem).attr('data-ind'), {{-- index --}}
					"vdr" : $(elem).attr('data-vdr'), {{-- api vendor --}}
					"vid" : $(elem).attr('data-vid') {{-- api vendor db id --}}
				};

			$.ajax({
				type	: "post",
				url 	:	"{{ urlFlightBook() }}"+rtoken,
				dataType: "JSON",
				data 	: data,
				success : function(response){
					$('#loging_log').hide();
					if (response.status == 200) {
						$(elem).attr('data-psid', response.id); {{-- package service id --}}
						thisObj.setRouteStartDate(
									thisObj.getNextRouteToken(rtoken), 
									_.get(response, 'end_date_time.date')
								);
						parentLi = $(elem).closest('.main-list-item');
						fixedBox = $(parentLi).closest('.tab-pane.tab-target')
													.find('.list.list-unstyled.fixed');
						$(parentLi).appendTo(fixedBox);
						filter.initFilter(rtoken);
					}
					else{
						$.alert('Something went wrong please try again.');
					}
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					$.alert('Something went wrong please try again.');
				}
			});
		},

		removeToCart : function (elem, rtoken) {
			thisObj = this;

			$('#loging_log').show();

			$(elem).toggleClass('btn-primary btn-danger').text('Select');

			var data = {
					"_method" : 'delete',
					"_token" 	: csrf_token,
					"psid" 		: $(elem).attr('data-psid')
				};

			$.ajax({
				type	: "post",
				url 	:	"{{ urlFlightBook() }}"+rtoken,
				dataType: "JSON",
				data 	: data,
				success : function(response){
					$('#loging_log').hide();
					if (response.status == 200) {
						$(elem).attr('data-psid', ''); {{-- package service id --}}
						parentLi = $(elem).closest('.main-list-item');
						resultBox = $(parentLi).closest('.tab-pane.tab-target')
													.find('.list.list-unstyled.result');
						$(parentLi).appendTo(resultBox);
						filter.initFilter(rtoken);
					}
					else{
						$.alert('Something went wrong please try again.');
					}
				}
			});
		}
	};



	{{-- bootstrap-daterangepicker --}}

	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "D/M/YYYY",

		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});
		/*$('#loging_log').hide();*/
		windata.populateSelectedFlights();
		windata.fatchFlights('{{$package->flightRoutes->first()->token}}');
	});

	{{-- /bootstrap-daterangepicker --}}


	{{-- filter List.js--}}
	var filter = {
		@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
			'flight_{{ $flightRoute->token }}' : '',
		@endforeach
		initFilter : function (targetList) {
			var options = { valueNames: ['search-word', 'stops'] };
			@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
				if (targetList == '{{ $flightRoute->token }}') {
					this.flight_{{ $flightRoute->token }} = new List("filter_{{ $flightRoute->token }}", options);
				}
			@endforeach
		}
	};

	var activeFilters = [];


	$(document).on('keypress keyup keydown', "#filter_search", function(){
		var targetList = windata.current_rtoken;
		var search = $(this).val();
		@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
			if (targetList == "{{ $flightRoute->token }}") {
				filter.flight_{{ $flightRoute->token }}.search(search);
			}
		@endforeach
	});

	$(document).on('change', '.search-stop', function() {
		var isChecked = this.checked;
		var value = $(this).data("value");
		if(isChecked){
			/*add to list of active filters*/
			activeFilters.push(value);
		}
		else
		{
			/*remove from active filters*/
			activeFilters.splice(activeFilters.indexOf(value), 1);
		}
		
		@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
			if (windata.current_rtoken == "{{ $flightRoute->token }}") {
				filter.flight_{{ $flightRoute->token }}.filter(function (item) {
					if(activeFilters.length > 0)
					{
						return(activeFilters.indexOf(item.values().stops)) > -1;
					}
					return true;
				});
			}
		@endforeach

	});

	{{-- /filter List.js --}}

	{{-- modify search --}}

	$(document).on('click', '#modify_search', function(){
		modifySearch(this);
	});
	{{-- /modify search --}}


	{{-- Book Flight --}}
	$(document).on('click', '.btn-addtocart.btn-primary', function(){
		windata.addToCart(this, windata.current_rtoken);
	});

	$(document).on('click', '.btn-addtocart.btn-danger', function(){
		windata.removeToCart(this, windata.current_rtoken);
	});
	{{-- /Book Flight --}}


	{{-- Book Flight=
	$(document).on('click', '.btn-addtocart-custom', function(){
		addToCartCustom(this);
		return false;
	});
	 /Book Flight --}}

	$(document).on('click', '#btn_next', function () {
		windata.nextFlightEvent(windata.current_rtoken);		
	});

	$(document).on('click', '.a-tab-menu', function(){
		var rtoken = $(this).attr('href').replace('#target_', '');
		windata.setRouteInfo(rtoken);
	});

	$(document).on('click', '.a_tab_menu',function () {
		clickAtab(this);
		return false;
	});

	$(document).on('click', '.add-custom-flight', function () {
		windata.addFlightManually(windata.current_rtoken);

		/*addCustomFlight(this);*/
		return false;
	});

	$(document).on('click', '.add-custom-flight-cart', function () {
		addCustomFlightCart(this);
		return false;
	});

	$(document).on('click', '.remove-custom-flight-cart', function () {
		removeCustomFlightCart(this);
		return false;
	});

	{{-- refreash flights --}}
	$(document).on('click', '.refreash-flights', function() {
		var vendor = $(this).attr('data-vendor');
		var did = $(this).attr('data-did');
		var rid = $(this).attr('data-rid');
		if (vendor == 'qpx') {
			postQpxFlight(rid);
		}
		else if (vendor == 'ss') {
			postSsFlight(rid);
		}
	});
	{{-- /refreash flights --}}

</script>
@include($viewPath.'.partials.scripts.autocomplete')
@include($viewPath.'.partials.scripts.function')