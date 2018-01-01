@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/builder_spin.css') }}">
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
@endsection

@section('menutab')
	@include('b2b.protected.dashboard.pages.common.menu')
@endsection

@section('content')
	<div id="loging_log">
		<div id="fgfpreloader" class="fixed-top"></div>
		<i id="logo" class="s-icon-fgf font-big fixed-top"></i>
	</div>
	<div id="hotels_result" class="row">
		<div class="col-md-3 col-md-3 col-xs-12">
			<div class="row">	
				<div class="x_panel nopadding" style="background: aliceblue;">
					<h3><div class="text-center">Hotels</div></h3>
				</div>
			</div>
			@include('b2b.protected.dashboard.pages.hotels.partials._filter')
			{{-- @include('b2b.protected.dashboard.pages.hotels.partials._search') --}}
			<div class="row m-top-70" align="center">
				<div id="btn_next" class="circle-big bg-blue glowing-green-border cursor-pointer" data-rid="{{ $package->hotelRoutes[0]->id }}">
					<div class="circle-in text-center font-size-20">Next <i class="fa fa-arrow-right"></i></div>
				</div>
			</div>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="exTab1" class="container">
						<ul id="tab_menu" class="nav nav-pills">
							@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
								<li class="col-md-2 col-sm-2 col-xs-12 text-center li-menu-dest 
									{{ $hotelRouteKey == 0 ? 'active' : ''}}" 
									data-list="hotel_{{ $hotelRoute->id }}_div">
									<a id="a_hotel_{{ $hotelRoute->id }}" 
										href="#hotel_{{ $hotelRoute->id }}_div" 
										data-rid="{{ $hotelRoute->id }}"
										class="a_tab_menu"
										data-toggle="tab">
										{{ $hotelRoute->destination_detail->destination.', '.$hotelRoute->destination_detail->country }}
									</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content tab-content-box clearfix">
							@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
								<div id="hotel_{{ $hotelRoute->id }}_div" 
										class="tab-pane {{ $hotelRouteKey == 0 ? 'active' : ''}}">
									<ul id="hotel_{{ $hotelRoute->id }}" class="list list-unstyled" data-rid="{{ $hotelRoute->id }}"></ul>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('b2b.protected.dashboard.pages.hotels.partials._hidden')

@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ asset('js/list.min.js') }}"></script>


	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

@endsection

@section('scripts')
	@include('b2b.protected.dashboard.pages.hotels.partials.scripts._scripts')
@endsection

