@extends('common.protected.dashboard.main')

@section('jquery')
	<script src="{!! asset('common/dashboard/vendors/jquery/dist/jquery.min.js') !!}"></script>
@endsection

@section('customCss')
	<link href="{{ asset('b2b/css/custom.min.css') }}" rel="stylesheet">
@endsection

@section('beforecontent')
	@include('b2b.protected.dashboard.partials._to_do')
@endsection

@section('_nav_left')
	@include('b2b.protected.dashboard.partials._nav_left')
@endsection

@section('_nav_top')
	@include('b2b.protected.dashboard.partials._nav_top')
@endsection

@section('b2b_scripts')
	@include('b2b.protected.dashboard.partials._scripts')
@endsection

