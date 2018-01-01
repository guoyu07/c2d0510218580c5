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
	<div id="cruises_result" class="row">
		<div class="col-md-3 col-md-3 col-xs-12">
			<div class="row">	
				<div class="x_panel nopadding" style="background: aliceblue;">
					<h3><div class="text-center">Cruises</div></h3>
				</div>
			</div>
			@include('b2b.protected.dashboard.pages.cruises.partials._filter')
			@include('b2b.protected.dashboard.pages.cruises.partials._search')
		</div>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="exTab1" class="container">
						<ul id="tab_menu" class="nav nav-pills">
							@foreach ($package->cruiseRoutes as $cruiseRouteKey => $cruiseRoute)
								<li class="col-md-2 col-sm-2 col-xs-12 text-center li-menu-dest {{ $cruiseRouteKey == 0 ? 'active' : ''}}" data-list="cruise_{{ $cruiseRoute->id }}_div">
									<a id="a_cruise_{{ $cruiseRoute->id }}" href="#cruise_{{ $cruiseRoute->id }}_div" data-toggle="tab"  data-rid="{{ $cruiseRoute->id }}">
										{{ $cruiseRoute->destination_detail->destination.', '.$cruiseRoute->destination_detail->country }}
									</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content clearfix">
							@foreach ($package->cruiseRoutes as $cruiseRouteKey => $cruiseRoute)
								<div id="cruise_{{ $cruiseRoute->id }}_div" class="tab-pane {{ $cruiseRouteKey == 0 ? 'active' : ''}}">
										<ul id="cruise_{{ $cruiseRoute->id }}" class="list list-unstyled">
											<li></li>
										</ul>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('b2b.protected.dashboard.pages.cruises.partials._hidden')

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
	@include('b2b.protected.dashboard.pages.cruises.partials.scripts._scripts')
@endsection

