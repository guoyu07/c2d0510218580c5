@extends('b2b.protected.dashboard.main')


@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('content')
<div class="row">
	{{-- @include('b2b.protected.dashboard.pages.voucher._partials.client') --}}
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Client Info</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<!-- <div class="col-md-3 col-sm-3 col-xs-3">
					<label>ID : <span class="show-client-id"></span></label>
				</div> -->
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Name : <span class="show-client-name"></span></label>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Mobile : <span class="show-client-mobile" data-token=""></span></label>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<label>Email : <span class="show-client-email"></span></label>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row main-service-box">
	{{-- @include('b2b.protected.dashboard.pages.voucher._partials.accommodation') --}}
</div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="col-md-2 col-sm-2 col-xs-12">
				{{-- <button class="btn btn-success btn-block btn-save">Finish</button> --}}
				<a href="" class="btn btn-dark btn-finish" disabled>Finish</a>
			</div>
			<!-- <div class="col-md-2 col-sm-2 col-xs-12">
				<button class="btn btn-default btn-block">Cancel</button>
			</div> -->

			<div class="col-md-2 col-sm-2 col-xs-12 pull-right">
				<button class="btn btn-primary btn-activity btn-block">Add Activity</button>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12 pull-right">
				<button class="btn btn-primary btn-accommodation">Add Accommodation</button>
			</div>
		</div>
	</div>
</div>

<div class="hide">
	@include('b2b.protected.dashboard.pages.voucher._partials.client_input')
	@include('b2b.protected.dashboard.pages.voucher._partials.accommodation_input')
	@include('b2b.protected.dashboard.pages.voucher._partials.activity_input')
</div>

@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

@endsection

