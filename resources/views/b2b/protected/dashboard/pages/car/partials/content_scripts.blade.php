
{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "DD/MM/YYYY",

		}, function(start, end, label) {
			// console.log(start.toISOString(), end.toISOString(), label);
		});

		// getting car menu
		getMenuJson();

	});
</script>
{{-- /bootstrap-daterangepicker --}}

{{-- Adults-Child-button --}}
<script>
	//plugin bootstrap minus and plus
	//http://jsfiddle.net/laelitenetwork/puJ6G/
	$('.btn-number').click(function(e){
			e.preventDefault();
			
			fieldName = $(this).attr('data-field');
			type      = $(this).attr('data-type');
			dataName = $(this).attr('data-name');
			var input = $("input[name='"+fieldName+"']");
			var spanWord_elem = $("span[name='"+fieldName+"']");
			var currentVal = parseInt(input.val());
			var spanWord = spanWord_elem.text(); 
			
			if (!isNaN(currentVal)) {
					if(type == 'minus') {
							
							if(currentVal > input.attr('min')) {
									input.val(currentVal - 1).change();
							} 
							if(parseInt(input.val()) == input.attr('min')) {
									$(this).attr('disabled', true);
							}

							if(currentVal == 2 && spanWord == 'Adults'){
								spanWord_elem.text('Adult');
							}

							if(dataName == 'child'){
								$("[data-age='"+fieldName+"'] div:nth-child("+currentVal+")").remove();
							}
							
							if(currentVal == 2 && spanWord == 'Children'){
								spanWord_elem.text('Child');
							}

					} else if(type == 'plus') {

							if(currentVal < input.attr('max')) {
									input.val(currentVal + 1).change();
							}
							if(parseInt(input.val()) == input.attr('max')) {
									$(this).attr('disabled', true);
							}

							if(currentVal >= 1 && spanWord == 'Adult'){
								spanWord_elem.text('Adults');
							}

							if(dataName == 'child'){
								// var child_elem = $("#age_temp").html();
								// console.log(child_elem);
								// $("[data-age='"+fieldName+"']").append(child_elem);
							}

							if(currentVal >= 1 && spanWord == 'Child'){
								spanWord_elem.text('Children');
							}
					}
			} else {
					input.val(0);
			}
	});

	$('.input-number').focusin(function(){
		 $(this).data('oldValue', $(this).val());
	});

	$('.input-number').change(function() {
			
			minValue =  parseInt($(this).attr('min'));
			maxValue =  parseInt($(this).attr('max'));
			valueCurrent = parseInt($(this).val());
			
			name = $(this).attr('name');
			if(valueCurrent >= minValue) {
					$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
					alert('Sorry, the minimum value was reached');
					$(this).val($(this).data('oldValue'));
			}
			if(valueCurrent <= maxValue) {
					$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
					alert('Sorry, the maximum value was reached');
					$(this).val($(this).data('oldValue'));
			}
			
	});

	$(".input-number").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) || 
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
							 // let it happen, don't do anything
							 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
			}
	});
</script>
{{-- /Adults-Child-button --}}

{{-- pick up address --}}
<script>
	$(document).on('click', '.pick-up-address', function(){
		var target = $(this).attr('data-target');
		$('#'+target).toggle();
	});
</script>
{{-- /pick up address --}}


{{-- Lat and Long --}}
<script>

	// google.maps.event.addDomListener(window, 'load', intilize);

	$(document).on('keypress', '.txtautocomplete', function(){
		intilize($(this).attr('id'));
	});

	function intilize(thisId) {
		// console.log(thisId);

		var autocomplete = new google.maps.places.Autocomplete(document.getElementById(thisId));

		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place =  autocomplete.getPlace();
				
			$('#'+thisId).attr('data-lat', place.geometry.location.lat());
			$('#'+thisId).attr('data-long', place.geometry.location.lng());

			if (thisId == 'destination') { showMapRoute(); }
		});
	}
</script>
{{-- /Lat and Long --}}


