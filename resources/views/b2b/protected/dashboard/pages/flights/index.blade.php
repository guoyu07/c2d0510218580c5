@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/builder_spin.css') }}">
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/>

@endsection

@section('menutab')
	@include('b2b.protected.dashboard.pages.common.menu')
@endsection

@section('content')
	<div id="loging_log">
		<div id="fgfpreloader" class="fixed-top"></div>
		<i id="logo" class="s-icon-fgf font-big fixed-top"></i>
	</div>
	<div id="flights_result" class="row">
		<div class="col-md-3 col-md-3 col-xs-12">
			<div class="row">
				<a href="{{ $package->backCurrentNextUrl('flight')->get('previous', '#') }}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Back</a>
			</div>
			<div class="row">	
				<div class="x_panel nopadding text-center" style="background: aliceblue;">
					<h3><div>Flights</div></h3>
					<div>Date : <span class="show-date">{{$flightRoutes->first()->start_datetime->format('d-M-Y')}}</span></div>
				</div>
			</div>
			@include($viewPath.'.partials._filter')
			@include($viewPath.'.partials._search')
			<div class="row m-top-5" align="center">
				<div id="btn_next" class="circle-big bg-blue glowing-green-border cursor-pointer">
					<div class="circle-in text-center font-size-20">Next <i class="fa fa-arrow-right"></i></div>
				</div>
			</div>
		</div>
		
		<div class="col-md-9 col-sm-9 col-xs-12">
			<div class="row">	
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="exTab1" class="container">
						<ul id="tab_menu" class="nav nav-pills">
							@foreach ($flightRoutes as $flightRouteKey => $flightRoute)
								<li class="col-md-2 col-sm-2 col-xs-12 text-center li-menu-dest {{ $flightRouteKey == 0 ? 'active' : ''}}">
									<a href="#target_{{ $flightRoute->token }}"
										class="a-tab-menu" data-toggle="tab">
										{{ $flightRoute->origin_code }} → 
										{{ $flightRoute->destination_code }}
									</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content tab-content-box clearfix">
							@foreach ($flightRoutes as $flightRouteKey => $flightRoute)
								<div id="target_{{ $flightRoute->token }}" class="tab-pane tab-target {{ $flightRouteKey == 0 ? 'active' : ''}}">
									<ul id="fixed_{{ $flightRoute->token }}" class="list list-unstyled fixed">
									</ul>
									<div id="filter_{{ $flightRoute->token }}">
										<ul id="result_{{ $flightRoute->token }}" class="list list-unstyled result">
										</ul>
									</div>
								</div>
							@endforeach
						</div>
						
						{{-- <ul id="tab_menu" class="nav nav-pills">
							@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
								<li class="col-md-2 col-sm-2 col-xs-12 text-center 
									{{ $flightRouteKey == 0 ? 'active' : ''}}" 
									data-list="flight_{{ $flightRoute->id }}_div">
									
									<a id="a_flight_{{ $flightRoute->id }}" 
										href="#flight_{{ $flightRoute->id }}_div" 
										class="a_tab_menu" data-toggle="tab" 
										data-rid="{{ $flightRoute->id }}">
										{{ $flightRoute->origin_code }} → 
										{{ $flightRoute->destination_code }}
									</a>

								</li>
							@endforeach
						</ul>
						<div class="tab-content tab-content-box clearfix">
							@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
								<div id="flight_{{ $flightRoute->id }}_div" 
									class="tab-pane {{ $flightRouteKey == 0 ? 'active' : ''}}">
									<ul id="flight_{{ $flightRoute->id }}" 
										data-rid="{{ $flightRoute->id }}"
										class="list list-unstyled" data-ispulled="0">
										@include($viewPath.'.partials.custom_flight') 
									</ul>
									<button class="btn btn-success add-custom-flight" data-id="flight_{{ $flightRoute->id }}">Add Flight</button> 
								</div>
							@endforeach
						</div> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="add-flight-manually">
		<button class="btn btn-success add-custom-flight">
			Add Flight Manually
		</button>
	</div>
@endsection

@section('js')
	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ asset('js/list.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	<script src="{{ commonAsset('datetimepicker/jquery.datetimepicker.full.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}
@endsection

@section('scripts')
	@include($viewPath.'.partials.scripts._scripts')
@endsection