@section('scripts')
	<script>
		var windata = {
			services : {},
			temp_room_count : 0,
			ukey_count : 0,
			vtoken : '',
			ctoken : '',
			getCurrentService : function (ukey) {
				return _.get(this, 'services['+ukey+']', {});
			},

			showClientInfoPopUp : function () {
				var content = `<hr>
				<div class="max-height-350px min-height-100px scroll-auto scroll-bar">
					<div class="col-md-12 col-sm-12 col-xs-12 client-popup-box">
						`+$('.client-input-box').html()+`
					</div>
				</div>`;

				$.confirm({
					title : "Client Details",
					columnClass: 'col-md-4 col-md-offset-4',
					content : content,
					buttons: {
						submit: {
							btnClass: 'btn-primary',
							action: function(){
								$('.client-popup-box').find('.border-red')
																				.removeClass('border-red');

								var token = $('.client-popup-box')
														.find('.client-contact')
															.attr('data-token');

								var mobile = $('.client-popup-box')
															.find('.client-contact').val();
								if (mobile.length < 10) {
									$('.client-popup-box')
											.find('.client-contact')
												.addClass('border-red').effect('shake');
									return false;
								}

								var name = $('.client-popup-box')
															.find('.client-name').val();

								if (name.length < 2) {
									$('.client-popup-box')
											.find('.client-name')
												.addClass('border-red').effect('shake');
									return false;
								}

								var email = $('.client-popup-box')
															.find('.client-email').val();

								if (!isEmail(email)) {
									$('.client-popup-box')
											.find('.client-email')
												.addClass('border-red').effect('shake');
									return false;
								}

								if (token.length < 10) {
									$.ajax({
										type : "POST",
										url : "{{ route('vouchers.client_add') }}",
										data : { 
												"_token" : csrf_token,
												"mobile" : mobile,
												"name" : name,
												"email" : email,
											},
										dataType : "JSON",
										success : function (res) {
											token = _.get(res, 'token', '');
										}
									});
								}
								windata.ctoken = token;
								$('.show-client-mobile').text(mobile)
													.attr('data-token', token);
								$('.show-client-name').text(name);
								$('.show-client-email').text(email);

							}
						},
						cancel: function () {
							document.location.href = '{{route('vouchers.index')}}';
						}
					}
				});
			},

			showAccommodationPopUp : function () {
				thisObj = this;
				var content = `<hr>
				<div class="max-height-350px min-height-100px scroll-auto scroll-bar">
					<div class="col-md-12 col-sm-12 col-xs-12 popup-box accommodation-popup-box">
						`+$('.temp-service-child-box').html()+`
					</div>
				</div>`;

				$.confirm({
					title : "Add accommodation voucher",
					columnClass: 'col-md-9 col-md-offset-2',
					content : content,
					onContentReady : function () {
						var popUpBox = $('.accommodation-popup-box');
						thisObj.initDatePicker(popUpBox);
					},
					buttons: {
						submit: {
							btnClass: 'btn-primary',
							action: function(){
								popUpBox = $('.accommodation-popup-box');

								$(popUpBox).find('.border-red').removeClass('border-red');
								var dest_id = $(popUpBox).find('.location')
																						.attr('data-code');
								if (dest_id == '') {
									$(popUpBox).find('.location')
											.addClass('border-red').effect('shake');
									return false;
								}

								var check_in = $(popUpBox).find('.check-in').val();
								if (check_in == '') {
									$(popUpBox).find('.check-in')
											.addClass('border-red').effect('shake');
									return false;
								}

								var check_out = $(popUpBox).find('.check-out').val();
								if (check_out == '') {
									$(popUpBox).find('.check-out')
											.addClass('border-red').effect('shake');
									return false;
								}

								var name = $(popUpBox).find('.accommo-name').val();
								var code = $(popUpBox).find('.accommo-name')
																				.attr('data-code');
								var vendor = $(popUpBox).find('.accommo-name')
																					.attr('data-vendor');

								if (name == '' || code == '' || vendor == '') {
									$(popUpBox).find('.accommo-name')
											.addClass('border-red').effect('shake');
									return false;
								}

								var prop_type = $(popUpBox).find('.prop-type').val();

								if (prop_type == '') {
									$(popUpBox).find('.prop-type')
											.addClass('border-red').effect('shake');
									return false;
								}
								guests = [];
								isGuestOk = true;
								$(popUpBox).find('.room-box .adults').each(function (i, v) {
									var adults = $(this).val();
									if (adults < 1) {
										isGuestOk = false;
										$(this).addClass('border-red').effect('shake');
										return false;
									}
									guests.push({
										"room" : i+1,
										"adults" : adults
									});
								});

								if (!isGuestOk) { return false; }

								data = {
									'_token' : csrf_token,
									'vtoken' : thisObj.vtoken,
									'ctoken' : thisObj.ctoken,
									'type' : $(popUpBox).find('.service-type').val(),
									'dest_id' : dest_id,
									'check_in' : check_in,
									'check_out' : check_out,
									'data' : {
											'name' : name,
											'code' : code,
											'vendor' : vendor,
											'image' : $(popUpBox).find('.accommo-name').attr('data-image'),
											'confirmation_no' : $(popUpBox).find('.confirmation-no').val(),
											'prop_type' : prop_type,
											'room_only' : + $(popUpBox).find('.meal.lunch').prop('checked'),
											'lunch' : + $(popUpBox).find('.meal.lunch').prop('checked'),
											'breakfast' : + $(popUpBox).find('.meal.breakfast').prop('checked'),
											'dinner' : + $(popUpBox).find('.meal.dinner').prop('checked'),
										},
									'guests' : guests,
									'terms' : $(popUpBox).find('.cancellation_policy').val(),
									'remark' : $(popUpBox).find('.remark').val()
								};
								
								$.ajax({
									type : "POST",
									url : "{{ route('vouchers.store_data') }}",
									data : data,
									dataType : "JSON",
									success : function (res) {
										$('.main-service-box').append(`<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="x_panel">
												<div class="x_title">
													<div class="col-md-5 col-sm-5 col-xs-5">
														<h2>Accommodation</h2>
													</div>
													<div class="col-md-7 col-sm-7 col-xs-7">
														<label class="pull-right">Confirmation No: `+_.get(data, 'data.confirmation_no', '?')+`</label>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="x_content">
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<h2>`+name+`</h2>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
															`+check_in+` - `+check_out+`
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<label>Property Type : `+prop_type+`</label>
														</div>`+thisObj.getGuestString(guests)+`</div>
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
															<a href="{{ url('dashboard/vouchers/show/pdf') }}/`+_.get(res, 'vstoken', '')+`" class="btn btn-success" target="_blank">Get Voucher</a>
														</div>
													</div>
												</div>
											</div>
										</div>`);

										$('.btn-finish.btn-dark').addClass('btn-success')
												.removeClass('btn-dark').removeAttr("disabled")
													.attr('href', '{{ url('dashboard/vouchers/show') }}/'+_.get(res, 'vtoken', ''));
									}
								});
							}
						},
						cancel: function () {
						}
					}
				});
			},
			
			showActivityPopUp : function () {
				thisObj = this;
				var content = `<hr>
				<div class="max-height-350px min-height-100px scroll-auto scroll-bar">
					<div class="col-md-12 col-sm-12 col-xs-12 popup-box activity-popup-box">
						`+$('.temp-activity-service-child-box').html()+`
					</div>
				</div>`;

				$.confirm({
					title : "Add activity voucher",
					columnClass: 'col-md-9 col-md-offset-2',
					content : content,
					onContentReady : function () {
						var popUpBox = $('.activity-popup-box');
						thisObj.initDatePicker(popUpBox);
					},
					buttons: {
						submit: {
							btnClass: 'btn-primary',
							action: function(){
								popUpBox = $('.activity-popup-box');

								$(popUpBox).find('.border-red').removeClass('border-red');
								var dest_id = $(popUpBox).find('.location')
																						.attr('data-code');
								if (dest_id == '') {
									$(popUpBox).find('.location')
											.addClass('border-red').effect('shake');
									return false;
								}

								var check_in = $(popUpBox).find('.check-in').val();
								if (check_in == '') {
									$(popUpBox).find('.check-in')
											.addClass('border-red').effect('shake');
									return false;
								}

								var check_out = $(popUpBox).find('.check-out').val();
								if (check_out == '') {
									$(popUpBox).find('.check-out')
											.addClass('border-red').effect('shake');
									return false;
								}

								var name = $(popUpBox).find('.accommo-name').val();
								var code = $(popUpBox).find('.accommo-name')
																				.attr('data-code');
								var vendor = $(popUpBox).find('.accommo-name')
																					.attr('data-vendor');

								if (name == '' || code == '' || vendor == '') {
									$(popUpBox).find('.accommo-name')
											.addClass('border-red').effect('shake');
									return false;
								}

								var prop_type = $(popUpBox).find('.prop-type').val();

								if (prop_type == '') {
									$(popUpBox).find('.prop-type')
											.addClass('border-red').effect('shake');
									return false;
								}
								guests = [];
								isGuestOk = true;
								$(popUpBox).find('.room-box .adults').each(function (i, v) {
									var adults = $(this).val();
									if (adults < 1) {
										isGuestOk = false;
										$(this).addClass('border-red').effect('shake');
										return false;
									}
									guests.push({
										"room" : i+1,
										"adults" : adults
									});
								});

								if (!isGuestOk) { return false; }

								data = {
									'_token' : csrf_token,
									'vtoken' : thisObj.vtoken,
									'ctoken' : thisObj.ctoken,
									'type' : $(popUpBox).find('.service-type').val(),
									'dest_id' : dest_id,
									'check_in' : check_in,
									'check_out' : check_out,
									'data' : {
											'name' : name,
											'code' : code,
											'vendor' : vendor,
											'image' : $(popUpBox).find('.accommo-name').attr('data-image'),
											'confirmation_no' : $(popUpBox).find('.confirmation-no').val(),
											'prop_type' : prop_type,
											'room_only' : + $(popUpBox).find('.meal.lunch').prop('checked'),
											'lunch' : + $(popUpBox).find('.meal.lunch').prop('checked'),
											'breakfast' : + $(popUpBox).find('.meal.breakfast').prop('checked'),
											'dinner' : + $(popUpBox).find('.meal.dinner').prop('checked'),
										},
									'guests' : guests,
									'terms' : $(popUpBox).find('.cancellation_policy').val(),
									'remark' : $(popUpBox).find('.remark').val()
								};
								
								$.ajax({
									type : "POST",
									url : "{{ route('vouchers.store_data') }}",
									data : data,
									dataType : "JSON",
									success : function (res) {
										$('.main-service-box').append(`<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="x_panel">
												<div class="x_title">
													<div class="col-md-5 col-sm-5 col-xs-5">
														<h2>Accommodation</h2>
													</div>
													<div class="col-md-7 col-sm-7 col-xs-7">
														<label class="pull-right">Confirmation No: `+_.get(data, 'data.confirmation_no', '?')+`</label>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="x_content">
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<h2>`+name+`</h2>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
															`+check_in+` - `+check_out+`
														</div>
													</div>
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<label>Property Type : `+prop_type+`</label>
														</div>`+thisObj.getGuestString(guests)+`</div>
													<div class="row">
														<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
															<a href="{{ url('dashboard/vouchers/show/pdf') }}/`+_.get(res, 'vstoken', '')+`" class="btn btn-success" target="_blank">Get Voucher</a>
														</div>
													</div>
												</div>
											</div>
										</div>`);

										$('.btn-finish.btn-dark').addClass('btn-success')
												.removeClass('btn-dark').removeAttr("disabled")
													.attr('href', '{{ url('dashboard/vouchers/show') }}/'+_.get(res, 'vtoken', ''));
									}
								});
							}
						},
						cancel: function () {
						}
					}
				});
			},
			getGuestString : function(guests) {
				var str = '';
				$.each(guests, function(i, v){
					room = i+1;
					str += `<div class="col-md-12 col-sm-12 col-xs-12">
						<label>Room `+room+` : <i class="fa fa-user"></i> Adult : `+_.get(v, 'adults', 2)+`</label>
					</div>`;
				});
				return str;
			},
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
			},

			initDatePicker : function (parent) {
				$(parent).find('.check-in.datepicker').daterangepicker({
					singleDatePicker: true,
					calender_style: "picker_1",
					format : "DD/MM/YYYY",
					minDate : new Date(),
					startDate: new Date(),
				}, function(start, end, label) {
					console.log(parent);
					var date = moment($(parent).find('.check-in.datepicker').val(), 'DD/MM/YYYY')
											.add(1, 'day')._d;

					$(parent).find('.check-out.datepicker').val('').daterangepicker({
						singleDatePicker: true,
						calender_style: "picker_1",
						format : "DD/MM/YYYY",
						minDate : date,
						startDate: date,
					});
				});

				$(parent).find('.check-out.datepicker').daterangepicker({
					singleDatePicker: true,
					calender_style: "picker_1",
					format : "DD/MM/YYYY",
					minDate : new Date(),
					startDate: new Date(),
				});
			},

			getAccommodationProps: function (elem, data) {
				$.ajax({
					type : 'POST',
					url : "{{ route('vouchers.show_accommodation_props') }}",
					dataType : "JSON",
					data : data,
					success : function (res) {
						console.log(res);
					}
				});
			}

		};

		$(document).ready(function(){
			windata.showClientInfoPopUp();
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
			windata.showAccommodationPopUp();
			// windata.addAccommodationBox();

		});

		$(document).on('click', '.btn-activity', function(){
			windata.showActivityPopUp();
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

		$(document).on('click', '.btn-add-room', function () {
			var parent = $(this).closest('.box-add-room');
			$(`<div class="col-md-2 col-sm-2 col-xs-2 m-top-5 room-box">
					<div class="row">
						<div class="col-md-9 col-sm-9 col-xs-9 nopadding p-right-5">
							<input type="text" class="form-control adults height-25 p-2-5" placeholder="Adults" value="2">
						</div>
						<div class="col-md-3 col-sm-3 col-xs-3 nopadding m-top-2">
							<a class="cursor-pointer remove-room"><i class="fa fa-times"></i></a>
						</div>
					</div>
				</div>`).insertBefore(parent);
			return  false;
		});

		$(document).on('click', 'a.remove-room', function () {
			$(this).closest('.room-box').remove();
		});

	</script>

	@include('b2b.protected.dashboard.pages.voucher.html.autocomplete')


@endsection 
