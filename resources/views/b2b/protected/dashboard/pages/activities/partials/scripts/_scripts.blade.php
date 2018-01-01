@include($viewPath.'.partials.scripts.objects')
<script>
	var windata = { 
			is_fine : true, 
			next_event : true,
			current_rtoken : "{{ isset($activityRoutes->first()->token) ? $activityRoutes->first()->token : "" }}",
			last_rtoken : "{{ isset($activityRoutes->last()->token) ? $activityRoutes->last()->token : "" }}",
			routes : {!! $activityRoutes->pluck('route_formatted', 'token')->toJson() !!},
			routes_order : {!! $activityRoutes->pluck('token')->toJson() !!},
			search_name : '',
			is_searched : false,
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
			
			setActivitiesResult: function (rtoken, result) {
				var route = this.getRouteData(rtoken);
				var oldResult = _.get(route, 'activities_result', []);
				result = _.unionWith(oldResult, result, _.isEqual);
				route['activities_result'] = result;
			},

			setSelectedActivity: function (rtoken, data) {
				var route = this.getRouteData(rtoken);
				var oldData = _.get(route, 'selected_activities', []);
				result = _.unionWith(oldData, data, _.isEqual);
				route['selected_activities'] = result;
			},

			overrideActivity : function (rtoken, activity) {
				var route = this.getRouteData(rtoken);
				var ukey = _.get(activity, 'ukey', null);
				var index = _.findIndex(
										route.activities_result, 
										{'ukey': ukey}
									);

				var selected = _.get(route.activities_result, index);
				if (index >= 0 && _.get(selected, 'ukey', null) != null) {
					route.activities_result[index] = activity;
				}
			},

			initDatePicker : function (rtoken) {
				var cb = function(start, end, label) {
					console.log(start.toISOString(), end.toISOString(), label);
				};
				var route = this.getRouteData(rtoken);

				var optionSet = {
					singleDatePicker: true,
					calender_style: "picker_1",
					format : "DD/MM/YYYY",
					minDate : moment(_.get(route, 'start_date')),
					maxDate : moment(_.get(route, 'end_date')),
					startDate: new Date(_.get(route, 'start_date')),
					endDate: new Date(_.get(route, 'end_date'))
				};

				$('#target_'+rtoken).find('.datepicker')
															.daterangepicker(optionSet);
			},

			fatchActivities : function (rtoken) {
				var thisObj = this;

				$.ajax({
					url: "{{ url('api/package/activities/fatch') }}/"+rtoken+"?format=json",
					type:"post",
					dataType: 'JSON',
					data: {'_token' : csrf_token, 'term' : thisObj.search_name},
					success: function(response, textStatus, xhr) {
						$('#loging_log').hide();
						activities = _.get(response, 'activities', []);
						thisObj.setActivitiesResult(rtoken, activities);
						thisObj.populateActivities(rtoken, activities);
					},
					error: function(xhr, textStatus) {
						handleError(xhr);
					}
				});
			},

			moveToTop : function (elem) {
				var parent = $(elem).closest('.list.list-unstyled');
				$(parent).prepend(elem);
				$(elem).find('.x_panel.glowing-border')
									.addClass('border-green-2px');
			},

			populateSelectedActivities : function (){
				thisObj = this;
				$.each(_.get(this, 'routes', []), function(routeKey, route){
					$.each(_.get(route, 'package_activities', []), function () {
						thisObj.populateActivity(_.get(route, 'token'), this);
					});
				});
			},

			populateActivities : function (rtoken, data) {
				var thisObj = this;

				$.each(data, function(i, object){
					var ukey = _.get(object, 'ukey', '');
					var targetElem = $('#target_'+rtoken);
					var isExits = $(targetElem).find('.li_'+ukey);

					if (isExits.length > 0) {
						thisObj.moveToTop(isExits);
					}
					else{
						thisObj.populateActivity(rtoken, object);	
					}
				});

				this.is_searched = false;
				this.initDatePicker(rtoken);
			},

			populateActivity : function (rtoken, object, oldUkey = null) {
				var route = this.getRouteData(rtoken);
				var targetElem = $('#target_'+rtoken);
				var ukey = _.get(object, 'ukey', '');
				var index = _.findIndex(
											route.package_activities, 
											{'ukey': ukey}
										);

				var isSelected = false;

				if (index >= 0 && _.get(_.get(route.package_activities, index), 'ukey', null) != null) {
					object = route.package_activities[index];
					isSelected = true;
				}
				var description = _.get(object, 'description');
				var border = isSelected ? 'border-green-3px' : '';
				var btnName = isSelected ? 'Remove' : 'Add';
				var btnClass = isSelected ? 'btn-danger' : 'btn-primary';
				var dateStyle = isSelected ? '' : 'style="display: none;"';
				var date = isSelected ? moment(_.get(object, 'date'))
									.format('DD/MM/YYYY') : '';

				var sortDescription = shortString(_.get(object, 'sort_description', ' '), 0, 50);
				var modeOption = getModeOption(_.get(object, 'mode'));
				var timingOption = getTimingOption(_.get(object, 'timing'));

				var pickUp = _.get(object, 'pick_up')
									 ? _.get(object, 'pick_up').substring(0, 5)
									 : '00:00';

				var duration = _.get(object, 'duration')
									 ? _.get(object, 'duration').substring(0, 5)
									 : '00:00';

				var pickUpWord = convertTime24to12(pickUp);
				var durationWord = convertTimeHrMin(duration);
				var isFullday = _.get(object, 'is_fullday', false)
												? 'checked' : '';
				var isMorning = _.get(object, 'is_morning', false)
												? 'checked' : '';
				var isNoon = _.get(object, 'is_noon', false)
												? 'checked' : '';
				var isEvening = _.get(object, 'is_evening', false)
												? 'checked' : '';
				var image = (_.get(object, 'image', null) == null)
									? _.get(object, 'images.0')
									: _.get(object, 'image');

				var activity = {
					'psid' : _.get(object, 'package_service_id', ''),
					'date' : date,
					'ukey' : ukey,
					'code' : _.get(object, 'code'),
					'name' : _.get(object, 'name'),
					'border' : border,
					'image' : image,
					'btnName' : btnName,
					'btnClass' : btnClass,
					'vendor' : _.get(object, 'vendor'),
					'dateStyle' : dateStyle,
					'pickUp' : pickUp,
					'duration' : duration,
					'pickUpWord' : pickUpWord,
					'durationWord' : durationWord,
					'modeOption' : modeOption,
					'timingOption' : timingOption,
					'description' : description,
					'sortDescription' : sortDescription,
					'isFullday' : isFullday,
					'isMorning' : isMorning,
					'isNoon' : isNoon,
					'isEvening' : isEvening
				};

				var html = this.makeActivityHtml(activity);

				if (oldUkey != null) {
					var elemBox = null;
					var containerElem = $('#result_'+rtoken);

					if ($('#fixed_'+rtoken).find('.li_'+oldUkey).length) {
						elemBox = $('#fixed_'+rtoken).find('.li_'+oldUkey);
						containerElem = $('#fixed_'+rtoken);
					}
					else if($('#result_'+rtoken).find('.li_'+oldUkey).length){
						elemBox = $('#result_'+rtoken).find('.li_'+oldUkey);
					}

					if ($(elemBox).length) {
						var isFullday = $(elemBox).find('.timing[value="fullday"]');
						var isMorning = $(elemBox).find('.timing[value="morning"]');
						var isNoon = $(elemBox).find('.timing[value="noon"]');
						var isEvening = $(elemBox).find('.timing[value="evening"]');
						var data = $(elemBox).find('.datepicker').val();
						var mode = $(elemBox).find('select.mode').val();
						
						$(html).insertAfter(elemBox);

						var insertedElem = $(containerElem).find('.li_'+ukey);

						$(insertedElem).find('.timing[value="fullday"]')
														.prop('checked', $(isFullday).prop('checked'));

						$(insertedElem).find('.timing[value="morning"]')
														.prop('checked', $(isMorning).prop('checked'));

						$(insertedElem).find('.timing[value="noon"]')
														.prop('checked', $(isNoon).prop('checked'));

						$(insertedElem).find('.timing[value="evening"]')
														.prop('checked', $(isEvening).prop('checked'));
						
						$(insertedElem).find('.timing[value="fullday"]')
														.prop('disabled', $(isFullday).prop('disabled'));

						$(insertedElem).find('.timing[value="morning"]')
														.prop('disabled', $(isMorning).prop('disabled'));

						$(insertedElem).find('.timing[value="noon"]')
														.prop('disabled', $(isNoon).prop('disabled'));

						$(insertedElem).find('.timing[value="evening"]')
														.prop('disabled', $(isEvening).prop('disabled'));

						$(insertedElem).find('.datepicker').val(data);
						$(insertedElem).find('select.mode').val(mode);

						if ($(elemBox).find('.btn-activity-select').hasClass('btn-danger')) {
							$(insertedElem).find('.btn-activity-select').trigger('click');
							$(elemBox).find('.btn-activity-select').trigger('click');
						}

						setTimeout(function(){
							$(elemBox).remove();
						}, 1000);
					}
					else{
						this.moveStack(rtoken, html, isSelected, !this.is_searched, isReplace);
					}
				}
				else{
					this.moveStack(rtoken, html, isSelected, !this.is_searched);
				}
			
			},
			
			nextActivityEvent : function (current_rtoken) {
				$('#loging_log').show();

				if (current_rtoken == this.last_rtoken) {
					setTimeout(function () {    
						document.location.href = "{{ $package->eventActionUrl('activities') }}";
					}, 5000);
				}
				else{
					var rtoken = this.getNextRouteToken(current_rtoken);
					$('[href="#target_'+rtoken+'"]').click();
					$('#filter_search').val('');
					$('#loging_log').hide();
				}
			},

			makeActivityHtml : function (activity) {
				return @include($viewPath.'.partials.scripts.html');
			},

			manageActivityManually : function (elem = null) {

				var thisObj = this;
				var route = this.getCurrentRoute();
				var isEdit = (elem == null) ? 0 : 1;
				var activity = {};
				var ukey = '';
				var images = [];

				if (elem != null) {
					var parentLi = $(elem).closest('.activity-container');
					ukey = $(parentLi).find('.btn-activity-select')
															.attr('data-ukey');

					var index = _.findIndex(
														route.activities_result, 
														{'ukey':ukey}
													);

					activity = _.get(route.activities_result, index, {});
					if (_.get(activity, 'image', null) != null) {
						images.push(_.get(activity, 'image', null));
					}

					images = _.unionWith(images, _.get(activity, 'images', []), _.isEqual);
				}

				console.log(activity);
				
				var name = _.get(activity, 'name', '');
				var description = _.get(activity, 'description', '');
				var inclusion = _.get(activity, 'inclusion', '');
				var exclusion = _.get(activity, 'exclusion', '');
				var pick_up = _.get(activity, 'pick_up', '');
				var duration = _.get(activity, 'duration', '');

				var content = `<div class="manage-activity-pop-up">@include($viewPath.'.partials.manage_activity')</div>`;
				$.confirm({
					title : "Activity",
					columnClass: 'col-md-8 col-md-offset-2',
					content : content,
					onContentReady : function () {
						$(":input").inputmask();
						addDropzone('#uploadform', '{{ url('image/upload') }}');
					},
					buttons: {
						submit: {
							btnClass: 'btn-primary',
							action: function(){
								var popUp = $('.manage-activity-pop-up');
								var pickUp = $(popUp).find('.pick_up')
														.val().replace(/_/g, '0');
								var duration = $(popUp).find('.duration')
															.val().replace(/_/g, '0');
								$(popUp).find('.dz-response-json').each(function () {
									var path = _.get(JSON.parse($(this).text()), 'path');
									images.push(path);
								});
								
								images = _.uniq(images);

								var data = {
									'title' : $(popUp).find('.title').val(),
									'description' : $(popUp).find('.description').val(),
									'inclusion' : $(popUp).find('.inclusion').val(),
									'exclusion' : $(popUp).find('.exclusion').val(),
									'pick_up' : pickUp,
									'duration' : duration,
									'images' : images,
									'is_temp' : isEdit,
									'ukey' : ukey
								};
								
								thisObj.createAndPopulate(route.token, data);
								thisObj.initDatePicker(rtoken);

								/*console.log(data);
								console.log(JSON.stringify(data));*/
							}
						},
						cancel: function () {
						}
					}
				});
			},

			refreshCheckbox : function (parentLi) {
				$(parentLi).find('[type="checked"]:checked').length;
			},

			createAndPopulate : function (rtoken, data) {
				$('#loging_log').show();
				thisObj = this;
				data['_token'] = csrf_token;
				$.ajax({
					url : '{{ url('my/activity/store') }}/'+rtoken,
					type : 'post',
					data : data,
					dataType : 'json',
					success : function (response) {
						$('#loging_log').hide();
						if (response.status = 200) {
							thisObj.is_searched = true;
							activity = _.get(response, 'activity', []);
							thisObj.setActivitiesResult(rtoken, [activity]);
							thisObj.populateActivity(rtoken, activity, _.get(data, 'ukey', null));
						}
					}
				});
			},

			selectActivity : function (elem) {
				thisObj = this;
				var parentLi = $(elem).closest('.activity-container');

				if (!$(parentLi).find('.timing:checked').length) {
					$(parentLi).find('.main-timing')
											.addClass('red')
												.effect('shake');
					return false;
				}

				$(parentLi).find('.main-timing').removeClass('red');
				var is_fullday = $(parentLi).find('.timing[value="fullday"]')
													.prop('checked') ? 1 : 0;
				var is_morning = $(parentLi).find('.timing[value="morning"]')
													.prop('checked') ? 1 : 0;
				var is_noon = $(parentLi).find('.timing[value="noon"]')
													.prop('checked') ? 1 : 0;
				var is_evening = $(parentLi).find('.timing[value="evening"]')
													.prop('checked') ? 1 : 0;

				var date = $(parentLi).find('.datepicker').val();
				if (date == '') {
					$(parentLi).find('.datepicker')
											.addClass('border-red').effect('shake');
					return false;
				}
				else{
					$(parentLi).find('.datepicker').removeClass('border-red');
				}

				var mode = $(parentLi).find('select.mode').val();
				if (mode == '') {
					$(parentLi).find('select.mode')
											.addClass('border-red').effect('shake');
					return false;
				}
				else{
					$(parentLi).find('select.mode')
											.removeClass('border-red');
				}

				var route = this.getCurrentRoute();
				$(elem).prop('disabled', true)
								.find('.fa.fa-spinner').toggleClass('hide');
				var ukey = $(elem).attr('data-vendor')+'_'+$(elem).attr('data-code');
				var psid = $(elem).attr('data-psid');
				var index = _.findIndex(
													route.activities_result, 
													{'ukey': ukey}
												);
				var activity = _.get(route.activities_result, index, {});
				var data = {
						'_token' : csrf_token,
						'package_service_id' : psid,
						'activity_vendor' : _.get(activity, 'vendor', null),
						'activity_id' : _.get(activity, 'code', null),
						'mode' : mode,
						'date' : date,
						'is_fullday' : is_fullday,
						'is_morning' : is_morning,
						'is_noon' : is_noon,
						'is_evening' : is_evening,
					};

				$.ajax({
					type:"post",
					url: "{{ urlActivitiesBuilder('add') }}/"+route.token,
					data: data,
					dataType : "JSON",
					success : function (response) {
						if (response.status == 200) {
							$(elem).attr('data-psid', response.psid)
											.toggleClass('btn-danger btn-primary')
												.prop('disabled', false);

							$(elem).find('.btn-name').text('Remove');
							$(elem).find('.fa.fa-spinner').toggleClass('hide');
							thisObj.moveStack(route.token, parentLi);
							/*data['package_service_id'] = response.id;
							windata.setSelectedActivity(rtoken, data);*/
						}
					}
				});
			},
			removeActivity : function (elem) {
				var thisObj = this;
				var route = this.getCurrentRoute();
				var parentLi = $(elem).closest('.activity-container');
				$(elem).prop('disabled', true)
								.find('.fa.fa-spinner').toggleClass('hide');
				var data = {
					'_token' : csrf_token,
					'psid' : $(elem).attr('data-psid')
				};

				$.ajax({
					type:"post",
					url: "{{ urlActivitiesBuilder('remove') }}/"+route.token,
					data: data,
					dataType : "JSON",
					success : function (response) {
						if (response.status == 200) {
							$(elem).toggleClass('btn-danger btn-primary')
											.prop('disabled', false);
							$(elem).find('.btn-name').text('Add');
							$(elem).find('.fa.fa-spinner').toggleClass('hide');

							$(parentLi).find('.x_panel.glowing-border')
													.prop('class', 'x_panel glowing-border');
							thisObj.moveStack(route.token, parentLi, false, false);
						}
					}
				});
			},
			moveStack: function (rtoken, parentLi, isFixed = true, isAppend = true) {
				var containerElem = (isFixed ? '#fixed_' : '#result_')+rtoken;

				if (isAppend) {
					$(containerElem).append(parentLi);
				}else{
					$(containerElem).prepend(parentLi);
				}

			}

		};

	{{-- bootstrap-daterangepicker --}}
	$(document).ready(function() {
		windata.populateSelectedActivities();
		@foreach ($package->activityRoutes as $activityRouteKey => $activityRoute)
			windata.fatchActivities('{{ $activityRoute->token }}');
		@endforeach
	});
	{{-- /bootstrap-daterangepicker --}}



	$(document).on('click', '#btn_filter_search', function() {
		searchActivities();
	});


	$(document).on('click', '.btn-edit-activitiy', function () {
		windata.manageActivityManually(this);
	});


	{{-- Activity Select Button --}}
	$(document).on('click', '.btn-activitySelect', function(){
		$('#loging_log').show();
		selectActivity(this);
		$('#loging_log').hide();
	});
	{{-- /Activity Select Button --}}


	$(document).on('click', '.btn-activity-select', function () {
		if ($(this).hasClass('btn-danger')) {
			windata.removeActivity(this);
		}
		else{
			windata.selectActivity(this);
		}
	});

	$(document).on('change', '.timing', function () {
		var parentLi = $(this).closest('.activity-container');
		var prop = $(this).prop('checked');
		var val = $(this).val();
		var selectorDisable = '';
		var selectorEnable = '';
		if (prop) {
			if (val == 'fullday') {
				selectorDisable = '.timing[value="morning"], .timing[value="noon"], .timing[value="evening"]';
			}
			else if (val == 'morning') {
				selectorDisable = '.timing[value="fullday"], .timing[value="evening"]';
			}
			else if (val == 'noon') {
				selectorDisable = '.timing[value="fullday"]';
			}
			else if (val == 'evening') {
				selectorDisable = '.timing[value="fullday"], .timing[value="morning"]';
			}
		}
		else{
			if (val == 'fullday') {
				selectorEnable = '.timing[value="morning"], .timing[value="noon"], .timing[value="evening"]';
			}
			else if (val == 'morning') {
				selectorEnable = '.timing[value="evening"]';
				if (!$(parentLi).find('.timing[value="noon"]').prop('checked')) {
					selectorEnable = selectorEnable+', .timing[value="fullday"]';
				}
			}
			else if (val == 'noon') {
				if (!$(parentLi).find('.timing:checked').length) {
					selectorEnable = '.timing[value="fullday"]';
				}
			}
			else if (val == 'evening') {
				selectorEnable = '.timing[value="morning"]';
				if (!$(parentLi).find('.timing[value="noon"]').prop('checked')) {
					selectorEnable = selectorEnable+', .timing[value="fullday"]';
				}
			}
		}

		$(parentLi).find(selectorDisable).attr('disabled', true);
		$(parentLi).find(selectorEnable).attr('disabled', false);
	});



	{{-- Save Activities --}}
	$(document).on('click', '#saveActivities', function(){
		$.each(idObject.rid, function (i, v) {
			var firstLi = $('#rid_'+v).find('.activity-container');
			addActivity(firstLi[0]);
		});
		setTimeout(function () {
			nextHotelEvent();
		}, 2000);
	});
	{{-- /Save Activities --}}


	$(document).on('click', '#btn_next', function(){
		windata.nextActivityEvent(windata.current_rtoken);		
	});

	$(document).on('click', '.a-tab-menu', function () {
		var rtoken = $(this).attr('href').replace('#target_', '');
		windata.setRouteInfo(rtoken);
	});

	$(document).on('click', '.a_tab_menu', function () {
		setCrid($(this).attr('data-rid'));
	});

	{{-- add-own-activity --}}
	$(document).on('click', '.add-own-activity', function() {
		/*addOwnActivity(this);*/
		windata.manageActivityManually(this);

	});
	{{-- /add-own-activity --}}


	{{-- remove-own --}}
	/*--Asking premission for delete--*/
	$(document).on('click', '.btn-remove-own', function() {
		removeOwnActivity(this);
	});
	{{-- /remove-own --}}

	{{-- description pop up--}}
	$(document).on('click', '.btn-description', function () {
		showDescription(this); 
	});
	{{-- /description pop up--}}

	$(document).on('click', '.btn-link.toggle-group', function () {
		toggleGroup(this);
	});
</script>
@include($viewPath.'.partials.scripts.autocomplete')
@include($viewPath.'.partials.scripts.function')

