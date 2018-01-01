
{{-- 
	
	this room guest detail can be use globaly 
	file need to use 
	
	1) this file

	script :
	2) <script src="{{ asset('js/my_plus_minus.js') }}"></script>

	3) create or append 

	var windata = { 
			is_guest_detail_changed : 1,
			guest_details : [{"id":16,"adults":2,"kids":2,"kids_age":[{"id":7,"age":3,"is_bed":0},{"id":8,"age":6,"is_bed":0}]},{"id":17,"adults":3,"kids":1,"kids_age":[{"id":9,"age":5,"is_bed":0}]}]
		}

 --}}

<script>
	$(document).ready(function () {
		makeGuestDetailtTitle();
	});

	$(document).on('click', '#btn_room_guests', function(){
		var content = '';
		var room_no = 1;
		$.each(windata.guest_details, function(index, value){
			if (value != undefined) {
				value['index'] = index;
				value['room_no'] = room_no;
				content += makeGuestDetailHtml(value);
				room_no++; 
			}
		});

		content = '<hr><div class="max-height-350px min-height-100px scroll-auto scroll-bar"><div class="col-md-12 col-sm-12 col-xs-12 room-guest-popup-box">'+content+'</div><div><a class="btn btn-link btn-popup-add-room" data-count="1">Add Room</a></div></div>';	

		$.confirm({
			title : "Rooms details",
			columnClass: 'col-md-8 col-md-offset-2',
			content : content,
			buttons: {
				submit: {
					btnClass: 'btn-primary',
					action: function(){
						if (!checkRoomGuestInputs()) {
							return false;
						}
						updateGuestDetails();
						syncGuestDetials();
					}
				},
				cancel: function () {
					updateGuestDetails();
				}
			}
		});
	});



	$(document).on('click', '.btn-popup-add-room', function(){
		if (checkRoomGuestInputs()) {
			var data = {"id":'',"adults":2,"kids":0,"kids_age":[]};
			windata.no_of_room = windata.no_of_room+1;
			data['room_no'] = windata.no_of_room;
			data['index'] = windata.guest_details.push(data)-1;
			var html = makeGuestDetailHtml(data);
			$('.room-guest-popup-box').append(html);
		}
	});


	$(document).on('click', '.btn-remove-room', function(){
		var id = $(this).closest('.room-main-box').attr('data-id');
		if (id != '') windata.remove_rooms.push(id);
		$(this).closest('.room-main-box').remove();
	});


	$(document).on('click', '.btn-child', function () {
		var inputController = $(this).closest('.input-controller-box');
		var val = $(inputController).find('.input-field').val();
		var index = $(this).hasClass('btn-decrease') ? val : val-1; 
		var childAgeBox = $(this).closest('.room-main-box').find('.age');
		childAgeBox.children().eq(index).toggleClass('hide');
	});



	function checkRoomGuestInputs() {
		var result = true;
		$('.room-main-box .age .age-box:not(\'.hide\')').each(function(i, v){
			var selectElem = $(v).find('.age-elem');
			if ($(selectElem).val() == '') {
				result = false;
				$(selectElem).addClass('border-red').effect('shake');
				return false;
			}
			else{
				$(selectElem).removeClass('border-red');
				result = true;
			}
		});
		return result;
	}


	function makeGuestDetailHtml(data){
		var id = data.id;
		var index  = data.index; 
		var room 	 = data.room_no;
		var adults = data.adults;
		var kids 	 = data.kids;
		var kids_age 	= data.kids_age;
		var wordAdult = adults > 1 ? adults+' Adults' : adults+' Adult';
		var wordKid   = kids > 1 ? kids+' Kids' 
								  : (kids == 0 ? '' : kids)+' Kid';
		var content = @include($viewPath.'.create_partials.guests');
		return content;
	}


	function syncGuestDetials(){
		if (windata.is_guest_detail_changed) {

			var url = "{{ url('dashboard/package/route/'.$package->token.'/cur') }}";
			var data = {
							"_token" : csrf_token, 
							"rooms" : windata.guest_details,
							"remove_rooms" : windata.remove_rooms
						};

			$.ajax({
				url: url,
				type : 'post',
				data : data,
				dataType : "json",
				success : function (response) {
					if (response.status == 200) {
						windata.guest_details = response.response;
						windata.is_guest_detail_changed = 0;
						windata.remove_rooms = [];
						windata.no_of_room = windata.guest_details.length;
					}
					else{
						windata.is_guest_detail_changed = 1;
					}
				}
			});
		}
	}


	function updateGuestDetails() {
		var rooms = [];
		$('.room-main-box').each(function (ri, rv) {
			guest = {
				"id" : $(rv).attr('data-id'),
				"adults" : $(rv).find('.adults.input-field').val(),
				"kids" : $(rv).find('.children.input-field').val(),
				"kids_age" : []
			}
			$(rv).find('.age-box:not(\'.hide\')').each(function (ai, av) {
				var isBed = $(av).find('.is-bed').prop('checked') ? 1 : 0;
				guest['kids_age'].push({
					"id" : $(av).attr('data-id'),
					"age" : $(av).find('.age-elem').val(),
					"is_bed" : isBed
				});
			})
			rooms.push(guest);
		});

		windata.guest_details = rooms;
		windata.is_guest_detail_changed = 1;
		makeGuestDetailtTitle();
	}


	function makeGuestDetailtTitle() {
		var adults = 0;
		var kids = 0;
		$.each(windata.guest_details, function(i, v){
			adults += parseInt(v.adults);
			kids += parseInt(v.kids);
		});

		var string = adults+(adults > 1 ? ' Adults' : ' Adult')
							 + (kids > 1 ? ', '+kids+' Kids' 
							 : (kids == 0 ? '' : ', '+kids+' Kid'));

		$('.guests-word').text(string);
	}



</script>
