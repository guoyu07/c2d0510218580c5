@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">

  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
  {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
@endsection

@section('menutab')
	<li role="presentation" class="dropdown">
		<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
			<i class="fa fa-car"></i>
			<span>Cabs</span>
			<span id="menu_cars_count" class="badge bg-green"></span>
		</a>
		<ul id="menu_cars" class="width-550 dropdown-menu list-unstyled msg_list" role="menu">
			{{-- <li>
				<a>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<div class="row">
							<img src="http://logos.skyscnr.com/images/carhire/sippmaps/mercedes_vito.jpg" alt="" height="" width="80">
						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="row">
							<div class="col-md-9 col-sm-9 col-xs-12">
								<h2>Toyota Prado or similar</h2>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12 text-right">
								<h2>
									<i class="fa fa-rupee font-size-15"></i>
									<span class="font-size-17">66778</span>
								</h2>
							</div>
							<div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<b>From : </b>Auckland, New Zealand
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<b>To : </b>Wellington, New Zealand
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-12">
						<div class="m-top-10 text-center">
							<i class="fa fa-trash font-size-30 font-dark-red menu-car-cart" data-pcid=""></i>
						</div>
					</div>
				</a>
			</li> --}}
		</ul>
		{{-- warning modal --}}
		<div class="modal fade bs-example-modal-delete-menu-car" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
						</button>
						<h3 class="modal-title" id="myModalLabel3"><i class="fa fa-warning" ></i> Warning</h3>
					</div>
					<div class="modal-body" id="myModalBody3">
						<h4>Are you sure you want to delete?</h4>
					</div>
					<div class="modal-footer" id="myModalButton3">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						<button type="button" id="remove_menu_car_cart" class="btn btn-danger" data-dismiss="modal" data-pcid="">Yes</button>
					</div>
				</div>
			</div>
		</div>
		{{-- /warning model --}}
	</li>
	@include('b2b.protected.dashboard.pages.common.menu_partials.client')
@endsection

@section('content')
	<div class="row">

		{{-- Cab Serach --}}
		@include('b2b.protected.dashboard.pages.car.partials.content_search')
		{{-- /Cab Serach --}}
		
		{{-- Cabs Body  --}}
		<div class="col-md-9 col-sm-9 col-xs-12">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div id="CabResult">
					<div class="row">	
						<div class="x_panel">
							<div class="height-50vh" id="dvMap"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- /Cabs Body  --}}
	</div>
		{{-- "ssid" mean skyscanner db id --}}
	<div id="cars_result" class="row" data-ssid="" data-id="">
		{{-- <div class="col-md-4 col-sm-4 col-xs-12">
			<div class="x_panel">
				<div >
					<h3>Ford Fiesta or similar</h3>
					<h5><b>Price (all days): </b>INR 131.43</h5>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<h5><b>Car type: </b>ECMN</h5>
							<h5><b>Doors: </b>3 | <b>Seats: </b>6</h5>
							<h5><b>Fuel type: </b>Petrol</h5>
							<h5>
								<a class="btn-link cursor-pointer pick-up-address" data-target="car_1">Pick up address</a>
							</h5>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<img src="http://logos.skyscnr.com/images/carhire/sippmaps/renault_twingo.jpg" alt="">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div id="car_1" hidden>
								London, SE16 <br>
								Distance to search location: 2.681614 km"; 
								Lat/Lon: 51.50161 / -0.05583
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-12 pull-right">
							<button class="btn btn-success btn-block" data-index="">
								Choose
							</button>
						</div>
					</div>
				</div>
			</div>
		</div> --}}
	</div>
	@include('b2b.protected.dashboard.pages.car.partials.content_hidden')

@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}

	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyC-IDStnRaA8ueCCENLDL_s0nCzehhTrF0"></script>
   {{-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC-IDStnRaA8ueCCENLDL_s0nCzehhTrF0&sensor=false"></script> --}}

	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

	{{-- list.js --}}
	<script src="{{ asset('js/list.min.js') }}"></script>
	{{-- /list.js --}}
		
@endsection

@section('scripts')
	@include('b2b.protected.dashboard.pages.car.partials.content_scripts')
@endsection