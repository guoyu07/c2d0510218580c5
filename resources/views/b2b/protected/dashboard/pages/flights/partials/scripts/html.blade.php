appendHtml += '<li class="min-height-110px main-list-item">
	<span class="stops" hidden>stop_'+flight.stops+'</span>
	<div class="x_panel glowing-border">
		<div class="col-md-10 col-sm-10 col-xs-12">';
		$.each(flight.stacks, function (stackId, stackVal) {
		
			var flightName = stackVal.name;
			var flightCode = stackVal.code;
			var flightNumber = stackVal.flightNumber;
			var departureDate = stackVal.departureDate;
			var departureTime = stackVal.departureTime;
			var arrivalDate = stackVal.arrivalDate;
			var arrivalTime = stackVal.arrivalTime;
			var origin = stackVal.origin;
			var originCode = stackVal.originCode;
			var destination = stackVal.destination;
			var destinationCode = stackVal.destinationCode;
			searchWord += ' '+flightName+' '+flightCode+flightNumber;

			appendHtml += '<div class="row">
				<div class="col-md-5 col-sm-5 col-xs-12">
					<div class="row m-tb-10px text-left">
						<div class="col-md-3 col-sm-3 col-xs-12">
							<div class="row">
								<img src="{{ urlImage('images/airlineImages') }}/'+flightCode+'.gif" onerror="defaultAirlineIcon(this)" alt="">
							</div>
						</div>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<div class="flightName font-size-15">'+flightName+'</div>
							<div>
								<small>'+flightCode+flightNumber+'</small>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="text-center">
								<h2>
									<span>'+departureTime+' </span>
									<small>('+departureDate+')</small>
								</h2>
								<div>'+origin+'
									<small>('+originCode+')</small>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="text-center">
								<h2>
									<span>'+arrivalTime+' </span>
									<small>('+arrivalDate+')</small>
								</h2>
								<div>'+destination+'
									<small>('+destinationCode+')</small>
								</div>
							</div>
						</div>
					</div>';
				appendHtml += '</div>
			</div>';
		});
		
		appendHtml += '</div>
		<div class="col-md-2 col-sm-2 col-xs-12">
			<div class="search-word" hidden>'+searchWord+'</div>
			<div class="row m-tb-20px">
				<button class="btn btn-'+flight.btnClass+' btn-block btn-addtocart" 
					data-vid="'+flight.vid+'"
					data-vdr="'+flight.vdr+'"
					data-ind="'+flight.ind+'"
					data-psid="'+flight.psid+'">'+flight.btnName+'
				</button>
			</div>
		</div>
	</div>
</li>';