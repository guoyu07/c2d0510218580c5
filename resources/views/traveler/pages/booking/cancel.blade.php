@extends('traveler.layout.main')

@section('title', $data->bookedTo->roomBlock->hotel_name)

@section('content')
<div class="gap"></div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="booking-item-payment">
				<header class="clearfix">
					<h5>Cancellation status <span class="pull-right"><label>Request Id  : {{ $cancelRes->change_request_id }}</label></span></h5>
				</header>
				<div class="booking-item-payment-details {{ $cancelRes->messageCss() }}">
					<ul><li>{{ $cancelRes->get_change_message }}</li></ul>
					
					@if ($cancelRes->get_change_message == 1)
						<p>
							<label>Refund Amount : {{ $cancelRes->refund_amount }}</label>
							<label>Cancellation Charge : {{ $cancelRes->cancellation_charge }}</label>
						</p>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="gap"></div>
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
								{{-- <li>
									<p class="booking-item-payment-price-title">Taxes</p>
									<p class="booking-item-payment-price-amount">₹15<small>/per day</small>
									</p>
								</li> --}}
							</ul>
						</li>
					@endforeach
				</ul>
				
				<p class="booking-item-payment-total">Total trip: <span>₹ {{ $data->bookedTo->roomBlock->total_amount }}</span>
				</p>
			</div>
		</div>
	</div>
	<div class="gap"></div>
</div>

@endsection
