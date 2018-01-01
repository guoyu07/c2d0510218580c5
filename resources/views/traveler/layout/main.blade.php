<!DOCTYPE HTML>
<html>
	<head>
		@include('traveler.layout.partials._head')
		@yield('css')
	</head>
	<body>
		@include('traveler.layout.widget.facebook')
		<div class="global-wrap">
			{{-- @include('traveler.layout.partials._theme_changer') --}}
			<header id="main-header">
				@include('traveler.layout.partials._header')
				@include('traveler.layout.partials._menu')
			</header>
			@yield('content')

			<div class="gap"></div>
			
			@include('traveler.layout.partials._footer')
		</div>
		@include('traveler.layout.partials._scripts')
		@yield('scripts')
	</body>
</html>



