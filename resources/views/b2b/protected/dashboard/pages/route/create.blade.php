@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('timepicker/wickedpicker.min.css') }}"/>
	<link rel="stylesheet" href="{{ commonAsset('timepicker/jquery.timepicker.css') }}"/>
	{{-- <link rel="stylesheet" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/> --}}
	<style>
		.portlet-placeholder {
	    border: 1px dotted black;
	    margin: 0 1em 1em 0;
	    height: 50px;
	  }
	</style>
@endsection

@section('menutab')
	@include($viewPath.'.create_partials._menu')
@endsection

@section('content')
	{{-- @include($viewPath.'.create_partials.req') --}}
	<div class="row">
		{{-- Hotel Serach --}}
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">	
				<div class="x_panel">
					<form id="search_form">
						<div class="x_title" >
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-12">
									<h3>
										<i class="fa fa-road"></i>
										Define Your Route
										<small>(Package Id : {{ $package->uid }})</small>
									</h3>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12 m-top-5">
									<input type="text" class="form-control has-feedback-left datepicker p-left-10 arrival border-blue-2px" placeholder="Start Date" id="startDate" aria-describedby="inputSuccess2Status3" data-saved="0" data-pid="{{$package->id}}" 

									@if ($package->is_start_date_set)
										value="{{ $package->start_date->format('d/m/Y') }}"
									@endif
									>
									<i class="fa fa-calendar form-control-feedback right" aria-hidden="true"></i>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
								</div>
							</div>
							<div class="row">
								<div class="col-md-8 col-sm-8 col-xs-8">
									<label for="">Title:</label>
									<b id="package_title" data-saved="{{ is_null($package->title) ? 0 : 1 }}">{{ $package->title }}</b>
									<a id="btn_package_title" class="btn btn-link">Edit</a>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-4">
									@include('b2b.protected.dashboard.pages.common.guests.field')
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="">Requirements:</label>
									<b id="show_req" data-saved="0">{{ $package->req }}</b>
									<a id="edit_req" class="btn btn-link">Edit</a>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content nopadding">
							<div class="form-group">
								<div class="destinationClass">
									@if ($routes->count())
										@include($viewPath.'.create_partials.filled')
									@else
										@include($viewPath.'.create_partials.empty')
									@endif
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
									{{-- <a id="btn-addDestination" class="btn-link cursor-pointer" data-count="1">Add Route</a>
									<span id="pipeSaprDestination" hidden> | </span>
									<a id="btn-removeDestination" class="btn-link cursor-pointer" hidden>Remove Route</a> --}}
								</div>
							</div>

							{{-- <div class="col-md-12 col-sm-12 col-xs-12">
								<hr>
								<h2>Guests Detail</h2>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								@include($viewPath.'.create_partials.rooms')
							</div> --}}
							<div class="col-md-2 col-sm-2 col-xs-12 m-top-30">
								<button type="button" id="formSubmit" class="btn btn-success btn-block">Next</button>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12 m-top-30">
								<a href="{{ $package->package_url }}" class="btn btn-default btn-block">Cancel</a>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
		{{-- /Hotel Serach --}}
	</div>


	{{-- Hidden template Html  --}}
	@include($viewPath.'.create_partials._hidden')
	{{-- /Hidden template Html  --}}

@endsection


@section('js')
	{{-- autocomplete --}}
	<script src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script type="text/javascript" src="{{commonAsset('timepicker/wickedpicker.min.js')}}"></script>
	<script type="text/javascript" src="{{commonAsset('timepicker/jquery.timepicker.min.js')}}"></script>

	{{-- <script src="{{ commonAsset('datetimepicker/jquery.datetimepicker.full.js') }}"></script> --}}
	{{-- autocomplete --}}
	
	{{-- bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

	<script src="{{ asset('js/parsley.min.js') }}"></script>
	<script src="{{ asset('js/my_plus_minus.js') }}"></script>

@endsection

@section('scripts')
	@include($viewPath.'.create_partials._scripts')
@endsection
