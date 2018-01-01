<!DOCTYPE html>
<html lang="en">
	<head>
		@include('hotels.layouts.partials.head')
	</head>
	<body id="top">

		<!-- start preloader -->
		<div class="preloader">
			<div class="sk-spinner sk-spinner-wave">
				<div class="sk-rect1"></div>
				<div class="sk-rect2"></div>
				<div class="sk-rect3"></div>
				<div class="sk-rect4"></div>
				<div class="sk-rect5"></div>
			</div>
		</div>
		<!-- end preloader -->
		
		{{-- @include('hotels.layouts.partials.start_header') --}}

		<!-- start navigation -->
		@include('hotels.layouts.partials.menu')
		<!-- end navigation -->
		
		@yield('content')

		<!-- start copyright -->
		@include('hotels.layouts.partials.footer')
		<!-- end copyright -->

	</body>
</html>