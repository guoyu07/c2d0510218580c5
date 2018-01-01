@extends('hotels.layouts.main')

@section('content')
	<!-- start home -->
		@include('hotels.pages.partials.home')
	<!-- end home -->

	<!-- start about -->
		@include('hotels.pages.partials.about')
	<!-- end about -->

	<!-- start team -->
		@include('hotels.pages.partials.team')
	<!-- end team -->

	<!-- start service -->
		@include('hotels.pages.partials.service')
	<!-- end servie -->

	<!-- start portfolio -->
		@include('hotels.pages.partials.portfolio')
	<!-- end portfolio -->

	<!-- start contact -->
		@include('hotels.pages.partials.contact')
	<!-- end contact -->
@endsection
