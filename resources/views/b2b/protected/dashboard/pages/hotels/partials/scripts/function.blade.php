<?php 
	$viewPath = 'b2b.protected.dashboard.pages.hotels.partials.html_partials';
	$hotelHtml = trimHtml(view($viewPath.'.container')->render());
	$hotelRoomHtml = trimHtml(view($viewPath.'.rooms')->render()); 
?>
<script>
		{{-- get rid object --}}

	function getRidObject(rid) {
		return idObject['hotel_'+rid];
	}

	{{-- get rid object --}}



	function showSpinIcon() {
		$('#fa_home_filter_icon').addClass('hide');
		$('#fa_spin_filter_icon').removeClass('hide');
	}

	function hideSpinIcon() {
		$('#fa_spin_filter_icon').addClass('hide');
		$('#fa_home_filter_icon').removeClass('hide');
	}


	{{-- show description --}}

	function showDescription(thisObj) {
		var popupTitle = proper($(thisObj).attr('data-title'));
		var popupBodyId = $(thisObj).attr('data-bodyid');
		var popupBody = $('#'+popupBodyId).html();
		$.alert({
			backgroundDismiss: true,
			keyboardEnabled: true,
			title: popupTitle,
			content: popupBody,
			columnClass: 'col-md-6 col-md-offset-3'
		});
	}

	{{-- show description --}}



	function clickAtab(thisObj) {
		var rid = $(thisObj).attr('data-rid');
		$('#btn_next').attr('data-rid', rid);
	}


	{{-- checkChange --}}
	function checkChange(thisObj) {
		var type = $(thisObj).attr('data-type');
		var isChecked = $(thisObj).is(':checked');
		var parent = $(thisObj).closest('.pick-drop-container');
		/*console.log(parent);*/
		if (type == 'pick_up') {
			if (isChecked) {
				$(parent).find('.pick-drop').hide();
				$(parent).find('.select-pick-drop').show();
				$(parent).find('.h-pick-up').attr('data-selected', 1);
			}
			else{
				$(parent).find('.select-pick-drop').hide();
				$(parent).find('.pick-drop').show();
				$(parent).find('.h-pick-up').attr('data-selected', 0);
			}
		}
		else if (type == 'drop_off') {
			if (isChecked) {
				$(parent).find('.pick-drop').hide();
				$(parent).find('.select-pick-drop').show();
				$(parent).find('.h-drop-off').attr('data-selected', 1);
			}
			else{
				$(parent).find('.select-pick-drop').hide();
				$(parent).find('.pick-drop').show();
				$(parent).find('.h-drop-off').attr('data-selected', 0);
			}
		}
		else if(type == 'meal'){
			if (isChecked) {
				$(thisObj).addClass('selected');
			}
			else{
				$(thisObj).removeClass('selected');
			}
		}
	}

	{{-- /check Change --}}


	{{-- post hotel --}}

	function postHotels(rid) {
		var ridObj 	= getRidObject(rid);
		var elem_id = ridObj.elem_id;

		$.ajax({
			type:"post",
			url: "{{ url('fatch/hotels/result') }}/"+rid,
			data: { '_token' : csrf_token },
			success: function(response, textStatus, xhr) {
				var html = '';
				var response = JSON.parse(response);
				var hotels = response.hotels;

				$('#loging_log').hide();
				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeHotelObject(i, v, rid);
						$('#'+elem_id).append(html);
					});
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					postFgfAgoda(rid);
				}
			}
		});
	}

	{{-- post hotel --}}



	{{-- make hotel object --}}

	function makeHotelObject(i, object, rid) {
		var code = object.id;
		var ukey = code+'_'+object.vendor;   {{-- uniqueKye = hotel_id_vendor --}}
		var name = proper(object.name);
		var address = object.address.replace(/, , /g, ', '); 
		var sortAddress = address.substring(0, 50);
		var sortDescription = object.description.substring(0, 120);
		var starRatingHtml = star_Rating(object.star_rating);
		var ridObj = getRidObject(rid);
		var hid = ridObj.hid;
		var hdid = ridObj.hdid;
		var btnClass = hid == code ? 'btn-danger' : 'btn-primary';
		var btnName = hid == code ? 'Selected' : 'Rooms';
		var hotel = {
				"ukey" : ukey,
				"name" : name,
				"code" : code,
				"hdid" : hdid,
				"btnClass" : btnClass,
				"btnName" : btnName,
				"ridObj" : ridObj,
				"address" : address,
				"vendor" : object.vendor,
				"image" : object.image,
				"latitude" : object.latitude,
				"longitude" : object.longitude,
				"sortAddress" : sortAddress,
				"starRating" : object.star_rating,
				"description" : object.description,
				"starRatingHtml" : starRatingHtml,
				"sortDescription" : sortDescription
			};

		var sameElem = $('#'+ridObj.elem_id).find('.li_'+ukey);

		if (sameElem.length) {
			moveToTop(sameElem);
			return false;
		}
		else{
			return makeHotelHtml(hotel);
		}
		{{-- $('#'+ridObj.elem_id).find('.li_'+ukey).remove();   Removing old cart --}}
	}

	{{-- make hotel object --}}


	{{-- make hotel html --}}

	function makeHotelHtml(hotel) {
		var appendHtml = '';
		var searchWord = '';
		appendHtml += '{!!$hotelHtml!!}';
		return appendHtml;
	}

	{{-- make hotel html --}}


	{{-- Choose room --}}

	function chooseRoom(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		var parentLi = $(thisObj).closest('.main-list-item');
		$(parent).find('.hotel-detail').addClass('off');
		$(parentLi).find('.hotel-detail').addClass('on').removeClass('off');
		$(parent).find('.hotel-detail.off').hide();
		$(parentLi).find('.hotel-detail').toggle();
		var hasElem = $(parentLi).find('.btn-bookRoom');
		if (hasElem.length == 0) {
			$('#loging_log').show();
			var rid = $(parent).attr('data-rid');
			var vdr = $(thisObj).attr('data-vdr');
			var hid = $(thisObj).attr('data-hid');
			var data = {
					"hid" : hid,
					"vdr" : vdr,
					"rid" : rid,
					"_token" : csrf_token
				};

			$.ajax({
				type:"post",
				url: "{{ url('fatch/hotels/rooms/result/') }}",
				data: data,
				success: function(response, textStatus, xhr) {
					response = JSON.parse(response);
					response = $.extend({}, response, data);
					populateInTab(response);
					$('#loging_log').hide();
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					else if(xhr.status == 500){
						var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
					}
					$('#loging_log').hide();
				}
			});
		}
	}

	{{-- /Choose room --}}


	{{-- Book Room --}}
	function bookRoom(thisObj) {
		var parent = $(thisObj).closest('.hotel-detail');
		var parentLi = $(thisObj).closest('.main-list-item');
		var parentUl = $(thisObj).closest('.list.list-unstyled');

		$(parentUl).find('.btn-chooseRoom').addClass('off').removeClass('on');
		
		if ($(thisObj).hasClass("btn-primary")) {
			$(thisObj).addClass('btn-danger')
									.text('Remove')
										.removeClass('btn-primary');
			addRoom(thisObj);
		}
		else if ($(thisObj).hasClass("btn-danger")) {
			$(thisObj).addClass('btn-primary')
									.text('Add')
										.removeClass('btn-danger');
			removeRoom(thisObj);
		}

		var selected = $(parent).find('.btn-danger');
		if (selected.length > 0) {
			$(parentLi).find('.btn-chooseRoom')
										.addClass('on btn-danger')
											.text('Selected')
												.removeClass('off btn-primary');

			$(parentUl).find('.btn-chooseRoom.off')
										.addClass('btn-dark')
											.prop('disabled', true)
												.removeClass('btn-primary');
		}
		else{
			$(parentUl).find('.btn-chooseRoom')
										.addClass('btn-primary')
											.text('Rooms')
												.removeClass('btn-dark')
													.removeClass('btn-danger')
														.prop('disabled', false);
			removeHotel(thisObj);
		}
	}
	{{-- /Book Room --}}



	function addRoom(thisObj) {
		var parentLi = $(thisObj).closest('.main-list-item');
		var rid = $(parentLi).closest('.list.list-unstyled').attr('data-rid');
		var chooseRoom = $(parentLi).find('.btn-chooseRoom');
		var hid = $(chooseRoom).attr('data-hid');
		var hvdr = $(chooseRoom).attr('data-vdr');
		var hdid = $(chooseRoom).attr('data-hdid');
		var rmid = $(thisObj).attr('data-rmid');
		var rmvdr = $(thisObj).attr('data-vdr');
		var data = {
					"hid" : hid,
					"hdid" : hdid,
					"hvdr" : hvdr,
					"rmid" : rmid,
					"rmvdr" : rmvdr,
					"_token" : csrf_token
				};

		$.ajax({
			type:"post",
			url: "{{ urlHotelsBuilder('room/add') }}/"+rid,
			data: data,
			success: function(response, textStatus, xhr) {
				response = JSON.parse(response);
				$(chooseRoom).attr('data-hdid', response.hdid);
				$(thisObj).attr('data-rmdid', response.rmdid);
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
				}
			}
		});
	}




	function removeRoom(thisObj) {
		var parentLi = $(thisObj).closest('.main-list-item');
		var chooseRoom = $(parentLi).find('.btn-chooseRoom');
		var rmdid = $(thisObj).attr('data-rmdid');
		var rid = $(thisObj).closest('.list.list-unstyled').attr('data-rid');
		var data = {
					"rmdid" : rmdid,
					"_token" : csrf_token
				};

		$.ajax({
			type:"post",
			url: "{{ urlHotelsBuilder('room/remove') }}/"+rid,
			data: data,
			success: function(response, textStatus, xhr) {
				response = JSON.parse(response);
				if (response.is_copied == 1) {
					$(chooseRoom).attr('data-hdid', response.hdid);
					$.each(response.rooms, function(i,v) {
						$(parentLi).find("[data-rmdid='" + i + "']").attr('data-rmdid', v);
					});
				}
				$(thisObj).attr('data-rmdid','');
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
				}
			}
		});
	}




	function removeHotel(thisObj) {
		var parentUl = $(thisObj).closest('.list.list-unstyled');
		var parentLi = $(thisObj).closest('.main-list-item');
		var chooseRoom = $(parentLi).find('.btn-chooseRoom');
		var hdid = $(chooseRoom).attr('data-hdid');
		var rid = $(parentUl).attr('data-rid');
		var data = {
					"hdid" : hdid,
					"_token" : csrf_token
				};

		$.ajax({
			type:"post",
			url: "{{ urlHotelsBuilder('remove') }}/"+rid,
			data: data,
			success: function(response, textStatus, xhr) {
				$(chooseRoom).attr('data-hdid','');
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					var responseHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
				}
			}
		});
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


	{{-- populate in tab --}}

	function populateInTab(obj) {
		var ukey = obj.hid+'_'+obj.vdr+'_'+obj.rid;

		$.each(obj.rooms,function(roomKey, room) {
			room['hid'] = obj.hid;
			room['svdr'] = obj.vdr;
			room['rid'] = obj.rid;
			$('#'+ukey+'_rooms').append(makeRoomHtml(room));
			invokeIcheck('#'+ukey+'_rooms');
		});

		$.each(obj.images, function(imagekey, image) {
			$('#'+ukey+'_gallary').find('.gallery.cf').append(makeGallaryHtml(image));
		});

		invokeMap(ukey);
	}

	{{-- /populate in tab --}}



	function nextHotelEvent(thisObj) {
		$('#loging_log').show();
		rid = $(thisObj).attr('data-rid');
		ridObj = getRidObject(rid);
		if (ridObj.next_rid == "NaN") {
			setTimeout(function () {    
				document.location.href = "{{url('dashboard/package/builder/event/'.$package->token.'/hotel')}}";
			}, 5000);
		}
		else{
			aObject =  $('#a_hotel_'+ridObj.next_rid);
			$(aObject).click();
			clickAtab(aObject);
			$('#loging_log').hide();
		}
	}




	{{-- make room html --}}
	function makeRoomHtml(obj) {
		ridObj = getRidObject(obj.rid);
		var rmdid = '';
		var btnClass = 'btn-primary';
		var btnName = 'Add';
		var roomId = obj.id;
		var roomVdr = obj.vdr;
		var roomType = obj.roomtype;
		var roomImage = obj.image;
		var selectedRooms = ridObj.rooms;
		if (ridObj.hid == obj.hid && isset(selectedRooms, roomId)) {
			rmdid = selectedRooms[roomId];
			btnClass = 'btn-danger';
			btnName = 'Remove';
		}
		return '{!! $hotelRoomHtml !!}';
	}
	{{-- /make room html --}}


	{{-- make gallary html --}}
	function makeGallaryHtml(obj) {
		return '<div class="height-160px width-48-p"><img class="width-100-p height-100p" src="'+obj+'" /></div>'
	}
	{{-- /make gallary html --}}


	{{-- invoke map --}}
	function invokeMap(ukey) {
		var src = $('#'+ukey+'_map').attr('data-src');
		$('#'+ukey+'_map').html('<div class="m-top-5"><iframe width="100%" height="360" src="'+src+'" ></iframe></div>');
	}
	{{-- /invoke map --}}



	function postSearchHotel() {
		/*hideSpinIcon();*/
		$('#loging_log').show();
		var name = $('#filter_search').val();
		var rid = $('#tab_menu').find('.active').attr('data-rid');
		var ridObj = getRidObject(rid);
		var elem_id = ridObj.elem_id;
		var data = {
				'name' : name,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/hotels/search/') }}/"+rid+'?format=json',
			data: data,
			success: function(response, textStatus, xhr) {
				var html = '';
				var response = JSON.parse(response);
				var hotels = response.hotels;

				$('#loging_log').hide();
				if (hotels.length) {
					$.each(hotels, function(i,v){
						html = makeHotelObject(i, v, rid);
						$('#'+elem_id).append(html);
					});
				}
			}
		});
	}




	function postFgfAgodaDetail(ids){
		var ukey = ids.hid+'_fgfa';
		$.ajax({
			type:"post",
			url: "{{ url('/a/hotel/detail/') }}/"+ids.rid,
			data: ids,
			success : function(response){
				$('#'+ukey+'_about').html(response);
			}
		});
	}



	{{-- add to cart --}}
	function postAddtoCartHotel(data) {

		/*Object must be like this 
		var data = {
			"_token" : csrf_token,
			"did" : did,
			"index" :id,
			"vendor" : vendor
		}*/

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/package/builder/hotel/room/book/') }}/"+data.rid,
			data: data,
			success : function(response){
				response = JSON.parse(response);
				if (response.status == 200) {
					$('#a_hotel_'+data.next_rid).click();
					$(window).scrollTop(0);
				}else{
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
	{{-- add to cart --}}
</script>