
{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "D/M/YYYY",

		}, function(start, end, label) {
			// console.log(start.toISOString(), end.toISOString(), label);
		});

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


{{-- Choose Flight --}}
<script>
	$(document).on('click','.btn-chooseRoom', function(){
		
		var hotelIndex = $(this).attr('data-hotelIndex');
		var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
		var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
		var currntHotelDetailId = 'hoteldetail-'+hotelIndex;
		var currntHotelRoomlId = 'roomresult-'+hotelIndex;

		var isVisible = $('#'+currntHotelDetailId).is(':visible');

		if(isVisible){
			$('#'+currntHotelDetailId).hide();
		}
		else if(visibleHotelDetailId == undefined || visibleHotelDetailId != currntHotelDetailId){
			
			$('#'+currntHotelDetailId).show();
			$('#'+visibleHotelDetailId).hide();
			$('#'+currntHotelRoomlId).empty();

			console.log(visibleHotelDetailId+' '+currntHotelDetailId);

			var data = {
				"_token" : "{{ Session::token() }}",
				"Index" :hotelIndex,
			}

			// console.log(JSON.stringify(data));

			$.ajax({
				type:"post",
				{{-- url: "{{ url('dashboard/package/builder/hotel/room/'.$urlVariable->id.'/'.$urlVariable->packageDbId.'/'.$urlVariable->packageHotelId) }}", --}}
				data: data,
				success: function(response, textStatus, xhr) {
					// console.log(textStatus);
					if(xhr.status == 200){
						$('#'+currntHotelRoomlId).empty(response);
						$('#'+currntHotelRoomlId).html(response);
						// document.location.href = this.url;
					}
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					else if(xhr.status == 500){
						var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
						$('#'+currntHotelRoomlId).html(responseHtml);
					}
				},
			});
		}
		else{
			// $('#'+currntHotelDetailId+', #'+visibleHotelDetailId).toggle();
			alert('Error!!!');
		}

	})
</script>
{{-- /Choose Flight --}}

{{-- PickUp Cab --}}
<script>
	$(document).on('click', '.btn-pickUpCab', function(){
		var data = dataObj(this);
		console.log(data);
		$.ajax({
			type:"post",
			url: "{{ str_replace('/cab/', '/cab/pickup/', Request::url()) }}",
			data: data,
			success: function(response, textStatus, xhr) {
				showPopUp('PICKUP', response);
			}
		});
	});
</script>
{{-- /PickUp Cab --}}

{{-- Book Cab --}}
<script>
	$(document).on('click', '.btn-bookCab', function(){
		var data = dataObj(this);
		console.log(data);
		$.ajax({
			type:"post",
			url: "{{ str_replace('/cab/', '/cab/book/', Request::url()) }}",
			data: data,
			success: function(response, textStatus, xhr) {
				$('#booked_cab').html(response);
			}
		});
	});
</script>

{{-- <script>
	$(document).on('click', '.btn-bookCab', function(){
		var popupBody = $('.popup-cab-pickup').html();
		showPopUp('PICKUP', popupBody);

		var bookIndex = $(this).attr('data-index');
		var rowIndex = $(this).attr('data-rowIndex');

		var data = {
			"_token" : "{{ Session::token() }}",
			"index" : bookIndex,
			"rowIndex" : rowIndex 
		}
		
		$.ajax({
			type:"post",
			url: "{{ str_replace('/cab/', '/cab/book/', Request::url()) }}",
			data: data,
			success: function(response, textStatus, xhr) {
				// alert("Room Booked.");
				response = JSON.parse(response);
				console.log(response);
				if (response.status == 200) { 
					if (confirm('Go to the next')) {
							// yes 
							document.location.href = response.nextUrl;
					} else {
							// now
							document.location.href = response.packageUrl;
					}
				}
				else{
					alert(response.response);
				}


				// console.log(response);
				// if(xhr.status == 200){
				// 	$('#'+currntHotelRoomlId).empty(response);
				// 	$('#'+currntHotelRoomlId).html(response);
				// 	// document.location.href = this.url;
				// }
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
			},
		});

	});
</script> --}}
{{-- /Book Cab --}}

<script>
	function dataObj(elem) {
		var bookIndex = $(elem).attr('data-index');
		var rowIndex = $(elem).attr('data-rowIndex');

		var data = {
			"_token" : "{{ Session::token() }}",
			"index" : bookIndex,
			"rowIndex" : rowIndex 
		}

		return data;
	}
</script>

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

{{-- submit form --}}
<script>
	$(document).on('click', '#btn_submit', function(){
		var data = {
				'_token' : '{{ csrf_token() }}',
				'start_latitude' : $('#origin').attr('data-lat'),
				'start_longitude' : $('#origin').attr('data-long'),
				'end_latitude' : $('#destination').attr('data-lat'),
				'end_longitude' : $('#destination').attr('data-long'),
				'seat_count' : $('#seat_count').val(),
			};

		$.ajax({
			url : "{{ Request::url() }}",
			type: "post",
			data: data,
			
			success: function(response, textStatus, xhr) {
				// console.log(response);
				$('#cab_result').html(response);
				// var response = JSON.parse(response);
				// document.location.href = response.nextUrl;
			},
		});
	});
</script>
{{-- /submit form --}}

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
{{-- showMapRoute --}}