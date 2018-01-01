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
	<div id="accomos_result" class="row">
		<div class="col-md-3 col-md-3 col-xs-12">
			<div class="row">
				<a href="{{ $package->backCurrentNextUrl('accommodation')->get('previous', '#') }}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Back</a>
			</div>
			<div class="row">	
				<div class="x_panel nopadding text-center" style="background: aliceblue;">
					<h3><div >Accommodation</div></h3>
					<div>Date : <span class="show-start-date">{{$accomoRoutes->first()->start_datetime->format('d-M-Y')}}</span> to <span class="show-end-date">{{$accomoRoutes->first()->end_datetime->format('d-M-Y')}}</span></div>
				</div>
			</div>
			@include($viewPath.'.partials._filter')
			<div class="row">	
				<div class="x_panel">
					<div class="x_content">
						<div class="row">
							@include('b2b.protected.dashboard.pages.common.guests.field')
						</div>
					</div>
				</div>
			</div>
			{{-- @include('b2b.protected.dashboard.pages.accomos.partials._search') --}}
			<div class="row m-top-70" align="center">
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
							@foreach ($accomoRoutes as $accomoRouteKey => $accomoRoute)
								<li class="col-md-2 col-sm-2 col-xs-12 text-center li-menu-dest {{ $accomoRouteKey == 0 ? 'active' : ''}}">
									<a href="#target_{{ $accomoRoute->token }}"
										class="a-tab-menu" data-toggle="tab">
										{{ $accomoRoute->destination_detail->location }}
									</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content tab-content-box clearfix">
							@foreach ($accomoRoutes as $accomoRouteKey => $accomoRoute)
								<div id="target_{{ $accomoRoute->token }}" class="tab-pane tab-target {{ $accomoRouteKey == 0 ? 'active' : ''}}">
									@include($viewPath.'.partials.html_partials.meal_transfer')
									<ul id="fixed_{{ $accomoRoute->token }}" class="list list-unstyled fixed">
									</ul>
									<ul id="result_{{ $accomoRoute->token }}" class="list list-unstyled result">
									</ul>
								</div>
							@endforeach
							{{-- @include($viewPath.'.partials.html_partials.temp') --}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ asset('js/list.min.js') }}"></script>


	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- <script src="{{ commonAsset('dashboard/vendors/jquery.scrollTo/jquery.scrollTo.min.js') }}"></script> --}}
	{{-- /bootstrap-daterangepicker --}}

	<script src="{{ asset('js/my_plus_minus.js') }}"></script>
@endsection

@section('scripts')
	@include($viewPath.'.partials.scripts._scripts')
@endsection
