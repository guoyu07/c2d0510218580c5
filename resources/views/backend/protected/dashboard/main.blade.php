@extends('common.protected.dashboard.main')

@section('jquery')
	<script src="{!! asset('common/dashboard/vendors/jquery/dist/jquery.min.js') !!}"></script>
@endsection

@section('app_name', config('app.backend_name', 'Trawish'))

@section('customCss')
	<link href="{{ asset('backend/css/custom.min.css') }}" rel="stylesheet">
@endsection

@section('_nav_left')
	@include('backend.protected.dashboard.partials._nav_left')
@endsection

@section('_nav_top')
	@include('backend.protected.dashboard.partials._nav_top')
@endsection