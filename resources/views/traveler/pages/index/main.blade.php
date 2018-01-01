@extends('traveler.layout.main')

@section('content')
	<!-- TOP AREA -->
	<div class="top-area show-onload">
		<div class="bg-holder full">
			<div class="bg-mask"></div>
			<div class="bg-parallax" style="background-image:url(traveler/img/196_365_2048x1365.jpg);"></div>
			<div class="bg-content">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
							<div class="search-tabs search-tabs-bg mt50">
								<h1>Find Your Perfect Trip</h1>
								<div class="tabbable">
									<ul class="nav nav-tabs" id="myTab">
										<li class="active"><a href="{{ url('traveler') }}/#tab-1" data-toggle="tab"><i class="fa fa-building-o"></i> <span >Hotels</span></a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane fade in active" id="tab-1">
											<h2>Search and Save on Hotels</h2>
											@include('traveler.pages.index.form')
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="loc-info text-right hidden-xs hidden-sm">
								<h3 class="loc-info-title"><img src="{{ url('traveler') }}/img/flags/32/fr.png" alt="Image Alternative text" title="Image Title" />Paris</h3>
								<p class="loc-info-weather"><span class="loc-info-weather-num">+31</span><i class="im im-rain loc-info-weather-icon"></i>
								</p>
								<ul class="loc-info-list">
									<li><a href="{{ url('traveler') }}/#"><i class="fa fa-building-o"></i> 277 Hotels from $36/night</a>
									</li>
									<li><a href="{{ url('traveler') }}/#"><i class="fa fa-home"></i> 130 Rentals from $44/night</a>
									</li>
									<li><a href="{{ url('traveler') }}/#"><i class="fa fa-car"></i> 294 Car Offers from $45/day</a>
									</li>
									<li><a href="{{ url('traveler') }}/#"><i class="fa fa-bolt"></i> 200 Activities this Week</a>
									</li>
								</ul><a class="btn btn-white btn-ghost mt10" href="{{ url('traveler') }}/#"><i class="fa fa-angle-right"></i> Explore</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END TOP AREA  -->

	<div class="gap"></div>

	<div class="container">
		<div class="row row-wrap" data-gutter="60">
			<div class="col-md-4">
				<div class="thumb">
					<header class="thumb-header"><i class="fa fa-dollar box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
					</header>
					<div class="thumb-caption">
						<h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Best Price Guarantee</a></h5>
						<p class="thumb-desc">Eu lectus non vivamus ornare lacinia elementum faucibus natoque parturient ullamcorper placerat</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="thumb">
					<header class="thumb-header"><i class="fa fa-lock box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
					</header>
					<div class="thumb-caption">
						<h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Trust & Safety</a></h5>
						<p class="thumb-desc">Imperdiet nisi potenti fermentum vehicula eleifend elementum varius netus adipiscing neque quisque</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="thumb">
					<header class="thumb-header"><i class="fa fa-thumbs-o-up box-icon-md round box-icon-black animate-icon-top-to-bottom"></i>
					</header>
					<div class="thumb-caption">
						<h5 class="thumb-title"><a class="text-darken" href="{{ url('traveler') }}/#">Best Travel Agent</a></h5>
						<p class="thumb-desc">Curae urna fusce massa a lacus nisl id velit magnis venenatis consequat</p>
					</div>
				</div>
			</div>
		</div>
		<div class="gap gap-small"></div>
	</div>
	<div class="bg-holder">
		<div class="bg-mask"></div>
		<div class="bg-parallax" style="background-image:url(traveler/img/hotel_the_cliff_bay_spa_suite_2048x1310.jpg);"></div>
		<div class="bg-content">
			<div class="container">
				<div class="gap gap-big text-center text-white">
					<h2 class="text-uc mb20">Last Minute Deal</h2>
					<ul class="icon-list list-inline-block mb0 last-minute-rating">
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
					<h5 class="last-minute-title">The Peninsula - New York</h5>
					<p class="last-minute-date">Fri 14 Mar - Sun 16 Mar</p>
					<p class="mb20"><b>$120</b> / person</p><a class="btn btn-lg btn-white btn-ghost" href="{{ url('traveler') }}/#">Book Now <i class="fa fa-angle-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="gap"></div>
		<h2 class="text-center">Top Destinations</h2>
		<div class="gap">
			<div class="row row-wrap">
				<div class="col-md-3">
					<div class="thumb">
						<header class="thumb-header">
							<a class="hover-img curved" href="{{ url('traveler') }}/#">
								<img src="{{ url('traveler') }}/img/the_journey_home_400x300.jpg" alt="Image Alternative text" title="the journey home" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
							</a>
						</header>
						<div class="thumb-caption">
							<h4 class="thumb-title">Africa</h4>
							<p class="thumb-desc">Ut blandit pharetra suspendisse montes libero eleifend bibendum</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="thumb">
						<header class="thumb-header">
							<a class="hover-img curved" href="{{ url('traveler') }}/#">
								<img src="{{ url('traveler') }}/img/upper_lake_in_new_york_central_park_800x600.jpg" alt="Image Alternative text" title="Upper Lake in New York Central Park" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
							</a>
						</header>
						<div class="thumb-caption">
							<h4 class="thumb-title">USA</h4>
							<p class="thumb-desc">Cursus faucibus egestas rutrum mauris vulputate consequat ante</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="thumb">
						<header class="thumb-header">
							<a class="hover-img curved" href="{{ url('traveler') }}/#">
								<img src="{{ url('traveler') }}/img/people_on_the_beach_800x600.jpg" alt="Image Alternative text" title="people on the beach" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
							</a>
						</header>
						<div class="thumb-caption">
							<h4 class="thumb-title">Australia</h4>
							<p class="thumb-desc">Senectus hendrerit torquent lorem scelerisque quam a curae</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="thumb">
						<header class="thumb-header">
							<a class="hover-img curved" href="{{ url('traveler') }}/#">
								<img src="{{ url('traveler') }}/img/lack_of_blue_depresses_me_800x600.jpg" alt="Image Alternative text" title="lack of blue depresses me" /><i class="fa fa-plus box-icon-white box-icon-border hover-icon-top-right round"></i>
							</a>
						</header>
						<div class="thumb-caption">
							<h4 class="thumb-title">Greece</h4>
							<p class="thumb-desc">Penatibus ac lacinia platea cras lobortis nullam dapibus</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	@include('traveler.pages.index.scripts')
@endsection

