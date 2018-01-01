@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/builder_spin.css') }}">
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	{{-- <link rel="stylesheet" type="text/css" id="u0" href="https://cdn.tinymce.com/4/skins/lightgray/skin.min.css"> --}}
	<link rel="stylesheet" href="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.css') }}">

@endsection

@section('menutab')
	@include('b2b.protected.dashboard.pages.common.menu')
@endsection

@section('content')
	<div id="loging_log">
		<div id="fgfpreloader" class="fixed-top"></div>
		<i id="logo" class="s-icon-fgf font-big fixed-top"></i>
	</div>
	<div class="btn-right-top cursor-pointer" data-toggle="modal" data-target=".bs-example-modal-to-do">
		
	</div>
	<div id="rid_result" class="row">
		<div class="col-md-3 col-md-3 col-xs-12">
			<div class="row">
				<a href="{{ $package->backCurrentNextUrl('activities')->get('previous', '#') }}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Back</a>
			</div>
			<div class="row">	
				<div class="x_panel nopadding text-center" style="background: aliceblue;">
					<h3><div>Activities</div></h3>
					<div>Date : <span class="show-start-date">{{$activityRoutes->first()->start_datetime->format('d-M-Y')}}</span> to <span class="show-end-date">{{$activityRoutes->first()->end_datetime->format('d-M-Y')}}</span></div>
				</div>
			</div>
			@include($viewPath.'.partials._filter')
			<div class="row m-top-70" align="center">
				<div id="btn_next" class="circle-big bg-blue glowing-green-border cursor-pointer" data-rid="" data-did="">
					<div class="circle-in text-center font-size-20">Next <i class="fa fa-arrow-right"></i></div>
				</div>
			</div>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="exTab1" class="container">
						<ul id="tab_menu" class="nav nav-pills">
							@foreach ($activityRoutes as $activityRouteKey => $activityRoute)
								<li class="col-md-2 col-sm-2 col-xs-12 text-center li-menu-dest {{ $activityRouteKey == 0 ? 'active' : ''}}">
									<a href="#target_{{ $activityRoute->token }}"
										class="a-tab-menu" data-toggle="tab">
										{{ $activityRoute->destination_detail->location }}
									</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content tab-content-box clearfix">
							@foreach ($activityRoutes as $activityRouteKey => $activityRoute)
								<div id="target_{{ $activityRoute->token }}" class="tab-pane tab-target {{ $activityRouteKey == 0 ? 'active' : ''}}">
									<ul id="fixed_{{ $activityRoute->token }}" class="list list-unstyled fixed">
									</ul>
									<ul id="result_{{ $activityRoute->token }}" class="list list-unstyled result">
									</ul>
								</div>
							@endforeach
						</div>
					</div>
					{{-- <div id="exTab1" class="container">
						<ul id="tab_menu" class="nav nav-pills">
							@foreach ($package->activityRoutes as $activityRouteKey => $activityRoute)
								<li class="col-md-2 col-sm-2 col-xs-12 text-center li-menu-dest 
									{{ $activityRouteKey == 0 ? 'active' : ''}}" 
									data-list="rid_{{ $activityRoute->id }}_div">
									<a id="a_rid_{{ $activityRoute->id }}" 
										href="#rid_{{ $activityRoute->id }}_div" 
										data-rid="{{ $activityRoute->id }}"
										class="a_tab_menu"
										data-toggle="tab">
										{{ $activityRoute->destination_detail->destination.', '.$activityRoute->destination_detail->country }}
									</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content tab-content-box clearfix">
							@foreach ($package->activityRoutes as $key => $activityRoute)
								<div id="rid_{{ $activityRoute->id }}_div" 
										class="tab-pane {{ $activityRouteKey == 0 ? 'active' : ''}}">
									<ul id="rid_{{ $activityRoute->id }}" class="list list-unstyled" data-rid="{{ $activityRoute->id }}"></ul>
									<button class="btn btn-success add-own-activity" data-count="0"
										>Add your own Activity
									</button>
								</div>
							@endforeach
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</div>
	<div class="add-btn-manually-fixed">
		<button class="btn btn-success add-own-activity">
			Add Activity Manually
		</button>
	</div>

	{{-- @include($viewPath.'.partials._hidden') --}}

@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ asset('js/list.min.js') }}"></script>


	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>

	<script src="{{ commonAsset('dashboard/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
	
	<script src="{{ asset('js/mydropzone.js') }}"></script>

@endsection

@section('scripts')
	@include($viewPath.'.partials.scripts._scripts')
@endsection