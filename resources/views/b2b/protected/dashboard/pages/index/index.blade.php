@extends('b2b.protected.dashboard.main')

@section('content')
		{{-- top tiles --}}
		@include($viewPath.'.partials.client_status')
		{{-- /top tiles --}}
		<div class="row top_tiles">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				@include($viewPath.'.partials.shortcut')
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				@include($viewPath.'.partials.lead_action')
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-sm-6 col-xs-12">
				@include($viewPath.'.partials.lead_vendor')
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
				@include($viewPath.'.partials.currency')
			</div>
		</div>

		<div class="row">
			{{-- Start to do list --}}
				{{-- @include($viewPath.'.partials.todo') --}}
			{{-- End to do list --}}
			
			{{-- @if (!empty($travelFeeds))
				@include($viewPath.'.partials.travel_feeds')
			@endif --}}
		</div>
@endsection

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.0.3/vue.js"></script>

	<script src="{{ commonAsset('dashboard/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
	{{-- Chart.js --}}
	<script src="{{ commonAsset('dashboard/vendors/Chart.js/dist/Chart.min.js') }}"></script>
	{{-- ECharts --}}
	<script src="{{ commonAsset('dashboard/vendors/echarts/dist/echarts.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/echarts/map/js/world.js') }}"></script>
@endsection

@section('scripts')
	@include('b2b.protected.dashboard.pages.index.partials._scripts')
@endsection