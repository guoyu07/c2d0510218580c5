@extends('traveler.layout.main')

@section('title', $detail->name)

@section('content')
	<div class="container">
		{{-- <ul class="breadcrumb">
			<li><a href="{{ url('traveler') }}/index-2.html">Home</a>
			</li>
			<li><a href="{{ url('traveler') }}/#">United States</a>
			</li>
			<li><a href="{{ url('traveler') }}/#">New York (NY)</a>
			</li>
			<li><a href="{{ url('traveler') }}/#">New York City</a>
			</li>
			<li><a href="{{ url('traveler') }}/#">New York City Hotels</a>
			</li>
			<li class="active">InterContinental New York Barclay</li>
		</ul> --}}
		<div class="booking-item-details">
			<header class="booking-item-header">
				<div class="row">
					<div class="col-md-9">
						<h2 class="lh1em">{{ $detail->name }}</h2>
						<p class="lh1em text-small">
							<i class="fa fa-map-marker"></i>
							<span>{{ $detail->address }}</span>
						</p>
						{{-- <ul class="list list-inline text-small">
							<li><a href="{{ url('traveler') }}/#"><i class="fa fa-envelope"></i> Hotel E-mail</a>
							</li>
							<li><a href="{{ url('traveler') }}/#"><i class="fa fa-home"></i> Hotel Website</a>
							</li>
							<li><i class="fa fa-phone"></i> +1 (543) 461-7550</li>
						</ul> --}}
					</div>
					<div class="col-md-3">
						{{-- <p class="booking-item-header-price"><small>price from</small>  <span class="text-lg">$350</span>/night</p> --}}
					</div>
				</div>
			</header>
			<div class="row">
				<div class="col-md-6">
					<div class="tabbable booking-details-tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="active"><a href="{{ url('traveler') }}/#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
							</li>
							<li>
								<a href="{{ url('traveler') }}/#google-map-tab" data-toggle="tab"><i class="fa fa-map-marker"></i>On the Map</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab-1">
								<div id="photo_gallery" class="fotorama" data-width="555" data-height="416" data-allowfullscreen="true" data-nav="thumbs" data-auto="false">
									<img v-if="!gotDetails" src="{{ $detail->image }}" alt="{{ $detail->image }}" />
									<img v-for="(image, key) in detailsData.images" :src="image" :alt="image"{{--  v-for-callback="{key: key, array: detailsData.images, callback: intiFotorama}" --}} />
								</div>
							</div>
							<div class="tab-pane fade" id="google-map-tab">
								<div id="map-canvas" data-lat="{{ $detail->latitude }}" data-long="{{ $detail->longitude }}" style="width:100%; height:500px;"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="booking-item-meta">
						<h2 class="lh1em mt40">Exeptional!</h2>
						<h3>97% <small >of guests recommend</small></h3>
						<div class="booking-item-rating">
							<ul class="icon-list icon-group booking-item-rating-stars">
								@for ($i = 0; $i < 5 ; $i++)
									@if ($i < $detail->star_rating)
										<li><i class="fa fa-star"></i></li>
									@else
										<li><i class="fa fa-star-o"></i></li>
									@endif
								@endfor
							</ul>
							<span class="booking-item-rating-number"><b >{{ $detail->star_rating }}</b> of 5 <small class="text-smaller">guest rating</small></span>
							{{-- <p><a class="text-default" href="{{ url('traveler') }}/#">based on 1535 reviews</a> --}}
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<h4 class="lh1em">Traveler raiting</h4>
							<ul class="list booking-item-raiting-list">
								<li>
									<div class="booking-item-raiting-list-title">Exellent</div>
									<div class="booking-item-raiting-list-bar">
										<div style="width:89%;"></div>
									</div>
									<div class="booking-item-raiting-list-number">1231</div>
								</li>
								<li>
									<div class="booking-item-raiting-list-title">Very Good</div>
									<div class="booking-item-raiting-list-bar">
										<div style="width:5%;"></div>
									</div>
									<div class="booking-item-raiting-list-number">76</div>
								</li>
								<li>
									<div class="booking-item-raiting-list-title">Average</div>
									<div class="booking-item-raiting-list-bar">
										<div style="width:4%;"></div>
									</div>
									<div class="booking-item-raiting-list-number">40</div>
								</li>
								<li>
									<div class="booking-item-raiting-list-title">Poor</div>
									<div class="booking-item-raiting-list-bar">
										<div style="width:2%;"></div>
									</div>
									<div class="booking-item-raiting-list-number">13</div>
								</li>
								<li>
									<div class="booking-item-raiting-list-title">Terrible</div>
									<div class="booking-item-raiting-list-bar">
										<div style="width:1%;"></div>
									</div>
									<div class="booking-item-raiting-list-number">7</div>
								</li>
							</ul>
						</div>
						<div class="col-md-4">
							<h4 class="lh1em">Summary</h4>
							<ul class="list booking-item-raiting-summary-list">
								<li>
									<div class="booking-item-raiting-list-title">Sleep</div>
									<ul class="icon-group booking-item-rating-stars">
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
									</ul>
								</li>
								<li>
									<div class="booking-item-raiting-list-title">Location</div>
									<ul class="icon-group booking-item-rating-stars">
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o text-gray"></i>
										</li>
									</ul>
								</li>
								<li>
									<div class="booking-item-raiting-list-title">Service</div>
									<ul class="icon-group booking-item-rating-stars">
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
									</ul>
								</li>
								<li>
									<div class="booking-item-raiting-list-title">Clearness</div>
									<ul class="icon-group booking-item-rating-stars">
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
									</ul>
								</li>
								<li>
									<div class="booking-item-raiting-list-title">Rooms</div>
									<ul class="icon-group booking-item-rating-stars">
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
										<li><i class="fa fa-smile-o"></i>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
					<a href="{{ url('traveler') }}/#" class="btn btn-primary">Write a Review</a>
				</div>
			</div>
			<div class="gap"></div>
			<div id="rooms" class="row">
				<div class="col-md-9">
					<h3>Available Rooms 
						<button class="col-md-3 btn btn-success proceed-book pull-right">Proceed to Book</button>
					</h3>

					@include('traveler.pages.hotel.detail.room')
					
					<button class="col-md-3 btn btn-success proceed-book pull-right">Proceed to Book</button>

					<a href="" id="new_link" hidden></a>
				</div>
				<div class="col-md-3">
					<h4>About the Hotel</h4>
					<p class="mb30">{{ $detail->description }}</h4>
					{{-- @include('traveler.pages.hotel.detail.facilities') --}}
				</div>
			</div>
			{{-- @include('traveler.pages.hotel.detail.reviews') --}}
		</div>
		<div class="gap gap-small"></div>
	</div>
@endsection


@section('scripts')
	@include('traveler.pages.hotel.detail.scripts')
@endsection