{{-- /choose car --}}
<script>
	$(document).on('click', '.btn-choose', function(){
		var index = $(this).attr('data-index');
		var vendor = $(this).attr('data-vendor');
		var pcid = $('#cars_result').attr('data-id');
		var dbid = '';

		if (vendor == 'ss') {
			dbid =	$('#cars_result').attr('data-ssid');
		}

		var data = {
			"_token" : "{{ Session::token() }}",
			"index" : index,
			"vendor" : vendor,
			"dbid" : dbid, // this is selected vendor table id
			"pcid" : pcid // this is package_cars table id
		}
		
		$.ajax({
			type:"post",
			url: "{{ Request::url().'/choose' }}",
			data: data,
			success: function(response, textStatus, xhr) {
				response = JSON.parse(response);
				// console.log(response);
				if (response.status == 200) { 
					if (confirm('Want to add anouther car?')) {
							getMenuJson();

					} else {
							// no
							document.location.href = response.packageUrl;
					}
				}
				else{
					alert(response.response);
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
			},
		});

	});
</script>
{{-- /choose car --}}


{{-- submit form --}}
<script>
	$(document).on('click', '#btn_submit', function(){
		var start_place =  $('#origin').val();
		var start_lat = $('#origin').attr('data-lat');
		var start_long = $('#origin').attr('data-long');
		var start_date =  $('#start_date').val();
		var end_place =  $('#destination').val();
		var end_lat = $('#destination').attr('data-lat');
		var end_long = $('#destination').attr('data-long');
		var end_date =  $('#end_date').val();
		
		var dataArray = [
				start_place, 
				start_lat, 
				start_long,
				end_place,
				end_lat, 
				end_long,
				start_date, 
				end_date
			];

		var findIndex = $.inArray("", dataArray);
		findIndex = -1;

		if(findIndex == -1){
			
			var data = {
					'_token' : '{{ csrf_token() }}',
					'start_date' : start_date,
					'start_place' : start_place,
					'start_latitude' : start_lat,
					'start_longitude' : start_long,
					'end_date' : end_date,
					'end_place' : end_place,
					'end_latitude' : end_lat,
					'end_longitude' : end_long,
				};

			$.ajax({
				url : "{{ Request::url() }}",
				type: "post",
				data: data,
				
				success: function(response, textStatus, xhr) {
					// console.log(response);
					
					var response = JSON.parse(response);
					var html = '';
					
					$('#cars_result').empty();
					$('#cars_result').attr('data-id', response.db.package_car_id);
					$('#cars_result').attr('data-ssid', response.db.id);
					if (response.hasOwnProperty('cars')) {
						$.each(response.cars, function(i,v){
							elemId = i;

							if (elemId % 3 == 0) {
								$('#cars_result').append('<div class="row"></div>');
							}

							html = makeCarHtml(i,v);
							$('#cars_result').append(html);
						});
					}else if(response.hasOwnProperty('errors')){
						alert(response.errors[0]);
					}
					// document.location.href = response.nextUrl;
				},
			});
		}
		else{
			
			$('.border-red').removeClass('border-red');

			var keyArray = [
					'origin', 
					'origin', 
					'origin', 
					'destination', 
					'destination', 
					'destination',
					'start_date', 
					'end_date'
				];

			var nullIndex = keyArray[findIndex];
			$('#'+nullIndex).addClass('border-red');

		}
	});
</script>
{{-- /submit form --}}


{{-- Model PopUp --}}
<script>
	$(document).on('click', "[data-toggle='modal']", function(){
		var popupTarget = $(this).attr('data-target');
		var popupTitle = $(this).attr('data-title');
		var popupButton = $(this).attr('data-button');
		var popupBodyId = $(this).attr('data-bodyid');
		var popupBody = $('#'+popupBodyId).html();
		var popupSize = '';
		
		// alert(popupTitle+' '+popupTarget);

		if(popupTarget == '.bs-example-modal-sm'){
			popupSize = '2';
		}

		$('#myModalLabel'+popupSize).html(popupTitle);
		$('#myModalBody'+popupSize).empty();
		$('#myModalBody'+popupSize).html(popupBody);
		
		if(popupButton == 'false'){
			$('#myModalButton'+popupSize).hide();
		}
	})
</script>
{{-- /model PopUp --}}

{{-- showMapRoute --}}
<script>
	function showMapRoute() {
		var displayDivId = 'dvMap';
		var origin = $('#origin').val();
		var originLat = $('#origin').attr('data-lat');
		var originLong = $('#origin').attr('data-long');
				
		var destination = $('#destination').val();
		var destinationLat = $('#destination').attr('data-lat');
		var destinationLong = $('#destination').attr('data-long');

		var markers = [
			{
				"title": origin,
				"lat": originLat,
				"lng": originLong,
				"description": origin
			},
			{
				"title": destination,
				"lat": destinationLat,
				"lng": destinationLong,
				"description": destination
			}
		];

		var mapOptions = {
			center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
			zoom: 10,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById(displayDivId), mapOptions);
		var infoWindow = new google.maps.InfoWindow();
		var lat_lng = new Array();
		var latlngbounds = new google.maps.LatLngBounds();
		for (i = 0; i < markers.length; i++) {
			var data = markers[i]
			var myLatlng = new google.maps.LatLng(data.lat, data.lng);
			lat_lng.push(myLatlng);
			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: data.title
			});
			latlngbounds.extend(marker.position);
			(function (marker, data) {
				google.maps.event.addListener(marker, "click", function (e) {
					infoWindow.setContent(data.description);
					infoWindow.open(map, marker);
				});
			})(marker, data);
		}
		map.setCenter(latlngbounds.getCenter());
		map.fitBounds(latlngbounds);

		//***********ROUTING****************//

		//Intialize the Path Array
		var path = new google.maps.MVCArray();

		//Intialize the Direction Service
		var service = new google.maps.DirectionsService();

		//Set the Path Stroke Color
		var poly = new google.maps.Polyline({ map: map, strokeColor: '#4986E7' });

		//Loop and Draw Path Route between the Points on MAP
		for (var i = 0; i < lat_lng.length; i++) {
			if ((i + 1) < lat_lng.length) {
				var src = lat_lng[i];
				var des = lat_lng[i + 1];
				path.push(src);
				poly.setPath(path);
				service.route({
					origin: src,
					destination: des,
					travelMode: google.maps.DirectionsTravelMode.DRIVING
				}, function (result, status) {
					if (status == google.maps.DirectionsStatus.OK) {
						for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
							path.push(result.routes[0].overview_path[i]);
						}
					}
				});
			}
		}
	}
