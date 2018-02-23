<script>
	windata.extend({
		makeGuestDetailHtml : function(params){
			return `<div class="row m-bottom-10 room-guest">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<label class="m-top-5">Room `+_.get(params, 'room', '')+`</label>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<input type="text" class="form-control guests-adult" value="`+_.get(params, 'adult', 2)+`" placeholder="Adult">
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<input type="text" class="form-control guests-kid" value="`+_.get(params, 'kid', '')+`" placeholder="Kid">
					</div>
					<div class="col-md-1 col-sm-1 col-xs-1 nopadding">
						<a class="btn-remove-room cursor-pointer">
							<i class="fa fa-times m-top-5 font-size-20"></i>
						</a>
					</div>
				</div>`;
		},

		addRoomGuestPopUp : function (){
			this.temp_room_count++;
			var params = {room: this.temp_room_count, adults : 2};
			$('.room-guest-popup-box').append(this.makeGuestDetailHtml(params));
		},

		removeRoomGuestPopUp : function (thisObj){
			$(thisObj).closest('.row.room-guest').remove();
			this.temp_room_count--;
		},

		showGuestDetailsPopUp : function(elem){
			var ukey = $(elem).closest('.service-child-box').attr('data-ukey');
			var services = this.getCurrentService(ukey);
			var guests =  _.get(services, 'guests');
			// console.log(elem, ukey, guests, services);
			this.temp_room_count = guests.length;
			var content = '';
			var thisObj = this;
			$.each(guests, function(index, value){
				content += thisObj.makeGuestDetailHtml(value);
			});

			content = `<hr>
			<div class="max-height-350px min-height-100px scroll-auto scroll-bar">
				<div class="col-md-12 col-sm-12 col-xs-12 room-guest-popup-box">
					`+content+`
				</div>
				<div>
					<a class="btn btn-link btn-popup-add-room">Add Room</a>
				</div>
			</div>`;	

			$.confirm({
				title : "Rooms details",
				columnClass: 'col-md-3 col-md-offset-5',
				content : content,
				buttons: {
					submit: {
						btnClass: 'btn-primary',
						action: function(){
							thisObj.updateRoomGuests(ukey);
							thisObj.temp_room_count = 0;
						}
					},
					cancel: function () {
						thisObj.temp_room_count = 0;
					}
				}
			});
		},

		updateRoomGuests : function(ukey){
			var guests = [];
			$('.room-guest.row').each(function(i, v){
				var adults = parseInt($(v).find('.guests-adult').val());
				var kid = $(v).find('.guests-kid').val();
				kid = (kid == '') ? 0 : parseInt(kid);

				guests.push({
					'room' : i+1,
					'adults' : adults,
					'kid' : kid
				});
			});

			this.services[ukey].guests = guests;
			this.updateRoomGuestsWord(ukey);
		},

		updateRoomGuestsWord: function(ukey){
			guests = _.get(this.getCurrentService(ukey), 'guests');
			adults = _.sumBy(guests, 'adults');
			kid = _.sumBy(guests, 'kid');

			var word = adults+' Adult'+(adults > 1 ? 's' : '')+
									(kid > 0 ? ' '+kid+' kid'+(kid > 1 ? 's' : '') : '');
			$('[data-ukey="'+ukey+'"]').find('.guests-word').text(word);
		},
		addAccommodationBox : function () {

			var html = `@include('b2b.protected.dashboard.pages.voucher._partials.accommodation')`;
			$('.main-service-box .x_panel:not(".height-auto")').toggleClass('height-auto');
			$('.main-service-box .x_content:not(".hide")').toggleClass('hide');

			$('.main-service-box').append(html);

			this.services[this.ukey_count] = {
							guests : [{room:1, adults:2, kid:0}]
						};

			this.updateRoomGuestsWord(this.ukey_count);
			this.initDatePicker($('[data-ukey="'+this.ukey_count+'"]'));
			this.ukey_count++;
		}
	});

	$(document).ready(function(){
		
		windata.updateRoomGuestsWord();

		$('.check-in.datepicker').daterangepicker({
				singleDatePicker: true,
				calender_style: "picker_1",
				format : "DD/MM/YYYY",
				minDate : new Date(),
				startDate: new Date(),
			}, function(start, end, label) {
			
			var date = moment($('.check-in.datepicker').val(), 'DD/MM/YYYY')
									.add(1, 'day')._d;

			$('.check-out.datepicker').val('').daterangepicker({
				singleDatePicker: true,
				calender_style: "picker_1",
				format : "DD/MM/YYYY",
				minDate : date,
				startDate: date,
			});
		});

		$('.check-out.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_1",
			format : "DD/MM/YYYY",
			minDate : new Date(),
			startDate: new Date(),
		});
		
	});

	$(document).on('click', '.btn-popup-room-guest', function () {
		windata.showGuestDetailsPopUp(this);
	});

	$(document).on('click', '.btn-popup-add-room', function(){
		windata.addRoomGuestPopUp();
	});

	$(document).on('click', '.btn-remove-room', function(){
		windata.removeRoomGuestPopUp(this);
	});

	$(document).on('click', '.btn-accommodation', function(){
		windata.addAccommodationBox();
	});


	$(document).on('click', '.btn-save', function(){
		var services = [];
		var check = true;
		$('.service-child-box').each(function (i, v) {
			ukey = $(v).attr('data-ukey');
			guests = _.get(windata.getCurrentService(ukey), 'guests', []);
			/*dest_id = $(v).find('.location').attr('data-code');
			check_in = $(v).find('.check-in').val();
			check_out = $(v).find('.check-out').val();
			if (dest_id == '' || dest_id == 'undefined' || check_in = '' || check_out == '') {
				check = false;
				return false;
			}*/

			services.push({
				'type' : $(v).attr('data-type'),
				'dest_id' : $(v).find('.location').attr('data-code'),
				'check_in' : $(v).find('.check-in').val(),
				'check_out' : $(v).find('.check-out').val(),
				'guests' : guests,
				'data' : {
						'name' : $(v).find('.accommo-name').val(),
						'code' : $(v).find('.accommo-name').attr('data-code'),
						'vendor' : $(v).find('.accommo-name').attr('data-vendor'),
						'image' : $(v).find('.accommo-name').attr('data-image'),
						'prop_type' : $(v).find('.prop-type').val(),
						'room_only' : + $(v).find('.meal.lunch').prop('checked'),
						'lunch' : + $(v).find('.meal.lunch').prop('checked'),
						'breakfast' : + $(v).find('.meal.breakfast').prop('checked'),
						'dinner' : + $(v).find('.meal.dinner').prop('checked'),
					},
				'terms' : $(v).find('.cancellation_policy').val(),
				'remark' : $(v).find('.remark').val()
			});
		});

		var data = {
				'_token' : csrf_token,
				'ctoken' : $('.client-contact').attr('data-token'),
				'mobile' : $('.client-contact').val(),
				'name' : $('.client-name').val(),
				'email' : $('.client-email').val(),
				'services' : services
			};


		$.ajax({
			type: "POST",
		  url:"{{ route("vouchers.store_data") }}",
		  data: data,
		  dataType: 'json',
		  success: function (res) {
		  	document.location.href = '{{ url('dashboard/vouchers/show') }}/'+
		  											_.get(res, 'token', '');
		  }
		});

	});

	$(document).on('click', '.collapse-link', function () {
		$(this).closest('.x_panel').toggleClass('height-auto')
						.find('.x_content').toggleClass('hide');
	});


	$(document).on('click', '.new-close-link', function () {
		thisObj = this;
		$.confirm({
			title : "Warnging",
			columnClass: 'col-md-3 col-md-offset-5',
			content : `are you sure to delete this? cause if delete it can't be recovered.`,
			buttons: {
				submit: {
					btnClass: 'btn-primary',
					action: function(){
						$(thisObj).closest('.service-child-box').remove();
					}
				},
				cancel: function () {
				}
			}
		});
	});

</script>