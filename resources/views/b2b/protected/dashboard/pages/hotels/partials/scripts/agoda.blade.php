<script>
	function postFgfAgoda(rid, index = 0) {
		var ridObj = getRidObject(rid);
		var did = ridObj.did;
		var ids = {
				'did' : did,
				'elem_id' : elem_id,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('/a/hotels/result/') }}/"+did+"/"+index,
			data: ids,
			success: function(response, textStatus, xhr) {
				var response = JSON.parse(response);
				var html = '';
				var hotels = response.hotels;
				$('#loging_log').hide();

				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeFgfAgodaHtml(i, v, ids);
						$('#'+elem_id).append(html);
					});

					/*filter.initFilter(rid);
					index = index+1;
					postFgfAgoda(did, rid, index)*/
				}
				/*else{
					return postFgfAgoda(did, rid, index);
				}*/
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					postFgfAgoda(did, rid);
				}
			}
		});
	}
</script>

<script>
	function postSearchFgfA(name, did, rid) {
		var elem_id = "hotel_"+rid;
		var ids = {
				'did' : did,
				'rid' : rid,
				'name' : name,
				'elem_id' : elem_id,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/hotel/find/a') }}/"+did,
			data: ids,
			success: function(response, textStatus, xhr) {
				var response = JSON.parse(response);
				var html = '';
				var hotels = response.hotels;
				$('#loging_log').hide();

				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeFgfAgodaHtml(i, v, ids);
						html = html.replace('glowing-border', 'glowing-border border-green-2px');
						$('#'+elem_id).find('.border-green-2px').removeClass('border-green-2px');
						$('#'+elem_id).prepend(html);
					});
				}
			}
		});
	}
</script>

<script>
	function makeFgfAgodaHtml(i, obj, ids) {
		var hotel_id = obj.hotel_id;
		var uniqueKey = obj.hotel_id+'_a'; {{-- uniqueKye = hotel_id_vendor --}}
		$('#li_'+obj.hotel_id+'_fgfa').remove();
		var name = proper(obj.hotel_name);
		var address = obj.address; 
		address = address.replace(/, , /g, ', ');
		var sortAddress = address.substring(0, 50);
		var description = obj.overview;
		var sortDescription = description.substring(0, 120);
		var starRating = obj.star_rating;
		var starRatingHtml = star_Rating(starRating);
		var image = obj.images[0];
		var latitude = obj.latitude;
		var longitude = obj.longitude;

		var hotel = {
				"code" : hotel_id,
				"name" : name,
				"uniqueKey" : uniqueKey,
				"address" : address,
				"sortAddress" : sortAddress,
				"description" : description,
				"sortDescription" : sortDescription,
				"starRating" : starRating,
				"starRatingHtml" : starRatingHtml,
				"image" : image,
				"latitude" : latitude,
				"longitude" : longitude,
				"ids" : ids
			};
		return makeHotelHtml(hotel);
	}
</script>

<script>
	function postFgfAgodaRoom(did, rid, hid) {
		var elem_id = "hotel_"+rid;
		var ids = {
				'did' : did,
				'hid' : hid,
				'elem_id' : elem_id,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('/a/hotel/rooms/') }}/"+did,
			data: ids,
			success: function(response, textStatus, xhr) {
				var response = JSON.parse(response);
				var html = '';
				var rooms = response.rooms;
				var uniqueKey = hid+'_fgfa';
				
				invokeMap(uniqueKey);

				if (rooms.length) {
					$('#loging_log').hide();

					$.each(rooms, function(i,v){
						html = makeFgfAgodaRoomHtml(i, v, ids);
						$('#'+uniqueKey+'_rooms').append(html);
					});

					$.each(response.images, function(i,v){
						html = makeGallaryHtml(i, v);
						$('#'+uniqueKey+'_gimg').append(html);
					});

					$('#main_hotelDetail_'+uniqueKey).find('input').iCheck({
						checkboxClass: 'icheckbox_flat-green'
					});
				}
				else{
					return postFgfAgodaRoom(did, rid, hid);
				}
				
				postFgfAgodaDetail(ids);

			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					return postFgfAgodaRoom(did, rid, hid);
				}
			}
		});
	}
</script>


<script>
	function makeFgfAgodaRoomHtml(i, obj, ids) {
		var uniqueKey = obj.hotel_id+'_fgfa';
		var roomId = obj.id;
		var roomType = obj.roomtype
		var roomImage = obj.image;

		<?php 
			$html = view('b2b.protected.dashboard.pages.hotels.partials.html_partials.rooms')->render(); 
			$html = trimHtml($html);
		?>
		return '{!! $html !!}';
	}
</script>

<script>
	function makeGallaryHtml(i, obj) {
		return '<div class="height-160px width-48-p"><img class="width-100-p height-100p" src="'+obj.LocationWithSquareSize2X+'" /></div>'
	}
</script>

<script>
	function invokeMap(uniqueKey) {
		var map_iframe_src = $('#'+uniqueKey+'_map').attr('data-src');
		var map_iframe = '<div class="m-top-5"><iframe width="100%" height="360" src="'+map_iframe_src+'" ></iframe></div>';
		$('#'+uniqueKey+'_map').html(map_iframe);
	}
</script>

<script>
	function postFgfAgodaDetail(ids){
		var uniqueKey = ids.hid+'_fgfa';
		$.ajax({
			type:"post",
			url: "{{ url('/a/hotel/detail/') }}/"+ids.did,
			data: ids,
			success : function(response){
				$('#'+uniqueKey+'_about').html(response);
			}
		});
	}
</script>