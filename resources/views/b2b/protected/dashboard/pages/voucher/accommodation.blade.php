@extends('b2b.protected.dashboard.main')


@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Create Voucher for : </h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form class="form-horizontal form-label-left input_mask">
					<input type="text" class="voucher-type" value="accommodation" hidden="">
					{{-- <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess2" placeholder="First Name">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess3" placeholder="Last Name">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess3" placeholder="File No.">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div> --}}

					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="contact form-control" data-token="" placeholder="Phone">
						<span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
						<label class="m-top-10"> Name : <span class="name"></span></label>
					</div>

					<div class="col-md-5 col-sm-5 col-xs-12 form-group has-feedback">
						<label class="m-top-10"> Email : <span class="email"></span></label>
					</div>

					{{-- <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control has-feedback-right" id="inputSuccess4" placeholder="No of Adult">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control has-feedback-right" id="inputSuccess4" placeholder="No of Child">
						<span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
					</div>

					<div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control" id="inputSuccess5" placeholder="Emergency Phone">
						<span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
					</div>
					
					<div class="col-md-8 col-sm-8 col-xs-12 form-group has-feedback">
						<input type="text" class="form-control has-feedback-right" id="inputSuccess4" placeholder="Email">
						<span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
					</div> --}}
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Hotel Detail</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="form-horizontal form-label-left input_mask">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label for="">Hotel {{-- 1: --}}</label>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control location" placeholder="Destination">
								<span class="fa fa-map-marker form-control-feedback right" aria-hidden="true"></span>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" class="form-control col-md-12 col-sm-12 col-xs-12 check-in datepicker" placeholder="Check-in" aria-describedby="inputSuccess2Status3" data-saved="0" value="">
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12">
								{{-- <input type="text" class="form-control col-md-12 col-sm-12 col-xs-12" placeholder="Check-out"> --}}

								<input type="text" class="form-control col-md-12 col-sm-12 col-xs-12 check-out datepicker" placeholder="Check-out" aria-describedby="inputSuccess2Status3" data-saved="0" value="">
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button class="btn-popup-room-guest form-control text-right font-gray" type="button">
									<span class="pull-left font-gray">Guests : </span>
									<span class="guests-word font-gray">Adults, Kid</span>
									<span class="caret"></span>
								</button>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control m-top-5 accommo-name" placeholder="Hotel Name">
								<span class="fa fa-building-o form-control-feedback right" aria-hidden="true"></span>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<input type="text" class="form-control prop-type" placeholder="Room Type">
								<span class="fa fa-bookmark-o form-control-feedback right" aria-hidden="true"></span>
							</div>
							<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="meal lunch"> Lunch</label>
							<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="meal breakfast"> Breakfast</label>
							<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="meal dinner"> Dinner</label>
							<label class="col-md-3 col-sm-3 col-xs-12"><input type="checkbox" class="meal room_only"> Room Only</label>
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<label class="m-top-10">
									Early check-in and check-out  
								</label>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<textarea id="message" required="required" class="form-control cancellation_policy" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="margin: 0px -2px 0px 0px; height: 120px; width: 485px;" placeholder="Cancellation policy"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
								<textarea id="message" required="required" class="form-control remark" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10" style="margin: 0px -2px 0px 0px; height: 120px; width: 485px;" placeholder="Remark"></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<button class="btn btn-success btn-save col-md-2 col-sm-2 col-xs-2">Save</button>
						<a href="{{ url('dashboard/vouchers/') }}" class="btn btn-default col-md-2 col-sm-2 col-xs-2">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
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
			guests : [{room: 1, adults : 2}],
			temp_room_count : 1,
			makeGuestDetailHtml : function(params){
				return `<div class="row m-bottom-10 room-guest">
						<div class="col-md-3 col-sm-3 col-xs-12">
							<label class="m-top-5">Room `+_.get(params, 'room', this.guests.length)+`</label>
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

			showGuestDetailsPopUp : function(){
				var thisObj = this;
				var content = '';
				var room_no = 1;
				$.each(this.guests, function(index, value){
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
								thisObj.updateRoomGuests();
							}
						},
						cancel: function () {
						}
					}
				});
			},

			updateRoomGuests : function(){
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

				
				this.guests = guests;
				this.temp_room_count = guests.length;
				this.updateRoomGuestsWord();
			},

			updateRoomGuestsWord: function(){
				adults = _.sumBy(this.guests, 'adults');
				kid = _.sumBy(this.guests, 'kid');

				var word = adults+' Adult'+(adults > 1 ? 's' : '')+
										(kid > 0 ? ' '+kid+' kid'+(kid > 1 ? 's' : '') : '');

				$('.guests-word').text(word);
			}
		};

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
			windata.showGuestDetailsPopUp();
		});

		$(document).on('click', '.btn-popup-add-room', function(){
			windata.addRoomGuestPopUp();
		});

		$(document).on('click', '.btn-remove-room', function(){
			windata.removeRoomGuestPopUp(this);
		});


		$(document).on('click', '.btn-save', function(){
			var data = {
					'_token' : csrf_token,
					'type' : $('.voucher-type').val(),
					'ctoken' : $('.contact').attr('data-token'),
					'dest_id' : $('.location').attr('data-code'),
					'check_in' : $('.check-in').val(),
					'check_out' : $('.check-out').val(),
					'guests' : windata.guests,
					'data' : {
							'name' : $('.accommo-name').val(),
							'code' : $('.accommo-name').attr('data-code'),
							'vendor' : $('.accommo-name').attr('data-vendor'),
							'image' : $('.accommo-name').attr('data-image'),
							'prop_type' : $('.prop-type').val(),
							'lunch' : $('.meal.lunch').prop('checked'),
							'breakfast' : $('.meal.breakfast').prop('checked'),
							'dinner' : $('.meal.dinner').prop('checked'),
						},
					'terms' : $('.cancellation_policy').val(),
					'remark' : $('.remark').val()
				};

			$.ajax({
				type: "POST",
			  url:"{{ route("vouchers.store_data") }}",
			  data: data,
			  dataType: 'json',
			  success: function (res) {
			  	document.location.href = '{{ url('dashboard/vouchers/show') }}/'+
			  											_.get(res, 'token', '')+'/pdf';
			  }
			});

		});

	</script>

	@include('b2b.protected.dashboard.pages.voucher.html.autocomplete')


@endsection 
