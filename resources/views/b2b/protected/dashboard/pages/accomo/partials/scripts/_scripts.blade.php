@include($viewPath.'.partials.scripts.objects')
<script>
	var windata = {
		apivendor : ['self', 'tbo'], 
		current_rtoken : "{{ isset($accomoRoutes->first()->token) ? $accomoRoutes->first()->token : "" }}",
		routes : {!! $accomoRoutes->pluck('route_formatted', 'token')->toJson() !!},
		routes_order : {!! $accomoRoutes->pluck('token')->toJson() !!},
		search_name : '',
		is_searched : false,
		last_rtoken : "{{ isset($accomoRoutes->last()->token) ? $accomoRoutes->last()->token : "" }}",
		getCurrentRoute : function () {
			return this.getRouteData(this.current_rtoken);
		},

		getRouteData : function(rtoken){
			return this.routes[rtoken];
		},

		getNextRouteToken : function(rtoken){
			var isFound = false;
			var nextRtoken = "";
			
			$.each(this.routes_order, function(i, v){
				if (isFound) {
					nextRtoken = v;
					return false
				}

				if (rtoken == v) {
					isFound = true;
				}
			});

			return nextRtoken;
		},

		setRouteInfo(rtoken){
			this.current_rtoken = rtoken;
			var route = this.getRouteData(rtoken);
			$('#filter_search').val('');

			if (_.get(route, 'start_date', null) != null) {
				$('span.show-start-date').html(moment(_.get(route, 'start_date', null)).format('DD-MMM-YYYY'));
			}
			if (_.get(route, 'end_date', null) != null) {
				$('span.show-end-date').html(moment(_.get(route, 'end_date', null)).format('DD-MMM-YYYY'));
			}
		},

		setGuestDetails: function(){
			this.guest_details.data['rtoken'] = this.current_rtoken;
			this.guest_details.data.rooms = this.routes[this.current_rtoken].guest_details;
			this.guest_details.data.no_of_room = this.guest_details.data.rooms.length;
			this.makeGuestDetailtTitle();
		},


		setAccommodationResult: function (result, rtoken) {
			var oldHotelResult = _.get(this.routes[rtoken], 'accommodation_result', []);
			this.routes[rtoken]['accommodation_result'] = _.unionWith(oldHotelResult, result, _.isEqual);
		},

		validateInputs: function (targetTab){
			if ($(targetTab).find('[data-type="pick_up"]').prop('checked')) {
				if ($(targetTab).find('.h-pick-up.transfer').val() == '') {
					$(targetTab).find('.h-pick-up.transfer')
												.addClass('border-red').effect('shake');
					$.alert({
						title : 'Pick-Up issue.', 
						content : 'Kindly select pick-up location'
					});
					return false;
				}
				else{
					$(targetTab).find('.h-pick-up.transfer')
												.removeClass('border-red');
				}

				if ($(targetTab).find('.h-pick-up.transfer-mode').val() == '') {
					$(targetTab).find('.h-pick-up.transfer-mode')
												.addClass('border-red').effect('shake');

					$.alert({
						title : 'Pick-Up issue.', 
						content : 'Kindly select pick-up mode'
					});
					return false;
				}
				else{
					$(targetTab).find('.h-pick-up.transfer-mode')
												.removeClass('border-red');
				}
			}


			if ($(targetTab).find('[data-type="drop_off"]').prop('checked')) {
				if ($(targetTab).find('.h-drop-off.transfer').val() == '') {
					$(targetTab).find('.h-drop-off.transfer')
												.addClass('border-red').effect('shake');
					$.alert({
						title : 'Drop off issue.', 
						content : 'Kindly select drop-off location'
					});
					return false;
				}
				else{
					$(targetTab).find('.h-drop-off.transfer')
												.removeClass('border-red');
				}

				if ($(targetTab).find('.h-drop-off.transfer-mode').val() == '') {
					$(targetTab).find('.h-drop-off.transfer-mode')
												.addClass('border-red').effect('shake');
					$.alert({
						title : 'Drop off issue.', 
						content : 'Kindly select drop-off mode'
					});
					return false;
				}
				else{
					$(targetTab).find('.h-drop-off.transfer-mode')
												.removeClass('border-red');
				}
			}

			var availableRooms = parseInt(this.guest_details.data.no_of_room);
			var currentRoom = 0;
			var result = false;

			$(targetTab).find('.btn-danger.btn-book-prop').each(function(i,v){
				currentRoom += parseInt($(v).closest('.prop-container')
																			.find('.no-of-rooms').val());
				if (currentRoom > availableRooms) {
					result = false;
					return false;
				}
			});
			
			if (currentRoom == availableRooms) { 
				result = true; 
			}
			else{
				$.alert({
					title : 'No of room mismatch.', 
					content : 'Kindly check the no of room'
				});
			}
			return result;
		},

		isProptryCountLess: function (targetTab){
			var availableRooms = parseInt(this.guest_details.data.no_of_room);
			var currentRoom = 0;
			var result = false;

			$(targetTab).find('.btn-danger.btn-book-prop').each(function(i,v){
				currentRoom += parseInt($(v).closest('.prop-container')
																			.find('.no-of-rooms').val());
				if (currentRoom > availableRooms) {
					result = false;
					return false;
				}
			});
			
			if (currentRoom < availableRooms) { result = true; }
			return result;
		},

		fatchAccomoResult : function (rtoken = '') {
			$('#loging_log').show();
			route = this.getRouteData(rtoken);
			mode = _.get(route, 'mode');
			var thisObj = this;
			var vendors = mode == 'cruise' ? ['self'] : this.apivendor;
			var isSearched = this.is_searched;
			$.each(vendors, function(vendorKey, vendor){
				rtoken = rtoken.length > 1 ? rtoken : thisObj.current_rtoken;
				var url = "{{ urlAccomoApi('fatch') }}/"+rtoken+"?format=json&vendor="+vendor;

				$.ajax({
					url: url,
					type:"post",
					dataType: 'JSON',
					data: {'_token' : csrf_token, 'term' : thisObj.search_name},
					success: function(response, textStatus, xhr) {
						$('#loging_log').hide();
						accomos = _.get(response, 'accommodations', []);
						thisObj.populateAccomos(rtoken, accomos, isSearched);
						thisObj.setAccommodationResult(accomos, rtoken);
						/*thisObj.populateHtmlInView(rtoken);*/
					},
					error: function(xhr, textStatus) {
						handleError(xhr);
					}
				});
			});
		},

		nextAccomoEvent : function (current_rtoken) {
			$('#loging_log').show();

			if (current_rtoken == this.last_rtoken) {
				setTimeout(function () {    
					document.location.href = "{{ $package->eventActionUrl('accommodation') }}";
				}, 5000);
			}
			else{
				var rtoken = this.getNextRouteToken(current_rtoken);
				$('#filter_search').val('');
				$('[href="#target_'+rtoken+'"]').click();
				$('#loging_log').hide();
			}
		},



		fatchAccomoPropResult : function (elem, rtoken) {
			var thisObj = this;
			var parent = $(elem).closest('.list.list-unstyled');
			var parentLi = $(elem).closest('.main-list-item');

			$(elem).toggleClass('off on');
			$(parent).find('.hotel-detail').addClass('off');
			$(parentLi).find('.hotel-detail')
									.addClass('on').removeClass('off');

			$(parent).find('.hotel-detail.off').hide();
			$(parentLi).find('.hotel-detail').toggle();

			var hasElem = $(parentLi).find('.btn-book-prop');

			if (hasElem.length == 0) {
				$('#loging_log').show();
				var vdr = $(elem).attr('data-vdr');
				var id = $(elem).attr('data-id');
				var idx = $(elem).attr('data-idx');
				var ukey = $(elem).attr('data-ukey');


				var data = {
						"id" : id, 
						"vdr" : vdr,
						"idx" : idx,
						"ukey" : ukey,
						"_token" : csrf_token
					};

				$.ajax({
					type:"post",
					url: "{{ urlAccomoApi('fatch/prop') }}/"+rtoken,
					data: data,
					dataType : 'JSON',
					success: function(response, textStatus, xhr) {
						response = $.extend({}, response, data);
						thisObj.populatePropInTab(response, rtoken);
						$('#loging_log').hide();
						return false;
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
		},

		populateAccomos : function (rtoken, accomos, isTop = false) {
			/*console.log(rtoken, accomos);*/
			var thisObj = this;
			var route = this.getRouteData(rtoken);
			$.each(accomos, function(i, object){
				if (object != null) {
					var code = _.get(object, 'code', '');

					var vendor = _.get(object, 'vendor', '');
					var ukey = _.get(object, 'ukey', code+'_'+vendor);
					var name = proper(_.get(object, 'name', ''));
					var address = _.get(object, 'address', '')
												.replace(/, , /g, ', '); 
					var sortAddress = address.substring(0, 50);
					var sortDescription = _.get(object, 'description', '')
																.substring(0, 120);
					var starRatingHtml = star_Rating(_.get(object, 'star_rating', 1));
					var index = _.findIndex(
													route.package_accommodations, 
													{'ukey': ukey}
												);

					var selectedAccomo = _.get(route.package_services, index);
					var isSelected = index >= 0 ? true : false;
					var fid = code;
					var fdid = _.get(selectedAccomo, 'id', ''); {{-- pacakge serviceid --}}
					var btnClass = isSelected ? 'btn-danger' : 'btn-primary';
					var btnName = isSelected ? 'Selected' : ((route.mode  == 'hotel' || route.mode  == 'hotel_only') ? 'Rooms' : 'Cabins');

					var search_class = (object.is_search != 'undefined' &&  object.is_search == 1) ? 'border-orange' : '';

					var accomo = {
							"id" : _.get(object, 'id', ''),
							"psid" : _.get(object, 'package_service_id', ''),
							"index" : _.get(object, 'index', ''),
							"rtoken" : rtoken,
							"ukey" : ukey,
							"name" : name,
							"code" : code,
							"fdid" : fdid,
							"btnName" : btnName,
							"address" : address,
							"btnClass" : btnClass,
							"propTabName" : btnName,
							"image" : object.image,
							"vendor" : vendor,
							"latitude" : object.latitude,
							"longitude" : object.longitude,
							"sortAddress" : sortAddress,
							"starRating" : object.star_rating,
							"description" : object.description,
							"starRatingHtml" : starRatingHtml,
							"sortDescription" : sortDescription,
							"search_class" : search_class,
							"route" : route
						};

					var containerElem = (isSelected ? "#fixed_" : "#result_") 
														+ rtoken;
					var sameElem = $(containerElem).find('.li_'+ukey);

					if (sameElem.length) {
						moveToTop(sameElem);
					}
					else{
						var appendHtml = '';
						var searchWord = '';
						appendHtml += '@include($viewPath.'.partials.html_partials.container')';
						if (isTop) {
							$(containerElem).prepend(appendHtml);
						}
						else{
							$(containerElem).append(appendHtml);
						}
					}
				}
			});
			this.is_searched = false;
			$('#target_'+rtoken).find('.btn-danger.btn-choose-prop.off')
														.click();
		},

		/*populateHtmlInView : function (rtoken) {
			var accomos = _.get(this.getRouteData(rtoken), 'hotel_result', []);
			this.populateAccomos(rtoken, accomos);
		},*/

		invokeMap : function (elem) {
			var src = $(elem).attr('data-src');
			$(elem).find('.tab-map').html('<div class="m-top-5"><iframe width="100%" height="360" src="'+src+'" ></iframe></div>');
		},

		{{-- populate in tab --}}
		populatePropInTab : function (obj, rtoken) {
			/*console.log('populatePropInTab', obj);*/
			thisObj = this;
			var parentLi = $('#target_'+rtoken)
											.find('.li_'+_.get(obj, 'ukey', ''));

			var route = this.getRouteData(rtoken);
			var props = [];

			if (route.mode == 'hotel' || route.mode == 'hotel_only') {
				this.invokeMap($(parentLi).find('tab-map-container'));
				props = obj.rooms;
			}
			else if(route.mode == 'cruise'){
				props = obj.cabins;
			}

			$.each(props,function(propKey, prop) {
				var isSelected = _.get(prop, 'package_accommodation_property_id', null) != null ? true : false;
				prop['proptype'] = '';
				prop['btnClass'] = isSelected ? 'btn-danger' : 'btn-primary';
				prop['btnName'] = isSelected ? 'Remove' : 'Add';
				prop['mode'] = route.mode;
				prop['proptype'] = _.get(prop, 'property_type');

				/*if (route.mode == 'hotel' || route.mode == 'hotel_only') {
					prop['proptype'] = _.get(prop, 'roomtype');
				}
				else if(route.mode == 'cruise'){
					prop['proptype'] = _.get(prop, 'cabintype');
				}*/

				$(parentLi).find('.tab-room')
										.append(thisObj.makePropHtml(prop));
				invokeIcheck(parentLi);
			});

			$.each(obj.images, function(imagekey, image) {
				$(parentLi).find('.gallery.cf').append(makeGallaryHtml(image));
			});
		},


		{{-- make prop html --}}
		makePropHtml : function (obj) {
			var propType = _.get(obj, 'proptype');
			var propImage = _.get(obj, 'image');
			/*var mode = _.get(obj, 'mode');*/

			/*button object*/
			var btnClass = _.get(obj, 'btnClass');
			var btnName = _.get(obj, 'btnName');
			var propId = _.get(obj, 'id');
			var papId = _.get(obj, 'package_accommodation_property_id', '');
			var propVdr = _.get(obj, 'vendor', '');

			var totalRooms = parseInt(this.guest_details.data.no_of_room);
			var noOfRooms = _.get(obj, 'no_of_rooms', totalRooms);
			var roomOptions = '';
			
			for (var i = 1; i <= totalRooms; i++) {
				var isSelected = noOfRooms == i ? 'selected' : '';
				roomOptions += '<option value="'+i+'" '+isSelected+'>'+i+'</option>';
			}

			return `@include($viewPath.'.partials.html_partials.props')`;
		},
		{{-- /populate in tab --}}

		addPropertyManually : function (elem) {
			var thisObj = this;
			var parentLi = $(elem).closest('.main-list-item');
			var hotelName = $(parentLi).find('.hotel-name').text();
			var content = '<div class="add-room-pop-up"><input type="text" class="form-control own-room-type" placeholder="Room Type"></div>';
			$.confirm({
				title : hotelName+" (<small>Add Room</small>)",
				columnClass: 'col-md-6 col-md-offset-3',
				content : content,
				buttons: {
					submit: {
						btnClass: 'btn-primary',
						action: function(){
							var inputBox = $('.add-room-pop-up')
															.find('.own-room-type');

							if ($(inputBox).val().length < 5) {
								$(inputBox).addClass('border-red').effect('shake');
								return false;
							}
							else{
								var parentLi = $(elem).closest('.main-list-item');
								var chooseBtn = $(parentLi).find('.btn-choose-prop');
								var data = {
									"_token" : csrf_token,
									"accomo_vendor" : $(chooseBtn).attr('data-vdr'),
									"accomo_id" : $(chooseBtn).attr('data-fid'),
									"proptype" : $(inputBox).val()
								};

								$.ajax({
									url : '{{ route('accomo.add_own_property') }}',
									type : 'post',
									data : data,
									dataType : 'JSON',
									success : function (response) {
										if (response.status == 200) {
											var obj = {
												'id' : response.id,
												'proptype' : data.proptype,
												'vendor' : data.accomo_vendor
											};

											thisObj.populatePropertyManually(elem, obj);
										}
										else{
											$.alert(response.response);
										}
									}
								});
							}
						}
					},
					cancel: function () {
					}
				}
			});
		},

		populatePropertyManually(elem, data){
			var route = this.getCurrentRoute();
			var mode = '';

			if (route.mode == 'hotel' || route.mode == 'hotel_only') {
				mode = 'hotel';
			}
			else if(route.mode == 'cruise'){
				mode = 'cruise';
			}

			var obj = {
				'rmdid' : '',
				'btnClass' : 'btn-primary',
				'btnName' : 'Add',
				'id' : data.id,
				'proptype' : data.proptype,
				'image' : '',
				'vdr' : data.vendor,
				'mode' : mode
			};

			$(elem).closest('.tab-pane').find('.tab-room')
								.append(this.makePropHtml(obj));
		},

		bookProp : function (elem) {
			var parent = $(elem).closest('.hotel-detail');
			var parentLi = $(elem).closest('.main-list-item');
			var parentUl = $(elem).closest('.list.list-unstyled');
			var rtoken = parentUl.attr('id').split('_')[1];

			$(parentUl).find('.btn-choose-prop')
									.addClass('off').removeClass('on');
			
			if ($(elem).hasClass("btn-primary")) {

				$(elem).addClass('btn-danger')
								.text('Remove').removeClass('btn-primary');

				this.addProp(elem, rtoken);

			}
			else if ($(elem).hasClass("btn-danger")) {
				$(elem).addClass('btn-primary')
										.text('Add')
											.removeClass('btn-danger');
				this.removeProp(elem);
			}

			var selected = $(parent).find('.btn-danger');
			if (selected.length > 0) {
				$(parentLi).find('.btn-choose-prop')
											.addClass('on btn-danger')
												.text('Selected')
													.removeClass('off btn-primary');
				
				if (!$(parentLi).hasClass('fixed')) {
					fixedBox = $(parentLi).closest('.tab-pane.tab-target')
											.find('.list.list-unstyled.fixed');
					$(parentLi).appendTo(fixedBox);
					$(window).scrollTop(0);
				}

				/*$(parentUl).find('.btn-choose-prop.off')
											.addClass('btn-dark')
												.prop('disabled', true)
													.removeClass('btn-primary');*/
			}
			else{
				resultBox = $(parentLi).closest('.tab-pane.tab-target')
											.find('.list.list-unstyled.result');

				$(parentLi).find('.btn-choose-prop')
											.addClass('btn-primary')
												.text('Rooms')
													.removeClass('btn-dark')
														.removeClass('btn-danger')
															.prop('disabled', false);

				$(parentLi).prependTo(resultBox);
				/*removeHotel(elem);*/
			}
		},


		addProp : function (elem, rtoken) {
			var parentLi = $(elem).closest('.main-list-item');
			var accomoElem = $(parentLi).find('.btn-choose-prop');
			var rooms = $(parentLi).find('.no-of-rooms').val();
			var data = {
					'_token' : csrf_token,
					'accommodation' : {
						'id' 		 : $(accomoElem).attr('data-id'),
						'psid' 	 : $(accomoElem).attr('data-psid'),
						'vendor' : $(accomoElem).attr('data-vdr'),
						'index'	 : $(accomoElem).attr('data-idx'),
						'property' : {
							'id'		 : $(elem).attr('data-id'),
							'papid'  : $(elem).attr('data-papid'),
							'vendor' : $(elem).attr('data-vdr'),
							'no_of_rooms' : rooms
						}
					}
				};

			$.ajax({
				type:"post",
				url: "{{ urlAccomoBuilder('prop/add') }}/"+windata.current_rtoken,
				data: data,
				dataType : 'json',
				success: function(response, textStatus, xhr) {
					$(accomoElem).attr('data-psid', response.psid);
					$(elem).attr('data-papid', response.papid);
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
		},

		removeProp : function (elem) {
			var parentLi = $(elem).closest('.main-list-item');
			var accomoElem = $(parentLi).find('.btn-choose-prop');
			var data = {
					'_token' : csrf_token,
					'papid'		 : $(elem).attr('data-papid'),
					};

			$.ajax({
				type:"post",
				url: "{{ urlAccomoBuilder('prop/remove') }}/"+windata.current_rtoken,
				data: data,
				dataType : 'JSON',
				success: function(response, textStatus, xhr) {
					if(response.status == 200){
						if (response.is_copied == 1) {
							$(accomoElem).attr('data-psid', response.psid);
							$.each(response.ids, function(i,v) {
								$(parentLi).find(".btn-book-prop[data-id='"+i+"']")
														.attr('data-id', v);
							});
						}

						$(elem).attr('data-id','');
					}
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
		},
		populateSelectedProperties : function(parentLi){
			var thisObj = this;
			$.each(this.routes_order, function(rtokenKey, rtoken){
				var route = thisObj.getRouteData(rtoken);
				var accomos = _.get(route, 'package_accommodations', []);

				thisObj.populateAccomos(rtoken, accomos);

				$.each(accomos, function(accomoKey, accomo){
					var accomoId = _.get(accomo, 'id', '');
					var accomoVdr = _.get(accomo, 'vendor', '');
					var ukey = _.get(accomo, 'ukey');
					var parentLi = $('#target_'+rtoken).find('.li_'+ukey);

					$(parentLi).find('.btn-choose-prop')
											.addClass('btn-danger')
												.removeClass('btn-primary');

					var properties = {
						'id' : accomoId,
						'vdr' : accomoVdr,
						'ukey' : ukey
					};

					var propKey = (route.mode == 'cruise') ? 'cabins' : 'rooms';

					properties[propKey] = _.get(accomo, 'properties', []);
					thisObj.populatePropInTab(properties, rtoken);
				});
			});
		}

	};

	{{-- bootstrap-daterangepicker --}}
	$(document).ready(function() {
		setTimeout(function () {
			windata.setGuestDetails();
		}, 500);
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "D/M/YYYY",

		}, function(start, end, label) {
			/*console.log(start.toISOString(), end.toISOString(), label);*/
		});


		windata.populateSelectedProperties();

		/*$('#loging_log').hide();*/
		@foreach ($accomoRoutes as $key => $accomoRoute)
			@if ($key)
				setTimeout(function () {
			@endif
			windata.fatchAccomoResult("{{ $accomoRoute->token }}");
			@if ($key)
				}, 3000);
			@endif
		@endforeach
	});
	{{-- /bootstrap-daterangepicker --}}

	{{-- search hotel --}}
	$(document).on('click', '#btn_filter_search', function() {
		/*postSearchProp();*/
		windata.is_searched = true;
		windata.search_name = $('#filter_search').val();
		windata.fatchAccomoResult(windata.current_rtoken);
	});
	{{-- /search hotel --}}

	{{-- check box chenge --}}
	$(document).on('ifChanged', 'input', function() {
		checkChange(this);
	});
	{{-- /check box chenge --}}

	{{-- Choose Room --}}
	$(document).on('click','.btn-choose-prop', function(){
		var rtoken = $(this).closest('.tab-target')
									.attr('id').replace('target_', '');

		windata.fatchAccomoPropResult(this, rtoken);
	});
	{{-- /Choose Room --}}

	{{-- Book hotel --}}
	$(document).on('click', '.btn-book-prop', function(){
		var targetTab = $(this).closest('.tab-pane.tab-target');
		if ($(this).hasClass('btn-danger') || windata.isProptryCountLess(targetTab)) {
			windata.bookProp(this);
		}
		else{
			$.alert({
				title : 'Rooms Complete', 
				content : 'you have selected all rooms.'
			});
		}
	});
	{{-- /Book hotel --}}

	{{-- Model PopUp --}}
	$(document).on('click', ".btn-link.description", function(){
		showDescription(this);
	});
	{{-- /model PopUp --}}

	{{-- click on tab menu button --}}
	$(document).on('click', '.a-tab-menu',function () {
		var rtoken = $(this).attr('href').replace('#target_', '');
		windata.setRouteInfo(rtoken);

	});
	{{-- click on tab menu button --}}

	{{-- next button --}}
	$(document).on('click', '#btn_next', function () {
		if (windata.validateInputs($('#target_'+windata.current_rtoken))) {
			windata.nextAccomoEvent(windata.current_rtoken);		
		}
	});
	{{-- /next button --}}

	$(document).on('change', '.transfer', function () {
		if ($(this).hasClass('h-pick-up')) {
			params = {
						'is_pick_up' : 1,
						'pick_up' : $(this).val(),
					};
			addAttributes(params);
		}
		else if ($(this).hasClass('h-drop-off')) {
			params = {
						'is_drop_off' : 1,
						'drop_off' : $(this).val(),
					};
			addAttributes(params);
		}
	});

	$(document).on('change', '.transfer-mode', function () {
		if ($(this).hasClass('h-pick-up')) {
			params = { 'pick_up_mode' : $(this).val() };
			addAttributes(params);
		}
		else if ($(this).hasClass('h-drop-off')) {
			params = { 'drop_off_mode' : $(this).val() };
			addAttributes(params);
		}
	});


	$(document).on('click', '.add-room-manually', function(){
		windata.addPropertyManually(this);

		/*addRoomManually(this);*/
	});
</script>

@include('b2b.protected.dashboard.pages.common.guests.popup')
@include($viewPath.'.partials.scripts.autocomplete')
@include($viewPath.'.partials.scripts.function')

