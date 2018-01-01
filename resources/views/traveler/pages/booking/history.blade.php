@extends('traveler.layout.main')

@section('title', 'Booking History')

@section('content')
	<div class="gap"></div>
	<div class="container">
		<div class="row">
			{{-- <div class="col-md-3">
				<aside class="user-profile-sidebar">
					<div class="user-profile-avatar text-center">
						<img src="{{ url('traveler') }}/img/amaze_300x300.jpg" alt="Image Alternative text" title="AMaze" />
						<h5>John Doe</h5>
						<p>Member Since May 2012</p>
					</div>
					<ul class="list user-profile-nav">
						<li><a href="{{ url('traveler') }}/user-profile.html"><i class="fa fa-user"></i>Overview</a>
						</li>
						<li><a href="{{ url('traveler') }}/user-profile-settings.html"><i class="fa fa-cog"></i>Settings</a>
						</li>
						<li><a href="{{ url('traveler') }}/user-profile-photos.html"><i class="fa fa-camera"></i>My Travel Photos</a>
						</li>
						<li><a href="{{ url('traveler') }}/user-profile-booking-history.html"><i class="fa fa-clock-o"></i>Booking History</a>
						</li>
						<li><a href="{{ url('traveler') }}/user-profile-cards.html"><i class="fa fa-credit-card"></i>Credit/Debit Cards</a>
						</li>
						<li><a href="{{ url('traveler') }}/user-profile-wishlist.html"><i class="fa fa-heart-o"></i>Wishlist</a>
						</li>
					</ul>
				</aside>
			</div> --}}
			<div class="col-md-12">
				{{-- <div class="checkbox">
					<label>
						<input class="i-check" type="checkbox" />Show only current trip</label>
				</div> --}}
				<table class="table table-bordered table-striped table-booking-history">
					<thead>
						<tr>
							<th>Type</th>
							<th>Title</th>
							<th>Location</th>
							<th>Order Date</th>
							<th>Execution Date</th>
							<th>Cost</th>
							<th>Current</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($auth->myBookings as $myBooking)
							@if (!is_null($myBooking->bookedTo))
								<tr>
									<td class="booking-history-type">
										<i class="fa fa-building-o"></i><small>hotel</small>
									</td>
									<td class="booking-history-title">{{ $myBooking->bookedTo->hotel_name }}</td>
									<td>{{ $myBooking->bookedTo->roomBlock->rooms->hotels->destination->location }}</td>
									<td>{{ $myBooking->bookedTo->created_at->format('d/m/Y') }}</td>
									<td>{{$myBooking->bookedTo->roomBlock->rooms->hotels->start_date->format('d/m/Y') }} <i class="fa fa-long-arrow-right"></i> {{$myBooking->bookedTo->roomBlock->rooms->hotels->end_date->format('d/m/Y') }}</td>
									<td>₹{{ $myBooking->bookedTo->total_amount }}</td>

									@if ($myBooking->bookedTo->roomBlock->rooms->hotels->is_date_passed)
										<td class="text-center">
											<i class="fa fa-times"></i>
										</td>
										<td class="text-center">
											<a class="btn btn-default btn-sm" disabled>Open</a>
										</td>
									@else
										<td class="text-center">
											<i class="fa fa-check"></i>
										</td>
										<td class="text-center">
											<a class="btn btn-default btn-sm" href="{{ $myBooking->openUrl() }}">Open</a>
										</td>
									@endif

								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection