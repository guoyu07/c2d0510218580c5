<script>

	function getRidObj(rid) {
		return idObject['rid_'+rid];
	}


	function getModeOption(key = '') {
		var modeOption = '';
		
		$.each(modeObj, function(mI,mV){
			var isSelectedWord = '';
			if (mI == key) {
				isSelectedWord = 'selected';
			}
			modeOption += '<option value="'+mI+'" '+isSelectedWord+'>'+mV+'</option>';
		});
		return modeOption;
	}


	function getTimingOption(key = '') {
		var timingOption = '';
		$.each(timingObj, function(mI,mV){
			var isSelectedWord = '';
			if (mI == key) {
				isSelectedWord = 'selected';
			}
			timingOption += '<option value="'+mI+'" '+isSelectedWord+'>'+mV+'</option>';
		});
		return timingOption;
	}


	function showDescription(thisObj) {
		var popupTitle = proper($(thisObj).attr('data-title'));
		var popupTarget = $(thisObj).attr('data-target');
		var popupBody = $(popupTarget).html();
		$.alert({
			backgroundDismiss: true,
			keyboardEnabled: true,
			title: popupTitle,
			content: popupBody,
			columnClass: 'col-md-6 col-md-offset-3'
		});
	}


	function postActivities(rid, type = 'fatch', term = '') {
		if (rid != '') {
			var getRidObject = getRidObj(rid);
			var elem_id = "rid_"+rid;
			var data = {
					"_token" : csrf_token,
					"term" : term
				};

			$.ajax({
				type:"post",
				url: "{{ url('api/package/activities') }}/"+type+'/'+rid,
				data: data,
				success: function(response, textStatus, xhr) {
					var response = JSON.parse(response);
					if (response.activities) {
						$('#loging_log').hide();
						$.each(response.activities, function(i,v){
							v['rid'] = rid;
							$('#'+elem_id).append(makeActivityObject(i, v));
						});
						initDatePicker(rid);
    				$('#'+elem_id+" :input").inputmask();
					}
					else{
						$('#'+elem_id).append('<p>Activities Not Found</p>');
					}
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					else if(xhr.status == 500){
						$('#loging_log').hide();
						$('#'+elem_id).html('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button class="btn btn-primary btn-block" onclick="'+uniActivities(rid)+';">Refreash</button></div></div></div>');
					}
				}
			});

		}
	}

	function searchActivities() {
		var term = $('#filter_search').val();
		postActivities(idObject.crid, 'search', term);
		/*hideSpinIcon();*/
	}


	function makeActivityObject(i, obj) {
		var isExits = $('#rid_'+obj.rid).find('.li_'+obj.ukey);
		if (isExits.length > 0) {
			moveToTop(isExits);
		}
		else{
			var description = obj.description;
			var border = '';
			var date = '';
			var btnName = 'Add';
			var btnClass = 'btn-primary';
			var dateStyle = 'style="display: none;"';
			var modeOption = getModeOption(obj.mode);
			var timingOption = getTimingOption(obj.timing);
			var sortDescription = shortString(obj.sort_description);
			var pdid = isset(obj, 'pdid') ? obj.pdid : '';
			var pickUp = obj.pick_up != null 
								 ? obj.pick_up.substring(0, 5)
								 : '00:00';
			var duration = obj.duration != null 
									 ? obj.duration.substring(0, 5) 
									 : '00:00';
			var pickUpWord = convertTime24to12(obj.pick_up);
			var durationWord = convertTimeHrMin(obj.duration);

			if (obj.isSelected == 1) {
				border = 'border-green-3px';
				btnClass = 'btn-danger';
				btnName = 'Remove';
				dateStyle = '';
				date = moment(obj.date).format('DD/MM/YYYY');
				sortDescription = shortString(sortDescription, 0, 150);
			}

			var activity = {
				'rid' : obj.rid,
				'pdid' : pdid,
				'date' : date,
				'ukey' : obj.ukey,
				'code' : obj.code,
				'name' : obj.name,
				'border' : border,
				'image' : obj.image,
				'btnName' : btnName,
				'btnClass' : btnClass,
				'vendor' : obj.vendor,
				'dateStyle' : dateStyle,
				'modeOption' : modeOption,
				'timingOption' : timingOption,
				'isSelected' : obj.isSelected,
				'description' : description,
				'sortDescription' : sortDescription,
				'pickUp' : obj.pick_up,
				'duration' : obj.duration,
				'pickUpWord' : pickUpWord,
				'durationWord' : durationWord,
			};

			return getActivityStack(activity);
		}
	}


	function moveToTop(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		$(parent).prepend(thisObj);

		$(thisObj).find('.x_panel.glowing-border').addClass('border-green-2px');
	}


	{{-- get activity stack --}}
	function getActivityStack(activity) {
		return '@include($viewPath.'.partials.scripts.html')';
	}
	{{-- get activity stack --}}


	{{-- select activity --}}
	function selectActivity(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		if ($(thisObj).hasClass('btn-primary')) {
			if (checkInputs(thisObj)) {
				addActivity(parent); {{-- should give parent object --}}
				showSortDescription(parent);

				$(thisObj).addClass('btn-danger unsaved')
										.text('Remove')
											.removeClass('btn-primary');
				$(parent).find('.x_panel.glowing-border')
									.addClass('border-green-3px')
										.find('.input-container')
											.show();
			}
		}
		else{
			$(thisObj).addClass('btn-primary')
									.text('Add')
										.removeClass('btn-danger');
			$(parent).find('.x_panel.glowing-border')
								.removeClass('border-green-3px')
									.find('.input-container')
										.hide();

			showFullDescription(parent);
			removeActivity(thisObj); {{-- should give btn object --}}
		}
	}
	{{-- /select activity --}}


	{{-- this is to show sort description --}}
	function showSortDescription(thisObj) {
		var desc = $(thisObj).find('.full-description').text().trim();
		if (desc.length > 0) {
			$(thisObj).find('.sort-description').text(desc.substring(0,90)+'...');
		}
	}
	{{-- this is to show sort description --}}


	{{-- this is to show full description --}}
	function showFullDescription(thisObj) {
		var desc = $(thisObj).find('.full-description').text().trim();
		if (desc.length > 0) {
			$(thisObj).find('.sort-description').text(desc.substring(0,350)+'...');
		}
	}
	{{-- this is to show full description --}}

	{{-- add activity --}}
	function addActivity(thisObj) {
		var ulParent = $(thisObj).closest('.list.list-unstyled');
		var rid =  $(ulParent).attr('data-rid');
		$(ulParent).find('.btn-danger.unsaved').each(function () {

			var data = getActInputs(this);
			console.log(data);
			var btnObj = this;

			if (data == false) {
				return false;
			}
			else{
				windata.is_fine = false;
				data['_token'] = csrf_token;
				$.ajax({
					type:"post",
					url: "{{ urlActivitiesBuilder('add') }}/"+rid,
					data: data,
					dataType : "JSON",
					success : function (response) {
						if (response.status == 200) {
							windata.is_fine = true;
							windata.next_event = true;
							$(btnObj).attr('data-pdid', response.pdid)
													.removeClass('unsaved');
						}
						else{
							windata.next_event = false;
						}
					}
				});
			}
		});
	}
	{{-- /add activity --}}


	function removeActivity(thisObj) {
		var ulParent = $(thisObj).closest('.list.list-unstyled');
		var rid =  $(ulParent).attr('data-rid');
		var pdid = $(thisObj).attr('data-pdid');
		var data = {
				'_token' : csrf_token,
				'pdid' : pdid
			};
		$.ajax({
			type:"post",
			url: "{{ urlActivitiesBuilder('remove') }}/"+rid,
			data: data,
			dataType : "JSON",
			success : function (response) {
				$(thisObj).attr('data-pdid', '')
										.removeClass('unsaved');
			}
		});
	}

	function removeOwnActivity(thisObj) {
		/*$.confirm({
			title: 'Are you sure?',
			content: 'want to remove <b>Activity</b>',
			buttons: {
				confirm: function () {*/
					$(thisObj).text('Add')
											.addClass('btn-primary')
												.removeClass('btn-danger');
					removeActivity(thisObj);
				/*},
				cancel: function () {
				}
			}
		});*/

	}

	
	function checkInputs(thisObj) {
		var result = true; {{-- if true then every thing is fine --}}
		var ulParent = $(thisObj).closest('.list.list-unstyled');
		$(ulParent).find('.btn-danger.unsaved').each(function () {
			if (getActInputs(this) == false) {
				result = false;
				return false;
			}
		});

		return result;
	}




	function getDate(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		var element = $(parent).find('.datepicker');
		var value = $(element).val();
		if (value == '') {
			$(parent).get(0).scrollIntoView();
			$(element).addClass('border-red');
			return false;
		}
		else{
			$(element).removeClass('border-red');
			return value;
		}
	}


	function getTiming(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		var element = $(parent).find('.act-timing');
		var value = $(element).val();
		if (value == '') {
			$(parent).get(0).scrollIntoView();
			$(element).addClass('border-red');
			return false;
		}
		else{
			$(element).removeClass('border-red');
			return value;
		}
	}

	function getPickUp(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		var elementBox = $(parent).find('.pick-up-duration-box');
		return $(elementBox).find('.pick-up.toggle-group')
													.attr('data-final-value');
	}

	function getDuration(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		var elementBox = $(parent).find('.pick-up-duration-box');
		return $(elementBox).find('.duration.toggle-group')
													.attr('data-final-value');
	}


	function getMode(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		var element = $(parent).find('.mode');
		var value = $(element).val();
		if (value == '') {
			$(parent).get(0).scrollIntoView();
			$(element).addClass('border-red');
			return false;
		}
		else{
			$(element).removeClass('border-red');
			return value;
		}
	}


	function checkPickUpDurationBox(thisObj) {
		var parent = $(thisObj).closest('.activity-container')
														.find('.pick-up-duration-box');
		if ($(parent).hasClass('changed')) {
			$(parent).find('.btn-link-save').addClass('border-red');
			$.alert({title:"Error!", content : "Don't you want to save it?"});	
			$(parent).get(0).scrollIntoView();
			return false;
		}
		else{
			$(parent).find('.btn-link-save').removeClass('border-red');
		}
		return true;
	}


	function getActInputs(thisObj) {
		var date = getDate(thisObj);
		var mode = getMode(thisObj);
		var timing = getTiming(thisObj);
		var pickUp = getPickUp(thisObj);
		var duration = getDuration(thisObj);
		var checkpd  = checkPickUpDurationBox(thisObj);
		if (date && mode && timing && checkpd) {
			var code = $(thisObj).attr('data-code');
			var pdid = $(thisObj).attr('data-pdid');
			var vendor = $(thisObj).attr('data-vendor');
			var data =  {
					'pdid' : pdid,
					'date' : date,
					'code' : code,
					'mode' : mode,
					'vendor' : vendor,
					'timing' : timing,
					'pick_up' : pickUp,
					'duration' : duration
				};

			var parentLi = $(thisObj).closest('.activity-container');
			if ($(parentLi).hasClass('added-own')) {
				data['isAdded'] = 1;
				data['name'] = $(parentLi).find('.name').val();
				data['description'] = $(parentLi).find('.description').val();
				data['image'] = $(parentLi).find('.uploadform.dropzone')
																				.attr('data-path');
			}

			return data;
		}
		else{
			return false;
		}
	}


	function clickNextTab() {
		var ridObj = getRidObj(idObject.crid);
		$('#a_rid_'+ridObj.nrid).click();
		$('#filter_search').val('');
	}


	function setCrid(rid) {
		idObject.crid = rid;
	}


	function nextHotelEvent() {
		if (windata.is_fine) {
			var ridObj = getRidObj(idObject.crid);
			if (ridObj.nrid == "NaN" && windata.next_event == true) {
				setTimeout(function () {    
					document.location.href = "{{ $package->eventActionUrl('activities') }}";
				}, 1000);
			}
			else{
				clickNextTab();
			}
		}else{
			$.alert({title:"Error!", content : "Something went wrong."});	
		}
	}


	function populateHtml(obj, rid) {
		obj['rid'] = rid;
		elem_id = '#rid_'+rid;
		$(elem_id).prepend(makeActivityObject(0, obj));
		initDatePicker(rid);
		$(elem_id+" :input").inputmask();
	}

	function addOwnActivity(thisObj) {
		var rid = idObject.crid;
		var firstLi = $('#rid_'+rid).find('.activity-container');
		addActivity(firstLi[0]);
		var count = $(thisObj).attr('data-count');
		var code = 'ao_'+rid+'_'+count; {{-- added_own --}}
		count = parseInt(count)+1;
		$(thisObj).attr('data-count', count);
		var elemid = 'rid_'+rid;
		var html = '@include($viewPath.".partials._add")';
		$('#'+elemid).append(html);
		addDropzone('#uploadform_'+code);
		initDatePicker(rid);
	}


	{{-- addDropzone --}}
	/*function addDropzone(elemid) {
		Dropzone.autoDiscover = false; 	{{--keep this line if you have multiple dropzones in the same page --}}
		$(elemid).dropzone({	
			acceptedFiles: "image/*",
			url: '{{ url('image/upload') }}',
			maxFiles: 1, 	{{--Number of files at a time--}}
			maxFilesize: 2, 
			maxfilesexceeded: function(file) {
				alert('You have uploaded more than 1 Image. Only the first file will be uploaded!');
			},
			success: function (response) {
				{{--console.log(response.xhr.responseText);--}}
				var x = JSON.parse(response.xhr.responseText);
				$(this.element).attr('data-host', x.host)
													.attr('data-path', x.path)
														.removeClass('bg-color-gray');
				{{--console.log($(this.element));--}}
			},		
			addRemoveLinks: true,
			removedfile: function(file) {
				var _ref;
				$(this.element).addClass('bg-color-gray');
				return (_ref = file.previewElement) != null 
							? _ref.parentNode.removeChild(file.previewElement) 
							: void 0;  
			}	
		});
	}*/
	{{-- /addDropzone --}}


	{{-- initDatePicker --}}
	function initDatePicker(rid) {
		var cb = function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		};

		@foreach ($package->activityRoutes as $activityRouteKey => $activityRoute)
			
			<?php 
				$startDate = $activityRoute->start_datetime->format('Y-m-d');
				$endDate = $activityRoute->end_datetime->format('Y-m-d');
			?>

			if (rid == {{$activityRoute->id}}) {
				var optionSet{{ $activityRoute->id }} = {
					singleDatePicker: true,
					calender_style: "picker_1",
					format : "DD/MM/YYYY",
					minDate : moment('{{ $startDate }}'),
					maxDate : moment('{{ $endDate }}'),
					startDate: new Date('{{ $startDate }}'),
					endDate: new Date('{{ $endDate }}')
				};

				$('.datepicker-{{ $activityRoute->id }}').daterangepicker(optionSet{{ $activityRoute->id}}, cb);
			}
		@endforeach
	};
	{{-- /initDatePicker --}}

	function toggleGroup(thisObj) {
		var isSave = $(thisObj).hasClass('btn-link-save');
		var parent = $(thisObj).closest('.pick-up-duration-box');
		$(parent).toggleClass('changed').find('.toggle-group').toggle();

		if (isSave) {
			var pickUp = $(parent).find('input.pick-up').val();
			var duration = $(parent).find('input.duration').val();
			$(thisObj).closest('.activity-container')
									.find('.btn-activitySelect')
										.addClass('unsaved');
			
			/*console.log(thisObj, isSave, pickUp, duration);*/
			$(parent).find('input.pick-up').attr('data-final-value', pickUp);
			$(parent).find('input.duration').attr('data-final-value', duration);
			$(parent).find('.pick-up-word').text(convertTime24to12(pickUp));
			$(parent).find('.duration-word').text(convertTimeHrMin(duration));
		}
	}
</script>