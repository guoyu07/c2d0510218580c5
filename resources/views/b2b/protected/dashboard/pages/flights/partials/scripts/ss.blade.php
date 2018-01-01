
<script>
	function postSsFlight(rid ='') {
		var ridObject = getRidObject(rid);
		var elem_id = "flight_"+rid;
		var ids = {
				'rid' : rid,
				'vendor' : 'ss',
				'elem_id' : elem_id
			};

		$.ajax({
			type:"post",
			url: "{{ url('ss/flights/result') }}/"+rid,
			data: { "_token" : csrf_token },

			success: function(response, textStatus, xhr) {
					var response = JSON.parse(response);
					$('#sorry_error').remove();
					if (response.hasOwnProperty('Legs') && response.Legs.length) {
						/*console.log(Object.keys(response.Carriers).length);*/
						$('#loging_log').hide();

						$.each(response.Legs, function(i,v){
							var html = '';
							html = makeSsHtml(i, v, response, ids);
							$('#'+elem_id).append(html);
						});

					}
					else{
						postSsFlight(rid);
						/*refreashFlights(ids);*/
					}

					filter.initFilter(rid);

			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					$('#loging_log').hide();
					refreashFlights(ids);
				}
			}
		});
	}


	function makeSsHtml(legKey,leg, data, ids) {
		if (leg.hasOwnProperty('SegmentIds') && data.hasOwnProperty('Segments')) {
			var stacks = [];
			var segmentsIds = leg.SegmentIds;
			$.each(segmentsIds, function (segmentsId, segmentsVal) {
				if (data.Segments.hasOwnProperty(segmentsVal)) {
					var stack = {};
					var segment = data.Segments[segmentsVal];
					var departureDateTime = ssDateTime(segment.DepartureDateTime);
					var arrivalDateTime = ssDateTime(segment.ArrivalDateTime);

					stack[flightNumber] = segment.FlightNumber;
					stack[arrivalDate] = arrivalDateTime.time;
					stack[arrivalTime] = arrivalDateTime.date;
					stack[departureTime] = departureDateTime.time;
					stack[departureDate] = departureDateTime.date;
					stack[name] = data.Carriers[segment.Carrier].Name;
					stack[code] = data.Carriers[segment.Carrier].Code;
					stack[origin] = data.Places[segment.OriginStation].name;
					stack[originCode] = data.Places[segment.OriginStation].code;
					stack[destination] = data.Places[segment.DestinationStation].name;
					stack[destinationCode] = data.Places[segment.DestinationStation].code;

					stacks.push(stack);
				}
			});

			var flight = {
				'index' : legKey,
				'stacks' : stacks, 
				'vendor' : 'ss',
				'ids' : ids
			};
			return getFlightStack(flight);
		}
	}
</script>

