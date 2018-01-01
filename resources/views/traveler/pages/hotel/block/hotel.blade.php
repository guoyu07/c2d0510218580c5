<div class="booking-item-payment">
	<header class="clearfix">
		<a class="booking-item-payment-img width-22p" href="{{ url('traveler') }}/#">
			<img src="{{ url('traveler') }}/img/hotel_1_800x600.jpg" alt="Image Alternative text" title="hotel 1" />
		</a>
		<h5 class="booking-item-payment-title"><a href="{{ url('traveler') }}/#">{{ $data->hotel_name }}</a></h5>
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
				<h5>Booking for {{ $data->rooms->hotels->nights }} {{ str_plural('night', $data->rooms->hotels->nights) }}</h5>
				<div class="booking-item-payment-date">
					<p class="booking-item-payment-date-day">
						{{ $data->rooms->hotels->start_date->format('M, d') }}
					</p>
					<p class="booking-item-payment-date-weekday">
						{{ $data->rooms->hotels->start_date->format('l') }}
					</p>
				</div>
				<i class="fa fa-arrow-right booking-item-payment-date-separator"></i>
				
				<div class="booking-item-payment-date">
					<p class="booking-item-payment-date-day">
						{{ $data->rooms->hotels->end_date->format('M, d') }}
					</p>
					<p class="booking-item-payment-date-weekday">
						{{ $data->rooms->hotels->end_date->format('l') }}
					</p>
				</div>
			</li>
		</ul>
	</header>
	<ul class="booking-item-payment-details">
		@foreach ($data->roomData() as $key => $room)
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
	<p class="booking-item-payment-total">Total trip: <span>₹ {{ $data->total_amount }}</span>
	</p>
</div>