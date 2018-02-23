<script>
	var windata = {
		services : {!! $isCreate ? '{}' : $data->voucherServices->pluck('built_data', 'token') !!},
		is_create : {{ $isCreate }},
		ukey_count : 0,
		vtoken : "{{ $isCreate ? '' : $data->token }}",
		ctoken : "{{ $isCreate ? '' : $data->client->token }}",
		runOnReady: function () {
			if (this.is_create) {
				this.showClientInfoPopUp();
			}
			else{
				thisObj = this;
				$.each(this.services, function (i, v) {
					thisObj.showServiceHtml(v);
				});
			}


		},
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
										windata.ctoken = token;
										$('.show-client-mobile').attr('data-token', token);
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

		showAccommodationPopUp : function (vstoken = '') {
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
					if (vstoken.length > 10) {
						var tData = _.get(thisObj, 'services.'+vstoken, {});

						$(popUpBox).find('.location')
												.val(_.get(tData, 'dest', ''))
													.attr('data-code', _.get(tData, 'dest_id', ''));
						$(popUpBox).find('.check-in')
												.val(_.get(tData, 'check_in', ''));

						$(popUpBox).find('.check-out')
												.val(_.get(tData, 'check_out', ''));

						$(popUpBox).find('.accommo-name')
							.val(_.get(tData, 'data.name', ''))
								.attr('data-code', _.get(tData, 'data.code', ''))
								.attr('data-image', _.get(tData, 'data.image', ''))
								.attr('data-vendor', _.get(tData, 'data.vendor', ''));

						$(popUpBox).find('.prop-type')
													.val(_.get(tData, 'data.prop_type',''));
						
						$.each(_.get(tData, 'guests', []), function (gi, gv) {
							if (gi) {
								$(popUpBox).find('.btn-add-room').trigger('click');
							}

							$(popUpBox).find('.adults').last()
													.val(_.get(gv, 'adults', 2));
						});

						$(popUpBox).find('.cancellation_policy')
												.val(_.get(tData, 'terms', ''));

						$(popUpBox).find('.remark')
												.val(_.get(tData, 'remark', ''));
						
						$(popUpBox).find('.confirmation-no')
												.val(_.get(tData, 'data.confirmation_no', ''));
						
						$(popUpBox).find('.meal.breakfast')
											.prop('checked', _.get(tData, 'data.breakfast', 0));
						$(popUpBox).find('.meal.lunch')
											.prop('checked', _.get(tData, 'data.lunch', 0));
						$(popUpBox).find('.meal.dinner')
											.prop('checked', _.get(tData, 'data.dinner', 0));
					}
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
								'vstoken' : vstoken,
								'ctoken' : thisObj.ctoken,
								'type' : $(popUpBox).find('.service-type').val(),
								'dest' : $(popUpBox).find('.location').val(),
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

									thisObj.vtoken = _.get(res, 'vtoken', '');
									data.vstoken = _.get(res, 'vstoken', '');

									thisObj.showServiceHtml(data);

									$('.btn-finish.btn-dark').addClass('btn-success')
											.removeClass('btn-dark').removeAttr("disabled")
												.attr('href', '{{ url('dashboard/vouchers/show') }}/'+_.get(res, 'vtoken', ''));


									thisObj.services[_.get(res, 'vstoken', '')] = data;
								}
							});
						}
					},
					cancel: function () {
					}
				}
			});
		},

		showServiceHtml: function (data) {
			$('.main-service-box').find('[data-vstoken="'+
															_.get(data, 'vstoken', '')+'"]')
																.closest('.service-child-box').remove();

			$('.main-service-box').append(`<div class="col-md-12 col-sm-12 col-xs-12 service-child-box">
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
									<h2>`+_.get(data, 'data.name', '')+`</h2>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									`+_.get(data, 'check_in', '')+` - `+_.get(data, 'check_out', '')+`
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label>Property Type : `+_.get(data, 'data.prop_type', '')+`</label>
								</div>`+thisObj.getGuestString(_.get(data, 'guests', ''))+`</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
									<a href="{{ url('dashboard/vouchers/show/pdf') }}/`+_.get(data, 'vstoken', '')+`" class="btn btn-success" target="_blank">Get Voucher</a>

									<button class="btn btn-primary btn-primary btn-service-edit" data-vstoken="`+_.get(data, 'vstoken', '')+`">Edit</button>
								</div>
							</div>
						</div>
					</div>
				</div>`);
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

		initDatePicker : function (parent) {
			$(parent).find('.check-in.datepicker').daterangepicker({
				singleDatePicker: true,
				calender_style: "picker_1",
				format : "DD/MM/YYYY",
				minDate : new Date(),
				startDate: new Date(),
			}, function(start, end, label) {
				// console.log(parent);
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

		getAccommodationProps: function (data) {
			thisObj = this;

			$.ajax({
				type : 'POST',
				url : "{{ route('vouchers.show_accommodation_props') }}",
				dataType : "JSON",
				data : data,
				success : function (res) {
					thisObj.properties = res;
					/*var option = '';
					$.each(res, function (i , v) {
						if (_.get(v, 'property_type', false) != false) {
							option += '<option value="'+
												_.get(v, 'property_type', '')+'">';
						}
					});
					$('.popup-box').find('#prop_type').html(option);*/
				}
			});
		}

	};

	$(document).ready(function(){
		windata.runOnReady();
	});

	$(document).on('click', '.btn-accommodation', function(){
		windata.showAccommodationPopUp();
	});

	$(document).on('click', '.btn-activity', function(){
		windata.showActivityPopUp();
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

	$(document).on('click', '.btn-service-edit', function () {
		windata.showAccommodationPopUp($(this).attr('data-vstoken'));
	});

</script>

@include('b2b.protected.dashboard.pages.voucher.html.autocomplete')
