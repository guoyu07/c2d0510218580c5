@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">

  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
  {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
@endsection

@section('content')
	<div class="row">
		{{-- Cab Serach --}}
		@include('b2b.protected.dashboard.pages.cab.partials.content_search')
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
	<div id="cab_result" class="row"></div>
	@include('b2b.protected.dashboard.pages.cab.partials.content_hidden')

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
	@include('b2b.protected.dashboard.pages.cab.partials.content_scripts')
@endsection