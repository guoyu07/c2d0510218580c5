@extends('traveler.layout.main')

@section('title', $data->bookedTo->roomBlock->hotel_name)

@section('content')
<div class="gap"></div>

<div class="container">
	<div class="row">
		@if (!$data->bookedTo->is_booked)
		<div class="col-md-12">
			<div class="alert alert-danger">
				Sorry we unable to book your hotel kindly contact our customer care.
			</div>
		</div>
		@endif
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="booking-item-payment">
				<header class="clearfix">
					<h5>Guests Details</h5>
				</header>
				@foreach ($data->bookedTo->roomBlock->guestByRooms() as $key => $passengers)
					<ul class="booking-item-payment-details">
						<li>
							<h5>Room : {{ $key+1 }}</h5>
							@foreach ($passengers as $passenger)
								<p class="booking-item-payment-item-title">{{ $passenger->fullname }} <span class="pull-right">({{ $passenger->age.' '.str_plural('Year', $passenger->age).' old' }})</span></p>
							@endforeach
						</li>
					</ul>
				@endforeach
			</div>
		</div>
		<div class="col-md-6">
			<div class="booking-item-payment">
				<header class="clearfix">
					<a class="booking-item-payment-img width-22p" href="{{ url('traveler') }}/#">
						<img src="{{ url('traveler') }}/img/hotel_1_800x600.jpg" alt="Image Alternative text" title="hotel 1" />
					</a>
					<h5 class="booking-item-payment-title"><a href="{{ url('traveler') }}/#">{{ $data->bookedTo->roomBlock->hotel_name }}</a></h5>
					<ul class="icon-group booking-item-rating-stars">
						<li><i class="fa fa-star"></i>
						</li>
						<li><i class="fa fa-star"></i>
						</li>
						<li><i class="fa fa-star"></i>
						</li>
						<li><i class="fa fa-star"></i>
						</li>
						<li><i class="fa fa-star"></i>
						</li>
					</ul>
					<ul class="booking-item-payment-details noborder">
						<li>
							<h5>Booking for {{ $data->bookedTo->roomBlock->rooms->hotels->nights }} {{ str_plural('night', $data->bookedTo->roomBlock->rooms->hotels->nights) }}</h5>
							<div class="booking-item-payment-date">
								<p class="booking-item-payment-date-day">
									{{ $data->bookedTo->roomBlock->rooms->hotels->start_date->format('M, d') }}
								</p>
								<p class="booking-item-payment-date-weekday">
									{{ $data->bookedTo->roomBlock->rooms->hotels->start_date->format('l') }}
								</p>
							</div>
							<i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
							
							<div class="booking-item-payment-date">
								<p class="booking-item-payment-date-day">
									{{ $data->bookedTo->roomBlock->rooms->hotels->end_date->format('M, d') }}
								</p>
								<p class="booking-item-payment-date-weekday">
									{{ $data->bookedTo->roomBlock->rooms->hotels->end_date->format('l') }}
								</p>
							</div>
						</li>
					</ul>
				</header>
				<ul class="booking-item-payment-details">
					@foreach ($data->bookedTo->roomBlock->roomData() as $key => $room)
						<li>
							<h5>Room : {{ $key+1 }}</h5>
							<p class="booking-item-payment-item-title">{{ $room->room_type }}</p>
							<ul class="booking-item-payment-price">
								<li>
									<p class="booking-item-payment-price-amount">₹{{ $room->price }}<small>/per day</small>
									</p>
								</li>
							</ul>
						</li>
					@endforeach
				</ul>
				<p class="booking-item-payment-details">
					@if ($data->bookedTo->is_booked)
						<a href="{{ $data->voucherUrl() }}" class="btn btn-default">Voucher</a>
						@if (!$data->bookedTo->is_canceled)
							<button id="cancel_booking" class="btn btn-default btn-danger pull-right">Cancel Booking</button>
							<form method="post" action="{{ $data->cancelUrl() }}" hidden>
								{{ csrf_field() }}
								<textarea id="cancel_textarea" name="remarks"></textarea>
								<button id="cancel_submit" type="submit"></button>
							</form>
						@endif
					@endif

				</p>
				<p class="booking-item-payment-total">Total trip: <span>₹ {{ $data->bookedTo->roomBlock->total_amount }}</span>
				</p>
			</div>
		</div>
	</div>
	<div class="gap"></div>
</div>

@endsection

@section('scripts')
	<script>
		$(document).on('click', '#book_now', function () {
			var room_guest = [];

			$('.room-guest').each(function(){
				
				var new_guest = [];

				$(this).find('.guest-row').each(function(){
					new_guest.push({
						'prefix' : $(this).find('.prefix').val(),
						'name' : $(this).find('.name').val(),
						'age' : $(this).find('.age').val(),
					});
				});

				room_guest.push(new_guest);
			});

			var query = $.param({'guests' : room_guest});

			var url = '{{ url('hotel') }}/{{ $data->bookedTo->roomBlock->id }}/room/book?{!! http_build_query(request()->input()) !!}&'+query;

			$('#a_book_now').attr('href', url);

			document.getElementById('a_book_now').click();
		});

		$(document).on('keyup', '#cancel_remarks', function () {
			var left = 15 - $(this).val().length;
			
			if (left > 0) {
				$('#cancel_count').html(left+' more to go...');
				return false;
			}

			$('#cancel_count').html('');
		});

		$(document).on('click', '#cancel_booking', function () {
			var thisObj = this;
			$.confirm({
				title : 'Warning!',
				content : `<div class="row">
										<div class="col-md-12">Are you sure want to cancel?</div>
										<div class="col-md-12">
											<label for="">Enter Remarks</label>
											<textarea id="cancel_remarks" style="margin: 0px; width: 100%; height: 100px;"></textarea>
											<span id="cancel_count">enter at least 15 characters</span>
										</div>
									</div>`,
				backgroundDismiss: true,
				buttons: {
					No: {
						btnClass: 'btn-default'
					},
					'Cancel Now': {
						btnClass: 'btn-red',
						action: function(){
							var remarks = $('#cancel_remarks').val();
							console.log(remarks.length);
							if (remarks.length < 15) {
								$('#cancel_remarks').addClass('border-red');
								return false;
							}
							else{
								$('#cancel_textarea').html(remarks);
								$('#cancel_submit').click();
							}
						}
					},
				}
			});

		});
	</script>
@endsection