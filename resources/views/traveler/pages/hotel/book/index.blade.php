@extends('traveler.layout.main')

@section('title', $data->hotel_name)

@section('content')
<div class="gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<i class="fa fa-{{ $data->is_booked ? 'check' : 'times' }} round box-icon-large box-icon-center box-icon-{{
				$data->is_booked ? '' : 'un' }}success mb30"></i>	
			<h2 class="text-center">{{ isset($data->lead_passenger->firstname) ? $data->lead_passenger->firstname : '' }}, your hotel {{ $data->is_booked ? 'booked successful' : 'booking failed' }}!</h2>
			<h5 class="text-center mb30">Booking details has been send to {{$data->lead_passenger->email}}</h5>
			<ul class="order-payment-list list mb30">
				@foreach ($data->booked_rooms as $room)
					<li>
						<div class="row">
							<div class="col-xs-9">
								<h5><i class="fa fa-building-o"></i> {{ $data->hotel_name }}</h5>
								<p><small>{{ $room->room_type }}</small></p>
							</div>
							<div class="col-xs-3">
								<p class="text-right"><span class="text-lg">₹ {{ $room->price }}</span>
								</p>
							</div>
						</div>
					</li>
				@endforeach
			</ul>
			<hr>
			<h6 class="text-center">You will be redirected in 5 seconds</h6>

			{{-- <h4 class="text-center">You might also need in New York</h4>
			<ul class="list list-inline list-center">
				<li><a class="btn btn-primary" href="{{ url('traveler') }}/#"><i class="fa fa-building-o"></i> Hotels</a>
					<p class="text-center lh1em mt5"><small>362 offers<br /> from $75</small>
					</p>
				</li>
				<li><a class="btn btn-primary" href="{{ url('traveler') }}/#"><i class="fa fa-home"></i> Rentlas</a>
					<p class="text-center lh1em mt5"><small>240 offers<br /> from $85</small>
					</p>
				</li>
				<li><a class="btn btn-primary" href="{{ url('traveler') }}/#"><i class="fa fa-dashboard"></i> Cars</a>
					<p class="text-center lh1em mt5"><small>165 offers<br /> from $143</small>
					</p>
				</li>
				<li><a class="btn btn-primary" href="{{ url('traveler') }}/#"><i class="fa fa-bolt"></i> Activities</a>
					<p class="text-center lh1em mt5"><small>366 offers<br /> from $116</small>
					</p>
				</li>
			</ul> --}}
		</div>
	</div>
	<div class="gap"></div>
</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function () {
			setTimeout(function () {
				document.location.href = "{{ $redirect_to }}"
			}, 5000);
		});
	</script>
@endsection