</script>
{{-- /showMapRoute --}}

{{-- make car html --}}
<script>
	function makeCarHtml(i,v){
		var air_conditioning = v.air_conditioning == 1 ? 'Yes' : 'No';
		var pick_up_address = 'pick_up' in v.location && v.location.pick_up.address || 0;
		// var pick_up_address = v.location.pick_up.address;

		<?php 
			$html = 'return \'<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="x_panel">
						<div >
							<h3>\'+v.vehicle+\'</h3>
							<h5><b>Price (all days): </b>INR \'+v.price_all_days+\'</h5>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<h5><b>Car type: </b>\'+v.sipp+\'</h5>
									<h5><b>Doors: </b>\'+v.doors+\' | <b>Seats: </b>\'+v.seats+\'</h5>
									<h5><b>Air Conditioning: </b>\'+air_conditioning+\'</h5>
									<h5>
										<a class="btn-link cursor-pointer pick-up-address" data-target="car_\'+i+\'">Pick up address</a>
									</h5>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<img src="\'+v.image_url+\'" alt="" height="100" width="160">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div id="car_\'+i+\'" hidden>\'+pick_up_address+\'</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-sm-4 col-xs-12 pull-right">
									<button class="btn btn-success btn-block btn-choose" data-index="\'+i+\'" data-vendor="ss">
										Choose
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>\';';

			$html = trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html)));
			// dd($html);
			echo $html;
		?>
	}
</script>
{{-- /make car html --}}

{{-- delete car from menu --}}
<script>
	$(document).on('click', '.menu-car-cart', function() {
		var pcid = $(this).attr('data-pcid');
		$('#remove_menu_car_cart').attr('data-pcid', pcid);
		console.log(pcid);
		
	});

	$(document).on('click', '#remove_menu_car_cart', function() {
		var pcid = $(this).attr('data-pcid');
		console.log(pcid);
		$.ajax({
			type:"delete",
			url: "{{ Request::url() }}",
			data: {
				"_token" : "{{csrf_token()}}", 
				"_mathod" : "delete",
				"pcid" : pcid 
			},
			success: function(response, textStatus, xhr) {
				getMenuJson();
			}
		});
	});
	
</script>
{{-- /delete car from menu --}}

{{-- /getMenuJson--}}
<script>
	function getMenuJson(){
		$.ajax({
			type:"post",
			url: "{{ Request::url().'/menu' }}",
			data: {"_token" : "{{ csrf_token() }}" },
			success: function(response, textStatus, xhr) {
				var response = JSON.parse(response);
				var html = '';
				
				$('#menu_cars, #menu_cars_count').empty();

				if (response.length) {
					$('#menu_cars_count').html(response.length);
				}

				$.each(response, function(i,v){
					elemId = i;
					html = makeCarMenu(i,v);
					$('#menu_cars').append(html);
				});
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
			},
		});
	};
</script>
{{-- /getMenuJson --}}

{{-- makeCarMenu --}}
<script>
	function makeCarMenu(i,obj) {
		// console.log(obj);
		<?php 
			$html = 'return \'<li>
				<a>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<div class="row">
							<img src="\'+obj.image+\'" alt="" height="50" width="80">
						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h2 class="font-size-17 white-space-pl">\'+obj.name+\'</h2>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12 text-right" hidden>
								<h2>
									<i class="fa fa-rupee font-size-15"></i>
									<span class="font-size-17">\'+obj.price_all_days+\'</span>
								</h2>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<b>From : </b>\'+obj.start_place+\'
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<b>To : </b>\'+obj.end_place+\'
							</div>
						</div>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-12">
						<div class="row">
							<div class="m-top-10">
								<i class="fa fa-trash font-size-30 pull-right font-dark-red menu-car-cart" data-pcid="\'+obj.pcid+\'" data-toggle="modal" data-target=".bs-example-modal-delete-menu-car"></i>
							</div>
						</div>
					</div>
				</a>
			</li>\';';

			$html = trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html)));
			// dd($html);
			echo $html;
		?>
			
	}
</script>
{{-- /makeCarMenu --}}