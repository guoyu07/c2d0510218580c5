@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
	<link rel="stylesheet" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/>
	<link rel="stylesheet" type="text/css" id="u0" href="https://cdn.tinymce.com/4/skins/lightgray/skin.min.css">
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					@include($viewPath.'.open_partials.info')
					@include($viewPath.'.open_partials.follow_up')
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					@include($viewPath.'.open_partials.modify')
				</div>
			</div>
		</div>
	
		<div class="col-md-12 col-sm-12 col-xs-12">
			@include($viewPath.'.open_partials.routes')
		</div>

		{{-- Flights List --}}
		<a name="flights"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.open_partials.flights')
			</div>
		</div>
		{{-- /Flights List --}}


		{{-- Hotels List --}}
		<a name="hotels"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.open_partials.hotels')
			</div>
		</div>
		{{-- /Hotels List --}}

		{{-- Hotels List --}}
		<a name="cruises"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.open_partials.cruises')
			</div>
		</div>
		{{-- /Hotels List --}}
		

		{{-- Hotels List --}}
		<a name="cabs"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.open_partials.cars')
			</div>
		</div>
		{{-- /Hotels List --}}


		{{-- Activitiy List --}}
		<a name="activities"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.open_partials.activities')
			</div>
		</div>
		{{-- /Activitiy List --}}

		<div class="col-md-12 col-sm-12 col-xs-12">
			@include($viewPath.'.open_partials.note')
		</div>

		{{-- Grand Total List --}}
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-5 col-sm-5 col-xs-12">
					@include($viewPath.'.open_partials.costs')
					@include($viewPath.'.open_partials.action')
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					@include($viewPath.'.open_partials.cost_history')
				</div>
			</div>
		</div>
		{{-- /Grand Total List --}}
	</div>
@endsection

@section('js')
	{{-- bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('datetimepicker/jquery.datetimepicker.full.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}
@endsection

@section('headJs')
	<script src="{{ asset('js/tinymce.min.js') }}"></script>
	{{-- <script src="http://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ojx87hfs53fqsef62yibco7kh4nk7gyzf1trcc14tt3vlmrn"></script> --}}
	<script>
		tinymce.init({ 
			selector:'#note_area',
			plugins : 'autolink link image lists preview table',
			menu: {
				file: {title: 'File', items: 'newdocument'},
				edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
				insert: {title: 'Insert', items: 'link media | template hr'},
				view: {title: 'View', items: 'visualaid'},
				format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
				table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
				tools: {title: 'Tools', items: 'spellchecker code'}
			},
			menubar: 'file edit insert view format table tools',
			height : 210
		});
	</script>
@endsection

@section('scripts')
	@include($viewPath.'.open_partials._scripts')
@endsection