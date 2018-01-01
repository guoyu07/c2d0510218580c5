@extends('hotels.layouts.main')

@section('content')
	<!-- start home -->
		@include('hotels.pages.index.partials.home')
	<!-- end home -->

	<!-- start team -->
		@include('hotels.pages.partials.team')
	<!-- end team -->

	<!-- start contact -->
		@include('hotels.pages.partials.contact')
	<!-- end contact -->
@endsection
