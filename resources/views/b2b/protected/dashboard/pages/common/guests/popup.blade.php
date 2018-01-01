
{{-- 
	
	this room guest detail can be use globaly 
	file need to use 
	
	1) this file

	script :
	2) <script src="{{ asset('js/my_plus_minus.js') }}"></script>

	3) create or append 

	var windata = { 
			is_guest_detail_changed :
			no_of_room :
			guest_details :
			remove_rooms :
		}

 --}}
<script>
	{{-- windata must be defined to object --}}

	$.extend(windata, {
		
		guest_details : {
			is_guest_detail_changed : 1,
			data : {
				_token :csrf_token,
				rooms : {!! $package->roomGuestsOrDefault()->toJson() !!},
				no_of_room : {{ $package->roomGuestsOrDefault()->count() }},
				remove_rooms : []
			} 
		},

		makeGuestDetailtTitle : function(){
			var adults = 0;
			var kids = 0;
			$.each(this.guest_details.data.rooms, function(i, v){
				adults += parseInt(v.adults);
				kids += parseInt(v.kids);
			});
			var string = adults+(adults > 1 ? ' Adults' : ' Adult')
								 + (kids > 1 ? ', '+kids+' Kids' 
								 : (kids == 0 ? '' : ', '+kids+' Kid'));

			$('.guests-word').text(string);

			return true;
		},

		checkRoomGuestInputs : function () {
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
		},


		makeGuestDetailHtml : function(data){
			var id = data.id;
			var index  = data.index; 
			var room 	 = data.room_no;
			var adults = data.adults;
			var kids 	 = data.kids;
			var kids_age 	= data.kids_age;
			var wordAdult = adults > 1 ? adults+' Adults' : adults+' Adult';
			var wordKid   = kids > 1 ? kids+' Kids' 
									  : (kids == 0 ? '' : kids)+' Kid';

			var content = @include('b2b.protected.dashboard.pages.common.guests.html');
			return content;
		},


		syncGuestDetials :function (){
			if (this.guest_details.is_guest_detail_changed) {
				thisObj = this;
				var url = "{{ route('package.roomGuests',$package->token) }}";
				$.ajax({
					url: url,
					type : 'post',
					data : this.guest_details.data,
					dataType : "json",
					success : function (response) {
						if (response.status == 200) {
							thisObj.guest_details.data.rooms = response.response;
							thisObj.guest_details.is_guest_detail_changed = 0;
							thisObj.guest_details.data.remove_rooms = [];
							thisObj.guest_details.data.no_of_room = thisObj.guest_details.data.rooms.length;
						}
						else{
							thisObj.guest_details.is_guest_detail_changed = 1;
						}
					}
				});
			}
		},

		updateGuestDetails : function () {
			var rooms = [];
			$('.room-main-box').each(function (ri, rv) {
				guest = {
					"id" : $(rv).attr('data-id'),
					"adults" : $(rv).find('.adults.input-field').val(),
					"kids" : $(rv).find('.children.input-field').val(),
					"kids_age" : []
				};
				$(rv).find('.age-box:not(\'.hide\')').each(function (ai, av) {
					var isBed = $(av).find('.is-bed').prop('checked') ? 1 : 0;
					guest['kids_age'].push({
						"id" : $(av).attr('data-id'),
						"age" : $(av).find('.age-elem').val(),
						"is_bed" : isBed
					});
				});
				rooms.push(guest);
			});

			this.guest_details.data.rooms = rooms;
			this.guest_details.is_guest_detail_changed = 1;
			this.makeGuestDetailtTitle();
		},

		showGuestDetailsPopUp : function(){
			var thisObj = this;
			var content = '';
			var room_no = 1;
			$.each(this.guest_details.data.rooms, function(index, value){
				if (value != undefined) {
					value['index'] = index;
					value['room_no'] = room_no;
					content += thisObj.makeGuestDetailHtml(value);
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
							if (!thisObj.checkRoomGuestInputs()) {
								return false;
							}
							thisObj.updateGuestDetails();
							thisObj.syncGuestDetials();
						}
					},
					cancel: function () {
						thisObj.updateGuestDetails();
					}
				}
			});
		},

		addRoomInPopUp : function(){
			if (this.checkRoomGuestInputs()) {
				var data = {"id":'',"adults":2,"kids":0,"kids_age":[]};
				this.guest_details.data.no_of_room++;
				data['room_no'] = this.guest_details.data.no_of_room;
				data['index'] = this.guest_details.data.rooms.push(data)-1;
				var html = this.makeGuestDetailHtml(data);
				$('.room-guest-popup-box').append(html);
			}
		},
		
		removeRoomFromPopUp : function(elem){
			var id = $(elem).closest('.room-main-box').attr('data-id');
			if (id != '') this.guest_details.data.remove_rooms.push(id);
			$(elem).closest('.room-main-box').remove();
		},

		manageChildFromPopUp : function (elem) {
			var inputController = $(elem).closest('.input-controller-box');
			var val = $(inputController).find('.input-field').val();
			var index = $(elem).hasClass('btn-decrease') ? val : val-1; 
			var childAgeBox = $(elem).closest('.room-main-box').find('.age');
			childAgeBox.children().eq(index).toggleClass('hide');
		}
	});

	$(document).ready(function () {
		windata.makeGuestDetailtTitle();
	});

	$(document).on('click', '.btn-popup-room-guest', function(){
		windata.showGuestDetailsPopUp()
	});

	$(document).ready(function () {
		windata.makeGuestDetailtTitle();
	});

	$(document).on('click', '.btn-popup-add-room', function(){
		windata.addRoomInPopUp();
	});

	$(document).on('click', '.btn-remove-room', function(){
		windata.removeRoomFromPopUp(this);
	});

	$(document).on('click', '.btn-child', function () {
		windata.manageChildFromPopUp(this);
	});
</script>
