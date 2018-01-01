<script>
	function postQpxFlight(rid ='') {
		var ridObject = getRidObject(rid);
		var elem_id = ridObject.elem_id;
		$.ajax({
			type:"post",
			url: "{{ url('qpx/flights/result') }}/"+rid,
			data: { "_token" : csrf_token },
			success: function(response, textStatus, xhr) {
					var response = JSON.parse(response);
					var fullhtml = '';
					$('#sorry_error').remove();
					if (response.hasOwnProperty('trips') && response.trips.hasOwnProperty('tripOption')) {
						var tripOption = response.trips.tripOption;
						$.each(tripOption, function(i,v){
							fullhtml = makeQpxHtml(i, v, response);
							$('#'+elem_id).append(fullhtml);
						});
					}
					/*else{
						refreashFlights(ids);
					}*/
					dataIsPulled(rid);					
					filter.initFilter(rid);
					
					$('#loging_log').hide();
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					$('#loging_log').hide();
					/*refreashFlights(ids);*/
				}
			}
		});
	}

	function makeQpxHtml(tripOptionKey, tripOption, data) {
		var appendHtml = '';
		var airlines = data.airlines;
		var cities = data.cities;
		var stacks = [];

		$.each(tripOption.slice, function(sliceKey,slice){
			$.each(slice.segment, function(segmentKey,segment){
				var stack = {};
				stack['name'] = airlines[segment.flight.carrier].replace('Limited', '');
				stack['code'] =	segment.flight.carrier;
				stack['flightNumber'] = segment.flight.number;

				$.each(segment.leg, function(legKey,leg){
					var departureDateTime = qpxDateTime(leg.departureTime);
					stack['departureTime'] = departureDateTime.time;
					stack['departureDate'] = departureDateTime.date;			
					
					var arrivalDateTime = qpxDateTime(leg.arrivalTime);
					stack['arrivalTime'] = arrivalDateTime.time;
					stack['arrivalDate'] = arrivalDateTime.date;

					stack['origin'] = cities[leg.origin];
					stack['originCode'] = leg.origin;
					stack['destination'] = cities[leg.destination];
					stack['destinationCode'] = leg.destination;
				});
				stacks.push(stack);
			});
		});

		var flight = {
				'vendor_id': data.db.id, {{-- this is vendor db id like qpx db id --}}
				'index' : tripOptionKey,
				'stacks' : stacks, 
				'vendor' : 'qpx'
			};

		return getFlightStack(flight);
	}
</script>

