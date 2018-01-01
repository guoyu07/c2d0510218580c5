<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-car"></i>
		<span>Cabs</span>
		<span class="badge bg-green">{{-- Count of the cart --}}</span>
	</a>
	<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		<li>
			<a>
				<span>
					<span>Ajay</span>
					<span class="time">3 mins ago</span>
				</span>
				<span class="message">
					Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			</a>
		</li>
		<li>
			<a>
				<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
				<span>
					<span>John Smith</span>
					<span class="time">3 mins ago</span>
				</span>
				<span class="message">
					Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			</a>
		</li>
		<li>
			<a>
				<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
				<span>
					<span>John Smith</span>
					<span class="time">3 mins ago</span>
				</span>
				<span class="message">
					Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			</a>
		</li>
		<li>
			<div class="text-center">
				<a href="{{ url('dashboard/inbox') }}">
					<strong>See All Alerts</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		</li>
	</ul>
</li>
<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-fighter-jet"></i>
		<span>Flight</span>
		<span class="badge bg-green">{{-- Count of the cart --}}</span>
	</a>
	<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		<li>
			<a>
				<span>
					<span>Ajay</span>
					<span class="time">3 mins ago</span>
				</span>
				<span class="message">
					Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			</a>
		</li>
		<li>
			<a>
				<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
				<span>
					<span>John Smith</span>
					<span class="time">3 mins ago</span>
				</span>
				<span class="message">
					Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			</a>
		</li>
		<li>
			<a>
				<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
				<span>
					<span>John Smith</span>
					<span class="time">3 mins ago</span>
				</span>
				<span class="message">
					Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			</a>
		</li>
		<li>
			<div class="text-center">
				<a href="{{ url('dashboard/inbox') }}">
					<strong>See All Alerts</strong>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
		</li>
	</ul>
</li>
<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="glyphicon glyphicon-home"></i>
		<span>Hotels</span>
		<span class="badge bg-green">{{ isset($bookedHotel->count) ? $bookedHotel->count : '' }}</span>
	</a>
	{{-- <ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		@forelse( $bookedHotel->hotels as $booked_Hotel)
			<li>
				<a>
					<div class="text-center"><h3>{{ $booked_Hotel->RoomTypeName }}</h3></div>
					<div><h3>{{ $booked_Hotel->RoomTypeName }}</h3></div>
				</a>
			</li>
		@empty
			<li>No Hotel Booked</li>
		@endforelse
		@if (bool_array($bookedHotel->hotels))
			<li>
				<div class="text-center">
					<a href="{{  url('dashboard/package/builder/hotel/all/'.$urlVariable->id.'/'.$urlVariable->packageDbId.'/'.$urlVariable->packageHotelId) }}">
						<strong>See All Hotels</strong>
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
			</li>
		@endif
	</ul> --}}
</li>
<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-user"></i>
		<span>Client Info</span>
		<span class="badge bg-green">{{-- Count of the cart --}}</span>
	</a>
	<ul id="menu1" class="width-450 dropdown-menu list-unstyled msg_list" role="menu">
		<li>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-10 col-sm-10 col-xs-12">
						<h3>{{ $client->fullname }}</h3>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 nopadding">
						<img class="width-100-p" src="{{ asset('images/user.jpg') }}" alt="Profile Image" />
					</div>
				</div>
			</div>
			
			<span class="image">
			</span>
		</li>
		<li class="text-left">
			<label for="">Package Id : </label>
			<span>{{ $urlVariable->packageId }}</span>
		</li>
		<li class="text-left">
			<div>
				<i class="fa fa-phone"> </i>
				<span>{{ $client->mobile }}</span>
			</div>
			<div>
				<i class="fa fa-envelope"> </i>
				<span>{{ $client->email }}</span>
			</div>
		</li>
		<li>
			<div><b>Message</b></div>
			<span>
				<div>
					{{ $client->note }}
				</div>
			</span>
		</li>
	</ul>
</li>
